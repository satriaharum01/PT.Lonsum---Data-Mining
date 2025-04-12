import React, { useState, useEffect } from 'react';
import axios from 'axios';
import DataTable from "datatables.net-react";
import DT from "datatables.net-bs5";
import Swal from 'sweetalert2';
import Api from '../api';

DataTable.use(DT);

const History = ({ subTitle, title }) => {
  const [prediksiList, setPrediksi] = useState([]);
  const [dataList, setDataList] = useState([]);

  const deletePost = async (id) => {
    //delete with api
    await Api.delete(`/data/prediksi/delete/${id}`)
      .then(() => {
        setDataList([]);
        fetchDataList();
      })
  }

  useEffect(() => {
    fetchDataList();
  }, []);

  const fetchDataList = () => {
    axios.get('/get/prediksi/')
      .then((response) => {
        const resultData = response.data.data;
        setDataList(resultData);
      })
      .catch((error) => {
        console.error('Gagal load data:', error);
      });
  };

  useEffect(() => {
    // Attach event listener setiap kali tabel selesai dirender ulang
    $("body").on("click", ".btn-eye", function () {
      const id = $(this).data("id");
      const prediksi = prediksiList.find((p) => p.id === id);
      handleEditClick(prediksi);
    });
    // Bersihkan event listener saat component unmount
    return () => {
      $("body").off("click", ".btn-edit");
    };
  }, [prediksiList]);

  useEffect(() => {
    // Attach event listener setiap kali tabel selesai dirender ulang
    $("body").on("click", ".btn-hapus", function () {
      const id = $(this).data("id");
      Swal.fire({
        title: 'Hapus Data ?',
        text: "Data yang dihapus tidak dapat dikembalikan !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.value) {
          Swal.fire({
            title: "Hapus Berhasil!",
            text: 'Data Berhasil dihapus !',
            icon: "success"
          });
          deletePost(id);
        }
      });
    });
    // Bersihkan event listener saat component unmount
    return () => {
      $("body").off("click", ".btn-hapus");
    };
  }, []);

  // Define columns for DataTable
  const columns = [
    {
      data: 'DT_RowIndex'
    },
    {
      data: 'timestamp'
    },
    {
      data: 'nama_barang'
    },
    {
      data: 'alpha'
    },
    {
      data: 'beta'
    },
    {
      data: 'start'
    },
    {
      data: 'end'
    },
    {
      data: 'id',
      render: function (data) {
        return '<button class="btn btn-primary btn-eye d-none" data-id="' + data + '" > <i class="fa fa-eye"></i></button>\
          <button class="btn btn-danger btn-hapus" data-id="' + data + '" > <i class="fa fa-trash"></i></button>';
      },
    },
  ];

  return (
    <div className="my-3 my-md-5">
      <div className="container">
        <div className="row">
          <div className="col-md-12 col-xl-12">
            <div className="card">
              <div className="card-header d-flex justify-content-between align-items-center">
                <h3 className="card-title">{subTitle}</h3>
                <div className="card-options align-items-center">
                </div>
              </div>
              <div className="card-body" id="card-main">
                <div className="table-responsive">
                  <DataTable
                    columns={columns}
                    data={dataList}
                    pagination className="table table-hover" id="data-width" width="100%"
                  >
                    <thead>
                      <tr>
                        <th width="10%"></th>
                        <th>Timestamp</th>
                        <th className="text-primary text-center" width="20%">Nama Barang</th>
                        <th className="text-primary text-center">Alpha</th>
                        <th className="text-primary text-center">Beta</th>
                        <th className="text-primary text-center">Peridoe Awal</th>
                        <th className="text-primary text-center">Peridoe Akhir</th>
                        <th className="text-primary text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody className='text-center'></tbody>
                  </DataTable>
                </div>
              </div>
              <div className="card-footer d-flex justify-content-between">
                <div>
                  {import.meta.env.VITE_APP_NAME} - {title}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default History;
