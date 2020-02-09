@extends('template.master_layout_petugas')
@section('title', 'Kepuasan')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <input type="hidden" id="API_KEY" value="{{env('API_KEY')}}">
  <input type="hidden" id="petugas_id" value="{{session('petugas_id')}}">
  <input type="hidden" id="antrian_id" value="">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-12">
      <h1 class="text-center"><b>LOKET {{session('nomor_loket')}}</b></h1>
      <h1 class="text-center">NOMOR ANTRIAN <b><span id="nomorAntrian">-</span></b></h1>
    </div>
  </div>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row rowKepuasan">
        <div class="col-lg-6">
          <a href="javascrip:void">
            <img src="{{asset('img/happy.png')}}" alt="" width="40%" class="mx-auto d-block tombol" data-kepuasan="PUAS">
          </a>
          <h1 class="text-center mt-2" style="color: orange"><b>PUAS</b></h1>
        </div>
        <div class="col-lg-6">
          <a href="javascrip:void">
            <img src="{{asset('img/sad.png')}}" alt="" width="40%" class="mx-auto d-block tombol" data-kepuasan="TIDAK PUAS">
          </a>
          <h1 class="text-center mt-2" style="color: orange"><b>TIDAK PUAS</b></h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

@endsection
@section('js')
<script src="{{asset('js/kepuasan-petugas.js')}}"></script>
@endsection
