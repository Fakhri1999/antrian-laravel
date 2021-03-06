<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
  public function showRegister()
  {
    if (session('pelanggan') != null) {
      return redirect('home');
    }
    return view('pelanggan/register');
  }

  public function register(Request $request)
  {
    $this->validate($request, [
      'npwp' => 'required|unique:pelanggan|min:15|max:15',
      'nama' => 'required',
      'email' => 'required|unique:pelanggan',
      'password' => 'required',
      'no_telp' => 'required'
    ]);
    $kodePendaftaran = sha1('pajak' . $request->email);
    $insert = [
      'npwp' => $request->npwp,
      'nama' => $request->nama,
      'email' => $request->email,
      'password' => sha1($request->password),
      'no_telp' => $request->no_telp,
      'status' => '0',
      'kode_pendaftaran' => $kodePendaftaran
    ];
    Mail::send('email.aktivasi_akun', ['kode_pendaftaran' => $kodePendaftaran], function ($message) use ($request) {
      $message->from('no-reply@maksel805.org', 'Antrian Pajak Online');
      $message->to($request->email, $request->nama);
      $message->cc($request->email, $request->nama);
      $message->bcc($request->email, $request->nama);
      $message->subject('Aktivasi Akun');
    });
    DB::table('pelanggan')->insert($insert);
    return redirect('login')->with('status', '<script>alert("Registrasi akun berhasil. Silahkan cek kotak inbox email Anda untuk verifikasi akun")</script>');;
  }

  public function activateAccount($kodePendaftaran)
  {
    if (session('pelanggan') != null) {
      return redirect('home');
    }
    $result = DB::table('pelanggan')->where('kode_pendaftaran', $kodePendaftaran)->first();
    if ($result->status == 1) {
      return redirect('login')->with('status', '<script>alert("Akun telah terverifikasi")</script>');
    }
    DB::table('pelanggan')->where('kode_pendaftaran', $kodePendaftaran)->update(['status' => '1']);
    return redirect('login')->with('status', '<script>alert("Verifikasi akun berhasil")</script>');
  }

  public function showLogin()
  {
    return view('pelanggan/login');
  }

  public function login(Request $request)
  {

    if (session('pelanggan') != null) {
      return redirect('home');
    }
    $this->validate($request, [
      'npwp' => 'required',
      'password' => 'required',
      'g-recaptcha-response' => 'required|captcha'
    ]);

    $where = [
      'npwp' => $request->npwp,
      'password' => sha1($request->password)
    ];
    $result = DB::table('pelanggan')->where($where)->first();
    if ($result == null) {
      return redirect('login')->with('status', '<script>alert("npwp / password salah")</script>');
    }
    if ($result->status == 0) {
      return redirect('login')->with('status', '<script>alert("Maaf, User kamu belum terverifikasi silahkan cek email kamu untuk verifikasi.")</script>');
    }
    session(['pelanggan' => $result]);
    return redirect('home');
  }

  public function home()
  {
    $layanan = DB::table('layanan')->where('id', '>', '0')->get();
    $display = DB::table('display')->where('id', 1)->first();
    date_default_timezone_set('Asia/Jakarta');
    $dateNow = date("d-m-Y");
    // $dateNow = '11-02-2020';
    $layanan = DB::table('layanan')->where('id', '>', '0')->get();
    $arr = [];
    $jumlahTiapLayanan = DB::table('antrian')
      ->where('tanggal_pembuatan', $dateNow)
      ->where('status', '1')
      ->select(DB::raw('id_layanan, count(*) as jumlah'))
      ->groupBy('id_layanan')->get();
    for ($i = 0; $i < sizeof($layanan); $i++) {
      $cek = false;
      for ($j = 0; $j < sizeof($jumlahTiapLayanan); $j++) {
        if ($jumlahTiapLayanan[$j]->id_layanan == $layanan[$i]->id) {
          $arrTemp = [
            'nama_layanan' => $layanan[$i]->nama_layanan,
            'status' => $layanan[$i]->status,
            'id' => $layanan[$i]->id,
            'urutan' => $layanan[$i]->urutan,
            'jumlah' => $jumlahTiapLayanan[$j]->jumlah,
            'total_estimasi' => $jumlahTiapLayanan[$j]->jumlah * $layanan[$i]->estimasi_waktu
          ];
          array_push($arr, $arrTemp);
          $cek = true;
          break;
        }
      }
      if (!$cek) {
        $arrTemp = [
          'nama_layanan' => $layanan[$i]->nama_layanan,
          'status' => $layanan[$i]->status,
          'id' => $layanan[$i]->id,
          'urutan' => $layanan[$i]->urutan,
          'jumlah' => '0',
          'total_estimasi' => '0'
        ];
        array_push($arr, $arrTemp);
      }
    }
    $display = DB::table('display')->where('id', 1)->first();
    return view('pelanggan/index', ['layanan' => $arr, 'data' => $display]);
  }

  public function logout()
  {
    session()->flush();
    return redirect('login');
  }

  public function history()
  {
    $data = DB::table('antrian AS a')
      ->where('id_pelanggan', session('pelanggan')->id)
      ->join('layanan AS l', 'a.id_layanan', 'l.id')
      ->select(DB::raw('a.id, a.nomor_antrian, a.tanggal_pembuatan, a.status, l.nama_layanan'))
      ->get();
    return view('pelanggan/history', ['antrian' => $data]);
  }
}
