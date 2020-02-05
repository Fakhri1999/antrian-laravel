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
    $updateCounter = [
      'status' => '0',
      'id_petugas' => '0',
      'id_antrian' => '0'
    ];
    DB::table('loket')->update($updateCounter);
    $updateEmployee = [
      'status' => '0'
    ];
    DB::table('petugas')->update($updateEmployee);
    return response()->json(['status' => 'success', 'message' => 'Counter succesfully resetted'], 200);
  }

  public function addCounter(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $insert = [
      'nomor_loket' => $request->nama
    ];
    $isNameUnique = DB::table('loket')->where('nomor_loket', $insert['nomor_loket'])->first() == null;
    if (!$isNameUnique) {
      return response()->json(['status' => 'success', 'message' => 'Counter name already in use'], 400);
    }
    $result = DB::table('loket')->insert($insert);
    if ($result) {
      return response()->json(['status' => 'success', 'message' => 'Counter succesfully added'], 201);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Something gone wrong. Please fix it ASAP'], 400);
    }
  }

  public function resetSingleCounter(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $id = $request->id;
    $counter = DB::table('loket')->where('id', $id)->first();
    if ($counter == null) {
      return response()->json(['status' => 'error', 'message' => 'Counter not found'], 404);
    }
    $updateCounter = ['status' => '0', 'id_petugas' => '0', 'id_antrian' => '0'];
    $updateEmployee = ['status' => '0'];
    DB::table('petugas')->where('id', $counter->id_petugas)->update($updateEmployee);
    $result = DB::table('loket')->where('id', $id)->update($updateCounter);
    if ($result) {
      return response()->json(['status' => 'success', 'message' => 'Counter succesfully resetted'], 200);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Something gone wrong. Please fix it ASAP'], 400);
    }
  }

  public function deleteCounter(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $id = $request->id;
    $result = DB::table('loket')->where('id', $id)->delete();
    if ($result) {
      return response()->json([], 204);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Counter not found'], 404);
    }
  }
}
