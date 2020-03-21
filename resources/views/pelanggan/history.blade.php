<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pelanggan Antrian</title>
  <link rel="shortcut icon" href="https://www.masjidalamanah.com/wp-content/uploads/2015/10/LOGOdepkeu.png"
    type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
  {{-- <link rel="stylesheet" href="{{asset('css/style.css')}}"> --}}
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
      var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
      s1.async=true;
      s1.src='https://embed.tawk.to/5d0e064253d10a56bd7b57e8/default';
      s1.charset='UTF-8';
      s1.setAttribute('crossorigin','*');
      s0.parentNode.insertBefore(s1,s0);
    })();
  </script>
  <!--End of Tawk.to Script-->
</head>

<body>
  {{-- <input type="hidden" id="id_pelanggan" value="{{session('pelanggan')->id}}">
  <input type="hidden" id="password_pelanggan" value="{{base64_encode(session('pelanggan')->password)}}"> --}}
  <div class="container">
    <div class="row">
      <div class="col-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nomor Antrian</th>
              <th scope="col">Layanan</th>
              <th scope="col">Waktu</th>
              <th scope="col">Status</th>
              <th scope="col">Hasil</th>
            </tr>
          </thead>
          <tbody>
            @for ($i = 0; $i < sizeof($antrian); $i++) <tr>
              <th scope="row">{{$i + 1}}</th>
              <td>{{$antrian[$i]->nomor_antrian}}</td>
              <td>{{$antrian[$i]->nama_layanan}}</td>
              <td>{{$antrian[$i]->tanggal_pembuatan}}</td>
              @if ($antrian[$i]->status == '1')
              <td>Masih dalam antrian</td>
              @elseif($antrian[$i]->status == '9')
              <td>Sudah terlewati</td>
              @else
              <td>Sudah selesai</td>
              @endif
              @if ($antrian[$i]->status == '1' || $antrian[$i]->status == '9')
              <td><span class="badge badge-info" style="cursor:default">Lihat hasil</span></td>
              @else
              <td><a href="{{url('antrian/' . $antrian[$i]->id)}}"><span class="badge badge-primary">Lihat hasil</span></a></td>
              @endif
              </tr>
              @endfor
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap-4.4.1.min.js')}}"></script>
  <script src="{{asset('js/sweetalert2@9.js')}}"></script>
  <script src="{{asset('js/i-pelanggan.js')}}"></script>
</body>

</html>
