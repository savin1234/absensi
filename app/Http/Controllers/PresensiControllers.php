<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Helpers\CodeGenerator;

class PresensiControllers extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        $lok_kantor = DB::table('lokasi_kantor')->where('id', 1)->first();
        return view('presensi.create', compact('cek','lok_kantor'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        $lok_kantor = DB::table('lokasi_kantor')->where('id', 1)->first();
        $lok = explode(",", $lok_kantor->lokasi);
        $latitudekantor = $lok[0];
        $longtitudekantor = $lok[1];
        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
        if($cek > 0){
            $ket = "Out";
        }else{
            $ket = "In";
        }
        $image = $request->image;
        $folderPath ="public/uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi. "-" . $ket;
        $image_parts = explode(";base64",$image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath. $fileName;
        $data = [
            'nik' => $nik,
            'tgl_presensi' => $tgl_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'lokasi_in' => $lokasi
        ];
        if($cek > 0){
            $data_pulang = [
            'jam_out' => $jam,
            'foto_out' => $fileName,
            'lokasi_out' => $lokasi
            ];
            $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
            if ($update){
                echo 0;
                Storage::put($file, $image_base64);
            }else{
                echo 1;
            }
        }else{
            $simpan = DB::table('presensi')->insert($data);
        if ($simpan){
            echo 0;
            Storage::put($file, $image_base64);
        }else{
            echo 1;
        }
        }
        
        Storage::put($file, $image_base64);
        echo "0";

    }
    

    public function editprofile()
    {   
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofil(Request $request)
{
    $nik = Auth::guard('karyawan')->user()->nik;
    $karyawan = DB::table('karyawan')->where('nik', $nik)->first();

    $data = [
        'nama' => $request->nama,
        'telepon' => $request->telepon,
    ];

    // Hanya update password jika diisi
    if (!empty($request->password)) {
        $data['password'] = Hash::make($request->password);
    }

    // Hanya update foto jika diupload
    if ($request->hasFile('foto')) {
        $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        $request->file('foto')->storeAs('public/uploads/karyawan', $foto);
        $data['foto'] = $foto;
    }

    // Update data ke DB
    $update = DB::table('karyawan')->where('nik', $nik)->update($data);

// Tetap sukses jika update data atau upload file dilakukan
if ($update || $request->hasFile('foto')) {
    return Redirect::back()->with(['success' => 'Data Berhasil di Update']);
} else {
    return Redirect::back()->with(['error' => 'Tidak ada perubahan data']);
}

}


    public function history()
    {
        $namabulan = ["", "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","OKtober","November","Desember"];
        return view('presensi.history', compact('namabulan'));
    }

    public function gethistory(Request $request) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $history = DB::table('presensi')
        ->whereRaw('MONTH(tgl_presensi)="' .$bulan . '"')
        ->whereRaw('YEAR(tgl_presensi)="' .$tahun . '"')
        ->where('nik', $nik)
        ->orderBy('tgl_presensi')
        ->get();

        return view('presensi.gethistory', compact('history'));
    }

    public function izin() {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('izin')->where('nik', $nik)->get();
        return view('presensi.izin', compact( 'dataizin'));
    }

    public function buatizin() {
        return view('presensi.buatizin');
    }

    public function storeizin(Request $request) {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tanggalizin = now(); // gunakan timestamp lengkap
        $status = $request->status;
        $keterangan = $request->keterangan;
    
        $data = [
            'nik' => $nik,
            'tanggalizin' => $tanggalizin,
            'status' => $status,
            'keterangan' => $keterangan
        ];
    
        $simpan = DB::table('izin')->insert($data);
    
        if ($simpan){
            return redirect('/izin')->with(['success' => "Data berhasil disimpan"]);
        } else {
            return redirect('/izin')->with(['success' => "Data gagal disimpan"]);
        }
    }
    

    public function monitoring(){
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request) {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*','nama','nama_dept')
        ->join('karyawan', 'presensi.nik', '=','karyawan.nik')
        ->join('departemen','karyawan.kode_dept','=','departemen.kode_dept')
        ->where('tgl_presensi',$tanggal)
        ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }

    public function laporan()  {
        $karyawan = DB::table('karyawan')->orderBy('nama')->get();
        $namabulan = ["", "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","OKtober","November","Desember"];
        return view('presensi.laporan', compact('namabulan', 'karyawan'));
    }

    public function cetaklaporan(Request $request)  {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $karyawan =  DB::table('karyawan')->where('nik', $nik)
        ->join('departemen', 'karyawan.kode_dept','=','departemen.kode_dept')
        ->first();
        $namabulan = ["", "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","OKtober","November","Desember"];
        $presensi = DB::table('presensi')
        ->where('nik',$nik)
        ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
        ->whereRaw('YEAR(tgl_presensi)="'. $tahun . '"')
        ->get();

        return view('presensi.cetaklaporan', compact('bulan', 'tahun','namabulan', 'karyawan' , 'presensi'));
    }

    Public function rekap(){
        $namabulan = ["", "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","OKtober","November","Desember"];
        return view('presensi.rekap', compact('namabulan'));
    }

    public function cetakrekap(Request $request)
    {
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                  "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    $selects = 'presensi.nik, nama';
    for ($i = 1; $i <= 31; $i++) {
        $selects .= ', MAX(IF(DAY(tgl_presensi) = ' . $i . 
                    ', CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")), "")) as tgl_' . $i;
    }

    $rekap = DB::table('presensi')
        ->selectRaw($selects)
        ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
        ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
        ->groupByRaw('presensi.nik, nama')
        ->get();

    return view('presensi.cetakrekap', compact('bulan', 'tahun', 'rekap', 'namabulan'));
    }

    public function izinsakit(){
        $izinsakit = DB::table('izin')
        ->join('karyawan','izin.nik','=','karyawan.nik')
        ->orderBy('tanggalizin', 'desc')
        ->orderBy('id', 'desc') // jika tanggal sama, ID lebih besar dianggap lebih baru
        ->get();
        return view('presensi.izinsakit', compact('izinsakit'));
    }

    public function approveizinsakit(Request $request) {
        $status_approve = $request->status_approve;
        $id_izinsakit_form = $request->id_izinsakit_form;
        $update = DB::table('izin')->where('id', $id_izinsakit_form)->update([
            'status_approve' => $status_approve
        ]);
        if ($update){
            return Redirect::back()->with(['success'=>'Data berhasil disimpan']);
        }else{
            return Redirect::back()->with(['warning'=>'Data gagal disimpan']);
        }
    }

    public function batalkanizinsakit($id){
        $update = DB::table('izin')->where('id', $id)->update([
            'status_approve' => 0
        ]);
        if ($update){
            return Redirect::back()->with(['success'=>'Data berhasil disimpan']);
        }else{
            return Redirect::back()->with(['warning'=>'Data gagal disimpan']);
        }
    }

    public function lokasi(){
        $lok_kantor = DB::table('lokasi_kantor')->where('id', 1)->first();
        return view('presensi.lokasi', compact('lok_kantor'));
    }

    public function updatelokasikantor(Request $request) {
        $lokasi = $request->lokasi;
        $radius = $request->radius;
        $update = DB::table('lokasi_kantor')->where('id',1)->update([
            'lokasi' => $lokasi,
            'radius' => $radius
        ]);
        if($update){
            return Redirect::back()->with(['success'=>'Data berhasil disimpan']);
        }else{
            return Redirect::back()->with(['warning'=>'Data gagal disimpan']);
        }
    }

    public function buatkode() {
        $kode = CodeGenerator::generate(); // Ambil kode acak
        return view('presensi.buatkode', compact('kode'));
    }

    public function show()
    {
        $code = CodeGenerator::generate();
        return response()->json([
            'code' => $code,
            'valid_for_minutes' => 3
        ]);
    }
    public function inputkode() {

        return view('presensi.inputkode');
    }
    
    public function tampilpeta(Request $request)  {
        $lokasi_in = $request->lokasi_in;
        $presensi = DB::table('presensi')->where('lokasi_in', $lokasi_in)->first();
        return view('presensi.showmaps', compact('presensi'));
    }
} 
