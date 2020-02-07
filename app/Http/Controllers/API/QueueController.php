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
        'kepuasan' => 'TIDAK MENGISI',
        'id_layanan' => $this->hurufLayananToAngkaLayanan($queueType),
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
            'kepuasan' => 'TIDAK MENGISI',
            'id_layanan' => $this->hurufLayananToAngkaLayanan($queueType),
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
          'kepuasan' => 'TIDAK MENGISI',
          'id_layanan' => $this->hurufLayananToAngkaLayanan($queueType),
          'id_petugas' => '0'
        ]);
      }
    }
    return response()->json(['status' => 'success', 'message' => 'Queue succesfully added'], 201);
  }

  private function hurufLayananToAngkaLayanan($number){
    return ord($number) - 64;
  }

  public function getQueueForPetugas(){
    date_default_timezone_set('Asia/Jakarta');
    $dateNow = date("d-m-Y");
    $result = DB::table('antrian AS a')
    ->select(DB::raw('a.id_layanan, l.nama_layanan, count(*) as jumlah'))
    ->join('layanan AS l', 'l.id', 'a.id_layanan')
    ->where('a.status', '1')
    ->where('a.tanggal_pembuatan', $dateNow)
    ->groupBy('a.id_layanan')
    ->get();
    if(sizeof($result) == 0){
      return response()->json(['status' => 'success', 'message' => "Queue is empty"], 200);
    } else {
      return response()->json(['status' => 'success', 'message' => $result], 200);
    }
  }

  public function takeLatestQueueFromAService(Request $request, $layananId){
    date_default_timezone_set('Asia/Jakarta');
    $petugasId = $request->id_petugas;
    $dateNow = date("d-m-Y");
    $result = DB::table('antrian')->where('tanggal_pembuatan', $dateNow)->where('status', '1')->where('id_layanan', $layananId)->orderBy('jam_pembuatan', 'asc')->get();
    if(sizeof($result) == 0){
      return response()->json(['status' => 'success', 'message' => 'Queue for this service is empty'], 200);
    }
    DB::table('antrian')->where('id', $result[0]->id)->update(['id_petugas' => $petugasId, 'status' => '10']);
    return response()->json(['status' => 'success', 'message' => $result[0]], 200);
  }

  public function skipLatestQueueFromAService(Request $request, $layananId){
    date_default_timezone_set('Asia/Jakarta');
    $petugasId = $request->id_petugas;
    $currentId = $request->id_antrian;
    $dateNow = date("d-m-Y");
    DB::table('antrian')->where('id', $currentId)->update(['id_petugas' => $petugasId, 'status' => '9']);
    $result = DB::table('antrian')->where('tanggal_pembuatan', $dateNow)->where('status', '1')->where('id_layanan', $layananId)->orderBy('jam_pembuatan', 'asc')->get();
    if(sizeof($result) == 0){
      return response()->json(['status' => 'success', 'message' => 'Queue for this service is empty'], 200);
    }
    DB::table('antrian')->where('id', $result[0]->id)->update(['id_petugas' => $petugasId, 'status' => '10']);
    return response()->json(['status' => 'success', 'message' => $result[0]], 200);
  }
}
