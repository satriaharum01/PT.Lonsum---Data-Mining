import React from "react";

const historyExportTable = ({ data }) => {
    return (
        <table id="hidden-export-table">
            <thead>
                <tr>
                    <th className="text-primary text-center">Period</th>
                    <th className="text-primary text-center" width="30%">
                        Sumber Daya
                    </th>
                    <th className="text-primary text-center">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                {data.map((row, i) => (
                    <tr key={i}>
                        <td>{row.periode}</td>
                        <td>{row.nama_barang}</td>
                        <td>{row.jumlah}</td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
};

export default historyExportTable;
