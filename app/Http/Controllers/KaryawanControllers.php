<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class KaryawanControllers extends Controller
{
    public function index(Request $request){
        
        $query = Karyawan::query();
        $query->select('karyawan.*', 'nik');
        $query->orderBy('nik');
        if (!empty($request->nik)){
            $query->where('nik', 'like','%' . $request->nik . '%');
        }
        $karyawan = $query->paginate(2);
        
        return view('karyawan.index', compact('karyawan'));
    }

    public function store(Request $request)  {
        $nik = $request->nik;
        $nama = $request->nama;
        $jabatan = $request->jabatan;
        $telepon = $request->telepon;
        $kode_dept = $request->kode_dept;
        $password = hash::make(12345);
        $karyawan = DB::table('karyawan')->where('nik',$nik)->first();
        try{
            $data = [
                'nik' => $nik,
                'nama' => $nama,
                'jabatan' => $jabatan,
                'telepon' => $telepon,
                'kode_dept' => $kode_dept
            ];

            $simpan = DB::table('karyawan')->insert($data);
            return Redirect::back()->with(['success' => 'data berhasil disimpan']);
        }catch(\Exception $e){
        
        return Redirect::back()->with(['error' => 'data gagal disimpan']);
    }
    }


    public function edit(Request $request){
        $nik = $request->nik;
        $departemen = DB::table('departemen')->get();
        $karyawan = DB::table('karyawan')->where('nik',$nik)->first();
        return view('karyawan.edit', compact('karyawan', 'departemen'));
    }

    public function update($nik, Request $request){
        $nik = $request->nik;
        $nama = $request->nama;
        $jabatan = $request->jabatan;
        $telepon = $request->telepon;
        $kode_dept = $request->kode_dept;
        $password = hash::make(12345);
        $karyawan = DB::table('karyawan')->where('nik',$nik)->first();
        try{
            $data = [
                'nik' => $nik,
                'nama' => $nama,
                'jabatan' => $jabatan,
                'telepon' => $telepon,
                'kode_dept' => $kode_dept
            ];

            $update = DB::table('karyawan')->where('nik', $nik)->update($data);
            return Redirect::back()->with(['success' => 'data berhasil disimpan']);
        }catch(\Exception $e){
        
        return Redirect::back()->with(['error' => 'data gagal disimpan']);
    }
    }

    public function delete($nik){
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if ($delete){
            return Redirect::back()->with(['success' => 'data berhasil dihapus']);
        }else {
            return Redirect::back()->with(['warning' => 'data gagal dihapus']);
        }
    }


    
}