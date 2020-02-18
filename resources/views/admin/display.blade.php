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
        <div class="col-lg-2 d-flex align-items-center">
          Logo Perusahaan
        </div>
        <div class="col-lg-10">
          :
          @if ($data->logo_perusahaan == "")
          KOSONG
          @else
          <img src="{{asset("uploads/display/$data->logo_perusahaan")}}" class="img-fluid" alt="Responsive image" width="200px" height="200px">
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2">
          Nama Perusahaan
        </div>
        <div class="col-lg-10">
          : {{$data->nama_perusahaan}}
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2">
          Alamat Perusahaan
        </div>
        <div class="col-lg-10">
          : {{$data->alamat_perusahaan}}
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2">
          Running Text
        </div>
        <div class="col-lg-10">
          : {{$data->running_text}}
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2">
          Slogan
        </div>
        <div class="col-lg-10">
          : {{$data->slogan}}
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2 d-flex align-items-center">
          Video Display
        </div>
        <div class="col-lg-10">
          :
          @if ($data->video_display == "")
          KOSONG
          @else
          <video width="320" height="240" controls>
            <source src="{{asset("uploads/display/$data->video_display")}}" type="video/mp4">
            Your browser does not support the video tag.
          </video>
          @endif
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
            <label for="exampleInputEmail1">Nama Perusahaan</label>
            <input type="hidden" name="id_display" value="{{$data->id}}">
            <input type="text" class="form-control" id="nama-perusahaan" name="nama_perusahaan"
              placeholder="Masukkan nama perusahaan" required value="{{$data->nama_perusahaan}}">
            @if ($errors->has('nama_perusahaan'))
            <small class="form-text text-danger">{{$errors->first('nama_perusahaan')}}</small>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Alamat Perusahaan</label>
            <input type="text" class="form-control" id="alamat-perusahaan" name="alamat_perusahaan"
              placeholder="Masukkan alamat perusahaan" required value="{{$data->alamat_perusahaan}}">
            @if ($errors->has('alamat_perusahaan'))
            <small class="form-text text-danger">{{$errors->first('alamat_perusahaan')}}</small>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Running Text</label>
            <input type="text" class="form-control" id="running-text" name="running_text"
              placeholder="Masukkan running text" required value="{{$data->running_text}}">
            @if ($errors->has('running_text'))
            <small class="form-text text-danger">{{$errors->first('running_text')}}</small>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Slogan</label>
            <input type="text" class="form-control" id="running-text" name="slogan"
              placeholder="Masukkan slogan" required value="{{$data->slogan}}">
            @if ($errors->has('slogan'))
            <small class="form-text text-danger">{{$errors->first('slogan')}}</small>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Logo Perusahaan</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="logo-perusahaan" name="logo_perusahaan" accept="image/*">
              <label class="custom-file-label" for="logo-perusahaan">Choose
                file</label>
            </div>
            @if ($errors->has('logo_perusahaan'))
            <small class="form-text text-danger">{{$errors->first('logo_perusahaan')}}</small>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Video Display</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="video-display" name="video_display" accept="video/*">
              <label class="custom-file-label" for="video-display">Choose
                file</label>
            </div>
            @if ($errors->has('video_display'))
            <small class="form-text text-danger">{{$errors->first('video_display')}}</small>
            @endif
          </div>
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
{{-- <script src="{{asset('js/display-admin.js')}}"></script> --}}
@if ($errors->any())
<script>
  Swal.fire({
    icon: "error",
    title: "Error",
    text: "Error saat mengubah data. Silahkan lihat keterangan errornya pada form edit"
  });
</script>
@endif
{!!session('status')!!}
@endsection
