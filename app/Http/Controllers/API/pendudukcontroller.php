<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PendudukController extends Controller
{
    /**
     * Get list penduduk (untuk wilayah petugas yang login)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Penduduk::with('creator:id,name,rt_rw');

        // Filter berdasarkan RT/RW petugas
        if ($user->rt_rw) {
            $query->where('rt_rw', $user->rt_rw);
        }

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Filter by sync status
        if ($request->has('is_synced')) {
            $query->where('is_synced', $request->is_synced);
        }

        // Pagination
        $perPage = $request->get('per_page', 20);
        $penduduk = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $penduduk->items(),
            'meta' => [
                'current_page' => $penduduk->currentPage(),
                'last_page' => $penduduk->lastPage(),
                'per_page' => $penduduk->perPage(),
                'total' => $penduduk->total(),
            ],
        ], 200);
    }

    /**
     * Get detail penduduk
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $penduduk = Penduduk::with(['creator:id,name', 'user:id,name,email'])->find($id);

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $penduduk,
        ], 200);
    }

    /**
     * Create penduduk baru
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:penduduk,nik',
            'no_kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pendidikan_terakhir' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'kewarganegaraan' => 'nullable|string|max:50',
            'status_dalam_keluarga' => 'nullable|string|max:50',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'rt_rw' => 'required|string|max:10',
            'kecamatan' => 'nullable|string|max:100',
            'kelurahan' => 'nullable|string|max:100',
            'alamat_lengkap' => 'required|string',
            'no_telp' => 'nullable|string|max:20',
            'photo_ktp' => 'nullable|string', // Base64 string
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Validasi RT/RW sesuai dengan petugas
        $user = $request->user();
        if ($user->rt_rw && $request->rt_rw !== $user->rt_rw) {
            return response()->json([
                'success' => false,
                'message' => 'Anda hanya dapat menginput data untuk wilayah RT/RW: ' . $user->rt_rw,
            ], 403);
        }

        $data = $validator->validated();
        $data['created_by'] = $user->id;
        $data['is_synced'] = true; // Langsung dari API berarti sudah sync
        $data['synced_at'] = now();

        // Handle photo KTP jika ada
        if ($request->has('photo_ktp') && !empty($request->photo_ktp)) {
            $photoPath = $this->saveBase64Image($request->photo_ktp, 'ktp');
            $data['photo_ktp'] = $photoPath;
        }

        $penduduk = Penduduk::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data penduduk berhasil ditambahkan',
            'data' => $penduduk,
        ], 201);
    }

    /**
     * Update penduduk
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::find($id);

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:penduduk,nik,' . $id,
            'no_kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pendidikan_terakhir' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'kewarganegaraan' => 'nullable|string|max:50',
            'status_dalam_keluarga' => 'nullable|string|max:50',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'rt_rw' => 'required|string|max:10',
            'kecamatan' => 'nullable|string|max:100',
            'kelurahan' => 'nullable|string|max:100',
            'alamat_lengkap' => 'required|string',
            'no_telp' => 'nullable|string|max:20',
            'photo_ktp' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Handle photo KTP jika ada update
        if ($request->has('photo_ktp') && !empty($request->photo_ktp)) {
            // Hapus foto lama jika ada
            if ($penduduk->photo_ktp) {
                Storage::disk('public')->delete($penduduk->photo_ktp);
            }
            $photoPath = $this->saveBase64Image($request->photo_ktp, 'ktp');
            $data['photo_ktp'] = $photoPath;
        }

        $penduduk->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data penduduk berhasil diupdate',
            'data' => $penduduk,
        ], 200);
    }

    /**
     * Delete penduduk
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

        public function getKeluargaList()
    {
        try {
            $keluargaList = Penduduk::select(
                'no_kk',
                DB::raw('MAX(CASE WHEN LOWER(status_dalam_keluarga) LIKE "%kepala%" OR LOWER(status_dalam_keluarga) = "kk" THEN nama_lengkap ELSE NULL END) as kepala_keluarga'),
                DB::raw('COUNT(*) as jumlah_anggota'),
                DB::raw('MAX(rt_rw) as rt_rw'),
                DB::raw('MAX(alamat_lengkap) as alamat_lengkap')
            )
            ->groupBy('no_kk')
            ->orderBy('no_kk')
            ->get()
            ->map(function ($item) {
                // Fallback jika kepala keluarga tidak ditemukan, ambil nama pertama
                if (!$item->kepala_keluarga) {
                    $firstMember = Penduduk::where('no_kk', $item->no_kk)->first();
                    $item->kepala_keluarga = $firstMember ? $firstMember->nama_lengkap : 'Tidak Diketahui';
                }
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $keluargaList
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar keluarga',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get anggota keluarga by no_kk
     */
    public function getAnggotaKeluarga($no_kk)
    {
        try {
            $anggota = Penduduk::where('no_kk', $no_kk)
                ->orderByRaw("CASE
                    WHEN LOWER(status_dalam_keluarga) LIKE '%kepala%' OR LOWER(status_dalam_keluarga) = 'kk' THEN 1
                    ELSE 2
                    END")
                ->get();

            if ($anggota->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data keluarga tidak ditemukan',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $anggota
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data anggota keluarga',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function destroy($id)
    {
        $penduduk = Penduduk::find($id);

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'Data penduduk tidak ditemukan',
            ], 404);
        }

        // Hapus foto KTP jika ada
        if ($penduduk->photo_ktp) {
            Storage::disk('public')->delete($penduduk->photo_ktp);
        }

        $penduduk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data penduduk berhasil dihapus',
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
            $type = strtolower($type[1]); // jpg, png, gif

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
