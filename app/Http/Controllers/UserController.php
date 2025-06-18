<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }
    public function store(Request $request)
    {
        $kont = $request->validate([
            'nama' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'role' => 'required|string',
            'password' => 'required',
        ]);
        try {
            DB::table('users')->insert([
                'name' => $kont['nama'],
                'username' => $kont['username'],
                'password' => Hash::make($kont['password']),
                'role' => $kont['role'],
                'created_at' => Carbon::now(),
            ]);
            return response()->json(['message' => 'User berhasil ditambahkan!'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $data = [
                'role' => $request->role,
                'name' => $request->nama,
                'username' => $request->username,
                'updated_at' => Carbon::now(),
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
            DB::table('users')->where('id', $id)->update($data);
            return response()->json(['message' => 'User berhasil diUpdate!'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            DB::table('users')->where('id', $id)->delete();
            return response()->json(['message' => 'User berhasil diUpdate!'], 201);
        } catch (\Exception $e) {
            // return response()->json(['message' => 'Ada Masalah Diantara Input/Server'], 500);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
