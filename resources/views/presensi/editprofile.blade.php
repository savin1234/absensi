@extends('layouts.presensi')
@section('header')

<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goback">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="PageTitle">EditProfil</div>
    <div class="right"></div>
</div>

@endsection

@section('content')
<div class="row" style="margin-top:4rem">
<div class="col">
    @php
    $massagesuccess = Session::get('success');
    $massageerror = Session::get('error');
    @endphp
    @if (Session::get('success'))
    <div class="alert alert-success">
        {{ $massagesuccess }}
    </div>
    @endif
    @if (Session::get('error'))
    <div class="alert alert-error">
        {{ $massageerror }}
    </div>
    
    @endif
    
</div>
</div>
<form action="/presensi/{{ $karyawan->nik }}/updateprofil" method="POST" enctype="multipart/form-data" style="margin-top:3rem">
    @csrf
    <div class="col">
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $karyawan->nama }}" name="nama" placeholder="Nama Lengkap" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $karyawan->telepon }}" name="telepon" placeholder="No. HP" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
            </div>
        </div>
        <div class="custom-file-upload" id="fileUpload1">
            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <button type="submit" class="btn btn-primary btn-block">
                    <ion-icon name="refresh-outline"></ion-icon>
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
