<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use App\Models\laporanModel;
use App\Models\PengajuanDonasi;
use App\Models\UserDonasi;
use Donasi;
use Illuminate\Http\Request;

class PengajuanDonasiController extends Controller
{
    public function index()
    {
        $pengajuanDonasi = PengajuanDonasi::all();
        return response()->json($pengajuanDonasi);
    }

    public function store(Request $request)
    {
        $pengajuanDonasi = new PengajuanDonasi();
        $pengajuanDonasi->nama_lengkap = $request->input('nama_lengkap');
        $pengajuanDonasi->alamat = $request->input('alamat');   
        $pengajuanDonasi->nomor_hp = $request->input('nomor_hp');
        $pengajuanDonasi->alasan = $request->input('alasan');
        $pengajuanDonasi->tujuan_donasi = $request->input('tujuan_donasi');
        $pengajuanDonasi->nominal = $request->input('nominal');
        $pengajuanDonasi->bukti1 = $request->input('bukti1');
        $pengajuanDonasi->bukti2 = $request->input('bukti2');
        if ($request->hasFile('bukti1')) {
            $bukti1 = $request->file('bukti1');
            $bukti1Path = public_path('storage/bukti_donasi');
            $bukti1Name = $bukti1->getClientOriginalName();
            $bukti1->move($bukti1Path, $bukti1Name);
            $pengajuanDonasi->bukti1 = $bukti1Name;
        }
        
        if ($request->hasFile('bukti2')) {
            $bukti2 = $request->file('bukti2');
            $bukti2Path = public_path('storage/bukti_donasi');
            $bukti2Name = $bukti2->getClientOriginalName();
            $bukti2->move($bukti2Path, $bukti2Name);
            $pengajuanDonasi->bukti2 = $bukti2Name;
        }

        $pengajuanDonasi->save();

        return response()->json(['message','berhasil di ajukan']);
    }

    public function update(Request $request, $id)
    {
        $pengajuanDonasi = PengajuanDonasi::find($id);
        $pengajuanDonasi->nama_lengkap = $request->input('nama_lengkap');
        $pengajuanDonasi->alamat = $request->input('alamat');
        $pengajuanDonasi->nomor_hp = $request->input('nomor_hp');
        $pengajuanDonasi->alasan = $request->input('alasan');
        $pengajuanDonasi->tujuan_donasi = $request->input('tujuan_donasi');
        $pengajuanDonasi->nominal = $request->input('nominal');
        $pengajuanDonasi->bukti1 = $request->input('bukti1');
        $pengajuanDonasi->bukti2 = $request->input('bukti2');
        if ($request->hasFile('bukti1')) {
            $pengajuanDonasi->bukti1 = $request->file('bukti1')->store('bukti_donasi');
        }
        
        if ($request->hasFile('bukti2')) {
            $pengajuanDonasi->bukti2 = $request->file('bukti2')->store('bukti_donasi');
        }
    
        $pengajuanDonasi->save();

        return response()->json($pengajuanDonasi);
    }

    public function destroy($id)
    {
        $pengajuanDonasi = PengajuanDonasi::find($id);
        $pengajuanDonasi->delete();

        return response()->json(['message' => 'Pengajuan donasi deleted successfully']);
    }

        public function statusPengajuan(Request $request, $id, $status){

            $data = PengajuanDonasi::findOrFail($id);

            if ($status == 'Terima') {
                $tableDonasi = new UserDonasi();
                $tableDonasi->id = $data->id;
                $tableDonasi->nama_lengkap = $data->nama_lengkap;
                $tableDonasi->nominal = $data->nominal;
                $tableDonasi->alamat = $data->alamat;
                $tableDonasi->nomor_hp = $data->nomor_hp;
                $tableDonasi->tujuan_donasi = $data->tujuan_donasi;
                $tableDonasi->bukti1 = $data->bukti1;
                $tableDonasi->bukti2 = $data->bukti2;
                $tableDonasi->alasan = $data->alasan;
                
                $tableDonasi->save();
                // Hapus data dari PengajuanDonasi
                $data->delete();
                // Kirim respons sukses
                return response()->json([
                    'message' => 'Data pengajuan berhasil dipindahkan ke UserDonasi',
                ]);
            } if ($status == 'Tolak'){
                $data->delete();
            }else {
                // Kirim respons jika status tidak sesuai untuk dipindahkan
                return response()->json([
                    'message' => 'Status data tidak dapat dipindahkan ke UserDonasi',
                ], 400);
            }
        }

        public function edit()
    {
        return view('posts.edit', compact('post'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
}
