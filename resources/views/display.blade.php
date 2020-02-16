<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{$data->nama_perusahaan}}</title>
  <link rel="shortcut icon" href="{{asset('img/LOGOdepkeu.png')}}" type="image/x-icon">
  {{-- <link rel="stylesheet" href="{{asset('css/bootstrap-4.4.1.min.css')}}"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>
  <input type="hidden" id="API_KEY" value="{{env('API_KEY')}}">
  <audio id="in-sound" muted="muted">
    <source src="{{asset('file/in.wav')}}">
  </audio>
  <div class="container-fluid body-desktop">
    <div class="row h-100">
      <div class="p-0 col-12 col-lg-8 body-content">
        <div class="sebelum-footer">
          <nav>
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="d-flex align-items-center">
                    <img class="logo-desktop" src="{{asset("uploads/display/$data->logo_perusahaan")}}" alt="">
                    <div>
                      <h3 class="mb-0">
                        {{$data->nama_perusahaan}}
                      </h3>
                      <p class="mb-0">
                        {{$data->alamat_perusahaan}}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </nav>
          <div class="kotak-video w-100 h-100">
            <video width="100%" height="100%" autoplay loop muted>
              <source src="{{asset("uploads/display/$data->video_display")}}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
          <div class="push"></div>
        </div>
        <footer class="footer">
          <h4 class="marquee-horz">
            {{$data->running_text}}
          </h4>
        </footer>
      </div>
      <div class="col-12 col-lg-4 body-sidebar marquee-vert">
        <div class="rowLoket">
        </div>
      </div>
    </div>
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-4.4.1.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/jquery.marquee.min.js')}}"></script>
    <script src="{{asset('js/responsive-voice.js')}}"></script>
    <script src="{{asset('js/display.js')}}"></script>
</body>

</html>
