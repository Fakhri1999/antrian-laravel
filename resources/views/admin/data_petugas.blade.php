@extends('template.master_layout_admin')
@section('title', 'Petugas')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <input type="hidden" id="API_KEY" value="{{$API_KEY}}">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="#" class="mb-0 btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addEmployeeModal">
      <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Petugas</a>
  </div>
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Data Petugas</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" cellspacing="0">
          <thead>
            <tr>
              <th style="width: 5%">ID</th>
              <th style="width: 15%">Username</th>
              <th style="width: 25%">Nama</th>
              <th style="width: 10%">PIN</th>
              <th style="width: 25%">Status</th>
              <th style="width: 10%">Aksi</th>
            </tr>
          </thead>
          <tbody id="isiTablePetugas">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- Add Petugas Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Petugas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Username</label>
          <input type="text" class="form-control" id="petugasUseranameAdd" placeholder="Masukkan username">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Nama</label>
          <input type="text" class="form-control" id="petugasNamaAdd" placeholder="Masukkan nama">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Pin</label>
          <input type="text" class="form-control" id="petugasPinAdd" placeholder="Masukkan pin">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="submitTambahPetugas">Tambah</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Petugas Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Petugas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" id="petugasIdEdit">
          <label for="exampleInputEmail1">Username</label>
          <input type="text" class="form-control" id="petugasUseranameEdit" placeholder="Masukkan username">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Nama</label>
          <input type="text" class="form-control" id="petugasNamaEdit" placeholder="Masukkan nama">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Pin</label>
          <input type="text" class="form-control" id="petugasPinEdit" placeholder="Masukkan pin">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="submitEditPetugas">Edit</button>
      </div>
    </div>
  </div>
</div>
<!-- End of Main Content -->

@endsection
@section('js')
<script src="{{asset('js/petugas.js')}}"></script>
@endsection
