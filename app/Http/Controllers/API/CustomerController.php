<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
  public function addQueue(Request $request)
  {
    $pelanggan = DB::table('pelanggan')->where('id', $request->id)->first();
    date_default_timezone_set('Asia/Jakarta');
    $timeLama = $pelanggan->antrian_updated_at == null ? '01-01-2000 00:00:00' : $pelanggan->antrian_updated_at;
    $timeNow = date("d-m-Y H:i:s");
    $dateLama = new DateTime($timeLama);
    $dateNow = new DateTime($timeNow);
    $interval = $dateLama->diff($dateNow);
    if ($interval->y < 1 && $interval->m < 1 && $interval->d < 1 && $interval->h < 1) {
      $minutes = $interval->s > 0 ? 60 - $interval->i - 1 : 60 - $interval->i;
      $second = $interval->s == '0' ? 0 : 60 - $interval->s;
      return response()->json(['status' => 'error', 'message' => "Anda harus menunggu $minutes Menit $second detik untuk melakukan antrian lagi"], 400);
    }
    $where = [
      'id' => $request->id,
      'password' => base64_decode($request->password)
    ];
    $update = [
      'status' => '10',
      'antrian_updated_at' => $timeNow
    ];
    $result = DB::table('pelanggan')->where($where)->update($update);
    if ($result) {
      return response()->json(['status' => 'success', 'message' => "Antrian berhasil ditambah"], 200);
    } else {
      return response()->json(['status' => 'error', 'message' => "Error saat menambahkan antrian"], 400);
    }
  }

  public function resetWaktuAntrian()
  {
    $result = DB::table('pelanggan')->get();
    foreach ($result as $row) {
      date_default_timezone_set('Asia/Jakarta');
      $timeLama = $row->antrian_updated_at == null ? '01-01-2000 00:00:00' : $row->antrian_updated_at;
      $timeNow = date("d-m-Y H:i:s");
      $dateLama = new DateTime($timeLama);
      $dateNow = new DateTime($timeNow);
      $interval = $dateLama->diff($dateNow);
      if ($interval->y < 1 && $interval->m < 1 && $interval->d < 1 && $interval->h < 1) {
        // Do nothing
      } else {
        if($row->status == '10'){
          DB::table('pelanggan')->where('id', $row->id)->update(['status' => '1']);
        }
      }
    }
    return response()->json(['status' => 'success', 'message' => 'Berhasil'], 200);
  }
}
