/**
 * Autor : Wilson Neto 
 */
$(function () {
    /**
     * Responsável por apresentar os avisos do sistema
     * param: 
     *      tipo: Tipo de alerta que será exibido (alert-info, alert-danger, alert-success, alert-warning)
     *      info: Exibe o título do aviso /Info/Atenção/
     *      text: A mensagem que será exibida para o usuário
     *      icon: Qual o tipo de icone que será exibido (Atualmente só glyphicon, mas em breve atualização para usar também font-awesome)
     *      time: Tempo de duração da mensagem, esse valor irá no setTimeout ao final de cada mensagem
     */
    sessionStorage.removeItem('tipo');

    function avisosLogin(tipo, info, text, icon, time) {
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

        $('.form-signin').css('height', '400px');
        setTimeout(function () {
            $('#avisos > *').remove();
            $('.form-signin').css('height', '330px');
            $('#avisos').removeClass('alert ' + tipo);
        }, time);
    }

    /**
     * Desbloqueia o acesso do usuário que possui a senha expirada ou está fazendo o primeiro acesso.
     */
    function desbloquearAcesso(temp) {
        /**
         * s = Variável para comparação de senha, recebe a senha antiga.
         * Obs.: Não persistir o valor dessa variável.
         */
        var s = $('#txtSenha').val();
        $('#txtSenha').parent().parent().addClass('has-warning');
        $('#txtSenha').select();
        $('.login-button button').remove();
        $('<button>', {
            id: 'btn-desbloquear',
            class: 'btn btn-lg btn-block',
            text: ' Entrar',
            click: function (e) {
                e.preventDefault();
                var data = {
                    'senha': $('#txtSenha').val()//,
                    //'primacesso': false
                }
                var usuario = $('#txtUsuario').val();
                var regex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\<>\|\ªº\`´~¨\§\*])(?=.{8,})");
                if (!regex.test($('#txtSenha').val())) {
                    avisosLogin('alert-info', 'ATENÇÃO', 'A senha deve conter ao menos 1 caracter especial, 1 letra maiúscula, 1 letra minúscula, 1 número e no mínimo 8 caracteres!', 'glyphicon-exclamation-sign', 8000);
                    $('#txtSenha').select();
                    $('#btn-desbloquear')
                        .removeClass('btn-success')
                        .removeClass('btn-warning')
                        .removeClass('btn-danger')
                        .addClass('btn-danger');
                } else {
                    /**
                     * Efetua a troca de senha para o novo acesso
                     */
                    var Autenticar = new Autenticacao();
                    var resultado = Autenticar.NovaSenha(usuario, data);
                    if (JSON.parse(resultado.status)) {
                        /**
                         * Gerando um novo Object para validar o acesso
                         */
                        var Acesso = new Autenticacao();
                        Acesso.setUsuario($('#txtUsuario').val());
                        Acesso.setSenha($('#txtSenha').val());
                        var login = Acesso.Acessar();
                        if (JSON.parse(login.acesso))
                            sessionStorage.setItem('tipo', login.tipo);
                            $(location).attr('href', 'principal');
                    }else{
                        avisosLogin('alert-info', 'ATENÇÃO', resultado.log, 'glyphicon-exclamation-sign', 8000);
                    $('#txtSenha').select();
                    $('#btn-desbloquear')
                        .removeClass('btn-success')
                        .removeClass('btn-warning')
                        .removeClass('btn-danger')
                        .addClass('btn-danger');
                    }
                }
            }
        })
        .prepend($('<i>', {
            class: 'fa fa-lock',
            'aria-hidden': true
        })).appendTo('.login-button');
        $('#txtSenha').keyup(function () {
            if ((s !== $.trim($('#txtSenha').val())) && ($.trim($('#txtSenha').val()))) {
                $('#btn-desbloquear i')
                    .removeClass('fa-lock')
                    .addClass('fa-unlock')
                    .parent()
                    .removeClass('btn-warning')
                    .removeClass('btn-success')
                    .removeClass('btn-danger')
                    .addClass('btn-success');
                $('#txtSenha')
                    .parent()
                    .parent()
                    .removeClass('has-warning')
                    .addClass('has-success');
            } else {
                $('#btn-desbloquear i')
                    .removeClass('fa-unlock')
                    .addClass('fa-lock')
                    .parent()
                    .removeClass('btn-warning')
                    .removeClass('btn-success')
                    .addClass('btn-danger');
                $('#txtSenha')
                    .parent()
                    .parent()
                    .removeClass('has-success')
                    .addClass('has-danger');
            }
        });
    }

    /**
     * Apenas verifica campos em branco para o keyup dos campos de Usuário e Senha
     */
    function verificaCampos() {
        if (($.trim($('#txtUsuario').val())) && ($.trim($('#txtSenha').val()))) {
            $('#btn-entrar').removeClass('btn-danger').addClass('btn-success').prop('disabled', false);
        } else {
            $('#btn-entrar').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
        }
    }

    $('#txtUsuario, #txtSenha').keyup(function () {
        verificaCampos();
    });

    /**
     * Responsável por iniciar o login no sistema
     */
    $('#btn-entrar').click(function (e) { //ARRUMAR A PARTE DE MOSTRAR MSG D SENHA ERRADA
        e.preventDefault();

        var Autenticar = new Autenticacao();
        var result = null;
        Autenticar.setUsuario($('#txtUsuario').val());
        Autenticar.setSenha($('#txtSenha').val());
        result = Autenticar.Acessar();

        // var b = JSON.stringify(result.responseText);
        // var v = b.buscar;
        // console.log(v); //JSON.parse(buscar.motivo)
        // // console.log(buscar.motivo);
        // console.log(result);
        
        if (!$.isEmptyObject(result)) {
            if (JSON.parse(result.acesso)) {
                $(location).attr('href', result.url);
            } else if ((result.hasOwnProperty('primeiro_acesso') ? JSON.parse(result.primeiro_acesso) : false)) {
                avisosLogin('alert-info', 'INFORMAÇÃO', 'Digite sua nova senha de acesso no campo "SENHA" acima', 'glyphicon-exclamation-sign', 5000);
                $('#txtSenha')
                    .val('')
                    .focus();
                desbloquearAcesso(result.temp);
            } else if ((result.hasOwnProperty('expirada')) ? JSON.parse(result.expirada) : false) {
                avisosLogin('alert-warning', 'ATENÇÃO', 'Senha expirada, por favor digite uma nova senha', 'glyphicon-time', 8000);
                desbloquearAcesso(result.temp);
            } else {
                avisosLogin('alert-danger', 'ATENÇÃO', result.motivo, 'glyphicon-warning-sign', 5000);
                $.each(result, function (index, value) {
                    if (new RegExp('Usuário').test(value))
                        $('#txtUsuario').parent().addClass('has-error');
                    if (new RegExp('Senha').test(value))
                        $('#txtSenha').parent().addClass('has-error');
                });
                setTimeout(function () {
                    $('#txtUsuario').parent().removeClass('has-error');
                    $('#txtSenha').parent().removeClass('has-error');
                }, 5000)
            }
        }else{
             avisosLogin('alert-danger', 'ATENÇÃO', 'NÃO FOI POSSÍVEL CONECTAR AO SERVIDOR', 'glyphicon-warning-sign', 5000);
        }

    });
});