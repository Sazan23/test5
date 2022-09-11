$( document ).ready(function() {
  $('#file_name').val($('#file_name_val').val());
  let editable_string = [];
  let block = false;
  let file_id = $('#file_id_val').val();
  $('button.btn.btn_update').hide();
  $('button.btn.btn_cancel').hide();

  $('tbody tr').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    if (block) return;
    block = true;
    $('button.btn.btn_delete').hide();
    $('button.btn.btn_pdf').hide();
    $('button.btn.btn_upload').hide();
    lineToWriteMode($(this));
  });

  $('button.btn.btn_update').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    e.target.disabled = true;
    updateRecord(e);
  });

  $('button.btn.btn_cancel').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    cancelRecord(e);
  });

  $('button.btn.btn_delete').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    deleteRecord(e);
  });

  $('button.btn.btn_upload').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('#img_id').val($(e.target).data('upload'));
  });

  $('#p_file').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var formData = new FormData();
    formData.append( 'p_file', $('#formFile')[0].files[0] );
    formData.append( 'p_id', $('#img_id').val() );
    
    $.ajax({
      url: $('#url_upload').val(),
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      success: successUploadImg,
      error: ajaxError,
      complete: completeAction
    });
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
    let id = $(e.target).data('pdf')
    window.open(`/download/pdf/single/${file_id}/${id}`, '_blank');
  });

  function dataRequestPreparation(id) {
    let map = {
      0: 'record_name',
      1: 'record_phone',
      2: 'record_email',
      3: 'record_date',
      4: 'record_company',
      5: 'record_city',
      6: 'record_region',
    };
    let data = {};
    editable_string.forEach(function (item, i) {
      data[map[i]] = item;
    });
    data._token = $('#csrf_token').val();
    data.record_id = id;
    return data;
  }

  function lineToReadMode(id, el) {
    $(`#${id}`).children().each(function (index) {
      if ($(this).data('td') === 'technical' || $(this).data('td') === 'img') {
        return true;
      };
      if (el.hasClass("btn_update")) {
        editable_string[index] = $(this).find('input').val();
      }
      $(this).empty();
      $(this).html(editable_string[index]);
    });
  }

  function lineToWriteMode(element) {
    let id = element.prop('id');
    element.children().each(function (index) {
      if ($(this).data('td') === 'img') {
        return true;
      };

      if ($(this).data('td') === 'technical') {
        $(this).children('[data-update="' + id + '"]').show();
        $(this).children('[data-cancel="' + id + '"]').show();
        return true;
      };

      editable_string[index] = $(this).html();
      $(this).html('');

      if ($(this).data('td') === 'date') {
        addDatepicker($(this), index);
        return true;
      }

      let input = $(`<input class="form-control form-control-sm" type="text">`);
      $(this).append(input);
      input.val(editable_string[index]);
    });
  }

  function updateRecord(e) {
    let id = $(e.target).data('update');
    lineToReadMode(id, $(e.target));
    let data = dataRequestPreparation(id);

    $.ajax({
      url: $('#url_update').val(),
      data: data,
      success: successItemUpdate,
      error: ajaxError,
      complete: completeAction
    });
  }

  function cancelRecord(e) {
    let id = $(e.target).data('cancel');
    lineToReadMode(id, $(e.target));
    completeAction();
    block = false;
  }

  function deleteRecord(e) {
    if (confirm("Вы действительно хотите удалить эту запись?")) {
      block = true;
      e.target.disabled = true;
      let data = {
        _token: $('#csrf_token').val(),
        record_id: $(e.target).data('delete')
      };

      $.ajax({
        url: $('#url_delete').val(),
        data: data,
        success: successItemDelete,
        error: ajaxError,
        complete: completeAction
      });
    }
  }

  function successItemUpdate(data) {
    alert(data.success);
    block = false;
  }

  function successItemDelete(data) {
    $(`#${data.id}`).remove();
    alert(data.success);
    block = false;
  }

  function successUploadImg(data) {
    uploadModal.hide();
    alert(data.message);
    let cell = $(`tr#${data.id} > td[data-td="img"]`);
    cell.empty();
    let elem_img = $(`<img src="${data.url}" class="img-fluid" width="30" height="30" alt="">`);
    cell.append(elem_img);
    block = false;
  }

  function completeAction() {
    $('button.btn.btn_update').hide();
    $('button.btn.btn_cancel').hide();
    $('button.btn.btn_upload').show();
    $('button.btn.btn_delete').show();
    $('button.btn.btn_pdf').show();
  }

  function addDatepicker(element, index) {
    let datepicker = $(`<div class="input-group date" id="datepicker">
                          <input type="text" class="form-control form-control-sm">
                        </div>`);
    element.append(datepicker);
    datepicker.children().val(editable_string[index]);
    $(function () {
      $('#datepicker input').datepicker({
        format: "dd.mm.yyyy",
        language: "ru"
      });
    });
  }
});

let uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'), {
  keyboard: false
})


