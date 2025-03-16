<?php
use App\Http\helpers\Formula;

?>

<div class="col-md-6 col-lg-3">
    @php
        $isSerangan = preg_match('/^(r_|s_|b_|p_)serang/', $field); // Menggunakan regex untuk pola field serangan
        $isKeadaan = in_array($field, Formula::$keadaan_array);
    @endphp

    @if($isSerangan && !$seranganLabelShown)
        @php $seranganLabelShown = true; @endphp
        <label class="section-label">Luas Tambah Serangan</label>
    @endif

    @if($isKeadaan && !$keadaanLabelShown)
        @php $keadaanLabelShown = true; @endphp
        <label class="section-label">Luas Keadaan Serangan</label>
    @endif

    <div class="form-group">
        <label class="form-label">
            {{ $isSerangan ? ucwords(Formula::$serangan[$field] ?? str_replace(['_id', '_'], [' ', ' '], $field)) : 
            ($isKeadaan ? ucwords(Formula::$keadaan[$field]) : ucwords(str_replace(['_id', '_'], [' ', ' '], $field))) }}
        </label>

        @if ($type == 'textarea')
            <textarea class="form-control" name="{{$field}}" cols="30" rows="3">{{$value}}</textarea>
        @elseif($type == 'select')
            <select class="form-control" name="{{$field}}" id="{{$field}}">
                @if($field == 'periode')
                    @foreach(Formula::$periode as $row => $val)
                        <option value="{{$row}}" @if($val == $value) selected @endif>{{ucfirst($val)}}</option>
                    @endforeach
                @else
                    <option value="0" selected disabled>-- Pilih {{ucwords(str_replace(['_id', '_'], [' ', ' '], $field))}}</option>
                @endif
            </select>
        @else
            @if($type == 'number')
                <input type="{{$type}}" step="0.001" class="form-control" name="{{$field}}" value="{{$value}}"/>
            @else
                <input type="{{$type}}" class="form-control" name="{{$field}}" value="{{$value}}"/>
            @endif
        @endif
    </div>
</div>
