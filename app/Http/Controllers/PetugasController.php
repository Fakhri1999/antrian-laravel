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
    return view('loket/index', ['API_KEY' => env("API_KEY")]);
  }

  public function logout()
  {
    session()->flush();
    return redirect('petugas/login');
  }

  public function ambilLoket($id)
  {
    $result = DB::table('loket')->where('id_petugas', session('petugas_id'))->first();
    if($result != null){
      echo "Maaf, Anda sudah mengambil $result->nomor_loket";
      return;
    }
    $update = [
      'id_petugas' => session('petugas_id'),
      'status' => '1'
    ];
    $resultUpdate = DB::table('loket')->where('id', $id)->update($update);
    if($resultUpdate){
      echo "Selamat datang. Anda berhasil mengambil Loket $id";
    } else {
      echo "Error saat proses pengambilan loket. Silahkan menghubungi pihak IT";
    }
  }
}
