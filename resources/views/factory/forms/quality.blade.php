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
                  <div class="card-header">Enter Today's Quality Data</div>
                  <div class="card-body">
                      <form method="POST" action="/factory/quality/data">
                          @csrf
                          <input type="hidden" name="factory_id" value="{{ Auth::user()->factory_id }}">
                          <div class="form-group row">
                              <label for="inspected" class="col-md-4 col-form-label text-md-right">Inspected Quantity</label>

                              <div class="col-md-6">
                                  <input id="inspected" type="number" placeholder="Inspected Quantity" class="form-control{{ $errors->has('inspected') ? ' is-invalid' : '' }}" name="inspected" value="{{ old('inspected') }}" required>

                                  @if ($errors->has('inspected'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('inspected') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="failed" class="col-md-4 col-form-label text-md-right">Quantity Failed</label>
                              <div class="col-md-6">
                                  <input id="failed" placeholder="Quantity Failed" type="number" class="form-control{{ $errors->has('failed') ? ' is-invalid' : '' }}" name="failed" value="{{ old('failed') }}" required>

                                  @if ($errors->has('failed'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('failed') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row mb-0">
                              <div class="col-md-6 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Save Quality Data
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
