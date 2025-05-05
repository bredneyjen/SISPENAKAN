<?php

namespace App\Http\Controllers;

use App\Models\laporanModel;
use App\Models\PengajuanDonasi;
use App\Models\UserDonasi;
use Illuminate\Http\Request;
use PDO;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserDonasiController extends Controller
{

    public function storeUserDonasi(Request $request)
    {
        // Validasi data yang masuk (semuanya wajib ada jika kurang 1 maka proses tidak lanjut)
        $data = $request->validate([
            'nama_lengkap' => 'required',
            'nominal' => 'required',
            'email' => 'required',
            'nomor_hp' => 'required',
            'tujuan_donasi' => 'required',
            'bukti1' => 'required',
            'bukti2' => 'required',
            'alasan' => 'required',
            'status' => 'required',
        ]);

        // Simpan data yang telah divalidasi ke database
        UserDonasi::create($data);
        return response()->json(['message' => 'Data donasi berhasil disimpan ke
        database dan qr berhasil di generator', 'path' => 'storage/qrcodes/']);
    }

    public function getDataUser()
    {
        $data = UserDonasi::all();

        return response()->json($data);
    }

    public function update($id, Request $request)
    {
        // Validasi data yang masuk (semuanya wajib ada jika kurang 1 maka proses tidak lanjut)
        $data = $request->validate([
            'nama_lengkap' => 'required',
            'nominal' => 'required',
            'email' => 'required',
            'nomor_hp' => 'required',
            'tujuan_donasi' => 'required',
            'bukti1' => 'required',
            'bukti2' => 'required',
            'alasan' => 'required',
            'status' => 'required',
        ]);

        // Cari data user donasi berdasarkan ID
        $userDonasi = UserDonasi::findOrFail($id);

        // Perbarui data user donasi yang ada
        $userDonasi->update($data);

        return response()->json(['message' => 'Data donasi berhasil diperbarui.']);
    }
    public function getDataLaporanID($id){
        $data = laporanModel::findOrFail($id);

        return response()->json($data);
    }
    public function updateDonasi($id, Request $request)
    {
        // Validasi data yang masuk (semuanya wajib ada jika kurang 1 maka proses tidak lanjut)
        $data = $request->validate([
            'nominal' => 'required',
        ]);
    
        // Cari data user donasi berdasarkan ID
        $userDonasi = UserDonasi::find($id);
    
        // Ambil nilai donasi sebelumnya
        $donasiSebelumnya = $userDonasi->donasi;
    
        // Tambahkan nilai donasi sebelumnya dengan nilai nominal dari request
        $userDonasi->donasi = $donasiSebelumnya + $request->input('nominal');
        $userDonasi->save();
    
        return response()->json(['message' => 'Data donasi berhasil dikirim.']);
    }
    

    public function destroy($id)
    {
        // Cari data user donasi berdasarkan ID
        $userDonasi = UserDonasi::findOrFail($id);

        // Hapus data user donasi yang ada
        $userDonasi->delete();

        return response()->json(['message' => 'Data donasi berhasil dihapus.']);
    }
    public function statusPengajuan(Request $request, $id, $status){

        $data = UserDonasi::findOrFail($id);

        if ($status == 'Selesai') {
            $tableDonasi = new laporanModel();
    
            $tableDonasi->nama_lengkap = $data->nama_lengkap;
            $tableDonasi->alamat = $data->alamat;
            $tableDonasi->nominal = $data->nominal;
            $tableDonasi->nomor_hp = $data->nomor_hp;
            $tableDonasi->tujuan_donasi = $data->tujuan_donasi;
            $tableDonasi->donasi = $data->donasi;
            $tableDonasi->bukti1 = $data->bukti1;
            $tableDonasi->bukti2 = $data->bukti2;
            $tableDonasi->alasan = $data->alasan;
            
            $tableDonasi->save();
    
            // Hapus data dari PengajuanDonasi
            
            $data->delete();
    
            // Kirim respons sukses
            return response()->json([
                'message' => 'Data pengajuan berhasil dipindahkan ke Laporan',
            ]);
        } if ($data->status == 'Tolak'){
            $data->delete();
        }else {
            // Kirim respons jika status tidak sesuai untuk dipindahkan
            return response()->json([
                'message' => 'Status data tidak dapat dipindahkan ke UserDonasi',
            ], 400);
        }
    }
}
