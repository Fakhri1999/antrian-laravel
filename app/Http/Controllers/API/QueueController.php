<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
  public function addQueue(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    date_default_timezone_set('Asia/Jakarta');
    $timeNow = date("H:i:s");
    $dateNow = date("d-m-Y");
    $queueType = $request->type;
    $ada = false;
    $dbData = DB::table('antrian')->where('tanggal_pembuatan', $dateNow)->orderBy('id', 'desc')->get();
    if ($dbData == null) {
      DB::table('antrian')->insert([
        'nomor_antrian' => $queueType . '001',
        'tanggal_pembuatan' => $dateNow,
        'jam_pembuatan' => $timeNow,
        'status' => '1',
        'kepuasan' => '0',
        'id_layanan' => hurufLayananToAngkaLayanan($queueType),
        'id_petugas' => '0'
      ]);
    } else {
      for ($i = 0; $i < sizeof($dbData); $i++) {
        if (substr($dbData[$i]->nomor_antrian, 0, 1) == $queueType) {
          DB::table('antrian')->insert([
            'nomor_antrian' => ++$dbData[$i]->nomor_antrian,
            'tanggal_pembuatan' => $dateNow,
            'jam_pembuatan' => $timeNow,
            'status' => '1',
            'kepuasan' => '0',
            'id_layanan' => hurufLayananToAngkaLayanan($queueType),
            'id_petugas' => '0'
          ]);
          $ada = true;
          break;
        }
      }
      if (!$ada) {
        DB::table('antrian')->insert([
          'nomor_antrian' => $queueType . '001',
          'tanggal_pembuatan' => $dateNow,
          'jam_pembuatan' => $timeNow,
          'status' => '1',
          'kepuasan' => '0',
          'id_layanan' => hurufLayananToAngkaLayanan($queueType),
          'id_petugas' => '0'
        ]);
      }
    }
    return response()->json(['status' => 'success', 'message' => 'Queue succesfully added'], 201);
  }

  private function hurufLayananToAngkaLayanan($number){
    return ord($number) - 64;
  }
}