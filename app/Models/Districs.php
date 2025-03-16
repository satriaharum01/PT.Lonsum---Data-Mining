<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districs extends Model
{
    use HasFactory;
    protected $table = 'districs';
    protected $primaryKey = 'id';
    protected $fillable = ['province_id','nama'];
    protected $inputType = [
        'province_id' => 'text',
        'nama' => 'text'
    ];

    public function cariProvinsi()
    {
        return $this->belongsTo('App\Models\Provinsi', 'province_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn ($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }

    public function getField()
    {
        return $this->inputType;
    }
}
