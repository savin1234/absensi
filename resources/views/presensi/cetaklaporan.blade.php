@php
    function selisih($jam_masuk, $jam_keluar)
    {
        list($h, $m, $s) = explode(":", $jam_masuk);
        $dtAwal = mktime($h, $m, $s, "1", "1", "1");
        list($h, $m, $s) = explode(":", $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode(".", $totalmenit / 60);
        $sisamenit = ($totalmenit / 60) - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];

        return $jml_jam . ":" . round($sisamenit2);
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size -->
    <style>
        @page { size: A4 }

        .tabelpresensi {
            width: 100%;
            margin-top: 70px;
            border-collapse: collapse;
        }

        .tabelpresensi th,
        .tabelpresensi td {
            border: 2px solid black;
            padding: 5px;
            text-align: center;
        }

        .tabeldatakaryawan {
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .tabeldatakaryawan td {
            padding: 3px 8px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-size: 12px;
        }

        .bg-danger { background-color: red; }
        .bg-success { background-color: green; }
    </style>
</head>

<body class="A4">
    <section class="sheet padding-10mm">
        <table style="width: 100%;">
            <tr>
                <td style="width: 30px;">
                    <img src="{{ asset('assets/img/sample/photo/logo.png') }}" width="100" height="100" alt="">
                </td>
                <td>
                    <h3>
                        Laporan Presensi Karyawan<br>
                        Periode {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        PT Winnicode Garuda Teknologi
                    </h3>
                </td>
            </tr>
        </table>

        <table class="tabeldatakaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = Storage::url('uploads/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="" width="100px" height="100px">
                </td>
            </tr>
            <tr>
                <td>NIK</td><td>:</td><td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama</td><td>:</td><td>{{ $karyawan->nama }}</td>
            </tr>
            <tr>
                <td>Jabatan</td><td>:</td><td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departemen</td><td>:</td><td>{{ $karyawan->kode_dept }}</td>
            </tr>
            <tr>
                <td>Telepon</td><td>:</td><td>{{ $karyawan->telepon }}</td>
            </tr>
        </table>

        <table class="tabelpresensi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Foto</th>
                    <th>Jam Pulang</th>
                    <th>Foto</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presensi as $d)
                    @php
                        $path_in = Storage::url('uploads/absensi/' . $d->foto_in);
                        $path_out = Storage::url('uploads/absensi/' . $d->foto_out);
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_in ?? 'Belum Absen Masuk' }}</td>
                        <td>
                            <img src="{{ url($path_in) }}" width="80px" height="80px">
                        </td>
                        <td>{{ $d->jam_out ?? 'Belum Absen Pulang' }}</td>
                        <td>
                            <img src="{{ url($path_out) }}" width="80px" height="80px">
                        </td>
                        <td>
                            @if ($d->jam_in > '07:00')
                                @php
                                    $jamterlambat = selisih('07:00:00', $d->jam_in);
                                @endphp
                                <span class="badge bg-danger">Terlambat {{ $jamterlambat }}</span>
                            @else
                                <span class="badge bg-success">Tepat Waktu</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>
</html>
