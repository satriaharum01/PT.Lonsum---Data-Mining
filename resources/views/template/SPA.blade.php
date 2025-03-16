@extends('template.header')
@section('css')

<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/ionicons.min.css')}}" rel="stylesheet">
<style type="text/css">
    	body{
    margin-top:20px;
    background:#eee;
    color: #708090;
}
.icon-1x {
    font-size: 24px !important;
}
a{
    text-decoration:none;    
}
.text-primary, a.text-primary:focus, a.text-primary:hover {
    color: #00ADBB!important;
}
.text-black, .text-hover-black:hover {
    color: #000 !important;
}
.font-weight-bold {
    font-weight: 700 !important;
}
    </style>
@endsection
@section('js')
<script src="{{asset('assets/js/jquery-1.10.2.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

@livewireScripts
@endsection