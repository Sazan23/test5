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
              <button data-cancel="{{ $record->id }}" type="button" class="btn btn-secondary btn-sm btn_cancel">Отменить</button>
              <button data-pdf="{{ $record->id }}" type="button" class="btn btn-success btn-sm btn_pdf">PDF</button>
              <button data-delete="{{ $record->id }}" type="button" class="btn btn-danger btn-sm btn_delete">Удалить</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <script src="/js/records.js"></script>
@endsection