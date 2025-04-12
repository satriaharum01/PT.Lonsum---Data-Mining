import React, { useState, useEffect } from 'react';
import { Modal, Button, Form } from 'react-bootstrap';
import axios from 'axios';

const FilterModal = ({ show, onHide, onApply }) => {
    const [barangId, setBarangId] = useState('0');
    const [periode, setPeriode] = useState('');
    const [tahunList, setTahunList] = useState([]);
    const [barangList, setBarangList] = useState([]);

    useEffect(() => {
        axios.get('/get/pengadaan/tahun')
            .then(res => setTahunList(res.data))
            .catch(err => console.error(err));

        axios.get('/get/barang/')
            .then((response) => {
                const resultData = response.data.data;
                setBarangList(resultData);
            })
            .catch((error) => {
                console.error('Gagal mengambil data:', error);
            });
    }, []);

    const handleTerapkan = (e) => {
        e.preventDefault();
        
        const params = new URLSearchParams({
            id_barang: barangId,
            periode: periode,
        }).toString();

        axios.get(`/get/history/filter?${params.toString()}`)
            .then(res => {
                onApply(res.data); // lempar ke parent buat update table
            })
            .catch(err => {
                console.error('Filter Error:', err);
            });
        onHide(); // tutup modal
    };

    return (
        <Modal show={show} onHide={onHide} centered>
            <Form onSubmit={handleTerapkan}>
                <Modal.Header>
                    <Modal.Title className="w-100 text-center">Cari Data</Modal.Title>
                </Modal.Header>

                <Modal.Body>
                    <Form.Group>
                        <Form.Label>Sumber Daya</Form.Label>
                        <Form.Control
                            as="select"
                            value={barangId}
                            onChange={(e) => setBarangId(e.target.value)}
                            name="id_barang"
                        >
                            <option value="0">Semua Sumber Daya</option>
                            {barangList.map((row) => (
                                <option key={row.id} value={row.id}>
                                    {row.nama_barang}
                                </option>
                            ))}
                        </Form.Control>
                    </Form.Group>

                    <Form.Group>
                        <Form.Label>Periode</Form.Label>
                        <Form.Control
                            as="select"
                            value={periode}
                            onChange={(e) => setPeriode(e.target.value)}
                            name="periode"
                        >
                            <option value="">Semua Periode</option>
                            {tahunList.map(tahun => (
                                <option key={tahun} value={tahun}>
                                    {tahun}
                                </option>
                            ))}
                            {/* Tambahkan sesuai kebutuhan */}
                        </Form.Control>
                    </Form.Group>
                </Modal.Body>

                <Modal.Footer>
                    <Button type="submit" className="btn btn-terapkan btn-primary">
                        Terapkan
                    </Button>
                    <Button variant="danger" onClick={onHide}>
                        Close
                    </Button>
                </Modal.Footer>
            </Form>
        </Modal>
    );
};

export default FilterModal;
