<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Presensi (Landscape)</title>

    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Paper.css for printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page to A4 Landscape -->
    <style>
        @page { size: A4 landscape }

        body.A4.landscape {
            width: 297mm;
            height: 210mm;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 10px;
        }

        .tabelpresensi th,
        .tabelpresensi td {
            border: 1px solid black;
            padding: 3px;
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

<body class="A4 landscape">
    <section class="sheet padding-10mm">

        <!-- Header -->
        <table style="width: 100%;">
            <tr>
                <td style="width: 100px;">
                    <img src="{{ asset('assets/img/sample/photo/logo.png') }}" width="90" height="90" alt="Logo">
                </td>
                <td style="text-align: center;">
                    <h3>
                        Laporan Presensi Karyawan<br>
                        Periode {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        PT Winnicode Garuda Teknologi
                    </h3>
                </td>
            </tr>
        </table>

        <!-- Tabel Presensi -->
        <table class="tabelpresensi">
            <tr>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama</th>
                <th colspan="31">Tanggal</th>
            </tr>
            <tr>
                <?php
                for ($i = 1; $i <= 31; $i++){
                ?>
                    <th>{{ $i }}</th>
                <?php
                }
                ?>
            </tr>
            @foreach ($rekap as $d)
            <tr>
                <td>{{ $d->nik }}</td>
                <td>{{ $d->nama }}</td>

                <?php
                for($i=1;$i<=31;$i++){
                    $tgl = "tgl_".$i;
                    if(empty($d->$tgl)){
                        $hadir = ['',''];
                    }else{
                    $hadir = explode("-",$d->$tgl);
                    }
                ?>

                <td>
                    <span style="color:{{ $hadir[0]>"07:00:00" ? "red" : "" }}">{{ $hadir[0] }}</span><br>
                    <span style="color:{{ $hadir[1]>"16:00:00" ? "red" : "" }}">{{ $hadir[0] }}</span><br>
                </td>
                
                <?php 
                }
                ?>
            </tr>
            @endforeach

            {{-- Isi data presensi bisa ditambahkan di sini --}}
        </table>
    </section>
</body>
</html>
