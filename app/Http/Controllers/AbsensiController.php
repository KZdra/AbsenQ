<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function absen(Request $request)
    {
        $qrCode = $request->qr_code;

        // Cari siswa berdasarkan QR code
        $siswa = Siswa::where('nis', $qrCode)->first();
        if (!$siswa) {
            return response()->json(['message' => 'Siswa Tidak Ditemukan'], 500);
        }

        // Cek apakah siswa sudah absen hari ini
        $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('waktu_absen', now()->toDateString())
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'exist' => true,
                'message' => 'Siswa sudah absen hari ini',
            ]);
        }

        // Catat absensi
        Absensi::create([
            'siswa_id' => $siswa->id,
            'status' => 'hadir',
            'waktu_absen' => now(),
            'created_at' => now()
        ]);

        return response()->json([
            'exist' => false,
            'nama' => $siswa->nama,
            'message' => 'Absen berhasil',
        ],201);
    }
}
