// resources/js/App.jsx
import React, { useState, useEffect } from 'react';
const APP_NAME = 'PT. Lonsum';
import axios from 'axios';
import DataTable from "datatables.net-react";
import DT from "datatables.net-bs5";
import Swal from 'sweetalert2';

DataTable.use(DT);
const CetakPrediksi = () => {
  const [awal, setAwal] = useState(null);
  const [akhir, setAkhir] = useState(null);
  const [alpha, setAlpha] = useState(0.1);
  const [beta, setBeta] = useState(0.1);
  const [barang, setBarang] = useState('0');
  const [filter, setFilter] = useState('0');
  const [disabled, setDisabled] = useState(true);
  const [barangList, setBarangList] = useState([]);
  const [prediksiList, setPrediksiList] = useState([]);

  useEffect(() => {
    // Cek apakah semua field sudah ada nilainya
    if (awal && akhir && barang) {
      setDisabled(false); // aktifin tombol
    } else {
      setDisabled(true); // disable tombol
    }
  }, [awal, akhir, barang]);

  useEffect(() => {

    axios.get('/get/barang/')
      .then((response) => {
        const resultData = response.data.data;
        setBarangList(resultData);
      })
      .catch((error) => {
        console.error('Gagal mengambil data:', error);
      });
  }, []);

  // Define columns for DataTable
  const columns = [
    {
      data: 'tanggal'
    },
    {
      data: 'jumlah'
    },
    {
      data: 'single'
    },
    {
      data: 'double'
    },
    {
      data: 'triple'
    },

    {
      data: 'at'
    },
    {
      data: 'bt'
    },
    {
      data: 'ct'
    },
    {
      data: 'forecast'
    },
  ];

  const fetchPredict = () => {
    axios.get("/admin/prediksi/analys'")
      .then(response => {
        setPrediksiList(response.data);
      })
      .catch(error => {
        console.error("There was an error fetching the data!", error);
      });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    // Validasi input awal
    if (!awal || !akhir || !barang) {
      Swal.fire({
        icon: 'warning',
        title: 'Data Tidak Lengkap',
        text: 'Awal, akhir, dan barang harus diisi.',
      });
      return;
    }

    // Tampilkan loading
    Swal.fire({
      title: 'Processing...',
      text: 'Please wait while we submit your data.',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    try {
      const response = await axios.get("/admin/prediksi/analys", {
        params: {
          awal,
          akhir,
          id: barang,
          alpha,
          beta,
          filter,
        },
      });

      // Tutup loading
      Swal.close();

      if (response.data && response.data.data) {
        setPrediksiList(response.data.data);
        console.log("Prediksi berhasil:", response.data);

        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: 'Data prediksi berhasil dimuat!',
        });
      } else {
        Swal.fire({
          icon: 'info',
          title: 'Tidak Ada Data',
          text: 'Tidak ditemukan hasil prediksi.',
        });
      }

    } catch (error) {
      Swal.close();
      console.error("Gagal melakukan prediksi:", error);

      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Terjadi kesalahan saat memuat data prediksi.',
      });
    }
  };

  useEffect(() => {
    fetchPredict();
  }, []);

  return (
    <div className="my-3 my-md-5">
      <div className="container">
        <div className="row">

          <div className="col-md-12 col-xl-12">
            <div className="card">
              <div className="card-header">
                <h3 className="card-title">Laporan Prediksi </h3>
                <div className="card-options align-items-center">

                </div>
              </div>
              <div className="row card-body" id="card-main">
                <div className='col-lg-12 text-center justify-content-center row'>
                  <label className="card-title col-lg-3 my-auto" style={{ marginTop: '1%' }}>Sumber Daya :</label>
                  <select id="id_barang"
                    className="form-control col-lg-4 my-auto p-2"
                    value={barang}
                    onChange={(e) => setBarang(e.target.value)}
                  >
                    <option value="">-- Pilih Sumber Daya</option>
                    {barangList.map((row) => (
                      <option key={row.id} value={row.id}>
                        {row.nama_barang}
                      </option>
                    ))}
                  </select>
                </div>
                <div className='col-lg-6 row d-none'>
                  <label className="card-title col-lg-4 my-auto" style={{ marginTop: '1%' }}>Hasil :</label>
                  <select
                    className="form-control col-lg-8 my-auto p-2"
                    value={filter}
                    onChange={(e) => setFilter(e.target.value)}
                  >
                    <option value="0" selected>Semua Hasil</option>
                    <option value="Sangat Baik">Sangat Baik</option>
                    <option value="Baik">Baik</option>
                    <option value="Wajar">Wajar</option>
                    <option value="Gagal">Gagal</option>
                  </select>
                </div>
              </div>
              <div className="card-body text-center">
                <div className='row'>
                  <div className='col-lg-12 justify-content-center row'>
                    <label className="card-title my-auto mx-2" style={{ marginTop: '1%' }}>Periode :</label>
                    <input className="form-control col-lg-4 my-auto p-2"
                      type="month"
                      value={awal}
                      onChange={(e) => setAwal(e.target.value)}
                    />
                    <label className="card-title my-auto mx-2" style={{ marginTop: '1%' }}>S/d :</label>
                    <input className="form-control col-lg-4 my-auto p-2"
                      type="month"
                      value={akhir}
                      onChange={(e) => setAkhir(e.target.value)}
                    />
                  </div>
                  <div className='col-lg-12 row mt-5 justify-content-center'>
                    <label className="card-title my-auto mx-2" style={{ marginTop: '1%' }}>Alpha :</label>
                    <input className="form-control col-lg-4 my-auto p-2"
                      type="number"
                      step="0.1"
                      max={0.9}
                      value={alpha}
                      onChange={(e) => setAlpha(Math.min(0.9, parseFloat(e.target.value)))}
                    />
                    <label className="card-title my-auto mx-2" style={{ marginTop: '1%' }}>Beta :</label>
                    <input className="form-control col-lg-4 my-auto p-2"
                      type="number"
                      step="0.1"
                      max={0.9}
                      value={beta}
                      onChange={(e) => setBeta(Math.min(0.9, parseFloat(e.target.value)))}
                    />
                  </div>
                </div>
              </div>
              <div className="card-body text-center">
                <button className="btn btn-primary" onClick={handleSubmit} disabled={disabled}>
                  <i className="fa fa-search"></i> Prediksi
                </button>
              </div>
              <div className="card-body">
                <div className="table-responsive">
                  <DataTable
                    columns={columns}
                    data={prediksiList}
                    pagination className="table table-hover" id="data-predict" width="100%"
                  >
                    <thead className="text-center text-primary">
                      <tr>
                        <th style={{ verticalAlign: 'middle', textAlign: 'center' }}>
                          Tanggal
                        </th>
                        <th style={{ verticalAlign: 'middle', textAlign: 'center' }}>
                          Jumlah (X)
                        </th>
                        <th style={{ verticalAlign: 'middle', textAlign: 'center' }}>
                          Singel (S't)
                        </th>
                        <th style={{ verticalAlign: 'middle', textAlign: 'center' }}>
                          Double (S''t)
                        </th>
                        <th style={{ verticalAlign: 'middle', textAlign: 'center' }}>
                          Triple (S'''t)
                        </th>
                        <th style={{ verticalAlign: 'middle', textAlign: 'center' }}>
                          Konstanta (At)
                        </th>
                        <th style={{ verticalAlign: 'middle', textAlign: 'center' }}>
                          Konstanta (Bt)
                        </th>
                        <th style={{ verticalAlign: 'middle', textAlign: 'center' }}>
                          Konstanta (Ct)
                        </th>
                        <th style={{ verticalAlign: 'middle', textAlign: 'center' }}>
                          Peramalan TES
                        </th>
                      </tr>
                    </thead>
                    <tbody className='text-center'></tbody>
                  </DataTable>
                </div>
              </div>

              <div className='card-footer d-flex justify-content-between'>
                <div>
                  {APP_NAME} - Laporan Prediksi
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );

};

export default CetakPrediksi;
