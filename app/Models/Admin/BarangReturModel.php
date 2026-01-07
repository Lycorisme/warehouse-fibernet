<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangReturModel extends Model
{
    use HasFactory;
    protected $table = "tbl_barangretur";
    protected $primaryKey = 'retur_id';
    protected $fillable = [
        'retur_kode',
        'barang_kode',
        'retur_tanggal',
        'retur_jumlah',
        'retur_keterangan',
    ];
}
