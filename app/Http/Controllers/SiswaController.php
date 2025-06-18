<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;



class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $query = Siswa::with(['kelas:id,nama_kelas']);

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswa = $query->get();

        return view('siswa.index', compact('siswa', 'kelasList'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'nis' => 'required',
            'nama' => 'required|string',
            'kelas_id' => 'required',
        ]);
        try {
            Siswa::create([
                'nis' => $data['nis'],
                'nama' => $data['nama'],
                'kelas_id' => $data['kelas_id'],
                'created_at' => Carbon::now()
            ]);
            return response()->json(['message' => 'Siswa berhasil ditambahkan!'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nis' => 'required',
            'nama' => 'required|string',
            'kelas_id' => 'required',
        ]);
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->nis = $data['nis'];
            $siswa->nama = $data['nama'];
            $siswa->kelas_id = $data['kelas_id'];
            $siswa->updated_at = Carbon::now();
            $siswa->save();
            return response()->json(['message' => 'Siswa berhasil diUpdate!'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            Siswa::findOrFail($id)->delete();
            return response()->json(['message' => 'Siswa berhasil diHapus!'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_upload' => 'required|mimes:xlsx,xls',
        ]);
        try {
            Excel::import(new SiswaImport, $request->file('file_upload'));
            return response()->json(['message' => 'Data siswa berhasil diimport.'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function cetakQrMassal(Request $request)
    {
        $query = Siswa::with('kelas');

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswa = $query->get();

        return view('siswa.qr_massal', compact('siswa'));
    }
}
