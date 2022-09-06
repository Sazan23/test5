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
    <button type="button" class="btn btn-primary btn_download">Сформировать сводный отчёт</button>
  </form>
  <div class="card" style="width: 1900px;">
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
            <td>{{ $record->record_name }}</td>
            <td>{{ $record->record_phone  }}</td>
            <td>{{ $record->record_email }}</td>
            <td>{{ date('d.m.Y', strtotime($record->record_date)) }}</td>
            <td>{{ $record->record_company }}</td>
            <td>{{ $record->record_city  }}</td>
            <td>{{ $record->record_region }}</td>
            <td>{{ $record->record_guid }}</td>
            <td>
              <button data-update="{{ $record->id }}" type="button" class="btn btn-primary btn-sm btn_update" disabled>Сохранить</button>
              <button data-delete="{{ $record->id }}" type="button" class="btn btn-danger btn-sm btn_delete">Удалить</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <script>
    $( document ).ready(function() {
      $('#file_name').val('{{ $file->file_name }}');
      $('#file_description').val('{{ $file->file_name }}');
      let editable_string = [];
      let block = false;

      $('tr').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (block) return;
        block = true;
        $(this).children().each(function(index, el) {
          
          if (index === 7) {
            return true;
          };
          
          if (index === 8) {
            $(this).children().removeAttr('disabled');
            return true;
          };

          editable_string[index] = $(this).html();
          $(this).html('');

          if (index === 3) {
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
        block = false;
        let id = $(event.target).data('update');
        $(`#${id}`).children().each(function(index, el) {
          if (index === 7 || index === 8) {
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
        data._token = "{{ csrf_token() }}";
        data.record_id = id;

        $.ajax({
          url: "{{ route('itemSave') }}",
          data: data,
          success: successItemUpdate,
          error: ajaxError
        })
      });

      $('button.btn.btn_delete').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        if (confirm("Вы действительно хотите удалить эту запись?")) {
          e.target.disabled = true;
          let data = {
            _token: "{{ csrf_token() }}",
            record_id: $(event.target).data('delete')
          };

          $.ajax({
            url: "{{ route('itemDelete') }}",
            data: data,
            success: successItemDelete,
            error: ajaxError
          })
        }
      });

      $('button.btn.btn_download').on('click', function(e) {
        window.open('/download/{{ $file->id }}', '_blank');
      });

      function successItemUpdate(data) {
        alert(data.success);
      }

      function successItemDelete(data) {
        $(`#${data.id}`).remove();
        alert(data.success);
      }

    });
  </script>
@endsection