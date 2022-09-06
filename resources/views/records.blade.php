@extends('layout')

@section('title')
  Записи
@endsection

@section('content')
  <div class="p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal">Записи</h1>
  </div>
  <form>
    <fieldset disabled>
      <div class="mb-3">
        <label for="file_name" class="form-label">Имя файла</label>
        <input type="text" class="form-control" id="file_name">
      </div>
    </fieldset>
    <div class="mb-3">
      <label for="file_description" class="form-label">Описание</label>
      <input type="text" class="form-control" id="file_description">
    </div>
    <button type="submit" class="btn btn-primary">Сформировать сводный отчёт</button>
  </form>
  <div class="card" style="width: 1800px;">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Имя</th>
          <th scope="col">Телефон</th>
          <th scope="col">email</th>
          <th scope="col">Дата</th>
          <th scope="col">Организация</th>
          <th scope="col">Город</th>
          <th scope="col">Регион</th>
          <th scope="col">GUID</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach( $records as $record )
          <tr id="{{ $record->record_id }}">
            <td>{{ $record->record_name }}</td>
            <td>{{ $record->record_phone  }}</td>
            <td>{{ $record->record_email }}</td>
            <td>{{ date('d.m.Y', strtotime($record->record_date)) }}</td>
            <td>{{ $record->record_company }}</td>
            <td>{{ $record->record_city  }}</td>
            <td>{{ $record->record_region }}</td>
            <td>{{ $record->record_guid }}</td>
            <td></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <script>
    let records = [];
    @foreach( $records as $record )
      records.push(  {!! $record->toJson() !!} );
    @endforeach
    console.log(records);
    $('#file_name').val('{{ $file->file_name }}');
    $('#file_description').val('{{ $file->file_name }}');
    let block = false;
    $('tr').on('click', function(e){
      e.stopPropagation();
      if (block) return;
      block = true;
      $(this).children().each(function(index, el) {
        let text = $(this).html();
        $(this).html('');

        if (index === 3) {
          let datepicker = $(`<div class="input-group date" id="datepicker">
                                <input type="text" class="form-control form-control-sm">
                              </div>`);
          $(this).append(datepicker);
          datepicker.children().val(text);
          $(function() {
            $('#datepicker input').datepicker({
              format: "dd.mm.yyyy",
              language: "ru"
            });
          });
          return true;
        }

        if (index === 8) {
          return true;
        };

        let input = $(`<input class="form-control form-control-sm" type="text">`);
        $(this).append(input);
        input.val(text);
      });
    });
  </script>
@endsection