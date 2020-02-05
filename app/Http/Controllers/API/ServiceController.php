<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
  public function getService()
  {
    $result = DB::table('layanan')->where('id', '>', '0')->get();
    return response()->json(['status' => 'success', 'message' => $result], 200);
  }

  public function addService(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $insert = [
      'nama_layanan' => $request->nama
    ];
    $isNameUnique = DB::table('layanan')->where('nama_layanan', $insert['nama_layanan'])->first() == null;
    if (!$isNameUnique) {
      return response()->json(['status' => 'error', 'message' => 'Name already in use'], 400);
    }
    $result = DB::table('layanan')->insert($insert);
    if ($result) {
      return response()->json(['status' => 'success', 'message' => 'Service succesfully added'], 201);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Something gone wrong. Please fix it ASAP'], 400);
    }
  }

  public function editService(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $id = $request->id;
    $update = [
      'nama_layanan' => $request->nama
    ];
    $isNameUnique = DB::table('layanan')->where('id', '!=', $id)->where('nama_layanan', $update['nama_layanan'])->first() == null;
    if (!$isNameUnique) {
      return response()->json(['status' => 'error', 'message' => 'Name already in use'], 400);
    }
    $result = DB::table('layanan')->where('id', $id)->update($update);
    if ($result) {
      return response()->json(['status' => 'success', 'message' => 'Service succesfully edited'], 200);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Something gone wrong. Please fix it ASAP'], 400);
    }
  }

  public function deleteService(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $id = $request->id;
    $result = DB::table('layanan')->where('id', $id)->delete();
    if ($result) {
      return response()->json([], 204);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Service not found'], 404);
    }
  }

  public function changeStatusService(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $id = $request->id;
    $serviceBefore = DB::table('layanan')->where('id', $id)->first();
    if ($serviceBefore == null) {
      return response()->json(['status' => 'error', 'message' => 'Service not found'], 404);
    }
    $update = $serviceBefore->status == 0 ? ['status' => '1'] : ['status' => '0'];
    $result = DB::table('layanan')->where('id', $id)->update($update);
    if ($result) {
      return response()->json(['status' => 'success', 'message' => 'Service status succesfully changed'], 200);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Something gone wrong. Please fix it ASAP'], 400);
    }
  }
}
