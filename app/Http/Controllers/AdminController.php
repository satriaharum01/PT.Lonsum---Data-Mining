<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Billing;
use App\Models\Doctors;
use App\Models\MedicalRecords;
use App\Models\Patients;
use App\Models\Prescriptions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['title'] = 'Dashboard Admin';
        $this->data['c_patients'] = $this->count_patients();
        $this->data['c_doctors'] = $this->count_doctors();
        $this->data['c_appointments'] = $this->count_appointments();
        $this->data['c_payments'] = $this->count_payments();

        $this->data['chart'] = $this->graph_area();
        return view('admin/dashboard/index', $this->data);
    }

    public function appointment()
    {
        $this->data['title'] = 'Data Appointment';
        $this->data[ 'link' ] = '/admin/appointment';
        $this->data['page'] = 'admin/appointment';
        $this->view = 'admin/appointment/index';
        return view($this->view, $this->data);
    }

    public function billing()
    {
        $this->data['title'] = 'Data Pembayaran';
        $this->data[ 'link' ] = '/admin/billing';
        $this->data['page'] = 'admin/billing';
        $this->view = 'admin/billing/index';
        return view($this->view, $this->data);
    }

    public function doctors()
    {
        $this->data['title'] = 'Data Dokter';
        $this->data[ 'link' ] = '/admin/dokter';
        $this->data['page'] = 'admin/dokter';
        $this->view = 'admin/dokter/index';
        return view($this->view, $this->data);
    }

    public function patients()
    {
        $this->data['title'] = 'Data Pasien';
        $this->data[ 'link' ] = '/admin/pasien';
        $this->data['page'] = 'admin/pasien';
        $this->view = 'admin/pasien/index';
        return view($this->view, $this->data);
    }

    //COUNTERS
    public function count_patients()
    {
        $data = Patients::select('*')->count();

        return $data;
    }

    public function count_doctors()
    {
        $data = Doctors::select('*')->count();

        return $data;
    }

    public function count_appointments()
    {
        $data = Appointments::select('*')->count();

        return $data;
    }

    public function count_payments()
    {
        $data = Billing::select('*')->where('payment_status', 'Paid')->sum('total_amount');

        return number_format($data, 0);
    }

    //GRAPH
    public function graph_area()
    {
        $out = array();
        $date = date('Y-');
        for ($i = 1; $i <= 12 ; $i++) {
            if ($i < 10) {
                $finder = $date.'0'.$i;
            } else {
                $finder = $date.$i;
            }
            $data = Appointments::select('*')->where('created_at', '>=', $finder.'-00')->where('created_at', '<=', $finder.'-31')->get();
            $result = 0;
            $out[] = $result;
        }

        return json_encode($out);
    }
}
