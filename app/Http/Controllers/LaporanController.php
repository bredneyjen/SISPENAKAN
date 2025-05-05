<?php

namespace App\Http\Controllers;

use App\Models\laporanModel;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $pengajuanDonasi = laporanModel::all();
        return response()->json($pengajuanDonasi);
    }

    public function user()
    {
        $pengajuanDonasi = User::all();
        return response()->json($pengajuanDonasi);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Validate the request data here if needed
            $validatedData = $request->validate([
                'nama_lengkap' => 'required',
                'email' => 'required',
                'password' => 'required',
                'alamat' => 'required',
                'instansi' => 'required',
                'jenis_pendidikan' => 'required',
                'pendapatan' => 'required',
                'level' => 'required',
            ]);

            // Update the user record
            $user->update($validatedData);

            return response()->json(['message' => 'User updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found or could not be updated'], 404);
        }
    }

    public function uploadBukti(Request $request, $id)
    {
        $pengajuanDonasi = laporanModel::find($id);

        if ($request->hasFile('bukti2')) {
            $pengajuanDonasi->bukti2 = $request->file('bukti2')->store('bukti_donasi');
            $pengajuanDonasi->save();
            return response()->json(['message' => 'File uploaded successfully'], 200);
        } else {
            return response()->json(['message' => 'File not found'], 400);
        }
    }
}
