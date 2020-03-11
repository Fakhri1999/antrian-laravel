<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pelanggan Antrian</title>
  <link rel="shortcut icon" href="https://www.masjidalamanah.com/wp-content/uploads/2015/10/LOGOdepkeu.png"
    type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
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

<body class="body-antrian">
  <input type="hidden" id="id_pelanggan" value="{{session('pelanggan')->id}}">
  <input type="hidden" id="password_pelanggan" value="{{base64_encode(session('pelanggan')->password)}}">
  <div class="container container-antrian d-flex align-items-center justify-content-center">
    <div class="row">
      <div class="col-12">
        <img class="logo-desktop" src="{{asset("uploads/display/$data->logo_perusahaan")}}" alt="">
        <h3>{{$data->nama_perusahaan}}</h3>
        <h4>{{$data->alamat_perusahaan}}</h4>
      </div>
      @for ($i = 0; $i < sizeof($layanan); $i++) <div class="col-12 col-md-6 col-lg-4">
        @if ($layanan[$i]->status == 1)
        <button class="button-antrian add-queue" data-urutan_layanan="{{$layanan[$i]->urutan}}"
          data-id_layanan="{{$layanan[$i]->id}}">
          <p class="mb-0">
            Antrian
          </p>
          <h5>
            {{$layanan[$i]->nama_layanan}}
          </h5>
        </button>
        @endif
    </div>
    @endfor
  </div>
  <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap-4.4.1.min.js')}}"></script>
  <script src="{{asset('js/sweetalert2@9.js')}}"></script>
  <script src="{{asset('js/i-pelanggan.js')}}"></script>
</body>

</html>
