<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $kelas = Kelas::where('nama_kelas', $row['kelas'])->first();

        if (!$kelas) {
            return null; // atau throw error
        }

        return new Siswa([
            'nis' => $row['nis'],
            'nama' => ucwords(mb_strtolower($row['nama'])),
            'kelas_id' => $kelas->id,
        ]);
    }
}
