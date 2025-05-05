<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laporanModel extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'nomor_hp',
        'tujuan_donasi',
        'donasi',
        'nominal',
        'bukti1',
        'bukti2',
        'alasan'
    ];
}
