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
        <input type="text" class="form-control" id="file_name" placeholder="{{ $file->file_name }}">
      </div>
    </fieldset>
    <div class="mb-3">
      <label for="file_description" class="form-label">Описание</label>
      <input type="text" class="form-control" id="file_description" placeholder="{{ $file->file_descriprion }}">
    </div>
    <button type="submit" class="btn btn-primary">Сформировать сводный отчёт</button>
  </form>
  <table class="table">
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
        <th scope="col">Дата создания</th>
        <th scope="col">Дата обновления</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $records as $record )
        <tr>
          <td>{{ $record->record_name }}</td>
          <td>{{ $record->record_phone  }}</td>
          <td>{{ $record->record_email }}</td>
          <td>{{ $record->record_date }}</td>
          <td>{{ $record->record_company }}</td>
          <td>{{ $record->record_city  }}</td>
          <td>{{ $record->record_region }}</td>
          <td>{{ $record->record_guid }}</td>
          <td>{{ $record->updated_at }}</td>
          <td>{{ $record->created_at }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection