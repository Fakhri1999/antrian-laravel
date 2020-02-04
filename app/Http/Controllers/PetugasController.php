<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
  public function showLogin()
  {
    if (session('petugas_username') != null) {
      return redirect('petugas');
    } else if(session('admin_username') != null){
      return redirect('admin');
    }
    return view('loket/login');
  }
  public function login(Request $request)
  {
    $username = $request->username;
    $pin = $request->pin;
    $result = DB::table('petugas')->where('username', $username)->where('pin', $pin)->first();
    if ($result == null) {
      return redirect('petugas/login')->with('status', '<script>Swal.fire({
        icon: "error",
        title: "Error",
        text: "Username / pin salah"
      });</script>');
    }
    session(['petugas_username' => $username, 'petugas_name' => $result->nama]);
    return redirect('petugas');
  }

  public function index()
  {
    return view('loket/index');
  }

  public function logout()
  {
    session()->flush();
    return redirect('admin/login');
  }
}
