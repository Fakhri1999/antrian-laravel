<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\QueueUpdated;

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
    $pelangganWhere = [
      'id' => $request->id,
      'password' => base64_decode($request->password)
    ];
    $pelangganData = DB::table('pelanggan')->where($pelangganWhere)->first();

    if ($pelangganData == null) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    date_default_timezone_set('Asia/Jakarta');
    $timeNow = date("H:i:s");
    $dateNow = date("d-m-Y");
    if (!$this->isJumlahAntrianDibawahBatas()) {
      return response()->json(['status' => 'error', 'message' => 'Jumlah antrian online untuk hari ini sudah melebihi batas maksimal'], 400);
    }

    if (!$this->isAntrianDidalamJamOperasional()) {
      return response()->json(['status' => 'error', 'message' => 'Antrian online hanya dapat digunakan pada hari kerja dan pada jam 08:00 - 14:00'], 400);
    }
    $urutanLayanan = $request->urutan_layanan;
    $idLayanan = $request->id_layanan;
    $ada = false;
    $dbData = DB::table('antrian')->where('tanggal_pembuatan', $dateNow)->orderBy('id', 'desc')->get();
    if ($dbData == null) {
      $insert = [
        'nomor_antrian' => $this->angkaLayananToHurufLayanan($urutanLayanan) . '001',
        'tanggal_pembuatan' => $dateNow,
        'jam_pembuatan' => $timeNow,
        'status' => '1',
        'kepuasan' => 'TIDAK MENGISI',
        'id_layanan' => $idLayanan,
        'id_petugas' => '0',
        'id_pelanggan' => $request->id
      ];
      DB::table('antrian')->insert($insert);
    } else {
      for ($i = 0; $i < sizeof($dbData); $i++) {
        if (substr($dbData[$i]->nomor_antrian, 0, 1) == $this->angkaLayananToHurufLayanan($urutanLayanan)) {
          $insert = [
            'nomor_antrian' => ++$dbData[$i]->nomor_antrian,
            'tanggal_pembuatan' => $dateNow,
            'jam_pembuatan' => $timeNow,
            'status' => '1',
            'kepuasan' => 'TIDAK MENGISI',
            'id_layanan' => $idLayanan,
            'id_petugas' => '0',
            'id_pelanggan' => $request->id
          ];
          DB::table('antrian')->insert($insert);
          $ada = true;
          break;
        }
      }
      if (!$ada) {
        $insert = [
          'nomor_antrian' => $this->angkaLayananToHurufLayanan($urutanLayanan) . '001',
          'tanggal_pembuatan' => $dateNow,
          'jam_pembuatan' => $timeNow,
          'status' => '1',
          'kepuasan' => 'TIDAK MENGISI',
          'id_layanan' => $idLayanan,
          'id_petugas' => '0',
          'id_pelanggan' => $request->id
        ];
        DB::table('antrian')->insert($insert);
      }
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
      event(new QueueUpdated("New queue. Please update yours"));
      return response()->json(['status' => 'success', 'message' => "Antrian berhasil ditambah"], 201);
    } else {
      return response()->json(['status' => 'error', 'message' => "Error saat menambahkan antrian"], 400);
    }
  }

  private function angkaLayananToHurufLayanan($number)
  {
    return range('A', 'Z')[$number - 1];
  }

  public function isJumlahAntrianDibawahBatas()
  {
    date_default_timezone_set('Asia/Jakarta');
    $dateNow = date("d-m-Y");
    $queueCount = DB::table('antrian')->where('tanggal_pembuatan', $dateNow)->where('id_pelanggan', '>', '0')->get();
    if (sizeof($queueCount) < 76) {
      return true;
    } else {
      return false;
    }
  }

  private function isAntrianDidalamJamOperasional()
  {
    return true;
    date_default_timezone_set('Asia/Jakarta');
    $day = date("w");
    $timeNow = date("H:i:s");
    if ($day >= 1 && $day <= 5 && $timeNow > '07:59:59' && $timeNow < '14:00:01') {
      return true;
    } else {
      return false;
    }
  }

  public function resetWaktuAntrian()
  {
    $result = DB::table('pelanggan')->get();
    date_default_timezone_set('Asia/Jakarta');
    $timeNow = date("d-m-Y H:i:s");
    $dateNow = new DateTime($timeNow);
    foreach ($result as $row) {
      $timeLama = $row->antrian_updated_at == null ? '01-01-2000 00:00:00' : $row->antrian_updated_at;
      $dateLama = new DateTime($timeLama);
      $interval = $dateLama->diff($dateNow);
      if ($interval->y < 1 && $interval->m < 1 && $interval->d < 1 && $interval->h < 1) {
        // Do nothing
      } else {
        if ($row->status == '10') {
          DB::table('pelanggan')->where('id', $row->id)->update(['status' => '1']);
        }
      }
    }
    return response()->json(['status' => 'success', 'message' => 'Berhasil'], 200);
  }
}
