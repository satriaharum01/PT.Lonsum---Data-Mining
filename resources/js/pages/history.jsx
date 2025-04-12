import React, { useState, useEffect } from 'react';
import axios from 'axios';
import DataTable from "datatables.net-react";
import DT from "datatables.net-bs5";
import Swal from 'sweetalert2';
import Api from '../api';
import FilterModal from '../component/filterModalHistory';

DataTable.use(DT);

const History = ({ subTitle, title }) => {

  const [showModal, setShowModal] = useState(false);
  const [historyList, setHistory] = useState([]);
  const [dataList, setDataList] = useState([]);

  const deletePost = async (id) => {
    //delete with api
    await Api.delete(`/data/history/delete/${id}`)
      .then(() => {
        setDataList([]);
        fetchDataList();
      })
  }

  useEffect(() => {
    fetchDataList();
  }, []);
  const reFetchData = (data) => {
    setDataList([]);
    setDataList(data.data);
  }
  const fetchDataList = () => {
    axios.get('/get/history/')
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
      const history = historyList.find((p) => p.id === id);
      handleEditClick(history``);
    });
    // Bersihkan event listener saat component unmount
    return () => {
      $("body").off("click", ".btn-edit");
    };
  }, [historyList]);

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
      data: 'tanggal'
    },
    {
      data: 'nama_barang'
    },
    {
      data: 'jumlah'
    },
  ];

  return (
    <>
      <div className="my-3 my-md-5">
        <div className="container">
          <div className="row">
            <div className="col-md-12 col-xl-12">
              <div className="card">
                <div className="card-header d-flex justify-content-between align-items-center">
                  <h3 className="card-title">{subTitle}</h3>
                  <div className="card-options align-items-center">
                    <button className="btn btn-success btn-filter mx-2" onClick={() => setShowModal(true)}><i className="fa fa-filter"></i> Filter</button>

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
                          <th className="text-primary text-center">Timestamp</th>
                          <th className="text-primary text-center">Tanggal</th>
                          <th className="text-primary text-center" width="30%">Sumber Daya</th>
                          <th className="text-primary text-center">Jumlah</th>
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
      <FilterModal
        show={showModal}
        onHide={() => setShowModal(false)}
        onApply={(data) => reFetchData(data)}
      />
    </>
  );
};

export default History;
