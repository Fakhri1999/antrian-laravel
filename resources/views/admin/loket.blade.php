@extends('template.master_layout_admin')
@section('title', 'Petugas')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <input type="hidden" id="API_KEY" value="{{$API_KEY}}">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="#" class="mb-0 btn btn-sm btn-primary shadow-sm resetLoket">RESET SEMUA</a>
  </div>
  <div class="row rowLoket">
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

@endsection
@section('js')
<script src="{{asset('js/loket-admin.js')}}"></script>
@endsection
