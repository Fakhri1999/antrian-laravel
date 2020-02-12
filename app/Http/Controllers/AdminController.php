<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
  public function showLogin()
  {
    if (session('admin_username') != null) {
      return redirect('admin');
    } else if (session('petugas_username') != null) {
      return redirect('petugas');
    }
    return view('admin/login');
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
    return redirect('admin');
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

  public function showDisplayAdmin(){
    $result = DB::table('display')->first();
    return view('admin/display', ['API_KEY' => env("API_KEY"), 'data' => $result]);
  }

  public function updateDisplay(Request $request){
    $this->validate($request, [
      'nama-perusahaan' => 'required',
      'alamat-perusahaan' => 'required',
      'running-text' => 'required',
      // 'logo-perusahaan' => 'required|mimes:jpg,jpeg,png',
      // 'video-display' => 'required|mimes:mp4,mkv,mpg,webm,m4v,avi'
    ]);
  }
}
