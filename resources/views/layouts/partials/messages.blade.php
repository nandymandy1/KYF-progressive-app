@if (count($errors) >0)
  @foreach ($errors->all() as $error)
    <div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ $error }}
    </div>
  @endforeach
@endif

@if (session('success'))
  <div class="alert bg-green alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ session('success') }}
  </div>
@endif

@if (session('error'))

  <div class="alert bg-red alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session('error') }}
  </div>

@endif
