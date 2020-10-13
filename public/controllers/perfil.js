function marcaCheckbox(elm) {
    var ckbox = elm.attr('id');
    var check = $("#" + ckbox).is(':checked');
    if (check) $("input[data-toggle-target=" + ckbox + "]").prop('checked', true);
    else $("input[data-toggle-target=" + ckbox + "]").removeAttr('checked');
}