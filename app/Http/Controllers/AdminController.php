<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
  public function showLogin(Request $request)
  {
    if (session('admin_username') != null) {
      return redirect('admin');
    } else if (session('petugas_username') != null) {
      return redirect('petugas');
    }
    if($request->r != null){
      return view('admin/login', ['redirect' => $request->r, 'action' => "admin/login?r=$request->r"]);
    } else {    
      return view('admin/login', ['action' => 'admin/login']);
    }
  }
  public function login(Request $request)
  {
    $username = $request->username;
    $password = $request->password;
    $result = DB::table('admin')->where('username', $username)->where('password', $password)->first();
    if ($result == null) {
      return redirect('admin/login')->with('status', '<script>Swal.fire({
        icon: "error",
        title: "Error",
        text: "Username / password salah"
      });</script>');
    }
    session(['admin_username' => $username, 'admin_name' => $result->nama]);
    if($request->r != null){
      return redirect($request->r);
    } else {
      return redirect('admin');
    }
  }

  public function index()
  {
    return view('admin/index');
  }

  public function logout()
  {
    session()->flush();
    return redirect('admin/login');
  }

  public function showPetugas()
  {
    return view('admin/data_petugas', ['API_KEY' => env("API_KEY")]);
  }

  public function showLayanan()
  {
    return view('admin/layanan', ['API_KEY' => env("API_KEY")]);
  }

  public function showLoket()
  {
    return view('admin/loket', ['API_KEY' => env("API_KEY")]);
  }

  public function showDisplayAdmin()
  {
    $result = DB::table('display')->first();
    return view('admin/display', ['API_KEY' => env("API_KEY"), 'data' => $result]);
  }

  public function updateDisplay(Request $request)
  {
    $this->validate($request, [
      'nama_perusahaan' => 'required',
      'alamat_perusahaan' => 'required',
      'running_text' => 'required',
      'slogan' => 'required',
      'logo_perusahaan' => 'mimes:jpg,jpeg,png',
      'video_display' => 'mimes:mp4,mkv,mpg,webm,m4v,avi'
    ]);
    $logo = $request->file('logo_perusahaan');
    $video = $request->file('video_display');
    if ($logo != null) {
      $logoFileName = "logo." . $logo->getClientOriginalExtension();
      $logo->move(public_path('uploads/display'), $logoFileName);
    }
    if ($video != null) {
      $videoFileName = "video." . $video->getClientOriginalExtension();
      $video->move(public_path('uploads/display'), $videoFileName);
    }
    $dataDisplayLama = DB::table('display')->where('id', 1)->first();
    $update = [
      'nama_perusahaan' => $request->nama_perusahaan,
      'logo_perusahaan' => isset($logoFileName) ? $logoFileName : $dataDisplayLama->logo_perusahaan,
      'alamat_perusahaan' => $request->alamat_perusahaan,
      'running_text' => $request->running_text,
      'slogan' => $request->slogan,
      'video_display' => isset($videoFileName) ? $videoFileName : $dataDisplayLama->video_display,
    ];
    $id = $request->id_display;
    DB::table('display')->where('id', $id)->update($update);
    return redirect('admin/display')->with('status', '<script>Swal.fire({
      icon: "success",
      title: "Sukses",
      text: "Data display berhasil diubah"
    });</script>');;
  }

  public function showRekapan(){
    $result = DB::table('antrian as a')
    ->join('layanan as l', 'l.id', 'a.id_layanan')
    ->join('petugas as p', 'p.id', 'a.id_petugas')
    ->where('a.id', '>', '0')
    ->select('a.*', 'l.nama_layanan', 'p.nama as nama_petugas')
    ->get();
    $petugas = DB::table('petugas')->where('id', '>', '0')->get();
    return view('admin/rekapan/antrian', ['data' => $result, 'petugas' => $petugas]);
  }

  public function printAntrian(Request $request){
    $tanggal = $this->changeDateFormat($request->tanggal);
    $petugasId = $request->petugasId;
    if($petugasId == "kosong"){
      $result = DB::table('antrian as a')
      ->join('layanan as l', 'l.id', 'a.id_layanan')
      ->join('petugas as p', 'p.id', 'a.id_petugas')
      ->where('a.id', '>', '0')
      ->where('a.tanggal_pembuatan', $tanggal)
      ->orderBy('a.nomor_antrian', 'asc')
      ->select('a.*', 'l.nama_layanan', 'p.nama as nama_petugas')
      ->get();
    } else {
      $result = DB::table('antrian as a')
      ->join('layanan as l', 'l.id', 'a.id_layanan')
      ->join('petugas as p', 'p.id', 'a.id_petugas')
      ->where('a.id', '>', '0')
      ->where('a.tanggal_pembuatan', $tanggal)
      ->where('a.id_petugas', $petugasId)
      ->orderBy('a.nomor_antrian', 'asc')
      ->select('a.*', 'l.nama_layanan', 'p.nama as nama_petugas')
      ->get();
    }
    if(sizeof($result) == 0){
      return redirect('admin/rekapan')->with('status', "<script>Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Data antrian kosong'
      })</script>");
    }
    return view('admin/rekapan/print', ['data' => $result]);
  }

  public function printAntrianGet(){
    return redirect("admin/rekapan");
  }

  private function changeDateFormat($date)
  {
    $data = explode("-", $date);
    return "$data[2]-$data[1]-$data[0]";
  }
}
