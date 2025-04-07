<?php
use App\Http\helpers\Formula;
// Atur kolom berdasarkan total fields
    if ($totalFields %3 == 0 ) {
        $colLg = 4;
        $colMd = 6;
    } elseif ($totalFields == 2) {
        $colLg = 6;
        $colMd = 12;
    } elseif ($totalFields == 4) {
        $colLg = 3;
        $colMd = 3;
    } else {
        $colLg = 12;
        $colMd = 12;
    }
?>

<div class="col-md-{{$colMd}} col-lg-{{$colLg}}">
    <div class="form-group">
        <label class="form-label">{{ucwords(str_replace(['_id', '_'], [' ', ' '], $field))}}</label>
        @if ($type == 'textarea')
        <textarea class="form-control" name="{{$field}}" cols="30" rows="3">{{$value}}</textarea>
        @elseif($type == 'select')
        <select class="form-control" name="{{$field}}" id="{{$field}}">
            @if($field == 'tingkat_kerusakan')
                @foreach(Formula::$tingkatKerusakan as $row)
                <option value="{{$row}}" @if($row == $value) selected @endif>{{ucfirst($row)}}</option>
                @endforeach
            @elseif($field == 'level')
                <option value="0" selected disabled>-- Pilih {{ucwords(str_replace(['_id', '_'], [' ', ' '], $field))}}</option>
                @foreach(Formula::$level as $row)
                <option value="{{$row}}" @if($row == $value) selected @endif>{{ucfirst($row)}}</option>
                @endforeach
            @else
            <option value="0" selected disabled>-- Pilih {{ucwords(str_replace(['_id', '_'], [' ', ' '], $field))}}</option>
            @endif
        </select>
        @else
        @if($type == 'number')
            <input type="{{$type}}" step="0.001" class="form-control" name="{{$field}}" value="{{$value}}"/>
        @elseif($type =='password')
            <input type="{{$type}}" class="form-control" name="{{$field}}"/>
        @else
            <input type="{{$type}}" class="form-control" name="{{$field}}" value="{{$value}}"/>
        @endif
        @endif
    </div>
</div>