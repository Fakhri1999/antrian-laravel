<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
  public function addQueue(Request $request)
  {
    date_default_timezone_set('Asia/Jakarta');
    $timeNow = date("d-m-Y H:i:s");
    $dateNow = date("d-m-Y");
    $queueType = $request->type;
    $ada = false;
    if ($request->auth != 'inikodenya') {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $dbData = DB::table('antrian')->orderBy('id', 'desc')->get();
    for ($i = 0; $i < sizeof($dbData); $i++) {
      if (substr($dbData[$i]->nomor_antrian, 0, 1) == $queueType) {
        $latestDate = explode(" ", $dbData[$i]->waktu_pembuatan)[0];
        if ($latestDate != $dateNow) {
          DB::table('antrian')->insert([
            'nomor_antrian' => $queueType . '000',
            'waktu_pembuatan' => $timeNow,
            'status' => '1'
          ]);
        } else {
          DB::table('antrian')->insert([
            'nomor_antrian' => ++$dbData[$i]->nomor_antrian,
            'waktu_pembuatan' => $timeNow,
            'status' => '1'
          ]);
        }
        $ada = true;
        break;
      }
    }
    if (!$ada) {
      DB::table('antrian')->insert([
        'nomor_antrian' => $queueType . '000',
        'waktu_pembuatan' => $timeNow,
        'status' => '1'
      ]);
    }
    return response()->json(['status' => 'success', 'message' => 'Queue succesfully added'], 201);
  }
}
