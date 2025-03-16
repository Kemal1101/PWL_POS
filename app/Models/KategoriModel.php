<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriModel extends Model
{
    use HasFactory;

    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';

    protected $fillable = ['kategori_nama', 'kategori_kode', 'created_at'];

    public function barang(): HasMany{
        return $this->hasMany(BarangModel::class, 'barang_id', 'barang_id');
    }
}
