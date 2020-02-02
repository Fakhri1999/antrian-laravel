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
  <div class="container">
    <div class="row justify-content-center">
      @for ($i = 1; $i <= 6; $i++) 
      <div class="col-lg-2">
        <a href="javascrip:void" class="btn btn-primary add-queue" data-type="{{$type[$i - 1]}}">Antrian {{$i}}</a>
      </div>
    @endfor
  </div>
  </div>
  <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/sweetalert2@9.js')}}"></script>
  <script src="{{asset('js/script.js')}}"></script>
</body>

</html>