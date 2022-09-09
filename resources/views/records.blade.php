@extends('layout')

@section('title')
  Записи
@endsection

@section('content')
  <input id="file_id_val" type="hidden" value="{{ $file->id }}">
  <input id="file_name_val" type="hidden" value="{{ $file->file_name }}">
  <input id="csrf_token" type="hidden" value="{{ csrf_token() }}">
  <input id="url_update" type="hidden" value="{{ route('itemSave') }}">
  <input id="url_delete" type="hidden" value="{{ route('itemDelete') }}">
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
    <button type="button" class="btn btn-primary btn_download_xls">Сформировать сводный отчёт Excel</button>
    <button type="button" class="btn btn-success btn_download_pdf">Сформировать сводный отчёт PDF</button>
  </form>
  <div class="container-fluid py-3">
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
          <tr id="{{ $record->id }}">
            <td data-td="name">{{ $record->record_name }}</td>
            <td data-td="phone">{{ $record->record_phone  }}</td>
            <td data-td="email">{{ $record->record_email }}</td>
            <td data-td="date">{{ date('d.m.Y', strtotime($record->record_date)) }}</td>
            <td data-td="company">{{ $record->record_company }}</td>
            <td data-td="city">{{ $record->record_city  }}</td>
            <td data-td="region">{{ $record->record_region }}</td>
            <td data-td="guid">{{ $record->record_guid }}</td>
            <td data-td="technical">
              <button data-update="{{ $record->id }}" type="button" class="btn btn-primary btn-sm btn_update">Сохранить</button>
              <button data-pdf="{{ $record->id }}" type="button" class="btn btn-success btn-sm btn_pdf">PDF</button>
              <button data-delete="{{ $record->id }}" type="button" class="btn btn-danger btn-sm btn_delete">Удалить</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <script>
    $( document ).ready(function() {
      $('#file_name').val($('#file_name_val').val());
      let editable_string = [];
      let block = false;
      let file_id = $('#file_id_val').val();
      $('button.btn.btn_update').hide();

      $('tr').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (block) return;
        block = true;
        let id = $(this).prop('id');
        $('button.btn.btn_delete').hide();
        $('button.btn.btn_pdf').hide();

        $(this).children().each(function(index, el) {
          if ($(this).data('td') === 'guid') {
            return true;
          };
          
          if ($(this).data('td') === 'technical') {
            $(this).children('[data-update="'+id+'"]').show();
            return true;
          };

          editable_string[index] = $(this).html();
          $(this).html('');

          if ($(this).data('td') === 'date') {
            let datepicker = $(`<div class="input-group date" id="datepicker">
                                  <input type="text" class="form-control form-control-sm">
                                </div>`);
            $(this).append(datepicker);
            datepicker.children().val(editable_string[index]);
            $(function() {
              $('#datepicker input').datepicker({
                format: "dd.mm.yyyy",
                language: "ru"
              });
            });
            return true;
          }

          let input = $(`<input class="form-control form-control-sm" type="text">`);
          $(this).append(input);
          input.val(editable_string[index]);
        });
      });

      $('button.btn.btn_update').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.target.disabled = true;
        let id = $(event.target).data('update');
        $(`#${id}`).children().each(function(index, el) {
          if ($(this).data('td') === 'guid' || $(this).data('td') === 'technical') {
            return true;
          };
          editable_string[index] =  $(this).find('input').val();
          $(this).empty(); 
          $(this).html(editable_string[index]);
        });

        let map = {
          0: 'record_name',
          1: 'record_phone',
          2: 'record_email',
          3: 'record_date',
          4: 'record_company',
          5: 'record_city',
          6: 'record_region',
          7: 'record_guid',
        }
        let data = {};
        editable_string.forEach(function(item, i) {
          data[map[i]] = item;
        });
        data._token = $('#csrf_token').val();
        data.record_id = id;

        $.ajax({
          url: $('#url_update').val(),
          data: data,
          success: successItemUpdate,
          error: ajaxError,
          complete: completeAction
        })
      });

      $('button.btn.btn_delete').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        if (confirm("Вы действительно хотите удалить эту запись?")) {
          block = true;
          e.target.disabled = true;
          let data = {
            _token: $('#csrf_token').val(),
            record_id: $(event.target).data('delete')
          };

          $.ajax({
            url: $('#url_delete').val(),
            data: data,
            success: successItemDelete,
            error: ajaxError,
            complete: completeAction
          })
        }
      });

      $('button.btn.btn_download_xls').on('click', function(e) {
        window.open(`/download/xls/${file_id}`, '_blank');
      });

      $('button.btn.btn_download_pdf').on('click', function(e) {
        window.open(`/download/pdf/full/${file_id}`, '_blank');
      });

      $('button.btn.btn_pdf').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        let id = $(event.target).data('pdf')
        window.open(`/download/pdf/single/${file_id}/${id}`, '_blank');
      });

      function successItemUpdate(data) {
        alert(data.success);
        block = false;
      }

      function successItemDelete(data) {
        $(`#${data.id}`).remove();
        alert(data.success);
        block = false;
      }

      function completeAction() {
        $('button.btn.btn_update').hide();
        $('button.btn.btn_delete').show();
        $('button.btn.btn_pdf').show();
      }

    });
  </script>
@endsection