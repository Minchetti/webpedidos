$(function () {

    function verificaCampos() {
        if (($.trim($('#txtEmail').val())) || ($.trim($('#txtEmail').val()))) {
            $('#btn-enviar').addClass('btn-danger').removeClass('btn-success').attr('disabled', true);
        } else {
            $('#btn-enviar').addClass('btn-success').removeClass('btn-danger').attr('disabled', false);
        }
    }

    $('#txtSenha').keyup(function (e) {

    });

    $('#txtSenha').keyup(function (e) {

    });

});