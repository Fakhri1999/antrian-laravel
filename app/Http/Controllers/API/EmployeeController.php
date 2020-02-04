<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
  public function getEmployee()
  {
    $result = DB::table('petugas')->get();
    return response()->json(['status' => 'success', 'message' => $result], 200);
  }

  public function addEmployee(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $insert = [
      'username' => $request->username,
      'nama' => $request->name,
      'pin' => $request->pin,
      'status' => "0"
    ];
    $isUsernameUnique = DB::table('petugas')->where('username', $insert['username'])->first() == null;
    if (!$isUsernameUnique) {
      return response()->json(['status' => 'success', 'message' => 'Username already in use'], 400);
    }
    $result = DB::table('petugas')->insert($insert);
    if ($result) {
      return response()->json(['status' => 'success', 'message' => 'Officer succesfully added'], 201);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Something gone wrong. Please fix it ASAP'], 400);
    }
  }

  public function editEmployee(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $id = $request->id;
    $update = [
      'username' => $request->username,
      'nama' => $request->name,
      'pin' => $request->pin
    ];
    $isUsernameUnique = DB::table('petugas')->where('id', '!=', $id)->where('username', $update['username'])->first() == null;
    if (!$isUsernameUnique) {
      return response()->json(['status' => 'error', 'message' => 'Username already in use'], 400);
    }
    $result = DB::table('petugas')->where('id', $id)->update($update);
    if ($result) {
      return response()->json(['status' => 'success', 'message' => 'Officer succesfully edited'], 200);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Officer not found'], 404);
    }
  }

  public function deleteEmployee(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $id = $request->id;
    $result = DB::table('petugas')->where('id', $id)->delete();
    if ($result) {
      return response()->json(['status' => 'success', 'message' => 'Officer succesfully deleted'], 204);
    } else {
      return response()->json(['status' => 'error', 'message' => 'Officer not found'], 404);
    }
  }
}
