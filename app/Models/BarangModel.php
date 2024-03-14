<?php

namespace app\Models;

use illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\Relations\HasMany;

class BarangModel extends Model
{
    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';

    protected $fillable = ['barang_kode', 'barang_nama' , 'harga_beli', 'harga_jual'];


}
