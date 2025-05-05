<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDonasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';

    protected $fillable = [
        'nama_lengkap',
        'nominal',
        'email',
        'nomor_hp',
        'alamat',
        'tujuan_donasi',
        'nominal',
        'bukti1',
        'bukti2',
        'alasan',
        'status'
    ];
}
