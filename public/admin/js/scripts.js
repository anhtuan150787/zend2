$(document).ready(function() {

    $('div.captcha img').click(function(){
        $.get('/application/captcha/index', function(data) {
            $('div.captcha img').attr('src', data.url);
            $('input[name="Captcha[id]"]').val(data.id);
        });

    });

    $(".checkbox_all").change(function () {
        var chec = false;
        if ($(this).is(":checked")) {
            chec = true;
        }
        $(".checkbox_item").prop('checked', chec);
    });

    $('#btn_del_list').click(function(){
        var url = $("#frm_table").attr('action');

        $("#frm_table").attr('action', url + '/delete');
        $("#frm_table").submit();
    });

});

function showMessagePopup(message) {
    $('#message_body_modal').html(message);
    $("#btn_message_modal").trigger('click');
}

function showConfirm(functionName, object) {
    $('#message_confirm_body_modal').html('Bạn có chắc chắn thực hiện tác vụ này?');
    $('#btn_message_confirm_modal').trigger('click');

    if (functionName == 'deleteItem') {
        $('#btn_message_confirm_modal_action').attr('onclick', 'location.href="' + $(object).attr('data-href') + '"');
    }
}

function confirmDelete() {
    if (!confirm('Bạn có chắc chắn muốn xóa?')) {
        return false;
    }
}

function removeCommas(str) {
    str = str.replace(/\./g, '');
    return str;
}

function addCommas(str) {
    str = str.trim();
    str = str.replace(/\./g, '');
    if (str.length > 12)
        str = str.substring(0, 12);
    //str = Left(str,12);
    //alert(str);
    var ret = '';
    var i = str.length;
    while (i > 3) {
        ret = '.' + str.substr(i - 3, i) + ret;
        str = str.substr(0, i - 3);
        i = str.length;

    }
    if (i > 0)
        ret = '.' + str + ret;

    return ret.substr(1);
}