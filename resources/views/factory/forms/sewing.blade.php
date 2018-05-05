@extends('layouts.app')

@section('css')
  <!--<link rel="stylesheet" href="{{ asset('./css/bootstrap.min.css')}}">-->
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <a href="/home" class="btn btn-md btn-primary">Go Back</a>
    </div>
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Enter Today's Sewing Data</div>
                  <div class="card-body">
                      <form method="POST" action="/factory/sewing/data">
                          @csrf
                          <input type="hidden" name="factory_id" value="{{ Auth::user()->factory_id }}">
                          <div class="form-group row">
                              <label for="income" class="col-md-4 col-form-label text-md-right">Pieces Recieved From Cutting</label>
                              <div class="col-md-6">
                                <div class="form-line">
                                  <input id="income" type="number" placeholder="Pieces Recieved From Cutting" class="form-control{{ $errors->has('income') ? ' is-invalid' : '' }}" name="income" value="{{ old('income') }}" required>
                                </div>
                                  @if ($errors->has('income'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('income') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="sopr" class="col-md-4 col-form-label text-md-right">Number of Sewing Operators</label>
                              <div class="col-md-6">
                                  <input id="sopr" placeholder="Number of Sewing Operators" type="number" class="form-control{{ $errors->has('sopr') ? ' is-invalid' : '' }}" name="sopr" value="{{ old('sopr') }}" required>
                                  @if ($errors->has('sopr'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('sopr') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="kopr" class="col-md-4 col-form-label text-md-right">Number of Kaja Operators</label>

                              <div class="col-md-6">
                                  <input id="kopr" placeholder="Number of Kaja Operators" type="number" class="form-control{{ $errors->has('kopr') ? ' is-invalid' : '' }}" name="kopr" value="{{ old('kopr') }}" required>

                                  @if ($errors->has('kopr'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('kopr') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="hlpr" class="col-md-4 col-form-label text-md-right">Number of Helpers</label>

                              <div class="col-md-6">
                                  <input id="hlpr" placeholder="Number of Helpers" type="number" class="form-control{{ $errors->has('hlpr') ? ' is-invalid' : '' }}" name="hlpr" value="{{ old('hlpr') }}" required>

                                  @if ($errors->has('hlpr'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('hlpr') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="chkr" class="col-md-4 col-form-label text-md-right">Number of Checkers</label>

                              <div class="col-md-6">
                                  <input id="chkr" type="number" placeholder="Number of Checkers" class="form-control{{ $errors->has('chkr') ? ' is-invalid' : '' }}" name="chkr" value="{{ old('chkr') }}" required>

                                  @if ($errors->has('chkr'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('chkr') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="prod" class="col-md-4 col-form-label text-md-right">Total Production</label>

                              <div class="col-md-6">
                                  <input id="prod" type="number" placeholder="Total Production" class="form-control{{ $errors->has('prod') ? ' is-invalid' : '' }}" name="prod" value="{{ old('prod') }}" required>

                                  @if ($errors->has('prod'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('prod') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="outcome" class="col-md-4 col-form-label text-md-right">Pieces Sent for Finishing or Washing</label>

                              <div class="col-md-6">
                                  <input id="outcome" type="number" placeholder="Pieces Sent for Finishing or Washing" class="form-control{{ $errors->has('outcome') ? ' is-invalid' : '' }}" name="outcome" value="{{ old('outcome') }}" required>

                                  @if ($errors->has('outcome'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('outcome') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="sam" class="col-md-4 col-form-label text-md-right">Average SAM of Garment</label>

                              <div class="col-md-6">
                                  <input id="sam" type="text" placeholder="Average SAM of Garment" class="form-control{{ $errors->has('sam') ? ' is-invalid' : '' }}" name="sam" value="{{ old('sam') }}" required>

                                  @if ($errors->has('sam'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('sam') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row mb-0">
                              <div class="col-md-6 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Save Cutting Data
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript">

</script>
@endsection
