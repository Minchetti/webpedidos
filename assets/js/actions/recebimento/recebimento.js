$(function(){

    $('#div-sub-empresas').hide();
    var recebimento = new Recebimento();    
    var empresas = recebimento.buscarEmpresas();
    montarEmpresas(empresas);


    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }


    //   BfRQbzwyzP
    //   33100093

      $('#btn-enviar-token').click(function (e) {
        e.preventDefault();
        var filial = $.trim($('#lista-empresas').val());
        var matricula = $.trim($('#txtMatricula').val());
        var cnpj = $('#lista-sub-empresas').val();

        var recebimento = new Recebimento();
        // recuperar.setUsuario(usuario);
     
        var resultado = recebimento.enviarToken(filial, matricula, cnpj);
        alert(resultado.callback);
        // console.log(resultado.callback);
        // console.log(resultado['callback']);
        // console.log(resultado[0]);
        // console.log(resultado);
        
        if(resultado.cod == '1'){
            limpaCampos();
        }
        
    });




    $('#btn-entrar-recebimento').click(function (e) {
        e.preventDefault();

        var token = $('#txtToken').val();
        var token_cookie = getCookie('_Token_Access');
        
        // console.log(token);
        // console.log(token_cookie);
        // var recebimento = new Recebimento();
        // var resultado = recebimento.entrarRecebimento(token, token_cookie);

        // alert(resultado.callback);


        if(token == token_cookie){
            $(location).attr('href', 'painel_recebimento');
            // var recebimento = new Recebimento();
            // var resultado = recebimento.entrarRecebimento(token, token_cookie);

        // alert(resultado.callback);

        }
        else{
            alert("Token expirado ou incorreto!");
        }

        // if (!$.isEmptyObject(result)) {
        //     if (JSON.parse(result.acesso)) {
        //         $(location).attr('href', result.url);
        //     } else if ((result.hasOwnProperty('primeiro_acesso') ? JSON.parse(result.primeiro_acesso) : false)) {
        //         avisosLogin('alert-info', 'INFORMAÇÃO', 'Digite sua nova senha de acesso no campo "SENHA" acima', 'glyphicon-exclamation-sign', 5000);
        //         $('#txtSenha')
        //             .val('')
        //             .focus();
        //         desbloquearAcesso(result.temp);
        //     } else if ((result.hasOwnProperty('expirada')) ? JSON.parse(result.expirada) : false) {
        //         avisosLogin('alert-warning', 'ATENÇÃO', 'Senha expirada, por favor digite uma nova senha', 'glyphicon-time', 8000);
        //         desbloquearAcesso(result.temp);
        //     } else {
        //         avisosLogin('alert-danger', 'ATENÇÃO', result.motivo, 'glyphicon-warning-sign', 5000);
        //         $.each(result, function (index, value) {
        //             if (new RegExp('Usuário').test(value))
        //                 $('#txtUsuario').parent().addClass('has-error');
        //             if (new RegExp('Senha').test(value))
        //                 $('#txtSenha').parent().addClass('has-error');
        //         });
        //         setTimeout(function () {
        //             $('#txtUsuario').parent().removeClass('has-error');
        //             $('#txtSenha').parent().removeClass('has-error');
        //         }, 5000)
        //     }
        // }else{
        //      avisosLogin('alert-danger', 'ATENÇÃO', 'NÃO FOI POSSÍVEL CONECTAR AO SERVIDOR', 'glyphicon-warning-sign', 5000);
        // }
    });



    $('#lista-empresas').change(function (e) {
        console.log(document.getElementById("lista-empresas").value);
        if (document.getElementById("lista-empresas").value !== '0') {
            $('#div-sub-empresas').show();

            // var recebimento = new Recebimento();    
            var filial = $.trim($('#lista-empresas').val());
            var subEmpresas = recebimento.buscarSubEmpresas(filial);
            montarSubEmpresas(subEmpresas);
        }
        else{
            $('#div-sub-empresas').hide();
        }

    });



  

    function montarEmpresas(empresas){ //MM
        // console.log(empresas);
        $('#lista-empresas > *').remove();

        
        if (!$.isEmptyObject(empresas)) {
            $('<option>', {          
                text: "Escolha sua empresa",
                value: 0
            }).appendTo('#lista-empresas');    

            $.each(empresas, function (index, value) {

                $('<option>', {          
                    text: value.nome,
                    value: value.filial
                    // name: "grupos-de-acesso"
                }).appendTo('#lista-empresas');    
                
            })
        }
    }
    function montarSubEmpresas(subEmpresas){ 
        $('#lista-sub-empresas > *').remove();
        
        if (!$.isEmptyObject(subEmpresas)) {
            $('<option>', {          
                text: "Escolha empresa vinculada",
                value: 0
            }).appendTo('#lista-sub-empresas');    

            $.each(subEmpresas, function (index, value) {

                $('<option>', {          
                    text: value.fantasia,
                    value: value.cnpj
                    // tem parametro 'nome' tambem se precisar usar
                }).appendTo('#lista-sub-empresas');    
                
            })
        }
    }



    function limpaCampos() {
        document.getElementById("txtMatricula").value = '';
        document.getElementById("lista-empresas").value = 0;
        $("#div-sub-empresas").hide();
        verificaCampos();
        // $('#lista-sub-empresas').value = '0';
    }

    function verificaCampos() {
        if ($('#txtMatricula').val() && $('#lista-empresas').val() !== '0' && $('#lista-sub-empresas').val() !== '0') {
            $('#btn-enviar-token').addClass('btn-success').removeClass('btn-danger').attr('disabled', false);
        } 
        else {
            $('#btn-enviar-token').addClass('btn-danger').removeClass('btn-success').attr('disabled', true);
        };

        
        if ($('#txtToken').val()) {
            $('#btn-entrar-recebimento').addClass('btn-success').removeClass('btn-danger').attr('disabled', false);
        } 
        else {
            $('#btn-entrar-recebimento').addClass('btn-danger').removeClass('btn-success').attr('disabled', true);
        }
    }

    $('#lista-empresas, #lista-sub-empresas').change(function (e) {
        verificaCampos();
    });
    $('#txtMatricula, #txtToken').keyup(function (e) {
        verificaCampos();
    });





});



