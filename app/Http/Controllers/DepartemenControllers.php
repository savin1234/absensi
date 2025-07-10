<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class DepartemenControllers extends Controller{
    public function index(){
        $departemen = DB::table('departemen')->orderBy('kode_dept')->get();
        return view('departemen.index', compact('departemen'));
    }

    public function store(Request $request)  {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;
        try{
            $data = [
                'kode_dept' => $kode_dept,
                'nama_dept' => $nama_dept
            ];

            $simpan = DB::table('departemen')->insert($data);
            return Redirect::back()->with(['success' => 'data berhasil disimpan']);
        }catch(\Exception $e){
        
        return Redirect::back()->with(['error' => 'data gagal disimpan']);
    }
    }

    public function edit(Request $request){
        $kode_dept = $request->kode_dept;
        $departemen = DB::table('departemen')->where('kode_dept', $kode_dept)->first();
        return view('departemen.edit', compact( 'departemen'));
    }

    public function update($kode_dept, Request $request){
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;
        $departemen = DB::table('departemen')->where('kode_dept',$kode_dept)->first();
        try{
            $data = [
                'kode_dept' => $kode_dept,
                'nama_dept' => $nama_dept
            ];

            $update = DB::table('departemen')->where('kode_dept', $kode_dept)->update($data);
            return Redirect::back()->with(['success' => 'data berhasil disimpan']);
        }catch(\Exception $e){
        
        return Redirect::back()->with(['error' => 'data gagal disimpan']);
    }
    }

    public function delete($kode_dept){
        $delete = DB::table('departemen')->where('kode_dept', $kode_dept)->delete();
        if ($delete){
            return Redirect::back()->with(['success' => 'data berhasil dihapus']);
        }else {
            return Redirect::back()->with(['warning' => 'data gagal dihapus']);
        }
    }

}