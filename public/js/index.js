
/**
 * Default AJAX settings
 */
$.ajaxSetup({
    type: 'POST',
    cache: false,
    asinc: true,
    dataType: "json",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * AJAX error handling by default
 * @param {jqXHR} jqxhr  - jqXHR object
 * @param {PlainObject } status  - ajaxSettings
 * @param {String} errorMsg  - thrownError
 */
function ajaxError(jqxhr, status, errorMsg) {
    console.log("AJAX error:")
    console.log(jqxhr)
    console.log(status)
    console.log(errorMsg)
}