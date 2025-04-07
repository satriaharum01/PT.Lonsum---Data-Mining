<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;
    protected $table = 'pengadaan';
    protected $primaryKey = 'id';
    protected $fillable = ['id_barang','tanggal','jumlah'];
    protected $inputType = [
        'id_barang' => 'select',
        'tanggal' => 'date',
        'jumlah' => 'number'
    ];

    public function getField()
    {
        return $this->inputType;
    }
    
    public function cariBarang()
    {
        return $this->belongsTo('App\Models\Barang', 'id_barang', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn ($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }
}
