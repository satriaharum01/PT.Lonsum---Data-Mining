<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 'laporan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'petugas_id',
        'wilayah_kerja_id',
        'tanaman_id',
        'opt_id',
        'periode',
        'bulan_tahun',
        'luas_tanaman',
        'r_serang',
        's_serang',
        'b_serang',
        'p_serang',
        'r_keadaan',
        's_keadaan',
        'b_keadaan',
        'p_keadaan',
        'pemusnahan',
        'pestisida',
        'AH',
        'cara_lain',
    ];
    protected $inputType = [
        'petugas_id' => 'select',
        'wilayah_kerja_id' => 'select',
        'tanaman_id' => 'select',
        'opt_id' => 'select',
        'periode' => 'select',
        'bulan_tahun' => 'month',
        'luas_tanaman' => 'number',
        'r_serang' => 'number',
        's_serang' => 'number',
        'b_serang' => 'number',
        'p_serang' => 'number',
        'r_keadaan' => 'number',
        's_keadaan' => 'number',
        'b_keadaan' => 'number',
        'p_keadaan' => 'number',
        'pemusnahan' => 'number',
        'pestisida' => 'number',
        'AH' => 'number',
        'cara_lain' => 'number',
    ];


    public function getField()
    {
        return $this->inputType;
    }

    public function cariPetugas()
    {
        return $this->belongsTo('App\Models\Petugas', 'petugas_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn ($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }

    public function cariWilayahKerja()
    {
        return $this->belongsTo('App\Models\WilayahKerja', 'wilayah_kerja_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn ($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }

    public function cariTanaman()
    {
        return $this->belongsTo('App\Models\Tanaman', 'tanaman_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn ($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }

    public function cariOPT()
    {
        return $this->belongsTo('App\Models\OPT', 'opt_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn ($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }

    public function verifikasi()
    {
        return $this->hasOne(Verifikasi::class, 'laporan_id');
    }
}
