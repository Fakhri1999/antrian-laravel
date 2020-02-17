<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>List Antrian {{$data[0]->tanggal_pembuatan}}</title>
  <link rel="stylesheet" href="{{asset('css/bootstrap-4.4.1.min.css')}}">
</head>

<body>
  <div class="container mt-3">
    <div class="row">
      <div class="col-12">
        <h1 class="text-center mb-3">LIST ANTRIAN {{$data[0]->tanggal_pembuatan}}</h1>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Antrian</th>
              <th scope="col">Layanan</th>
              <th scope="col">Status</th>
              <th scope="col">Kepuasan</th>
              <th scope="col">Jam</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              @for ($i = 0; $i < sizeof($data); $i++) <tr>
                <th scope="row">{{$i + 1}}</th>
                <td>{{$data[$i]->nomor_antrian}}</td>
                <td>{{$data[$i]->nama_layanan}}</td>
                @if ($data[$i]->status == 1)
                <td>Masih antri</td>
                @elseif($data[$i]->status == 10)
                <td>Sudah dilayani</td>
                @else
                <td>Tidak ada orangnya</td>
                @endif
                <td>{{$data[$i]->kepuasan}}</td>
                <td>{{$data[$i]->jam_pembuatan}}</td>
            </tr>
            @endfor
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>
    window.print()
  </script>
</body>

</html>