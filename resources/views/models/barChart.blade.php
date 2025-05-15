<div class="col-lg-4">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Data CPO</h3>
    </div>
    <div class="card-body p-3 text-center">
      <div class="h1 m-0">{{$cpo['data']}}</div>
      <div class="text-danger mb-4">{{$cpo['satuan']}}</div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Data FFB</h3>
    </div>
    <div class="card-body p-3 text-center">
      <div class="h1 m-0">{{$ffb['data']}}</div>
      <div class="text-success mb-4">{{$ffb['satuan']}}</div>
    </div>
  </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Sumber Daya</h3>
      </div>
      <canvas id="grafikResources" class="p-5" style="height: 20rem"></canvas>
    </div>
</div>
<div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Grafik Aktual/Prediksi</h3>
      </div>
      <canvas id="grafikAktual" style="height: 20rem"></canvas>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Grafik Aktual/Prediksi</h3>
      </div>
      <canvas id="grafikAktual2" style="height: 20rem"></canvas>
    </div>
</div>