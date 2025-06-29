<?php
namespace App\Exports;

use App\Models\Siswa;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

use Carbon\Carbon;

class RekapAbsensiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = Carbon::parse($start)->startOfDay();
        $this->end   = Carbon::parse($end)->endOfDay();
    }

    public function collection()
    {
        $siswaList = Siswa::with('kelas')
            ->withCount([
                'absensis as sakit' => fn($q) => $q->where('status', 'sakit')->whereBetween('waktu_absen', [$this->start, $this->end]),
                'absensis as izin'  => fn($q) => $q->where('status', 'izin')->whereBetween('waktu_absen', [$this->start, $this->end]),
                'absensis as alpa'  => fn($q) => $q->where('status', 'alpa')->whereBetween('waktu_absen', [$this->start, $this->end]),
                'absensis as hadir' => fn($q) => $q->where('status', 'hadir')->whereBetween('waktu_absen', [$this->start, $this->end]),
            ])
            ->get();

        return $siswaList->map(function ($siswa) {
            return [
                'Nama'   => $siswa->nama,
                'Kelas'  => $siswa->kelas->nama_kelas ?? '-',
                'Hadir'  => $siswa->hadir ,
                'Sakit'  => $siswa->sakit,
                'Izin'   => $siswa->izin,
                'Alpa'   => $siswa->alpa,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama', 'Kelas', 'Hadir', 'Sakit', 'Izin', 'Alpa'];
    }
}
