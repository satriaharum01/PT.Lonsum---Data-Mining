<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    use HasFactory;
    protected $table = 'notif';
    protected $primaryKey = 'id';
    protected $fillable = ['judul','status','icon','color','id_user'];

    
    public function cari_user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id')->withDefault([
            'name' => 'Anonim',
            'email'  => 'Anonim'
        ]);
    }
}
