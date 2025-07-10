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
<style>
    .webcam-capture,
    .webcam-capture video{
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 13px;
    
    }
    #map { height: 180px; }
</style>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>




@endsection


@section('content')
<div class="row" style="margin-top: 70px">
<div class="col">
    <input type="hidden" id="lokasi"> 
    <div class="webcam-capture"></div>
    </div>
</div>

<div class="row">
    <div class="col">
        @if ($cek > 0)
        <button id="takeabsen" class="btn btn-danger btn-block"> 
            <ion-icon name="camera-outline"></ion-icon>
            Absen Pulang
        </button>
        @else
        <button id="takeabsen" class="btn btn-primary btn-block"> 
            <ion-icon name="camera-outline"></ion-icon>
            Absen Masuk
        </button>
        @endif
    </div>
</div>

<div class="row mt-2" >
<div class="col">
    <div id="map"></div>
    </div>
</div>

@endsection

@push('myscript')
<script>
    Webcam.set({
        height:480,
        width:640,
        imgae_format: 'jpeg',
        jpeg_quality: 80,
    });

    Webcam.attach('.webcam-capture');

    var lokasi = document.getElementById('lokasi');
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }
    function successCallback(position){
        lokasi.value = position.coords.latitude + "," + position.coords.longitude;
        var lokasi_kantor = "{{ $lok_kantor->lokasi }}";
        var lok = lokasi_kantor.split(",");
        var lat_kantor = lok[0];
        var long_kantor = lok[1];
        var radius = "{{ $lok_kantor->radius }}";
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
var circle = L.circle([lat_kantor, long_kantor], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: radius
}).addTo(map);
    
    }
    function errorCallback(position){

    }

    $("#takeabsen").click(function(e){
        Webcam.snap(function(uri){
            image = uri;
        })
        var lokasi = $("#lokasi").val();
        $.ajax({
            type : 'POST'
            , url: '/presensi/store'
            , data: {
                _token: "{{ csrf_token() }}"
                ,image : image
                , lokasi: lokasi
            }
            ,cache :false
            , success: function(respond){
                if (respond == 0) {
                    Swal.fire({
                title: 'Berhasil',
                text: 'TerimaKasih, Selamat Bekerja',
                icon: 'Success',
                })
                setTimeout("location.href='/dashboard'", 2000);
                }else{
                    Swal.fire({
                title: 'Error',
                text: 'Maaf Gagal, Silahkan hubungi IT',
                icon: 'Success',
                confirmButtonText: 'OK'
                })
                }
                
            }
        })
    })
       

    

</script>
@endpush