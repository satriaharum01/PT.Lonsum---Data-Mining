<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduksi extends Model
{
    use HasFactory;
    protected $table = 'deduksi';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','tanggal','amount','reason','status'];
    protected $inputType = [
        'user_id' => 'select',
        'tanggal' => 'date',
        'amount' => 'number',
        'reason' => 'text',
        'status' => 'select'
    ];

    public function getField()
    {
        return $this->inputType;
    }
}
