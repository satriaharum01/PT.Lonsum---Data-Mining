<?php

namespace App\Http\helpers;

class Formula
{
    public static $chartColor = [
        'red', 'green','blue','yellow','cyan'
    ];

    public static $chartColor2 = [
        'yellow','blue','yellow','cyan'
    ];

    public static $tingkatKerusakan = [
        'ringan','sedang','berat','puso'
    ];

    public static $level = [
        'Administrator','Manajer','SPV'
    ];

    public static $periode = [
        '1-15','16-30'
    ];
    public static $serangan_array = array('r_serang','s_serang','b_serang','p_serang');
    public static $serangan = [
        'r_serang' => 'Ringan',
        's_serang' => 'Sedang',
        'b_serang' => 'Berat',
        'p_serang' => 'Puso'
    ];

    public static $keadaan_array = array('r_keadaan','s_keadaan','b_keadaan','p_keadaan');
    public static $keadaan = [
        'r_keadaan' => 'Ringan',
        's_keadaan' => 'Sedang',
        'b_keadaan' => 'Berat',
        'p_keadaan' => 'Puso'
    ];

    public static $pengendalian_array = array('pemusnahan','pestisida','AH','cara_lain');
}
