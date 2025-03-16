<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $table = 'delivery';
    protected $primaryKey = 'id';
    protected $fillable = ['partner_id','shipment_id','status'];
    protected $inputType = [
        'partner_id' => 'select',
        'shipment_id' => 'select',
        'status' => 'select'
    ];

    public function getField()
    {
        return $this->inputType;
    }

    public function cariPartner()
    {
        return $this->belongsTo('App\Models\Partner', 'partner_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }
    
    public function cariShipment()
    {
        return $this->belongsTo('App\Models\Shipment', 'shipment_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }
}
