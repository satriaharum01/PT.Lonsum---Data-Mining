<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;
    protected $table = 'verifikasi';
    protected $primaryKey = 'id';
    protected $fillable = ['laporan_id','verifikator_id','status','catatan','tanggal_verifikasi'];
    protected $inputType = [
        'laporan_id' => 'select',
        'verifikator_id' => 'select',
        'status' => 'select',
        'catatan' => 'text',
        'tanggal_verifikasi' => 'date'
    ];

    public function getField()
    {
        return $this->inputType;
    }
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }
}
