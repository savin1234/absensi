@extends('layouts.presensi')
@section('header')
<div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Absen Dong</div>
        <div class="right"></div>
    </div>
    <form action="{{ url('/cek-kode') }}" method="POST" enctype="multipart/form-data" style="margin-top:15rem">
    @csrf

    @if(session('error'))
        <div class="alert alert-danger text-center mb-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="col">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" name="kode" placeholder="Kode presensi" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <button type="submit" class="btn btn-primary btn-block">
                    <ion-icon name="checkmark-outline"></ion-icon>
                    Absen
                </button>
            </div>
        </div>
    </div>
</form>


@endsection