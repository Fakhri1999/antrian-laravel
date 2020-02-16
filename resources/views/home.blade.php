<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{$data->nama_perusahaan}}</title>
  <link rel="shortcut icon" href="https://www.masjidalamanah.com/wp-content/uploads/2015/10/LOGOdepkeu.png"
    type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">

</head>

<body class="body-antrian">
  <input type="hidden" id="API_KEY" value="{{$API_KEY}}">
  <div class="container container-antrian d-flex align-items-center justify-content-center">
    <div class="row">
      <div class="col-12">
        <img class="logo-desktop" src="{{asset("upload/display/$data->logo_perusahaan")}}" alt="">
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
  </div>
  <div class="d-none">
    <div class="print">
      <div class="center text-center">
        <h3>KPP Pratama Biak</h3>
        <h4>Jl. Adibai No. 1 Sumberkar, Samofa, Papua</h4>
        <p>Nomor Antrian</p>
        <h1 id="antrian">A001</h1>
        <p><span id="tanggal">15 Februari 2020</span></p>
        <p id="jam">15:00:58</p>
        <p><b>Lunasi Pajaknya Awasi Penggunaannya</b></p>
      </div>
    </div>
  </div>
  <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
  <script src="{{asset('js/bootstrap-4.4.1.min.js')}}"></script>
  <script src="{{asset('js/jquery.marquee.min.js')}}"></script>
  <script src="{{asset('js/sweetalert2@9.js')}}"></script>
  <script src="{{asset('js/printThis.js')}}"></script>
  <script src="{{asset('js/script.js')}}"></script>
  <script src="{{asset('js/home.js')}}"></script>
</body>

</html>
