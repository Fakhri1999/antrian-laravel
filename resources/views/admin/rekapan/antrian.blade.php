@extends('template.master_layout_admin')
@section('title', 'Rekapan')
@section('css')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
{{-- <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}"> --}}
@endsection
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
      <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
    </a> --}}
  </div>

  <!-- Content Row -->
  <div class="row">
    <!-- Area Chart -->
    <div class="col-lg-12">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Antrian</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <table class="data-table table table-bordered display">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Antrian</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Layanan</th>
                <th scope="col">Status</th>
                <th scope="col">Kepuasan</th>
              </tr>
            </thead>
            <tbody>
              @for ($i = 0; $i < sizeof($data); $i++) <tr>
                <th scope="row">{{$i + 1}}</th>
                <td>{{$data[$i]->nomor_antrian}}</td>
                <td>{{$data[$i]->tanggal_pembuatan}}</td>
                <td>{{$data[$i]->nama_layanan}}</td>
                @if ($data[$i]->status == 1)
                <td>Masih antri</td>
                @elseif($data[$i]->status == 10)
                <td>Sudah dilayani</td>
                @else
                <td>Tidak ada orangnya</td>
                @endif
                <td>{{$data[$i]->kepuasan}}</td>
                </tr>
                @endfor
            </tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Antrian</th>
                <th>Tanggal</th>
                <th>Layanan</th>
                <th>Status</th>
                <th>Kepuasan</th>
              </tr>
            </tfoot>
          </table>
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
    $(".data-table").DataTable({
      initComplete: function () {
        this.api().columns([0,2,3,4,5]).every( function () {
          var column = this;
          var select = $('<select><option value=""></option></select>')
            .appendTo( $(column.footer()).empty() )
            .on( 'change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );
              column
                .search( val ? '^'+val+'$' : '', true, false )
                .draw();
            } );

          column.data().unique().sort().each( function ( d, j ) {
            select.append( '<option value="'+d+'">'+d+'</option>' )
          } );
        } );
      }
    } );
  })
</script>
@endsection
@endsection
