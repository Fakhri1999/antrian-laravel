<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
  <title>Register</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Register</h1>
        <form method="POST" action="{{url('register')}}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="exampleInputEmail1">NPWP</label>
            {{-- <input class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              placeholder="Enter NPWP" name="npwp" required pattern=".{15,15}" title="15 digit"> --}}
            <input class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              placeholder="Enter NPWP" name="npwp" required type="number" autofocus>
            @foreach ($errors->get('npwp') as $message)
            <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
            @endforeach
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Nama</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              placeholder="Enter nama" name="nama" required>
            @foreach ($errors->get('nama') as $message)
            <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
            @endforeach
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
              placeholder="Enter email" name="email" required>
            @foreach ($errors->get('email') as $message)
            <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
            @endforeach
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
              name="password" required>
            @foreach ($errors->get('password') as $message)
            <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
            @endforeach
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Konfirmasi Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Konfirmasi Password"
              name="repassword" required>
            @foreach ($errors->get('repassword') as $message)
            <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
            @endforeach
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">No telp</label>
            <input type="telp" class="form-control" id="exampleInputPassword1" placeholder="No telp" name="no_telp"
              required>
            @foreach ($errors->get('no_telp') as $message)
            <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
            @endforeach
          </div>
          <button type="submit" class="btn btn-primary">Register</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
</body>

</html>
