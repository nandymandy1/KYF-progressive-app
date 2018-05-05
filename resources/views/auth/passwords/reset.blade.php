@extends('auth.app')

@section('content')
  <body class="login-page">
    <div class="" id="particles-js">
      <div class="login-box">
          <div class="logo">
            <a href="javascript:void(0);">Arvind<b> KYF</b></a>
            <small>Powered by - <img src="{{ asset('logo.png')}}" alt="" height="15px"></small>
          </div>
          <div class="card">
              <div class="body">
                  <form id="sign_in" method="POST" action="{{ route('password.request') }}">
                    <div class="msg"><h5>Change Your Password</h5></div>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fa fa-user"></i>
                          </span>
                          <div class="form-line">
                            <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                          </div>
                      </div>

                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fa fa-lock"></i>
                          </span>
                          <div class="form-line">
                            <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                          </div>
                      </div>
                      <div class="row">
                          <div class="col pull-right">
                              <button class="btn btn-block bg-red waves-effect" type="submit">Rest Password</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
    </div>
@endsection
@section('scripts')

@endsection
