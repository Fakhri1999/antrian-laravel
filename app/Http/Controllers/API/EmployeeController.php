<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
  public function addEmployee(Request $request)
  {
    $insert = [
      'username' => $request->username,
      'nama' => $request->name,
      'pin' => $request->pin,
      'status' => $request->status
    ];
    $isUsernameUnique = DB::table('petugas')->where('username', $insert['username'])->first() == null;
    if (!$isUsernameUnique) {
      return response()->json(['status' => 'error', 'message' => 'Username already in use'], 400);
    }
    DB::table('petugas')->insert($insert);
    return response()->json(['status' => 'success', 'message' => 'Officer succesfully added'], 201);    
  }

  public function editEmployee(Request $request)
  {
    $id = $request->id;
    $update = [
      'username' => $request->username,
      'nama' => $request->name,
      'pin' => $request->pin,
      'status' => $request->status
    ];
    $isUsernameUnique = DB::table('petugas')->where('id', '!=', $id)->where('username', $update['username'])->first() == null;
    if (!$isUsernameUnique) {
      return response()->json(['status' => 'error', 'message' => 'Username already in use'], 400);
    }
    DB::table('petugas')->where('id', $id)->update($update);
    return response()->json(['status' => 'success', 'message' => 'Officer succesfully edited'], 200);
  }
}
