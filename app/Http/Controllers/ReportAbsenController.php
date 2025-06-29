<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Exports\RekapAbsensiExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportAbsenController extends Controller
{
    public function index()
    {
        $classList = Kelas::pluck('nama_kelas', 'id');
        $tipeList = ['per_semester', 'manual']; // 6 bulan 1 semster , Manual month picker
        return view('reportabsen.index', compact('classList', 'tipeList'));
    }
    public function getData(Request $request)
    {
        if ($request->filled("tipe")) {
            if ($request->tipe === 'per_semester') {
                $start = Carbon::now()->subMonths(6)->startOfDay();
                $end = Carbon::now()->endOfDay();
            } elseif ($request->tipe === 'manual') {
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end = Carbon::parse($request->end_date)->endOfDay();
            } else {
                return response()->json(['error' => 'Tipe tidak dikenal'], 400);
            }
        } else {
            return response()->json(['error' => 'Tipe wajib diisi'], 400);
        }

        $siswaList = Siswa::with('kelas')
            ->withCount([
                'absensis as sakit' => fn($q) => $q->where('status', 'sakit')->whereBetween('waktu_absen', [$start, $end]),
                'absensis as izin'  => fn($q) => $q->where('status', 'izin')->whereBetween('waktu_absen', [$start, $end]),
                'absensis as alpa'  => fn($q) => $q->where('status', 'alpa')->whereBetween('waktu_absen', [$start, $end]),
                'absensis as hadir' => fn($q) => $q->where('status', 'hadir')->whereBetween('waktu_absen', [$start, $end]),
            ])
            ->get();

        $response = $siswaList->map(function ($siswa) {
            return [
                'nama'  => $siswa->nama,
                'kelas' => $siswa->kelas->nama_kelas ?? '-',
                'sakit' => $siswa->sakit,
                'izin'  => $siswa->izin,
                'alpa'  => $siswa->alpa,
                'hadir' => $siswa->hadir,
            ];
        });

        return response()->json([
            'status' => 1,
            'message' => 'Success',
            'data' => $response,
        ]);
    }
    public function export(Request $request)
    {
        if ($request->filled("tipe")) {
            if ($request->tipe === 'per_semester') {
                $start = Carbon::now()->subMonths(6)->startOfDay();
                $end = Carbon::now()->endOfDay();
            } elseif ($request->tipe === 'manual') {
                if (!$request->filled(['start_date', 'end_date'])) {
                    return redirect()->back()->with('error', 'Tanggal harus diisi');
                }
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end = Carbon::parse($request->end_date)->endOfDay();
            } else {
                return redirect()->back()->with('error', 'Tipe tidak dikenal');
            }
        } else {
            return redirect()->back()->with('error', 'Tipe wajib diisi');
        }
        return Excel::download(new RekapAbsensiExport($start, $end), 'rekap_absensi.xlsx');
    }
}
