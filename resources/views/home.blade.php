<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Home</title>
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
</head>

<body>
  <input type="hidden" id="API_KEY" value="{{$API_KEY}}">

  <div class="container mt-2">
    <div class="row justify-content-center">
      @for ($i = 0; $i < sizeof($layanan); $i++) <div class="col-lg-2">
        <button class="btn btn-primary add-queue btn-block d-flex align-items-center mt-2"
          style="height:100px" data-urutan_layanan="{{$layanan[$i]->urutan}}" data-id_layanan="{{$layanan[$i]->id}}"
          {{$layanan[$i]->status == "0" ? "disabled" : ""}}>
          <span>Antrian <b>{{$layanan[$i]->nama_layanan}}</b></span>
        </button>
    </div>
    @endfor
  </div>
  </div>
  <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/sweetalert2@9.js')}}"></script>
  <script src="{{asset('js/home.js')}}"></script>
</body>

</html>
