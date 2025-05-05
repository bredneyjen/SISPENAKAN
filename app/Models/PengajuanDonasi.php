<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDonasi extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_donasi';

    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'nomor_hp',
        'tujuan_donasi',
        'nominal',
        'bukti1',
        'bukti2',
        'alasan'
    ];
}
