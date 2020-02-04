<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CounterController extends Controller
{
  public function getAllCounter(Request $request)
  {
    $result = DB::table('loket AS lo')
      ->join('petugas AS p', 'lo.id_petugas', '=', 'p.id')
      ->join('antrian AS a', 'lo.id_antrian', '=', 'a.id')
      ->join('layanan AS la', 'a.pilihan_layanan', '=', 'la.id')
      ->select('lo.*', 'a.nomor_antrian', 'p.nama as nama_petugas', 'la.nama_layanan')
      ->orderBy('lo.id', 'asc')
      ->get();
    return response()->json(['status' => 'success', 'message' => $result], 200);
  }

  public function resetAllCounter(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $update = [
      'status' => '0',
      'id_petugas' => '0',
      'id_antrian' => '0'
    ];
    DB::table('loket')->update($update);
    return response()->json(['status' => 'success', 'message' => 'Counter succesfully resetted'], 200);
  }
}
