<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_barang','satuan'];
    protected $inputType = [
        'nama_barang' => 'text',
        'satuan' => 'text'
    ];

    public function getField()
    {
        return $this->inputType;
    }

    public function pengadaan()
    {
        return $this->hasMany(Pengadaan::class, 'id_barang');
    }

    public function prediksi()
    {
        return $this->hasMany(Prediksi::class, 'id_barang');
    }
}
