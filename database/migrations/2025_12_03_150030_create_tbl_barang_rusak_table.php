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
        Schema::create('tbl_barangrusak', function (Blueprint $table) {
            $table->increments('br_id'); 
            $table->string('barang_kode', 255); 
            $table->date('br_tanggal');
            $table->integer('br_jumlah');
            $table->text('br_keterangan')->nullable(); 
            $table->string('br_status', 50)->default('Rusak');
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
        Schema::dropIfExists('tbl_barangrusak');
    }
};
