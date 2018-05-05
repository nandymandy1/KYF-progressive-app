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
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
              <div class="body">
                  <form id="sign_in" method="POST" action="{{ route('password.email') }}">
                    <div class="msg"><h5>Password Reset</h5></div>
                    @csrf
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fa fa-user"></i>
                          </span>
                          <div class="form-line">
                            <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                          </div>
                      </div>
                      <div class="row">
                          <div class="col pull-right">
                              <button class="btn btn-block bg-red waves-effect" type="submit">Send Password Reset Link</button>
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
