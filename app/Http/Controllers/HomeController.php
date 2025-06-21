<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $siswaCount = Siswa::count();
        $kelasCount = Kelas::count();
        $persentaseAbsen = DB::table('absensis')
            ->selectRaw("
        SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) AS total_hadir,
        SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) AS total_sakit,
        SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) AS total_izin,
        SUM(CASE WHEN status = 'alpa' THEN 1 ELSE 0 END) AS total_alpa,
        COUNT(*) AS total_absensi,
        ROUND(
            (SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) * 100.0) / NULLIF(COUNT(*), 0),
            2
        ) AS persentase_kehadiran
    ")
            ->whereDate('waktu_absen', now())
            ->first();

        // dd($persentaseAbsen);
        $absenData = [
            $persentaseAbsen->total_hadir,
            $persentaseAbsen->total_sakit,
            $persentaseAbsen->total_izin,
            $persentaseAbsen->total_alpa,
        ];
        return view('home', compact('siswaCount', 'kelasCount', 'persentaseAbsen','absenData'));
    }
}
