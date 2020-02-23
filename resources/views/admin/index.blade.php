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
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Grafik Jumlah Antrian (Semua layanan)</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <h2 class="text-center">Selamat Datang, Admin!</h2>
          <div class="d-flex flex-row align-items-center justify-content-end">
            Pilih jumlah data
            <select class="ml-2" id="jumlahData" onchange="updateData(this)">
              <option value="30">1 bulan terakhir</option>
              <option value="60">2 bulan terakhir</option>
              <option value="90">3 bulan terakhir</option>
              <option value="180">6 bulan terakhir</option>
              <option value="360">1 tahun terakhir</option>
              <option value="all">Semua data</option>
            </select>
          </div>
          <div class="chart-area">
            <canvas id="myAreaChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@section('js')
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.4"></script>
<script src="{{asset('js/jquery-3.3.1.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/index-admin.js')}}"></script>
{{-- <script>
  $(document).ready(function(){
    $(".table").DataTable();
    let ctx = document.getElementById('myAreaChart');
    let data = [{
      x: 10,
      y: 20
    }, {
      x: 15,
      y: 10
    }]
    let myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
          label: 'My First dataset',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: [0, 10, 5, 2, 20, 30, 45]
        }]
      },
      // options: options
    });
  })
</script> --}}
@endsection
@endsection
