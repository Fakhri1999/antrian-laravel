@extends('template.master_layout_admin')
@section('title', 'Display')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <input type="hidden" id="API_KEY" value="{{$API_KEY}}">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="#" class="mb-0 btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#edit-data-display">
      <i class="fas fa-plus fa-sm text-white-50"></i> Edit Data Display
    </a>
  </div>
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Display</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-2">
          Logo Perusahaan
        </div>
        <div class="col-lg-10">
          :
          <div id="logo-perusahaan">
            {{$data->logo_perusahaan}}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2">
          Nama Perusahaan
        </div>
        <div class="col-lg-10">
          :
          {{$data->nama_perusahaan}}
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2">
          Alamat Perusahaan
        </div>
        <div class="col-lg-10">
          :
          {{$data->alamat_perusahaan}}
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2">
          Running Text
        </div>
        <div class="col-lg-10">
          :
          {{$data->running_text}}
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2">
          Video Display
        </div>
        <div class="col-lg-10">
          :
          {{$data->video_display}}
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- Edit Layanan Modal -->
<div class="modal fade" id="edit-data-display" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Display</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{url('admin/display')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" id="display-id">
            <label for="exampleInputEmail1">Nama Perusahaan</label>
            <input type="text" class="form-control" id="nama-perusahaan" name="nama-perusahaan"
              placeholder="Masukkan nama perusahaan">
            @if ($errors->has('nama-perusahaan'))
            <small class="form-text text-danger">{{$errors->first('nama-perusahaan')}}</small>
            @endif
          </div>
          <div class="form-group">
            <input type="hidden" id="display-id">
            <label for="exampleInputEmail1">Alamat Perusahaan</label>
            <input type="text" class="form-control" id="alamat-perusahaan" name="alamat-perusahaan"
              placeholder="Masukkan alamat perusahaan" required>
          </div>
          <div class="form-group">
            <input type="hidden" id="display-id">
            <label for="exampleInputEmail1">Running Text</label>
            <input type="text" class="form-control" id="running-text" name="running-text"
              placeholder="Masukkan running text" required>
          </div>
          {{-- <div class="form-group">
            <input type="hidden" id="display-id">
            <label for="exampleInputEmail1">Logo Perusahaan</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="logo-perusahaan" name="logo-perusahaan" accept="image/*">
              <label class="custom-file-label" for="logo-perusahaan">Choose
                file</label>
            </div>
          </div>
          <div class="form-group">
            <input type="hidden" id="display-id">
            <label for="exampleInputEmail1">Video Display</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="video-display" name="logo-perusahaan" accept="video/*">
              <label class="custom-file-label" for="video-display">Choose
                file</label>
            </div>
          </div> --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary" id="submitEditLayanan">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End of Main Content -->

@endsection

@section('js')
<script src="{{asset('js/display-admin.js')}}"></script>
@endsection
