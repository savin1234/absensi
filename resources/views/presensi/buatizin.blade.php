@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal {
        max-height: 430px !important;
    }
    .datepicker-date-display{
        background-color: blue !important;
    }
    
</style>
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goback">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="PageTitle">Form IZIN</div>
    <div class="right"></div>
</div>

@endsection

@section('content')
<div class="row" style="margin-top:70px">
<div class="col">
    <form method="POST" action="/presensi/storeizin" id="izin">
        @csrf
        <div class="row">
            <div class="col">
                <div class="input-field" >
                    <input type="text" id="tanggalizin" class="form-control datepicker" placeholder="Tanggal">
                </div>
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="">Izin/Sakit</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="keterangan"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">Kirim</button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

@endsection
@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

$(document).ready(function() {
  $(".datepicker").datepicker({
    
    
    format: "yyyy/mm/dd"    
  });
  $("#izin").submit(function(){
    var tanggalizin = $("#tanggalizin").val();
    var status = $("#status").val();
    var keterangan = $("#keterangan").val();
    if (tanggalizin == ""){
        Swal.fire({
                title: 'Opss',
                text: 'mohon data diisi',
                icon: 'Warning',
                confirmButtonText: 'OK'
                })
        return false;
    } else if (status == ""){
        Swal.fire({
                title: 'Opss',
                text: 'mohon data diisi',
                icon: 'Warning',
                confirmButtonText: 'OK'
                })
        return false;
    } else if (keterangan == ""){
        Swal.fire({
                title: 'Opss',
                text: 'mohon data diisi',
                icon: 'Warning',
                confirmButtonText: 'OK'
                })
        return false;
    }
  })
});
</script>
@endpush