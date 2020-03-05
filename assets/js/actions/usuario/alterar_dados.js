$(function () {

    function validaPadraoSenha(senha) {
        var regex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\<>\|\ªº\`´~¨\§\*])(?=.{8,})");
        if (regex.test(senha))
            return true
        else return false;
    }

    function validaCampos(senha, confirmacao) {
        if (senha !== "" && confirmacao !== "") {
            $('#btn-alterar-senha')
                .prop('disabled', false)
                .removeClass('btn-primary')
                .addClass('btn-success');
        } else {
            $('#btn-alterar-senha')
                .prop('disabled', true)
                .removeClass('btn-success')
                .addClass('btn-primary');;
        }
    }

    function mensagem(mensagem, alerta, icone) {
        $('#avisos-alterar-dados > *').remove();
        $('#avisos-alterar-dados').addClass(alerta);
        $('<p>', {
            text: ' ' + mensagem,
            prepend: $('<i>', {
                class: icone
            })
        }).appendTo('#avisos-alterar-dados');
        setTimeout(function () {
            $('#avisos-alterar-dados > *').remove();
            $('#avisos-alterar-dados').removeClass(alerta);
            $('.form-signin').css('height', '420px');
        }, 5000);

        $('.form-signin').css('height', '460px');
    }

    $('#txtSenha').keyup(function () {
        validaCampos($(this).val(), $('#txtSenhaConfirmar').val());
    });

    $('#txtSenhaConfirmar').keyup(function () {
        validaCampos($('#txtSenha').val(), $(this).val());
    });

    $('#txtSenha').focusout(function () {
        if ($(this).val() !== '') {
            if (!validaPadraoSenha($('#txtSenha').val())) {
                $('#txtSenha').select();
                $('#txtSenhaConfirmar').val('');
                mensagem('A senha deve conter ao menos 1 caracter especial, 1 letra maiúscula, 1 letra minúscula, 1 número e no mínimo 8 caracteres!', 'alert alert-danger', 'glyphicon glyphicon-exclamation-sign');
            }
        }
    });

    $('#btn-alterar-senha').click(function (e) {
        e.preventDefault();
        var senha = $.trim($('#txtSenha').val());
        var confirmacao = $.trim($('#txtSenhaConfirmar').val());

        if (senha !== confirmacao) {
            $('#txtSenha').select();
            $('#txtSenhaConfirmar').val('');
            mensagem('As senhas não coincidem!', 'alert alert-danger', 'glyphicon glyphicon-exclamation-sign');
        } else {
            var usuario = new Usuario();
            var resultado = null;
            resultado = usuario.atualizar(senha);

            if (!$.isEmptyObject(resultado)) {
                
                if (JSON.parse(resultado.status)) {
                    mensagem('Senha alterada com sucesso!', 'alert alert-success', 'glyphicon glyphicon-ok');

                    if ($('#fs-log').length > 0) { 
                        setTimeout(function () {
                            $(location).attr('href', $('#fs-log').val());
                        }, 5000);
                    }
                } else {
                     mensagem(resultado.log, 'alert alert-danger', 'glyphicon glyphicon-exclamation-sign');
                }

                $('#txtSenha').val('');
                $('#txtSenhaConfirmar').val('');
            }
        }
    })
});