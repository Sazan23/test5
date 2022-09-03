@extends('layout')

@section('title')
  Главная
@endsection

@section('content')
  <div class="p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal">Главная</h1>
    <form enctype="multipart/form-data" action="/upload" method="POST">
      <div class="mb-3">
        <label for="formFile" class="form-label">Загрузить файл Excel: </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="50000" />
        <input class="form-control" type="file" name="xls_file" />
      </div>
      <input type="submit" value="Отправить файл" />
    </form>
    <hr>
    <p class="fs-5 text-start text-muted">1.  Загрузка excel-файл в базу данных.</p>
    <p class="fs-5 text-start text-muted">2.  Вывод списка загруженных файлов.</p>
    <p class="fs-5 text-start text-muted">3.  Просмотр и редактирование строк с данными разных типов (изображение, текстовое поле, поле для выбора даты) для выбранного файла. Выгрузка записи в виде PDF.</p>
    <p class="fs-5 text-start text-muted">4.  Формирование на выходе по загруженному файлу сводного отчета в excel.</p>
    <p class="fs-5 text-start text-muted">5.  Формирование PDF файла, содержащего на одной странице одну запись. В виде бланка документа. Т.е. для одного загруженного файла формируется один файл PDF, содержащий столько страниц, сколько строк в данном файле.</p>
  </div>
@endsection