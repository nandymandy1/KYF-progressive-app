@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <a href="/home" class="btn btn-md btn-primary">Go Back</a>
    </div>
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Enter Monthly General Data</div>
                  <div class="card-body">
                      <form method="POST" action="/factory/general/data">
                          @csrf
                          <input type="hidden" name="factory_id" value="{{ Auth::user()->factory_id }}">
                          <div class="form-group row">
                              <label for="payrole" class="col-md-4 col-form-label text-md-right">Payrole</label>

                              <div class="col-md-6">
                                  <input id="payrole" type="text" placeholder="Payrole" class="form-control{{ $errors->has('payrole') ? ' is-invalid' : '' }}" name="payrole" value="{{ old('payrole') }}" required>

                                  @if ($errors->has('payrole'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('payrole') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="ppeople" class="col-md-4 col-form-label text-md-right">People on Payrole</label>
                              <div class="col-md-6">
                                  <input id="ppeople" placeholder="People on Payrole" type="number" class="form-control{{ $errors->has('ppeople') ? ' is-invalid' : '' }}" name="ppeople" value="{{ old('ppeople') }}" required>

                                  @if ($errors->has('ppeople'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('ppeople') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="cpeople" class="col-md-4 col-form-label text-md-right">People on Contract</label>

                              <div class="col-md-6">
                                  <input id="cpeople" placeholder="People on Contract" type="number" class="form-control{{ $errors->has('cpeople') ? ' is-invalid' : '' }}" name="cpeople" value="{{ old('cpeople') }}" required>

                                  @if ($errors->has('cpeople'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('cpeople') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="ocut" class="col-md-4 col-form-label text-md-right">Cutting Overtime</label>

                              <div class="col-md-6">
                                  <input id="ocut" type="text" placeholder="Cutting Overtime" class="form-control{{ $errors->has('ocut') ? ' is-invalid' : '' }}" name="ocut" value="{{ old('ocut') }}" required>

                                  @if ($errors->has('ocut'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('ocut') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="osew" class="col-md-4 col-form-label text-md-right">Sewing Overtime</label>

                              <div class="col-md-6">
                                  <input id="osew" type="text" placeholder="Sewing Overtime" class="form-control{{ $errors->has('osew') ? ' is-invalid' : '' }}" name="osew" value="{{ old('osew') }}" required>

                                  @if ($errors->has('osew'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('osew') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="ofin" class="col-md-4 col-form-label text-md-right">Finishing Overtime</label>

                              <div class="col-md-6">
                                  <input id="ofin" type="text" placeholder="Finshing Overtime" class="form-control{{ $errors->has('ofin') ? ' is-invalid' : '' }}" name="ofin" value="{{ old('ofin') }}" required>

                                  @if ($errors->has('ofin'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('ofin') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="abs" class="col-md-4 col-form-label text-md-right">Total Absenteeism</label>

                              <div class="col-md-6">
                                  <input id="abs" type="number" placeholder="Total Absenteeism" class="form-control{{ $errors->has('abs') ? ' is-invalid' : '' }}" name="abs" value="{{ old('abs') }}" required>

                                  @if ($errors->has('abs'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('abs') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="twf" class="col-md-4 col-form-label text-md-right">Total Work Force</label>

                              <div class="col-md-6">
                                  <input id="twf" type="text" placeholder="Total Work Force" class="form-control{{ $errors->has('twf') ? ' is-invalid' : '' }}" name="twf" value="{{ old('twf') }}" required>

                                  @if ($errors->has('twf'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('twf') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row mb-0">
                              <div class="col-md-6 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Save General Data
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
