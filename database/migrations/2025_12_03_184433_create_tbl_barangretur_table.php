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
        Schema::create('tbl_barangretur', function (Blueprint $table) {
            // Primary Key: retur_id (Integer, Auto Increment)
            $table->integer('retur_id', true); 
            
            // Kolom Data
            $table->string('retur_kode', 50)->nullable();
            $table->string('barang_kode', 50)->nullable(); // Pastikan tipe data sama dengan tbl_barang
            $table->date('retur_tanggal')->nullable();
            $table->integer('retur_jumlah')->nullable();
            $table->text('retur_keterangan')->nullable();
            
            // Timestamps (created_at, updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_barangretur');
    }
};
