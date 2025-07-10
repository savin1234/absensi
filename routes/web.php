<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenControllers;
use App\Http\Controllers\KaryawanControler;
use App\Http\Controllers\KaryawanControllers;
use App\Http\Controllers\PresensiControllers;
use App\Http\Controllers\ProfilControllers;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Route;
use App\Helpers\CodeGenerator;
use Illuminate\Http\Request;

Route::middleware(['guest:karyawan'])->group(function(){
    Route::get('/',function(){
        return view('auth.login');
    })->name('login');

    
    Route::post('/proseslogin', [AuthController::class,'proseslogin']);
});

Route::middleware(['guest:user'])->group(function(){
    Route::get('/panel',function(){
        return view('auth.loginadmin');
    })->name('loginadmin');


    Route::post('/prosesloginadmin', [AuthController::class,'prosesloginadmin']);
});

Route::middleware(['auth:karyawan'])->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/proseslogout', [AuthController::class, 'proseslogout'])->name('proseslogout');


//presensi
Route::get('/verify-code', [PresensiControllers::class, 'showForm'])->name('verify.form');
Route::post('/verify-code', [PresensiControllers::class, 'checkCode'])->name('verify.check');
Route::get('/create',[PresensiControllers::class,'create']);
Route::get('/inputkode',[PresensiControllers::class,'inputkode']);
Route::post('/presensi/store',[PresensiControllers::class,'store']);
Route::get('/input-kode', function () {
    return view('inputkode'); // form input
});

Route::post('/cek-kode', function (Request $request) {
    $kodeInput = strtoupper($request->kode);
    $kodeValid = CodeGenerator::generate(); // ambil kode acak dari helper

    if ($kodeInput === $kodeValid) {
        // kode cocok, redirect ke halaman create
        return redirect('/create');
    } else {
        // kode salah, kembali dengan error
        return back()->with('error', 'Kode tidak valid, silakan coba lagi.');
    }
});


//profil 
Route::get('/editprofile',[PresensiControllers::class,'editprofile']);
Route::post('/presensi/{nik}/updateprofil',[PresensiControllers::class,'updateprofil']);

Route::get('/history',[PresensiControllers::class,'history']);
Route::post('/gethistory',[PresensiControllers::class,'gethistory']);

Route::get('/izin',[PresensiControllers::class,'izin']);
Route::get('/buatizin',[PresensiControllers::class,'buatizin']);
Route::post('/presensi/storeizin',[PresensiControllers::class,'storeizin']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/dashboardadmin',[DashboardController::class, 'dashboardadmin']);
    Route::get('/proseslogoutadmin',[AuthController::class,'proseslogoutadmin']);

    Route::get('/karyawan', [KaryawanControllers::class, 'index']);
    Route::post('/karyawan/store',[KaryawanControllers::class,'store']);
    Route::post('/karyawan/edit',[KaryawanControllers::class,'edit']);
    Route::post('/karyawan/{nik}/update',[KaryawanControllers::class,'update']);
    Route::post('/karyawan/{nik}/delete',[KaryawanControllers::class,'delete']);

    

    Route::get('/departemen',[DepartemenControllers::class, 'index']);
    Route::post('/departemen/store',[DepartemenControllers::class,'store']);
    Route::post('/departemen/edit',[DepartemenControllers::class,'edit']);
    Route::post('/departemen/{kode_dept}/update',[DepartemenControllers::class,'update']);
    Route::post('/departemen/{kode_dept}/delete',[DepartemenControllers::class,'delete']);


    Route::get('/presensi/monitoring',[PresensiControllers::class,'monitoring']);
    Route::post('/getpresensi',[PresensiControllers::class,'getpresensi']);

    Route::get('/presensi/laporan',[PresensiControllers::class,'laporan']);
    Route::post('/presensi/cetaklaporan',[PresensiControllers::class,'cetaklaporan']);
    Route::get('/presensi/rekap',[PresensiControllers::class,'rekap']);
    Route::post('/presensi/cetakrekap',[PresensiControllers::class,'cetakrekap']);
    Route::get('/presensi/izinsakit',[PresensiControllers::class,'izinsakit']);
    Route::post('/presensi/approveizinsakit',[PresensiControllers::class,'approveizinsakit']);
    Route::get('/presensi/{id}/batalkanizinsakit',[PresensiControllers::class,'batalkanizinsakit']);
    Route::get('/presensi/buatkode',[PresensiControllers::class,'buatkode']);
    Route::get('/random-code', [PresensiControllers::class, 'show']);
    Route::get('/api/kode-acak', function () {
        return response()->json([
            'kode' => CodeGenerator::generate()
        ]);
    });





    
    Route::get('/presensi/lokasi',[PresensiControllers::class,'lokasi']);
    Route::post('/presensi/updatelokasikantor',[PresensiControllers::class,'updatelokasikantor']);

     Route::post('/tampilpeta', [PresensiControllers::class, 'tampilpeta']);
});



