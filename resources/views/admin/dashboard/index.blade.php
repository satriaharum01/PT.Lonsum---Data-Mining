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
                @include('models.barChart', ['chartValue' => $chartValue,'chartColor'=> $chartColor])
            </div>
          </div>
        </div>
@endsection
@section('js')

<script>
    const donatvalue = @json($donatValue);
    const value = @json($chartValue);
    const chartColor = @json($chartColor);
    const chartColor2 = @json($chartColor2);

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

    const ctx = document.getElementById('grafikAktual').getContext('2d');
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
    const totalData = Object.keys(donatvalue.data).map((key, index) => ({
        label: key,
        total: donatvalue.data[key].reduce((sum, item) => sum + parseFloat(item), 0), // Menjumlahkan semua item untuk setiap kategori
        backgroundColor: chartColor2[index], // Warna untuk setiap kategori
        borderColor: 'rgba(255, 255, 255, 0.3)', // Warna border
        borderWidth: 1
    }));
    
    const cty = document.getElementById('grafikResources').getContext('2d');
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