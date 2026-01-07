<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tambah di tbl_jenis
        Schema::table('tbl_jenisbarang', function (Blueprint $table) {
            // CHAR(2) artinya wajib 2 karakter, misal: 'EL', 'MK'
            // Kita taruh setelah nama biar rapi
            $table->char('jenis_initial', 2)->nullable()->after('jenisbarang_nama');
        });

        // Tambah di tbl_satuan
        Schema::table('tbl_satuan', function (Blueprint $table) {
            $table->char('satuan_initial', 2)->nullable()->after('satuan_nama');
        });

        // Tambah di tbl_merk
        Schema::table('tbl_merk', function (Blueprint $table) {
            $table->char('merk_initial', 2)->nullable()->after('merk_nama');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Ini buat jaga-jaga kalau mau membatalkan perubahan
        Schema::table('tbl_jenisbarang', function (Blueprint $table) {
            $table->dropColumn('jenis_initial');
        });
        Schema::table('tbl_satuan', function (Blueprint $table) {
            $table->dropColumn('satuan_initial');
        });
        Schema::table('tbl_merk', function (Blueprint $table) {
            $table->dropColumn('merk_initial');
        });
    }
};
