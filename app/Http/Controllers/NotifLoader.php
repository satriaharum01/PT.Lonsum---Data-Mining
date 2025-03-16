<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Exception;
use DataTables;

use App\Models\Notif;

class NotifLoader extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public static function notifMe()
    {
        $data = Notif::select('*')->where('status', 'wait')->orderby('created_at', 'DESC')->get(5);

        foreach($data as $row) {
            $days = strtotime($row->created_at);
            $row->days = date('F d, Y', $days);
        }

        return $data;
    }

    public static function notifAll()
    {
        $data = Notif::select('*')->where('status', 'wait')->get();

        foreach($data as $row) {
            $days = strtotime($row->created_at);
            $row->days = date('F d, Y', $days);
            $row->waktu = $this->get_hari($time->created_at);
            $a = explode(' ', $row->cari_user->name);
            $row->akun = $row->cari_user->name;
            $user = $a[0];
            $row->full_judul = $row->cari_user->level . '('.$user.') '.ucwords($row->judul);
        }

        return $data;
    }

    public static function countNotifme()
    {
        $data = Notif::select('*')->where('status', 'wait')->get()->count();
        if($data == 0) {
            return null;
        } else {

            return $data . '+';
        }
    }

    public function read($id)
    {
        $data = [
            'status' => 'read'
        ];

        $rows = Notif::find($id);

        $rows->update($data);

        return  json_encode([
            'message' => 'Dilihat'
        ]);
    }

    public function get_notif()
    {
        $data = Notif::select('*')->where('status', 'wait')->orderBy('created_at','DESC')->get();

        foreach($data as $row) {
            $days = strtotime($row->created_at);
            $row->days = date('F d, Y', $days);
            $a = explode(' ', $row->cari_user->name);
            $user = $a[0];
            $row->waktu = $this->get_hari($row->created_at);
            $row->akun = $row->cari_user->name;
            $row->full_judul = $row->cari_user->level . '('.$user.') '.ucwords($row->judul);
        }

        return json_encode(array('data' => $data));
    }


    public function hitung_hari($tanggal)
    {
        $date1 = date('Y-m-d');
        $date2 = $tanggal;
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        return $days;
    }

    public function get_hari($tanggal)
    {
        $selisih = $this->hitung_hari($tanggal);
        $jam = date('h:i A', strtotime($tanggal));
        if($selisih < 1) {
            $result = $jam;
        } elseif($selisih == 1) {
            $result = 'Kemarin, ' . $jam;
        } elseif ($selisih <= 7) {
            $result = $this->hari[date('N', strtotime($tanggal))] . date(' d M,', strtotime($tanggal)) . date(' h:i A', strtotime($tanggal));
        } else {
            $result = date(' d M,', strtotime($tanggal)) . date(' h:i A', strtotime($tanggal));
        }

        return $result;
    }
}
