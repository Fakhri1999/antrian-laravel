@extends('template.master_layout_login_pelanggan')
@section('content')
<div class="body-login">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12">
        <div class="box-login">
          <form method="POST" action="{{url('login')}}">
            {{ csrf_field() }}
            <img src="{{asset('img/logo.png')}}" alt="" class="logo-box-login">
            <h2>
              Halaman Login
            </h2>
            <label for="npwp" class="d-block">NPWP <span>*</span></label>
            <input type="text" name="npwp" id="npwp" class="input-design">
            @foreach ($errors->get('npwp') as $message)
            <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
            @endforeach
            <label for="password" class="d-block mt-2">Password <span>*</span></label>
            <input type="password" name="password" id="password" class="input-design">
            @foreach ($errors->get('password') as $message)
            <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
            @endforeach
            {!! NoCaptcha::display() !!}
            @if ($errors->has('g-recaptcha-response'))
            <small class="form-text text-danger">
              {{ $errors->first('g-recaptcha-response') }}
            </small>
            @endif
            <button type="submit" class="button-design">
              Kirim
            </button>
            <a href="{{url('register')}}" class="d-block">Daftar akun</a>
            <a href="{{url('lupa-pasword')}}" class="d-block">Lupa Password</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection