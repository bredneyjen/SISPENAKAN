<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

         if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response()->json(['user' => $user]);
    } else {
        return response()->json(['message' => 'Invalid email or password'], 401);
    }
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'alamat' => 'required',
            'instansi' => 'required',
            'jenis_pendidikan' => 'required',
            'pendapatan' => 'required',
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'instansi' => $request->instansi,
            'jenis_pendidikan' => $request->jenis_pendidikan,
            'pendapatan' => $request->pendapatan,
            'level' => 'pelapor'
        ]);

        // Kirim respons sukses
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }
    public function logout()
    {
        Auth::logout();
        return response()->json('berhasil logout');
    }

        
}
