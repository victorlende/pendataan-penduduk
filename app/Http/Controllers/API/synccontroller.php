<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SyncController extends Controller
{
    /**
     * Sinkronisasi data penduduk dari mobile ke server
     * Ini adalah FITUR INTI dari aplikasi!
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncPenduduk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'sync_items' => 'required|array|min:1',
            'sync_items.*.uuid' => 'required|string',
            'sync_items.*.action' => 'required|in:create,update,delete',
            'sync_items.*.data' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $syncItems = $request->sync_items;
        $deviceId = $request->device_id;

        $successCount = 0;
        $failedCount = 0;
        $results = [];
        $errors = [];

        // Process each sync item
        foreach ($syncItems as $item) {
            try {
                $result = $this->processSyncItem($item, $user);

                if ($result['success']) {
                    $successCount++;
                } else {
                    $failedCount++;
                    $errors[] = [
                        'uuid' => $item['uuid'],
                        'error' => $result['message'],
                    ];
                }

                $results[] = $result;

            } catch (\Exception $e) {
                $failedCount++;
                $errors[] = [
                    'uuid' => $item['uuid'],
                    'error' => $e->getMessage(),
                ];

                $results[] = [
                    'uuid' => $item['uuid'],
                    'success' => false,
                    'message' => $e->getMessage(),
                ];
            }
        }

        // Log sync activity
        SyncLog::create([
            'user_id' => $user->id,
            'device_id' => $deviceId,
            'action' => 'sync',
            'table_name' => 'penduduk',
            'record_count' => count($syncItems),
            'success_count' => $successCount,
            'failed_count' => $failedCount,
            'errors' => $failedCount > 0 ? $errors : null,
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Sinkronisasi selesai: {$successCount} berhasil, {$failedCount} gagal",
            'data' => [
                'total' => count($syncItems),
                'success_count' => $successCount,
                'failed_count' => $failedCount,
                'results' => $results,
            ],
        ], 200);
    }

    /**
     * Process single sync item
     *
     * @param array $item
     * @param User $user
     * @return array
     */
    private function processSyncItem($item, $user)
    {
        $uuid = $item['uuid'];
        $action = $item['action'];
        $data = $item['data'];

        switch ($action) {
            case 'create':
                return $this->syncCreate($uuid, $data, $user);

            case 'update':
                return $this->syncUpdate($uuid, $data, $user);

            case 'delete':
                return $this->syncDelete($uuid, $user);

            default:
                return [
                    'uuid' => $uuid,
                    'success' => false,
                    'message' => 'Action tidak valid',
                ];
        }
    }

    /**
     * Sync Create: Insert data baru ke server
     *
     * @param string $uuid
     * @param array $data
     * @param User $user
     * @return array
     */
    private function syncCreate($uuid, $data, $user)
    {
        // Cek apakah UUID sudah ada (duplicate)
        $existing = Penduduk::where('uuid', $uuid)->first();

        if ($existing) {
            return [
                'uuid' => $uuid,
                'success' => false,
                'message' => 'Data dengan UUID ini sudah ada',
                'server_id' => $existing->id,
            ];
        }

        // Cek duplikasi NIK
        if (isset($data['nik'])) {
            $nikExists = Penduduk::where('nik', $data['nik'])->first();

            if ($nikExists) {
                return [
                    'uuid' => $uuid,
                    'success' => false,
                    'message' => 'NIK sudah terdaftar',
                ];
            }
        }

        // Validasi RT/RW sesuai dengan petugas
        if ($user->rt_rw && isset($data['rt_rw']) && $data['rt_rw'] !== $user->rt_rw) {
            return [
                'uuid' => $uuid,
                'success' => false,
                'message' => 'RT/RW tidak sesuai dengan wilayah Anda',
            ];
        }

        // Handle photo KTP jika ada
        if (isset($data['photo_ktp']) && !empty($data['photo_ktp'])) {
            try {
                $photoPath = $this->saveBase64Image($data['photo_ktp'], 'ktp');
                $data['photo_ktp'] = $photoPath;
            } catch (\Exception $e) {
                $data['photo_ktp'] = null; // Skip foto jika error
            }
        }

        // Prepare data untuk insert
        $data['uuid'] = $uuid;
        $data['created_by'] = $user->id;
        $data['is_synced'] = true;
        $data['synced_at'] = now();

        // Insert to database
        $penduduk = Penduduk::create($data);

        return [
            'uuid' => $uuid,
            'success' => true,
            'message' => 'Data berhasil disinkronkan',
            'server_id' => $penduduk->id,
            'synced_at' => $penduduk->synced_at->toIso8601String(),
        ];
    }

    /**
     * Sync Update: Update data yang sudah ada
     *
     * @param string $uuid
     * @param array $data
     * @param User $user
     * @return array
     */
    private function syncUpdate($uuid, $data, $user)
    {
        $penduduk = Penduduk::where('uuid', $uuid)->first();

        if (!$penduduk) {
            return [
                'uuid' => $uuid,
                'success' => false,
                'message' => 'Data tidak ditemukan di server',
            ];
        }

        // Conflict resolution: Last Write Wins (berdasarkan timestamp)
        // Jika data di server lebih baru, tolak update dari mobile
        if (isset($data['updated_at'])) {
            $mobileTimestamp = strtotime($data['updated_at']);
            $serverTimestamp = strtotime($penduduk->updated_at);

            if ($serverTimestamp > $mobileTimestamp) {
                return [
                    'uuid' => $uuid,
                    'success' => false,
                    'message' => 'Conflict: Data di server lebih baru',
                    'server_data' => $penduduk,
                ];
            }
        }

        // Handle photo KTP jika ada update
        if (isset($data['photo_ktp']) && !empty($data['photo_ktp'])) {
            try {
                // Hapus foto lama
                if ($penduduk->photo_ktp) {
                    Storage::disk('public')->delete($penduduk->photo_ktp);
                }
                $photoPath = $this->saveBase64Image($data['photo_ktp'], 'ktp');
                $data['photo_ktp'] = $photoPath;
            } catch (\Exception $e) {
                unset($data['photo_ktp']); // Skip foto jika error
            }
        }

        // Update synced status
        $data['is_synced'] = true;
        $data['synced_at'] = now();

        // Update to database
        $penduduk->update($data);

        return [
            'uuid' => $uuid,
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'server_id' => $penduduk->id,
            'synced_at' => $penduduk->synced_at->toIso8601String(),
        ];
    }

    /**
     * Sync Delete: Soft delete data
     *
     * @param string $uuid
     * @param User $user
     * @return array
     */
    private function syncDelete($uuid, $user)
    {
        $penduduk = Penduduk::where('uuid', $uuid)->first();

        if (!$penduduk) {
            return [
                'uuid' => $uuid,
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ];
        }

        // Soft delete
        $penduduk->delete();

        return [
            'uuid' => $uuid,
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ];
    }

    /**
     * Get sync logs history
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLogs(Request $request)
    {
        $user = $request->user();

        $logs = SyncLog::with('user:id,name,rt_rw')
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $logs->items(),
            'meta' => [
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'per_page' => $logs->perPage(),
                'total' => $logs->total(),
            ],
        ], 200);
    }

    /**
     * Helper: Save base64 image
     *
     * @param string $base64String
     * @param string $folder
     * @return string
     */
    private function saveBase64Image($base64String, $folder = 'photos')
    {
        // Extract base64 data
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1]);

            $base64String = str_replace(' ', '+', $base64String);
            $imageData = base64_decode($base64String);

            if ($imageData === false) {
                throw new \Exception('Base64 decode failed');
            }

            $filename = uniqid() . '.' . $type;
            $path = $folder . '/' . $filename;

            Storage::disk('public')->put($path, $imageData);

            return $path;
        }

        throw new \Exception('Invalid base64 image format');
    }
}
