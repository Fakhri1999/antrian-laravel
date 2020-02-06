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
    } else if (session('admin_username') != null) {
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
    session(['petugas_username' => $username, 'petugas_name' => $result->nama, 'petugas_id' => $result->id]);
    return redirect('petugas');
  }

  public function index()
  {
    return redirect('petugas/loket');
  }

  public function allLoket()
  {
    return view('loket/index', ['API_KEY' => env("API_KEY")]);
  }

  public function logout()
  {
    session()->flush();
    return redirect('petugas/login');
  }

  public function ambilLoket($id)
  {
    if (session('petugas_masuk')) {
      if($id != session('nomor_loket')){
        return redirect("petugas/loket/$id");
      } else {
        return view('loket/loket');
      }
    }
    $result = DB::table('loket')->where('id_petugas', session('petugas_id'))->first();
    if ($result != null) {
      session(['petugas_masuk' => true]);
      return view('loket/loket');
    }
    $update = [
      'id_petugas' => session('petugas_id'),
      'status' => '1'
    ];
    $resultUpdate = DB::table('loket')->where('id', $id)->update($update);
    if ($resultUpdate) {
      session(['petugas_masuk' => true, 'nomor_loket' => $id]);
      return view('loket/loket');
    } else {
      echo "Error saat proses pengambilan loket. Silahkan menghubungi pihak IT";
    }
  }
}
