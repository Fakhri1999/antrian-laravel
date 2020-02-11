<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700" rel="stylesheet">

  <title>Antrianku - Display</title>
  <style type="text/css">
    body {
      background-color: #cfd8dc;
    }

    .fixed-top {
      height: 120px;
      background-color: #2196f3;
      color: white;
    }

    .card-panggilan {
      font-family: 'Open Sans', sans serif;
      font-size: 80px;
      font-weight: bold;
      width: 600px;
      margin: 80px auto;
      border-radius: 10px;
      perspective: 1400px;
      color: #fff;
      background: #2196f3;
      display: flex;
      border-radius: 10px;
      justify-content: center;
      align-items: center;
      backface-visibility: hidden;
      text-align: center;
    }

    .container-fluid {
      margin-top: 100px;
    }

    .header-card-loket {
      font-family: 'Open Sans', sans serif;
      background: #2196f3;
      color: #fff;
      font-weight: bold;
      text-align: center;
    }
  </style>
</head>

<body onload="startTime()">
  <input type="hidden" id="API_KEY" value="{{env('API_KEY')}}">
  <div class="fixed-top">
    <h3>KPP PRATAMA BIAK</h3>
    <p>Jl. Adibai No. 1 Sumberkar</p>
    <p style="float: right;" id="time"></p>
  </div>
  <audio id="in-sound" muted="muted">
    <source src="{{asset('file/in.wav')}}">
  </audio>
  <div class="container-fluid">
    <div class="row">
      <div class="col-6">
        <div class="card card-panggilan">
          <div class="card-body">ANTRIAN<br> <span id="nomor-antrian">-</span><br> KE LOKET <span
              id="loket-antrian">-</span></div>
        </div>
      </div>
      <div class="col-6 mt-5 pt-4">
        <div class="row rowLoket">
          {{-- <div class="col-4 mb-2">
            <div class="card">
              <div class="card-header header-card-loket">
                LOKET 1
              </div>
              <div class="card-body">
                <blockquote class="blockquote mb-0 text-center">
                  <p>B301</p>
                </blockquote>
              </div>
            </div>
          </div> --}}
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/sweetalert2@9.js')}}"></script>
  <script src="{{asset('js/app.js')}}"></script>
  <script src="{{asset('js/responsive-voice.js')}}"></script>
  <script src="{{asset('js/display.js')}}"></script>
</body>

</html>
