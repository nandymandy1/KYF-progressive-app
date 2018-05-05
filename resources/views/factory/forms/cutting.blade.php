@extends('layouts.app')

@section('css')
  <!--<link rel="stylesheet" href="{{ asset('./css/bootstrap.min.css')}}">-->
@endsection

@section('content')
  <div class="container">
    <div class="row mb-2 ml-2">
      <a href="/home" class="btn btn-md btn-primary">Go Back</a>
    </div>
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header bg-blue">Enter Today's Cutting Data</div>
                  <div class="card-body bg-grey">
                      <form method="POST" action="/factory/cutting/data">
                          @csrf
                          <input type="hidden" name="factory_id" value="{{ Auth::user()->factory_id }}">
                          <div class="form-group row">
                              <label for="cqty" class="col-md-4 col-form-label text-md-right">Cut Quantity</label>

                              <div class="col-md-6">
                                  <input id="cqty" type="number" placeholder="Cutting Quantity" class="form-control{{ $errors->has('cqty') ? ' is-invalid' : '' }}" name="cqty" value="{{ old('cqty') }}" required>

                                  @if ($errors->has('cqty'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('cqty') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="psew" class="col-md-4 col-form-label text-md-right">Pieces Sent to Sewing Dept.</label>
                              <div class="col-md-6">
                                  <input id="psew" placeholder="Sent To Sewing" type="number" class="form-control{{ $errors->has('psew') ? ' is-invalid' : '' }}" name="psew" value="{{ old('psew') }}" required>

                                  @if ($errors->has('psew'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('psew') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="pemb" class="col-md-4 col-form-label text-md-right">Pieces Sent fo Embroidary</label>

                              <div class="col-md-6">
                                  <input id="pemb" placeholder="Sent for Embroidary" type="number" class="form-control{{ $errors->has('pemb') ? ' is-invalid' : '' }}" name="pemb" value="{{ old('pemb') }}" required>

                                  @if ($errors->has('pemb'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('pemb') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="pcut" class="col-md-4 col-form-label text-md-right">Total Pieces Cut</label>

                              <div class="col-md-6">
                                  <input id="pcut" type="number" placeholder="Total Pieces Cut" class="form-control{{ $errors->has('pcut') ? ' is-invalid' : '' }}" name="pcut" value="{{ old('pcut') }}" required>

                                  @if ($errors->has('pcut'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('pcut') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="fout" class="col-md-4 col-form-label text-md-right">Fusing Output</label>

                              <div class="col-md-6">
                                  <input id="fout" type="number" placeholder="Fusing Output" class="form-control{{ $errors->has('fout') ? ' is-invalid' : '' }}" name="fout" value="{{ old('fout') }}" required>

                                  @if ($errors->has('fout'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('fout') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="tpeople" class="col-md-4 col-form-label text-md-right">People In Cutting Dept.</label>

                              <div class="col-md-6">
                                  <input id="tpeople" type="number" placeholder="People in Cutting Dept." class="form-control{{ $errors->has('tpeople') ? ' is-invalid' : '' }}" name="tpeople" value="{{ old('tpeople') }}" required>

                                  @if ($errors->has('tpeople'))
                                      <span class="invalid-feedback">
                                          <strong>{{ $errors->first('tpeople') }}</strong>
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

@endsection
