@extends('template.app')

@section('content')


<div class="text-center mb-4">
    <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?= asset('/assets/login/img/nav-logo.png') ?>" height="100" alt=""></a>
</div>
<form class="border-1 border-warning card card-md text-white" action="{{ route('custom.login') }}" method="POST" autocomplete="off" style="z-index:1000;background: rgba(0, 0, 0, 0.3);">
    @csrf
    <div class="card-body">
        <h2 class="card-title text-center mb-4">Masuk menggunakan Akunmu</h2>
        @if(session()->has('email'))
            <div class="invalid-feedback d-block" role="alert">
                <strong>{{ session()->get('email') }}</strong>
            </div>
        @endif
        @if(session()->has('password'))
            <div class="invalid-feedback d-block" role="alert">
                <strong>{{ session()->get('password') }}</strong>
            </div>
        @endif
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="text-black form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukan email" autocomplete="off">
        </div>
        <div class="mb-2">
            <label class="form-label">
                Password
            </label>
            <div class="input-group input-group-flat">
                <input type="password" name="password" class="text-black form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Password" autocomplete="off">
            </div>
            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
    </div>
</form>

@endsection