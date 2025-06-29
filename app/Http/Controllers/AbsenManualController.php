<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use App\Models\Absensi;

class AbsenManualController extends Controller
{

    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $statusList = ['hadir', 'sakit', 'izin', 'alpa'];

        $query = Siswa::with(['kelas:id,nama_kelas']);

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswa = $query->get();

        // Ambil data absensi siswa hari ini (jika ada)
        $today = Carbon::today();
        $absensiHariIni = Absensi::whereDate('waktu_absen', $today)
            ->whereIn('siswa_id', $siswa->pluck('id'))
            ->get()
            ->keyBy('siswa_id'); // agar mudah dicocokkan nanti
        
        return view('absenmanual.index', compact('siswa', 'kelasList', 'statusList', 'absensiHariIni'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kehadiran' => 'required|in:hadir,sakit,izin,alpa',
        ]);

        $today = Carbon::today(); // hanya ambil tanggal
        $now = Carbon::now(); // tanggal + waktu

        $existing = Absensi::whereDate('waktu_absen', $today)
            ->where('siswa_id', $request->siswa_id)
            ->first();

        if ($existing) {
            // update status, tetap simpan waktu absen awal
            $existing->status = $request->kehadiran;
            $existing->save();
            $absensi = $existing;
        } else {
            // insert baru dengan waktu sekarang
            $absensi = Absensi::create([
                'siswa_id' => $request->siswa_id,
                'status' => $request->kehadiran,
                'waktu_absen' => $now,
            ]);
        }

        return response()->json([
            'message' => 'Absensi berhasil disimpan',
            'data' => $absensi,
        ]);
    }
}
