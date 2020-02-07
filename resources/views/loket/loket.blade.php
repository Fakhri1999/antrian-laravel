@extends('template.master_layout_petugas')
@section('title', 'Loket')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <input type="hidden" id="petugas-id" value="{{session('petugas_id')}}">
  <!-- Page Heading -->
  <input type="hidden" id="current-antrian-id">
  <button id="keluar" class="btn btn-danger"><b>KELUAR</b></button>
  <h1>HALO <b>{{strtoupper(session('petugas_name'))}}</b></h1>
  <h2>NO ANTRIAN SEKARANG<br><b><span id="current-antrian">-</span></b></h2>
  <button class="btn btn-warning text-dark" id="recall-btn"><b>RECALL</b></button>
  <select class="form-control mb-2 mt-2" id="list-antrian">
  </select>
  <button id="skip" class="btn btn-success"><b>SKIP</b></button> <button id="next" class="btn btn-primary"><b>NEXT</b></button>
</div>
<!-- /.container-fluid -->
</div>
<!-- Add Loket Modal -->
<div class="modal fade" id="addCounterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Loket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama Loket</label>
          <input type="text" class="form-control" id="loketNameAdd" placeholder="Masukkan nama" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="submitTambahLoket">Tambah</button>
      </div>
    </div>
  </div>
</div>
<!-- End of Main Content -->

@endsection
@section('js')
<script src="{{asset('js/loket-petugas-single.js')}}"></script>
@endsection
