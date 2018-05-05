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
                  <div class="card-header">Enter Today's Finishing Data</div>
                  <div class="card-body">
                      <form method="POST" action="/factory/finish/data">
                          @csrf
                          <input type="hidden" name="factory_id" value="{{ Auth::user()->factory_id }}">
                          <div class="form-group row">
                              <label for="income" class="col-md-4 col-form-label text-md-right">Quantity Recieved From Sewing</label>

                              <div class="col-md-6">
                                  <input id="income" type="number" placeholder="Pieces Recieved From Sewing" class="form-control{{ $errors->has('income') ? ' is-invalid' : '' }}" name="income" value="{{ old('income') }}" required>

                                  @if ($errors->has('income'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('income') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="feed" class="col-md-4 col-form-label text-md-right">Pieces Fed into Finishing Dept</label>
                              <div class="col-md-6">
                                  <input id="feed" placeholder="Quantity Fed Into Finishing" type="number" class="form-control{{ $errors->has('feed') ? ' is-invalid' : '' }}" name="feed" value="{{ old('feed') }}" required>

                                  @if ($errors->has('feed'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('feed') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="pkd" class="col-md-4 col-form-label text-md-right">Packed Pieces</label>

                              <div class="col-md-6">
                                  <input id="pkd" placeholder="Packed Pieces" type="number" class="form-control{{ $errors->has('pkd') ? ' is-invalid' : '' }}" name="pkd" value="{{ old('pkd') }}" required>

                                  @if ($errors->has('pkd'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('pkd') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row mb-0">
                              <div class="col-md-6 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Save Finishing Data
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

@endsection
