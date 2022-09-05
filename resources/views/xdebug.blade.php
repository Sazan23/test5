@extends('layout')

@section('title')
  xdebug
@endsection

@section('content')
  <div class="p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal">xdebug</h1>
    {{ <?php echo xdebug_info(); ?> }}
  </div>
@endsection