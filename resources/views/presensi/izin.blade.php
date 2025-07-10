@extends('layouts.presensi')
@section('header')

<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goback">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="PageTitle">Data IZIN / SAKIT</div>
    <div class="right"></div>
</div>


@section('content')
<div class="fab-button bottom-right" style="margin-bottom:70px">
<a href="/buatizin" class="fab">
    <ion-icon name="add-outline"></ion-icon>
</a>
</div>
<div class="row" style="margin-bottom:70px">
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
<div class="row">
    <div class="col">
        @foreach ($dataizin as $d )
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="in">
                        <div>
                            <b>{{ date("d-m-Y",strtotime($d->tanggalizin)) }} ({{ $d->status == "s" ? "Sakit" : "Izin" }})</b><br>
                            <small class="text-muted">{{ $d->keterangan }}</small>
                        </div>
                        @if($d->status_approve == 0)
                        <span class="badge bg-warning">Waiting</span>
                        @elseif($d->status_approve == 1)
                        <span class="badge bg-success">Approve</span>
                        @elseif($d->status_approve == 2)
                        <span class="badge bg-danger">Decline</span>
                        @endif
                    </div>
                </div>
            </li>
        </ul>
        @endforeach
        
    </div>
</div>




@endsection