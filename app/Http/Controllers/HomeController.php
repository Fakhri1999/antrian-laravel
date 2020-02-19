<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\Printer;

class HomeController extends Controller
{
  public function showHome()
  {
    $result = DB::table('layanan')->where('id', '>', '0')->get();
    $display = DB::table('display')->where('id', 1)->first();
    return view('home', ['API_KEY' => env("API_KEY"), 'layanan' => $result, 'data' => $display]);
  }

  public function tes()
  {
    echo public_path();
  }

  public function showDisplay()
  {
    $result = DB::table('display')->where('id', 1)->first();
    return view('display', ['data' => $result]);
  }

  public function printAntrian()
  {
    try {
      $data = DB::table('display')->where('id', '1')->first();
      $antrian = DB::table('antrian')->orderBy('id', 'desc')->get();
      $connector = new DummyPrintConnector();
      $printer = new Printer($connector);
      // $printer->initialize();
      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->setTextSize(3, 3);
      $printer->text($data->nama_perusahaan . "\n");
      $printer->setTextSize(2, 2);
      $printer->text($data->alamat_perusahaan . "\n");
      $printer->setTextSize(5, 5);
      $printer->text($antrian[0]->nomor_antrian . "\n");
      $data = $connector->getData();
      $printer->close();
      $base64data = base64_encode($data);
      return view('print_2', ['data' => $base64data]);
    } catch (Exception $e) {
      echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
    }
  }
}
