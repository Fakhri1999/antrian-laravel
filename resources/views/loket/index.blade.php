@extends('template.master_layout_petugas')
@section('title', 'Loket')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <input type="hidden" id="API_KEY" value="{{$API_KEY}}">
  <!-- Page Heading -->
  {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="#" class="mb-0 btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addCounterModal">
      <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Loket</a>
      <a href="#" class="mb-0 btn btn-sm btn-success shadow-sm resetLoket"><b>RESET SEMUA</b></a>
  </div> --}}
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row rowLoket">
        <div id="loader">
        </div>
      </div>
    </div>
  </div>
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
<script src="{{asset('js/loket-petugas.js')}}"></script>
@endsection
