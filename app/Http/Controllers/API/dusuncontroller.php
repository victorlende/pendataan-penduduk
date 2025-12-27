<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dusun;
use Illuminate\Http\Request;

class DusunController extends Controller
{
    /**
     * Get list of dusun (untuk petugas hanya dusun tugasnya)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $query = Dusun::select('id', 'nama_dusun', 'kepala_dusun');

            // Jika petugas memiliki dusun_id, filter hanya dusun tersebut
            if ($user && $user->dusun_id) {
                $query->where('id', $user->dusun_id);
            }

            $dusuns = $query->orderBy('nama_dusun')->get();

            return response()->json([
                'success' => true,
                'data' => $dusuns,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dusun',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
