
$.ajaxSetup({
    type: 'POST',
    cache: false,
    asinc: false,
    dataType: "json",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function ajaxError(jqxhr, status, errorMsg) {
    console.log("AJAX error:")
    console.log(jqxhr)
    console.log(status)
    console.log(errorMsg)
}