@extends('layout')

@section('title')
  Datepicker bootstrap 5
@endsection

@section('content')
  <div class="p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal">Datepicker bootstrap 5</h1>
  </div>
  <form>
    <div class="row form-group">
      <label for="date" class="col-sm-1 col-form-label">Date</label>
      <div class="col-sm-4">
        <div class="input-group date" id="datepicker">
          <input type="text" class="form-control">
          <!-- <span class="input-group-append">
            <span class="input-group-text bg-white d-block">
              <i class="fa fa-calendar"></i>
            </span>
          </span> -->
        </div>
      </div>
    </div>
  </form>
  
  <script>
    $('#datepicker input').val('05.12.2013');
    $(function() {
      $('#datepicker input').datepicker({
        format: "dd.mm.yyyy",
        language: "ru"
      });
    });
  </script>
@endsection