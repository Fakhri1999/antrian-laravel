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
    $petugasMasuk = DB::table('loket')->where('id_petugas', $result->id)->first();
    if ($petugasMasuk != null) {
      session(['petugas_masuk' => true, 'nomor_loket' => $petugasMasuk->id]);
      return redirect('petugas/loket/' . $petugasMasuk->id);
    }
    return redirect('petugas');
  }

  public function index()
  {
    return redirect('petugas/loket');
  }

  public function allCounter()
  {
    $petugasMasuk = DB::table('loket')->where('id_petugas', session('petugas_id'))->first();
    if ($petugasMasuk != null) {
      session(['petugas_masuk' => true, 'nomor_loket' => $petugasMasuk->id]);
      return redirect('petugas/loket/' . $petugasMasuk->id);
    }
    return view('loket/index', ['API_KEY' => env("API_KEY")]);
  }

  public function logout()
  {
    session()->flush();
    return redirect('petugas/login');
  }

  public function takeCounter($id)
  {
    $result = DB::table('loket')->where('id_petugas', session('petugas_id'))->first();
    if ($result != null) {
      session(['petugas_masuk' => true, 'nomor_loket' => $result->urutan]);
      return redirect("petugas/loket/$result->urutan");
    }
    $updateLoket = [
      'id_petugas' => session('petugas_id'),
      'status' => '1'
    ];
    $updatePetugas = [
      'status' => '1'
    ];
    $resultUpdateLoket = DB::table('loket')->where('id', $id)->update($updateLoket);
    $resultUpdatePetugas = DB::table('petugas')->where('id', session('petugas_id'))->update($updatePetugas);
    if ($resultUpdateLoket && $resultUpdatePetugas) {
      session(['petugas_masuk' => true, 'nomor_loket' => $id]);
      return redirect("petugas/loket/$id");
    } else {
      echo "Error saat proses pengambilan loket. Silahkan menghubungi pihak IT";
    }
  }

  public function counter($id)
  {
    $result = DB::table('loket')->where('id_petugas', session('petugas_id'))->first();
    if ($result == null) {
      return redirect('petugas/loket');
    }
    if($result->urutan != $id){
      return redirect("petugas/loket/$result->urutan");
    }
    return view('loket/loket');
  }

  public function exitCounter()
  {
    if (!session('petugas_masuk')) {
      return redirect("petugas/loket");
    }

    session()->forget('petugas_masuk');
    session()->forget('nomor_loket');
    DB::table('loket')->where('id_petugas', session('petugas_id'))->update(['status' => '0', 'id_petugas' => '0']);
    DB::table('petugas')->where('id', session('petugas_id'))->update(['status' => '0']);
    return redirect('petugas/loket');
  }

  public function showKepuasan($id)
  {
    $result = DB::table('loket')->where('id_petugas', session('petugas_id'))->first();
    if($result->id != $id){
      return redirect("petugas/loket/$result->id/kepuasan");
    }
    return view('loket/kepuasan');
  }
}
