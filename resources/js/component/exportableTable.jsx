import React from 'react';

const ExportableTable = ({ data }) => {
  return (
    <table id="hidden-export-table">
      <thead>
        <tr>
          <th>Periode</th>
          <th>Jumlah (X)</th>
          <th>Single (S't)</th>
          <th>Double (S''t)</th>
          <th>Triple (S'''t)</th>
          <th>At</th>
          <th>Bt</th>
          <th>Ct</th>
          <th>Forecast</th>
        </tr>
      </thead>
      <tbody>
        {data.map((row, i) => (
          <tr key={i}>
            <td>{row.tanggal}</td>
            <td>{row.jumlah}</td>
            <td>{row.single}</td>
            <td>{row.double}</td>
            <td>{row.triple}</td>
            <td>{row.at}</td>
            <td>{row.bt}</td>
            <td>{row.ct}</td>
            <td>{row.forecast}</td>
          </tr>
        ))}
      </tbody>
    </table>
  );
};

export default ExportableTable;
