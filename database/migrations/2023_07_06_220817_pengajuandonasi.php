<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pengajuandonasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_donasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('foto_calon_donasi');
            $table->string('keterangan');
            $table->longText('bukti_pendukung');
            $table->string('jenis_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_donasi', function (Blueprint $table) {
            //
        });
    }
}
