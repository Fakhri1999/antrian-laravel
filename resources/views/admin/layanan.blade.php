@extends('template.master_layout_admin')
@section('title', 'Layanan')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <input type="hidden" id="API_KEY" value="{{$API_KEY}}">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="#" class="mb-0 btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addServiceModal">
      <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Layanan</a>
  </div>
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Data Layanan</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" cellspacing="0">
          <thead>
            <tr>
              <th style="width: 5%">ID</th>
              <th style="width: 25%">Nama Layanan</th>
              <th style="width: 10%">Status</th>
              <th style="width: 15%">Aksi</th>
            </tr>
          </thead>
          <tbody id="isiTableLayanan">
            <div id="loader">
            </div>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- Add Layanan Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Layanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama Layanan</label>
          <input type="text" class="form-control" id="layananNamaAdd" placeholder="Masukkan nama" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="submitTambahLayanan">Tambah</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Layanan Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Layanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" id="layananIdEdit">
          <label for="exampleInputEmail1">Nama Layanan</label>
          <input type="text" class="form-control" id="layananNamaEdit" placeholder="Masukkan nama" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="submitEditLayanan">Edit</button>
      </div>
    </div>
  </div>
</div>
<!-- End of Main Content -->

@endsection

@section('js')
<script src="{{asset('js/layanan.js')}}"></script>
@endsection
