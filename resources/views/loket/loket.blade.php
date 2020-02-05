@extends('template.master_layout_petugas')
@section('title', 'Loket')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <input type="hidden" id="petugas_id" value="{{session('petugas_id')}}">
  <!-- Page Heading -->
  <BUTTON>KELUAR</BUTTON>
  <h1>HALO M. FIRHAN AZMI NOR</h1>
  <h1>NO ANTRIAN SEKARANG<br>301</h1>
  <button>RECALL</button>
  <select class="form-control">
  <option>Default select</option>
</select>
<BUTTON>SKIP</BUTTON><BUTTON>NEXT</BUTTON>
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
