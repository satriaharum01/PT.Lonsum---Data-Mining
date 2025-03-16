<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipments extends Model
{
    use HasFactory;
    protected $table = 'shipments';
    protected $primaryKey = 'id';
    protected $fillable = ['partner_id','tracking_number','type','cod_amount','delivery_fee'];
    protected $inputType = [
        'partner_id' => 'select',
        'tracking_number' => 'text',
        'type' => 'select',
        'cod_amount' => 'number',
        'delivery_fee' => 'number'
    ];

    public function getField()
    {
        return $this->inputType;
    }

    public function cariPartners()
    {
        return $this->belongsTo('App\Models\Partners', 'partner_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn ($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }
}
