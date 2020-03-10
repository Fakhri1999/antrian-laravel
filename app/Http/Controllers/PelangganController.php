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
      'npwp' => 'required|unique:pelanggan',
      'nama' => 'required',
      'email' => 'required|unique:pelanggan',
      'password' => 'required',
      'repassword' => 'required|same:password',
      'no_telp' => 'required'
    ]);
    $kodePendaftaran = sha1($request->email);
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
      $message->from('john@johndoe.com', 'John Doe');
      $message->to($request->email, $request->nama);
      $message->cc($request->email, $request->nama);
      $message->bcc($request->email, $request->nama);
      $message->subject('Aktivasi Akun');
    });
    DB::table('pelanggan')->insert($insert);
    return redirect('login');
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
      'email' => 'required',
      'password' => 'required',
      'g-recaptcha-response' => 'required|captcha'
    ]);

    $where = [
      'email' => $request->email,
      'password' => sha1($request->password)
    ];
    $result = DB::table('pelanggan')->where($where)->first();
    if ($result == null) {
      return redirect('login')->with('status', '<script>alert("username / password salah")</script>');
    }
    if ($result->status == 0) {
      return redirect('login')->with('status', '<script>alert("Maaf, User kamu belum terverifikasi silahkan cek email kamu untuk verifikasi.")</script>');
    }
    session(['pelanggan' => $result]);
    return redirect('home');
  }

  public function home()
  {
    return view('pelanggan/index');
  }

  public function logout()
  {
    session()->flush();
    return redirect('login');
  }
}
