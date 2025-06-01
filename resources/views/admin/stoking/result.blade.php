@extends('backend.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="my-3 my-md-5">
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$sub_title}}</h3>
                    </div>
                    <div class="card-body" id="card-main">
                        <form action="{{ route('admin.stoking.preview').'/process' }}" class=" row" method="POST">

                            <div class="col-md-6">
                                @csrf
                                <input type="hidden" name="raw_data" value="{{ json_encode($raw) }}">
                                <h3 class="pb-0 mb-0">Data List</h3>
                                <small class="text-danger pb-2">Catatan: format tanggal harus YYYY-mm-dd</small>
                                <table border="1" class="table table-hover" width="50%">
                                    <thead>
                                        <tr>
                                            @foreach ($data[0] as $colIndex => $val)
                                            <th class="text-primary">Kolom {{ chr(65 + $colIndex) }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $row)
                                        <tr>
                                            @foreach ($row as $val)
                                            <td>{{ $val }}</td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 row">
                                <div class="col-md-12">
                                    <h3>Mapping Kolom</h3>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal:</label>
                                        <select class="form-control" name="mapping[tanggal]">
                                            @foreach ($data[0] as $i => $val)
                                            <option value="{{ $i }}">Kolom {{ chr(65 + $i) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Jumlah:</label>
                                        <select class="form-control" name="mapping[jumlah]">
                                            @foreach ($data[0] as $i => $val)
                                            <option value="{{ $i }}">Kolom {{ chr(65 + $i) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Sumber Daya:</label>
                                        <select class="form-control" name="id_barang" id="id_barang">
                                            @foreach($barang as $row)
                                            <option value="{{ $row->id }}">{{$row->nama_barang}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger float-right mx-2" onclick="window.location.href='{{ route('admin.stoking') }}'">Kembali</button>
                                    <button type="submit" class="btn btn-primary float-right">Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection