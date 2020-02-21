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
      $display = DB::table('display')->where('id', '1')->first();
      $antrian = DB::table('antrian')->orderBy('id', 'desc')->get();
      $connector = new DummyPrintConnector();
      $printer = new Printer($connector);
      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->setFont(Printer::FONT_B);
      $printer->setEmphasis(true);
      $printer->setTextSize(3, 3);
      $printer->setEmphasis(false);
      $printer->text("\n");
      $arr = explode(" ", $display->nama_perusahaan);
      $printer->text("$arr[0] $arr[1]\n$arr[2] $arr[3]" . "\n\n");
      $printer->setTextSize(1, 1);
      $printer->text($display->alamat_perusahaan . "\n\n");
      $printer->text("Nomor Antrian\n");
      $printer->setTextSize(8, 8);
      $printer->setEmphasis(true);
      $printer->text($antrian[0]->nomor_antrian . "\n\n");
      $printer->setEmphasis(false);
      $printer->setTextSize(1, 1);
      $printer->text($antrian[0]->tanggal_pembuatan . "\n");
      $printer->text($antrian[0]->jam_pembuatan . "\n\n");
      $printer->text($display->slogan . "\n\n");
      $printer->cut();
      $data = $connector->getData();
      $printer->close();
      $base64data = base64_encode($data);
      $arrTanggal = explode("-", $antrian[0]->tanggal_pembuatan);
      setlocale(LC_TIME, "id_ID");
      $tanggal = strftime("%A, %d %B %Y", mktime(0, 0, 0, (int)$arrTanggal[1], (int)$arrTanggal[0], (int)$arrTanggal[2]));
      $tanggalCek = explode(" ", $tanggal);
      if($tanggalCek[2] == 'Pebruari'){
        $tanggalCek[2] = "Februari";
      }
      $tanggal = "$tanggalCek[0] $tanggalCek[1] $tanggalCek[2] $tanggalCek[3]";
      return view('print_2', ['data' => $base64data, 'tanggal' => $tanggal]);
    } catch (Exception $e) {
      echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
    }
  }
}
