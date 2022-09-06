
console.log('it file index.js');

$.ajaxSetup({
    type: 'POST',
    cache: false,
    asinc: false,
    dataType: "json",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});