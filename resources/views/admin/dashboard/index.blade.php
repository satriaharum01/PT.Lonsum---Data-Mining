@extends('backend.app')

@section('content')
        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>
            <div class="row row-cards">
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <i class="fe fe-chevron-up"></i>
                    </div>
                    <div class="h1 m-0">{{$laporan}}</div>
                    <div class="text-muted mb-4">Laporan</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-red">
                      <i class="fe fe-chevron-down"></i>
                    </div>
                    <div class="h1 m-0">{{$laporan_menunggu}}</div>
                    <div class="text-muted mb-4">Laporan Menunggu</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <i class="fe fe-chevron-up"></i>
                    </div>
                    <div class="h1 m-0">{{$laporan_verifikasi}}</div>
                    <div class="text-muted mb-4">Laporan Terverifikasi</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <i class="fe fe-chevron-up"></i>
                    </div>
                    <div class="h1 m-0">{{$kabupaten}}</div>
                    <div class="text-muted mb-4">Kabupaten</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <i class="fe fe-chevron-up"></i>
                    </div>
                    <div class="h1 m-0">{{$tanaman}}</div>
                    <div class="text-muted mb-4">Tanaman</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-red">
                      <i class="fe fe-chevron-down"></i>
                    </div>
                    <div class="h1 m-0">{{$opt}}</div>
                    <div class="text-muted mb-4">OPT</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-xl-12">
                  <div class="card">
                    <div class="card-header card-header justify-content-between">
                      <h3 class="card-title">Rekaptulasi Laporan</h3>
                      <div>
                      <button class="float-right btn btn-danger btn-print mx-1"><i class="fa fa-print"></i></button>
                      <button class="float-right btn btn-success btn-excel mx-1"><i class="fa fa-file-excel"></i></button>
                      
                      </div>
                    </div>
                    <div class="card-body " id="card-main">
                        <div class="table-responsive">
                          <table class="table table-hover" id="data-width" width="100%">
                              <thead>
                                <tr>
                                  <th class="text-primary text-center align-content-around" rowspan="2">Kabupaten</th>
                                  <th class="text-primary text-center align-content-around" rowspan="2">Komoditas</th>
                                  <th class="text-primary text-center align-content-around" rowspan="2">Periode</th>
                                  <th class="text-primary text-center align-content-around" rowspan="2">OPT</th>
                                  <th class="text-primary text-center" colspan="5">Luas Terserang</th>
                                </tr>
                                <tr>
                                  <th class="text-primary">R</th>
                                  <th class="text-primary">S</th>
                                  <th class="text-primary">B</th>
                                  <th class="text-primary">P</th>
                                  <th class="text-primary">J</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div>
                          {{env('APP_NAME')}} - {{$title}}
                        </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="row row-cards">
                @include('models.barChart', ['chartValue' => $chartValue,'chartColor'=> $chartColor])
            </div>
          </div>
        </div>
@endsection
@section('js')
<script>
  $(function () {
      table = $("#data-width").DataTable({
        searching: false,
        paging: false,
        lengthChange: false,
        info: false,
        ordering: false,
        ajax: '{{Request::url() }}/json',
        columns: [
          {
            data: "nama_kabupaten",
            className: "text-center",
          },
          {
            data: "tanaman",
            className: "text-center",
          },
          {
            data: "periode",
            className: "text-center",
          },
          {
            data: "jenis_opt",
            className: "text-center",
          },
          {
            data: "r_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "s_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "b_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "p_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "j_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
        ],
      });
  });
</script>

<script>
    const value = @json($chartValue);
    const chartColor = @json($chartColor);

    // Menghitung data tertinggi dari semua dataset
    let maxDataValue = 0;
    Object.keys(value.data).forEach(key => {
        const maxInDataset = Math.max(...value.data[key].map(item => parseFloat(item)));
        if (maxInDataset > maxDataValue) {
            maxDataValue = maxInDataset;
        }
    });

    // Menentukan max untuk sumbu Y sebagai 40% dari data tertinggi
    const yMax = maxDataValue * 2;
    const stepSize = Math.ceil(yMax / 10);

    const ctx = document.getElementById('grafikSerangan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: value.labels,
            datasets: Object.keys(value.data).map((key, index) => ({
                label: key,
                data: value.data[key].map(item => parseFloat(item)), 
                borderColor: chartColor[index],
                backgroundColor: chartColor[index], 
                fill: false
            }))
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    max: yMax,
                    suggestedMax: yMax,
                    stepSize: stepSize,
                    title: {
                        display: true,
                        text: 'Luas Serangan (ha)'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
</script>
<script>
    // Membuat dataset untuk chart donat
    const totalData = Object.keys(value.data).map((key, index) => ({
        label: key,
        total: value.data[key].reduce((sum, item) => sum + parseFloat(item), 0), // Menjumlahkan semua item untuk setiap kategori
        backgroundColor: chartColor[index], // Warna untuk setiap kategori
        borderColor: 'rgba(255, 255, 255, 0.3)', // Warna border
        borderWidth: 1
    }));
    
    const cty = document.getElementById('grafikSeranganBulat').getContext('2d');
    new Chart(cty, {
        type: 'doughnut', // Jenis chart menjadi doughnut
        data: {
            labels: totalData.map(item => item.label), // Menggunakan label dari totalData
            datasets: [{
                data: totalData.map(item => item.total), // Menggunakan total dari setiap kategori
                backgroundColor: totalData.map(item => item.backgroundColor), // Menggunakan warna yang sesuai
                borderColor: totalData.map(item => item.borderColor),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                },
                // Menambahkan label di tengah chart
                datalabels: {
                    display: true,
                    formatter: function (value, context) {
                        return value.toFixed(2); // Menampilkan nilai dengan 2 angka desimal
                    },
                    color: 'white',
                    font: {
                        weight: 'bold',
                        size: 14
                    }
                }
            }
        }
    });
</script>

<script>
  var tableId = 'data-width';
  function exportTableToExcel(tableId) {
    // Get the table element using the provided ID
    const table = document.getElementById(tableId);

    // Extract the HTML content of the table
    const html = table.outerHTML;

    // Create a Blob containing the HTML data with Excel MIME type
    const blob = new Blob([html], { type: "application/vnd.ms-excel" });

    // Create a URL for the Blob
    const url = URL.createObjectURL(blob);

    // Create a temporary anchor element for downloading
    const a = document.createElement("a");
    a.href = url;

    // Set the desired filename for the downloaded file
    a.download = "Rekaptulasi Laporan.xls";

    // Simulate a click on the anchor to trigger download
    a.click();

    // Release the URL object to free up resources
    URL.revokeObjectURL(url);
  }
  
  function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
  }

  $("body").on("click", ".btn-excel", function () {
    exportTableToExcel(tableId);
  })
  
  $("body").on("click", ".btn-print", function () {
    printDiv('card-main');
  })
</script>

@endsection