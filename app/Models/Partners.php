<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    use HasFactory;
    protected $table = 'partners';
    protected $primaryKey = 'id';
    protected $fillable = ['district_id','name','partner_id','job_title'];
    protected $inputType = [
        'district_id' => 'select',
        'name' => 'text',
        'partner_id' => 'number',
        'job_title' => 'select'
    ];

    public function getField()
    {
        return $this->inputType;
    }

    public function cariDistrics()
    {
        return $this->belongsTo('App\Models\Districs', 'kabupaten_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn ($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }
}
