$(function () {
    /**
     * Responsável por apresentar os avisos do sistema
     * param: 
     *      tipo: Tipo de alerta que será exibido
     *      info: Exibe o título do aviso /Info/Atenção/
     *      text: A mensagem que será exibida para o usuário
     *      icon: Qual o tipo de icone que será exibido (Atualmente só glyphicon, mas em breve atualização para usar também font-awesome)
     *      time: Tempo de duração da mensagem, esse valor irá no setTimeout ao final de casa mensagem
     */
    function avisosRecuperar(tipo, info, text, icon, time) {
        $('#avisos')
            .removeClass('alert-info')
            .removeClass('alert-danger')
            .removeClass('alert-success')
            .removeClass('alert-warning')
            .addClass('alert ' + tipo);

        $('#avisos > *').remove();

        $('<strong>', {
            text: info + ' : ',
        }).appendTo('#avisos');

        $('<p>').appendTo('#avisos').html(' ' + text).prepend($('<i>', {
            class: 'glyphicon ' + icon
        }));

        $('.form-signin').css('height', '500px');

        setTimeout(function () {
            $('#avisos > *').remove();
            $('.form-signin').css('height', '420px');
            $('#avisos').removeClass('alert ' + tipo);
        }, time);
    }

    function verificaCampos() {
        if ((!$.trim($('#txtEmail').val())) || (!$.trim($('#txtUsuario').val()))) {
            $('#btn-enviar').addClass('btn-danger').removeClass('btn-success').attr('disabled', true);
        } else {
            $('#btn-enviar').addClass('btn-success').removeClass('btn-danger').attr('disabled', false);
        }
    }

    $('#txtUsuario').keyup(function (e) {
        verificaCampos();
    });

    $('#txtEmail').keyup(function (e) {
        verificaCampos();
    });








    
    $('#btn-enviar').click(function (e) {
        e.preventDefault();
        var usuario = $.trim($('#txtUsuario').val());
        var email = $.trim($('#txtEmail').val());

        var recuperar = new Autenticacao();
        recuperar.setUsuario(usuario);
        var resultado = recuperar.EsqueciSenha(email);

        console.log(resultado.status);
        
        if (resultado !== true && resultado.status !== 200) {
            // console.log('12');
            avisosRecuperar('alert-danger', 'ATENÇÃO', resultado, 'glyphicon-warning-sign', 5000);
        } else {
            // console.log('32');
            avisosRecuperar('alert-success', 'Sucesso', 'Você receberá sua nova senha de acesso em até 24h no e-mail cadastrado', 'glyphicon-ok', 20000);
            $(this).css('display', 'none');
            $('#txtUsuario').prop('disabled', true);
            $('#txtEmail').prop('disabled', true);
            setTimeout(function () {
                $(location).attr('href', '/webpedidos');
            }, 20000);
        }
    });

});