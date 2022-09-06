@extends('layout')

@section('title')
  Список файлов
@endsection

@section('content')
  <div class="p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal">Загрузка файлов</h1>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">Имя файла</th>
        <th scope="col">Дата добавления</th>
        <th scope="col">Дата изменения</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $files as $file )
        <tr>
          <td><a href="/list/{{ $file->id }}">{{ $file->id }}</a></td>
          <td>{{ $file->file_name  }}</td>
          <td>{{ $file->updated_at }}</td>
          <td>{{ $file->created_at }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection