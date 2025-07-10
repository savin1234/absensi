<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1;
        $tahunini = date("Y");
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariini)->first();
        $historibulanini = DB::table('presensi')->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini. '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->orderBy('tgl_presensi')
            ->get();


        $profil = DB::table('karyawan')
            ->where('nik', $nik)
            ->get();

        $rekapabsen = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir , SUM(IF(jam_in > "07.00",1,0)) as jmlhtelat')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
        ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
        ->first();

        $leaderboard = DB::table('presensi')
        ->join('karyawan', 'presensi.nik', '=','karyawan.nik')
        ->where('tgl_presensi',$hariini)
        ->get();
        $namabulan = ["", "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","OKtober","November","Desember"];

        $rekapizin = DB::table('izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggalizin)="' . $bulanini .'"')
            ->whereRaw('YEAR(tanggalizin)="' . $tahunini .'"')
            ->where('status_approve', 1)
            ->first();
        return view('dashboard.dashboard', compact('presensihariini', 'historibulanini','namabulan', 'bulanini', 'tahunini', 'rekapabsen', 'leaderboard', 'profil', 'rekapizin'));
    }

    public function dashboardadmin(){
        $hariini = date('Y-m-d');
        $rekapabsen = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir , SUM(IF(jam_in > "07.00",1,0)) as jmlhtelat')
        ->where('tgl_presensi', $hariini)
        ->first();

        $rekapizin = DB::table('izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('tanggalizin', $hariini)
            ->where('status_approve', 1)
            ->first();
        return view('dashboard.dashboardadmin', compact('rekapabsen','rekapizin'));
    }
}
