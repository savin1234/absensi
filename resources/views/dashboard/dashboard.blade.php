@extends('layouts.presensi');
@section('content')
<div class="appHeader bg-primary text-light">
    <div class="left"></div>
    <div class="pageTitle">Dashboard</div>
    <div class="right">
    <a href="{{ route('proseslogout') }}" class="text-light">
    <ion-icon name="log-out-outline"></ion-icon>
</a>
    </div>
</div>

<form id="logout-form" action="{{ route('proseslogout') }}" method="POST" style="display: none;">
    @csrf
</form>
@foreach ($profil as $d)
<div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar">
                @if (!empty(Auth::guard('karyawan')->user()->foto))
                @php
                $path = Storage::url('uploads/karyawan/'.$d->foto);
                @endphp
                <img src="{{ $path }}" alt="avatar" class="imaged w64 rounded">
                @else
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                @endif     
                </div>
                
                
                
                <div id="user-info">
                    <h2 id="user-name">{{ $d->nama }}</h2>
                    <span id="user-role">{{ $d->jabatan }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="section" id="menu-section">
            <div class="card" style="margin-top:2rem">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Cuti</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Histori</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        <ion-icon name="camera"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Masuk</h4>
                                        <span>{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        <ion-icon name="camera"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Pulang</h4>
                                        <span>{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="rekappresensi">
                <h3>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding : 16px 17px !important; line-height: 0.8rem">
                            <span class="badge badge-danger" style="position: absolute; top:3px; right: 10px; font-size: 0,6rem;">{{ $rekapabsen -> jmlhadir }}</span>
                        <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0,8rem; font-weight:500">hadir</span>
                        </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding : 16px 17px !important; line-height: 0.8rem">
                            <span class="badge badge-danger" style="position: absolute; top:3px; right: 10px; font-size: 0,6rem;">{{ $rekapizin -> jmlizin }}</span>
                        <ion-icon name="create-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0,8rem; font-weight:500">Izin</span>
                        </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding : 16px 17px !important; line-height: 0.8rem">
                            <span class="badge badge-danger" style="position: absolute; top:3px; right: 10px; font-size: 0,6rem;">{{ $rekapizin -> jmlsakit }}</span>
                        <ion-icon name="medkit-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0,8rem; font-weight:500">Sakit</span>
                        </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding : 16px 17px !important; line-height: 0.8rem">
                            <span class="badge badge-danger" style="position: absolute; top:3px; right: 10px; font-size: 0,6rem;">{{ $rekapabsen -> jmlhtelat }}</span>
                        <ion-icon name="alarm-outline" style="font-size: 1.6rem;" class="text-danger mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0,8rem; font-weight:500">telat</span>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ( $historibulanini as $d )
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="image-outline" role="img" class="md hydrated"
                                            aria-label="image outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $d->jam_in }}</span>
                                        <span class="badge badge-danger">{{ $d->jam_out }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($leaderboard as $d )
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>{{ $d->nama }}</div>
                                        <small>{{ $d->jabatan }}</small>
                                        <span class="badge {{ $d->jam_in < "07.00" ? "bg-success" : "" }}">{{ $d->jam_in }}</span>
                                    </div>
                                </div>
                            </li>

                            @endforeach
                            

                </div>
            </div>
        </div>

@endsection