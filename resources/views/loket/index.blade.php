@extends('template.master_layout_petugas')
@section('title', 'Loket')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <input type="hidden" id="API_KEY" value="{{$API_KEY}}">
  <input type="hidden" id="petugas_id" value="{{session('petugas_id')}}">
  <!-- Page Heading -->
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
<!-- End of Main Content -->

@endsection
@section('js')
<script src="{{asset('js/loket-petugas.js')}}"></script>
@endsection
