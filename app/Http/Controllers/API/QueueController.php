<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\QueueUpdated;
use App\Events\LoketQueueUpdated;
use App\Events\DisplayQueueUpdated;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\Printer;

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
    $urutanLayanan = $request->urutan_layanan;
    $idLayanan = $request->id_layanan;
    $ada = false;
    $dbData = DB::table('antrian')->where('tanggal_pembuatan', $dateNow)->orderBy('id', 'desc')->get();
    if ($dbData == null) {
      $insert = [
        'nomor_antrian' => $this->angkaLayananToHurufLayanan($urutanLayanan) . '001',
        'tanggal_pembuatan' => $dateNow,
        'jam_pembuatan' => $timeNow,
        'status' => '1',
        'kepuasan' => 'TIDAK MENGISI',
        'id_layanan' => $idLayanan,
        'id_petugas' => '0'
      ];
      DB::table('antrian')->insert($insert);
    } else {
      for ($i = 0; $i < sizeof($dbData); $i++) {
        if (substr($dbData[$i]->nomor_antrian, 0, 1) == $this->angkaLayananToHurufLayanan($urutanLayanan)) {
          $insert = [
            'nomor_antrian' => ++$dbData[$i]->nomor_antrian,
            'tanggal_pembuatan' => $dateNow,
            'jam_pembuatan' => $timeNow,
            'status' => '1',
            'kepuasan' => 'TIDAK MENGISI',
            'id_layanan' => $idLayanan,
            'id_petugas' => '0'
          ];
          DB::table('antrian')->insert($insert);
          $ada = true;
          break;
        }
      }
      if (!$ada) {
        $insert = [
          'nomor_antrian' => $this->angkaLayananToHurufLayanan($urutanLayanan) . '001',
          'tanggal_pembuatan' => $dateNow,
          'jam_pembuatan' => $timeNow,
          'status' => '1',
          'kepuasan' => 'TIDAK MENGISI',
          'id_layanan' => $idLayanan,
          'id_petugas' => '0'
        ];
        DB::table('antrian')->insert($insert);
      }
    }
    $print = $this->getRawDataForPrinter();
    event(new QueueUpdated("New queue. Please update yours"));
    return response()->json(['status' => 'success', 'message' => 'Queue succesfully added', 'data' => $insert, 'rawPrintData' => $print], 201);
  }

  private function angkaLayananToHurufLayanan($number)
  {
    return range('A', 'Z')[$number - 1];
  }

  private function getRawDataForPrinter()
  {
    $display = DB::table('display')->where('id', '1')->first();
    $antrian = DB::table('antrian')->orderBy('id', 'desc')->get();
    $arrTanggal = explode("-", $antrian[0]->tanggal_pembuatan);
    setlocale(LC_TIME, "id_ID");
    $tanggal = strftime("%A, %d %B %Y", mktime(0, 0, 0, (int) $arrTanggal[1], (int) $arrTanggal[0], (int) $arrTanggal[2]));
    $tanggalCek = explode(" ", $tanggal);
    if ($tanggalCek[2] == 'Pebruari') {
      $tanggalCek[2] = "Februari";
    }
    $tanggal = "$tanggalCek[0] $tanggalCek[1] $tanggalCek[2] $tanggalCek[3]";
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
    $printer->text($tanggal . "\n");
    $printer->text($antrian[0]->jam_pembuatan . "\n\n");
    $printer->text($display->slogan . "\n\n");
    $printer->cut();
    $data = $connector->getData();
    $printer->close();
    $base64data = base64_encode($data);
    return $base64data;
  }

  public function getQueueForEmployee()
  {
    date_default_timezone_set('Asia/Jakarta');
    $dateNow = date("d-m-Y");
    $result = DB::table('antrian AS a')
      ->select(DB::raw('a.id, a.id_layanan'))
      ->where('a.status', '1')
      ->where('a.tanggal_pembuatan', $dateNow)
      ->get();
    if (sizeof($result) == 0) {
      return response()->json(['status' => 'success', 'message' => "Queue is empty"], 200);
    } else {
      return response()->json(['status' => 'success', 'message' => $result], 200);
    }
  }

  public function takeLatestQueueFromAService(Request $request, $layananId)
  {
    date_default_timezone_set('Asia/Jakarta');
    $petugasId = $request->id_petugas;
    $nomorLoket = $request->nomor_loket;
    $dateNow = date("d-m-Y");
    $result = DB::table('antrian')->where('tanggal_pembuatan', $dateNow)->where('status', '1')->where('id_layanan', $layananId)->orderBy('jam_pembuatan', 'asc')->get();
    if (sizeof($result) == 0) {
      event(new LoketQueueUpdated(["nomor_loket" => $nomorLoket, "message" => "New queue. Please update yours"]));
      return response()->json(['status' => 'success', 'message' => 'Queue for this service is empty'], 200);
    }
    DB::table('antrian')->where('id', $result[0]->id)->update(['id_petugas' => $petugasId, 'status' => '10']);
    DB::table('loket')->where('id_petugas', $petugasId)->update(['id_antrian' => $result[0]->id]);
    event(new QueueUpdated("New queue. Please update yours"));
    event(new LoketQueueUpdated(["nomor_loket" => $nomorLoket, "message" => "New queue. Please update yours"]));
    $queue = DB::table('loket AS l')
      ->join('antrian AS a', 'a.id', 'l.id_antrian')
      ->where('l.id_petugas', $petugasId)
      ->where('a.kepuasan', '=', 'TIDAK MENGISI')
      ->first();
    event(new DisplayQueueUpdated(["antrian" => $queue, "message" => "New queue. Please update yours"]));
    return response()->json(['status' => 'success', 'message' => $result[0]], 200);
  }

  public function skipLatestQueueFromAService(Request $request, $layananId)
  {
    date_default_timezone_set('Asia/Jakarta');
    $petugasId = $request->id_petugas;
    $currentId = $request->id_antrian;
    $nomorLoket = $request->nomor_loket;
    $dateNow = date("d-m-Y");
    DB::table('antrian')->where('id', $currentId)->update(['id_petugas' => $petugasId, 'status' => '9']);
    $result = DB::table('antrian')
      ->where('tanggal_pembuatan', $dateNow)
      ->where('status', '1')
      ->where('id_layanan', $layananId)
      ->orderBy('jam_pembuatan', 'asc')->get();
    if (sizeof($result) == 0) {
      DB::table('loket')->where('id_petugas', $petugasId)->update(['id_antrian' => '0']);
      event(new LoketQueueUpdated(["nomor_loket" => $nomorLoket, "message" => "New queue. Please update yours"]));
      return response()->json(['status' => 'success', 'message' => 'Queue for this service is empty'], 200);
    }
    DB::table('antrian')->where('id', $result[0]->id)->update(['id_petugas' => $petugasId, 'status' => '10']);
    DB::table('loket')->where('id_petugas', $petugasId)->update(['id_antrian' => $result[0]->id]);
    event(new QueueUpdated("New queue. Please update yours"));
    event(new LoketQueueUpdated(["nomor_loket" => $nomorLoket, "message" => "New queue. Please update yours"]));
    $queue = DB::table('loket AS l')
      ->join('antrian AS a', 'a.id', 'l.id_antrian')
      ->where('l.id_petugas', $petugasId)
      ->where('a.kepuasan', '=', 'TIDAK MENGISI')
      ->first();
    event(new DisplayQueueUpdated(["antrian" => $queue, "message" => "New queue. Please update yours"]));
    return response()->json(['status' => 'success', 'message' => $result[0]], 200);
  }

  public function getCurrentQueueInALoket(Request $request, $petugasId)
  {
    date_default_timezone_set('Asia/Jakarta');
    $result = DB::table('loket AS l')
      ->join('antrian AS a', 'a.id', 'l.id_antrian')
      ->where('l.id_petugas', $petugasId)
      ->where('a.kepuasan', '=', 'TIDAK MENGISI')
      ->first();
    return response()->json(['status' => 'success', 'message' => $result], 200);
  }

  public function updateKepuasanOfQueue(Request $request)
  {
    if ($request->auth != env('API_KEY')) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    $antrianId = $request->antrianId;
    $update = [
      'kepuasan' => $request->kepuasan
    ];
    DB::table('antrian')->where('id', $antrianId)->update($update);
    return response()->json(['status' => 'success', 'message' => $update], 200);
  }
  public function recall(Request $request)
  {
    $petugasId = $request->id_petugas;
    date_default_timezone_set('Asia/Jakarta');
    $result = DB::table('loket AS l')
      ->join('antrian AS a', 'a.id', 'l.id_antrian')
      ->where('l.id_petugas', $petugasId)
      ->where('a.kepuasan', '=', 'TIDAK MENGISI')
      ->first();
    event(new DisplayQueueUpdated(["antrian" => $result, "message" => "New queue. Please update yours"]));
  }

  public function getQueueForAdminByDate($jumlah = 30){
    if($jumlah == null || $jumlah == 'all'){
      $antrianId = DB::table('antrian')
      ->select(DB::raw('count(*) as jumlah, tanggal_pembuatan'))
      ->where('id', '>', '0')
      ->groupBy('tanggal_pembuatan')
      ->orderBy('id', 'asc')
      ->get();
    } else{
      $antrianId = DB::table('antrian')
      ->select(DB::raw('count(*) as jumlah, tanggal_pembuatan'))
      ->where('id', '>', '0')
      ->groupBy('tanggal_pembuatan')
      ->orderBy('id', 'asc')
      ->limit($jumlah)
      ->get();
    }
    return response()->json(['status' => 'success', 'message' => $antrianId], 200);
  }

  public function addQueueOnline(Request $request){
    $pelangganWhere = [
      'id' => $request->id_pelanggan,
      'password' => $request->password_pelangggan
    ];
    $pelangganData = DB::table('pelanggan')->where($pelangganWhere)->first();

    if ($pelangganData == null) {
      return response()->json(['status' => 'error', 'message' => 'You are unauthorized to do this action'], 401);
    }
    date_default_timezone_set('Asia/Jakarta');
    $timeNow = date("H:i:s");
    $dateNow = date("d-m-Y");
    // if(!$this->checkSyaratAddAntrianOnline()){
    //   return 
    // }
    $urutanLayanan = $request->urutan_layanan;
    $idLayanan = $request->id_layanan;
    $ada = false;
    $dbData = DB::table('antrian')->where('tanggal_pembuatan', $dateNow)->orderBy('id', 'desc')->get();
    if ($dbData == null) {
      $insert = [
        'nomor_antrian' => $this->angkaLayananToHurufLayanan($urutanLayanan) . '001',
        'tanggal_pembuatan' => $dateNow,
        'jam_pembuatan' => $timeNow,
        'status' => '1',
        'kepuasan' => 'TIDAK MENGISI',
        'id_layanan' => $idLayanan,
        'id_petugas' => '0',
        'id_pelanggan' => $request->id_pelanggan
      ];
      DB::table('antrian')->insert($insert);
    } else {
      for ($i = 0; $i < sizeof($dbData); $i++) {
        if (substr($dbData[$i]->nomor_antrian, 0, 1) == $this->angkaLayananToHurufLayanan($urutanLayanan)) {
          $insert = [
            'nomor_antrian' => ++$dbData[$i]->nomor_antrian,
            'tanggal_pembuatan' => $dateNow,
            'jam_pembuatan' => $timeNow,
            'status' => '1',
            'kepuasan' => 'TIDAK MENGISI',
            'id_layanan' => $idLayanan,
            'id_petugas' => '0',
            'id_pelanggan' => $request->id_pelanggan
          ];
          DB::table('antrian')->insert($insert);
          $ada = true;
          break;
        }
      }
      if (!$ada) {
        $insert = [
          'nomor_antrian' => $this->angkaLayananToHurufLayanan($urutanLayanan) . '001',
          'tanggal_pembuatan' => $dateNow,
          'jam_pembuatan' => $timeNow,
          'status' => '1',
          'kepuasan' => 'TIDAK MENGISI',
          'id_layanan' => $idLayanan,
          'id_petugas' => '0',
          'id_pelanggan' => $request->id_pelanggan
        ];
        DB::table('antrian')->insert($insert);
      }
    }
    event(new QueueUpdated("New queue. Please update yours"));
    return response()->json(['status' => 'success', 'message' => 'Queue succesfully added', 'data' => $insert], 201);
  }

  public function checkSyaratAddAntrianOnline(){
    date_default_timezone_set('Asia/Jakarta');
    $day = date("w");
    $timeNow = date("H:i:s");
    $dateNow = date("d-m-Y");
    $queueCount = DB::table('antrian')->where('tanggal_pembuatan', $dateNow)->first();    
    if($day >= 1 && $day <= 5 && $timeNow > '07:59:59' && $timeNow < '15:00:00' && sizeof($queueCount) < 76){
      return true;
    } else {
      return false;
    }
  }
}
