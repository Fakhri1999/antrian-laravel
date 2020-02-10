@extends('template.master_layout_petugas')
@section('title', 'Loket')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">

      <div id="loader">
      </div>
      <input type="hidden" id="petugas-id" value="{{session('petugas_id')}}">
      <input type="hidden" id="nomor-loket" value="{{session('nomor_loket')}}">
      <!-- Page Heading -->
      <input type="hidden" id="current-antrian-id">
      <h1 class="text-center"><b>LOKET {{session('nomor_loket')}}</b></h1>
      <button id="keluar" class="btn btn-danger"><b>KELUAR</b></button>
      <a class="btn btn-info" target="_blank" href="{{url('petugas/loket/' . session('nomor_loket') . '/kepuasan')}}">KEPUASAN</a>
      <h1>HALO <b>{{strtoupper(session('petugas_name'))}}</b></h1>
      <h2>NO ANTRIAN SEKARANG<br><b><span id="current-antrian">-</span></b></h2>
      <button class="btn btn-warning text-dark" id="recall-btn"><b>RECALL</b></button>
      <select class="form-control mb-2 mt-2" id="list-antrian">
      </select>
      <button id="skip" class="btn btn-success"><b>SKIP</b></button> <button id="next"
        class="btn btn-primary"><b>NEXT</b>
      </button>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

@endsection
@section('js')
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/loket-petugas-single.js')}}"></script>
@endsection
