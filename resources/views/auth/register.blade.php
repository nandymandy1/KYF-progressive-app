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
                  <form id="sign_in" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="msg"><h5>Register to get started</h5></div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-at"></i>
                        </span>
                        <div class="form-line">
                          <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                          @if ($errors->has('email'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <div class="form-line">
                          <input id="username" type="text" placeholder="Username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
                          @if ($errors->has('username'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('username') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <div class="form-line">
                          <input id="name" type="text" placeholder="Name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                          @if ($errors->has('name'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <div class="form-line">
                          <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required autofocus>

                          @if ($errors->has('password'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <div class="form-line">
                          <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control{{ $errors->has('password-confirm') ? ' is-invalid' : '' }}" name="password_confirmation" value="{{ old('password-confirm') }}" required autofocus>

                          @if ($errors->has('password-confirm'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('password-confirm') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-industry"></i>
                        </span>
                        <div class="form-line">
                          <select id="factory" class="form-control{{ $errors->has('factory') ? ' is-invalid' : '' }}" name="factory" value="{{ old('factory') }}">
                          </select>
                          @if ($errors->has('factory'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('factory') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-wrench"></i>
                        </span>
                        <div class="form-line">
                          <select id="job" class="form-control{{ $errors->has('job') ? ' is-invalid' : '' }}" name="job" value="{{ old('job') }}">
                            <option value="">Choose your Job Here</option>
                            <option value="cutting">Cutting</option>
                            <option value="sewing">Sewing</option>
                            <option value="finishing">Finishing</option>
                            <option value="quality">Quality</option>
                            <option value="general">General</option>
                            <option value="master">Master</option>
                            <option value="merchandiser">Merchandiser</option>
                          </select>
                          @if ($errors->has('job'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('job') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                          <a href="{{route('login')}}">Already have an Account?</a>
                      </div>
                      <div class="col-xs-6 pull-right">
                          <button class="btn btn-block btn-lg bg-red waves-effect" type="submit">Register</button>
                      </div>
                    </div>
                  </form>
              </div>
          </div>
      </div>
    </div>

@endsection

@section('scripts')
  <script type="text/javascript">
  $(document).ready(function(){
    factoryValue();
  });
  function factoryValue(){
    $("#factory").empty();
    $("#factory").append('<option name="none" value="">Loading...</option>');
    $.ajax({
      url: "/factorylist",
      type: "get",
      data:{
        factory: "factory",
      },
      contentType: "json",
      success: function (factoryV){
        $("#factory").empty();
        console.log(factoryV);
        $("#factory").append('<option name="none" value="">--Choose Factory--</option>');
        for(var i =0; i <factoryV.length ; i++){
          $("#factory").append('<option name="none" value="'+factoryV[i].id+'">'+factoryV[i].name+'</option>');
        }
      }
    });
  }
  </script>

@endsection
