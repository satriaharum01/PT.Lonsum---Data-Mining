<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    use HasFactory;
    protected $table = 'prediksi';
    protected $primaryKey = 'id';
    protected $fillable = ['id_barang','startPeriod','endPeriod','alpha','beta'];
    protected $inputType = [
        'id_barang' => 'select',
        'startPeriod' => 'month',
        'endPeriod' => 'month',
        'alpha' => 'number',
        'beta' => 'number',
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
