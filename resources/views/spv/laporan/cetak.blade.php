@extends('backend.cetak')
@section('title','Cetak Prediksi')
@section('content')
<?php
error_reporting(0);
$tgla = $start;
$tglk = $end;
$bulan = array(
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
);

$array1 = explode("-", $tgla);
$tahun = $array1[0];
$bulan1 = $array1[1];
$hari = $array1[2];
$bl1 = $bulan[$bulan1];
$tgl1 =  $bl1 . ' ' . $tahun;

$no = 1;
$array2 = explode("-", $tglk);
$tahun2 = $array2[0];
$bulan2 = $array2[1];
$hari2 = $array2[2];
$bl2 = $bulan[$bulan2];
$tgl2 =   $bl2 . ' ' . $tahun2;
$total = 0;
?>

<div class="my-5 my-md-5">
  <div class="container">
    <div class="row">
    <div class="cold-md-12 col-xl-12">
        <span class="login-form-title">
            <center>
                <div style="display: flex;flex-direction: row;justify-content: center; height:50%;">
                    <img src="{{asset('assets/img/logo.png')}}" class="pr-2" alt="logo">
                    <div class="print-content">
                        <h4 style="margin-bottom:0px;">
                        PT. LONSUM <br>
                        </h4>
                        <?= env('APP_ADDRESS')?>
                        <br>
                        Telp / Hp : <i class="fas fa-building "></i> 061 42771589
                        <br>
                    </div>
                </div>
                </center>
        </span>
    </div>
      <div class="col-md-12 col-xl-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">Laporan Prediksi</h3>
            <h3 class="card-title font-weight-bold">Barang: {{$barang}}</h3>
          </div>

          <div class="card-header d-flex justify-content-between align-items-center">

          <h3 class="card-title font-weight-bold">Periode: {{$tgl1}} s/d {{$tgl2}}</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="data-predict" width="100%">
                <thead class="text-center text-black">
                  <tr>
                    <th class="text-primary">Periode</th>
                    <th class="text-primary">Jumlah (X)</th>
                    <th class="text-primary">Singel (S't)</th>
                    <th class="text-primary">Double (S''t)</th>
                    <th class="text-primary">Triple (S'''t)</th>
                    <th class="text-primary">Konstanta (At)</th>
                    <th class="text-primary">Konstanta (Bt)</th>
                    <th class="text-primary">Konstanta (Ct)</th>
                    <th class="text-primary">Peramalan TES</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                <?php foreach ($prediksiList as $data): ?>
                    <tr>
                      <td><?= $data['tanggal'] ?></td>
                      <td><?= $data['jumlah'] ?></td>
                      <td><?= $data['single'] ?></td>
                      <td><?= $data['double'] ?></td>
                      <td><?= $data['triple'] ?></td>
                      <td><?= $data['at'] ?></td>
                      <td><?= $data['bt'] ?></td>
                      <td><?= $data['ct'] ?></td>
                      <td><?= $data['forecast'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card-footer d-flex justify-content-between">
            <div>
              <?= env('APP_NAME') ?> - Laporan Prediksi
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('js')


@endsection