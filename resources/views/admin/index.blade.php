@extends('template.master_layout_admin')
@section('title', 'Dashboard')
@section('css')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <!-- Content Row -->
  <div class="row">
    <!-- Area Chart -->
    <div class="col-lg-12">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        {{-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
        </div> --}}
        <!-- Card Body -->
        <div class="card-body">
          <h2 class="text-center">Selamat Datang, Admin!</h2>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@section('js')
<script src="{{asset('js/jquery-3.3.1.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script>
  $(document).ready(function(){
    $(".table").DataTable();
  })
</script>
@endsection
@endsection
