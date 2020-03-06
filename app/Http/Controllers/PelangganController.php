<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganController extends Controller
{
  public function showRegister()
  {
    return view('pelanggan/register');
  }

  public function register(Request $request)
  {
  }
}
