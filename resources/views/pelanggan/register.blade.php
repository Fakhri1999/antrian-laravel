@extends('template.master_layout_login_pelanggan')
@section('content')
<div class="body-register">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12">
        <div class="box-register">
          <form action="{{url('register')}}" method="POST">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-12">
                <img src="{{asset('img/logo.png')}}" alt="" class="logo-box-register">
                <h2>
                  Halaman Register
                </h2>
                <label for="npwp" class="d-block">NPWP <span>*</span></label>
                <input type="text" name="npwp" id="npwp" class="input-design" required>
                @foreach ($errors->get('npwp') as $message)
                <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                @endforeach
              </div>
              <div class="col-12 col-lg-6">
                <label for="email" class="d-block">Email <span>*</span></label>
                <input type="text" name="email" id="email" class="input-design" required>
                @foreach ($errors->get('email') as $message)
                <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                @endforeach
                <label for="password" class="d-block">Password <span>*</span></label>
                <input type="password" name="password" id="password" class="input-design" required>
                @foreach ($errors->get('password') as $message)
                <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                @endforeach
              </div>
              <div class="col-12 col-lg-6">
                <label for="nama" class="d-block">Nama <span>*</span></label>
                <input type="text" name="nama" id="nama" class="input-design" required>
                @foreach ($errors->get('nama') as $message)
                <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                @endforeach
                <label for="no_telp" class="d-block">No. Telp <span>*</span></label>
                <input type="telp" name="no_telp" id="no_telp" class="input-design" required>
                @foreach ($errors->get('no_telp') as $message)
                <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                @endforeach
              </div>
              <div class="col-12">
                <button type="submit" class="button-design">
                  Kirim
                </button>
                <p>
                  Sudah punya akun ? <a href="{{url('login')}}">Login</a>
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection