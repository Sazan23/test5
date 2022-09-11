@extends('layout')

@section('title')
  Главная
@endsection

@section('content')
  <div class="p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal">Главная</h1>
    <form enctype="multipart/form-data" action="/upload" method="POST">
      @csrf
      <div class="mb-3">
        <label for="formFile" class="form-label">Загрузить файл Excel: </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="50000" />
        <input class="form-control" type="file" name="xls_file" />
      </div>
      <input type="submit" value="Отправить файл" />
    </form>
  </div>
  <p class="fs-5 text-start text-muted">Загружаемый xls-файл должен иметь следующий формат:</p>
  <div class="card">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">name</th>
          <th scope="col">phone</th>
          <th scope="col">email</th>
          <th scope="col">date</th>
          <th scope="col">company</th>
          <th scope="col">city</th>
          <th scope="col">region</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Dolan Haney</td>
          <td>916235541558</td>
          <td>sem.molestie@protonmail.edu</td>
          <td>09.05.2022</td>
          <td>Mattis Integer PC</td>
          <td>Dublin</td>
          <td>Katsina</td>
        </tr>
        <tr>
          <td>Maris Buck</td>
          <td>9998563247</td>
          <td>dapibus.gravida@aol.ca</td>
          <td>23.09.2022</td>
          <td>Et Rutrum Non Industries</td>
          <td>Ananindeua</td>
          <td>East Region</td>
        </tr>
        <tr>
          <td>Rigel Murphy</td>
          <td>4568256554</td>
          <td>ut.erat.sed@icloud.net</td>
          <td>19.12.2022</td>
          <td>A Industries</td>
          <td>Darwin</td>
          <td>Niedersachsen</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div>
      <a href="{{url('/storage/examples/data1.xls')}}">Скачать образец файла</a>
  </div>
@endsection