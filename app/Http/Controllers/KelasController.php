<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }
    public function store(Request $request)
    {
        $kont = $request->validate([
            'nama_kelas' => 'required|string',
        ]);
        try {
            DB::table('kelas')->insert([
                'nama_kelas' => $kont['nama_kelas'],
                'created_at' => Carbon::now(),
            ]);
            return response()->json(['message' => 'Kelas berhasil ditambahkan!'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $data = [
                'nama_kelas' => $request->nama_kelas,
                'updated_at' => Carbon::now(),
            ];
            DB::table('kelas')->where('id', $id)->update($data);
            return response()->json(['message' => 'Kelas berhasil diUpdate!'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            DB::table('kelas')->where('id', $id)->delete();
            return response()->json(['message' => 'Kelas berhasil diHapus!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            // return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
