<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use function Laravel\Prompts\warning;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        if(Auth::guard('karyawan')->attempt(['nik' => $request->nik,'password' => $request->password])){
            return redirect('/dashboard');
        }else {
            return redirect('/')->with(['warning'=>'NIK/Password Salah']);
        }
    } 

    public function proseslogout(Request $request)
    {
        if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }

    public function proseslogoutadmin(Request $request){
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }

    public function prosesloginadmin(Request $request)
    {
        if(Auth::guard('user')->attempt(['email' => $request->email,'password' => $request->password])){
            return redirect('/dashboardadmin');
        }else {
            return redirect('/panel')->with(['warning'=>'Email/Password Salah']);
        }
    } 
}
