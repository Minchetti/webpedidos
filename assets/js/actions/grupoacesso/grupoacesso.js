$(function(){
    var error = false;
    $('#frm-user').click(function(e){
        e.preventDefault();
        setTimeout(function(){
            $('#txtMatricula').focus();
        }, 1500);
    });

    $('#txtMatricula').keyup(function(){
        if($(this).val() && $(this).val().length > 4)
        {
            $('#txtUsuario').prop('disabled', false);
            $('#txtEmail').prop('disabled', false);
            $('#txtFuncionario').prop('disabled', false); //MM
        }else{
            $('#txtUsuario').prop('disabled', true);
            $('#txtEmail').prop('disabled', true);
            $('#txtFuncionario').prop('disabled', true); //MM
        }
    });

    $('#txtUsuario').focusout(function(){
        var usuario = new Usuario();
        usuario.setUsuario($(this).val());
        if(usuario.verificarUsuario()){
            
        console.log('JA EXISTE');
            error = true;
            alert('Já existe usuário cadastrado com esse nome.');
            setTimeout(function(){
                $('#txtUsuario').focus().select();
            }, 1000);
        }else{
            
        console.log('NAO EXISTE');
            error = false;
        }
    });

    // $('#txtEmail, #txtUsuario').keyup(function(){
    //     if(!error && $.trim($('#txtUsuario').val()) && $.trim($('#txtEmail').val())){
    //         $('#salvar-usuario').prop('disabled', false);
    //         $('#salvar-usuario').removeClass('btn-danger').addClass('btn-success');
    //     }else{
    //         console.log('TRAVOIU');
    //         $('#salvar-usuario').prop('disabled', true);
    //         $('#salvar-usuario').removeClass('btn-success').addClass('btn-danger');
    //     }
    // });

});





function montarGruposAcesso(gruposacesso){ //MM

    $('#listar-grupoacesso > *').remove();
    $('#tablegrupoacesso').show();

    
    $.ajax({
        url: 'autenticacao/pegarGA',
        async: false,
        success: function (data) {
            resultado = data;
        },
        error: function (error) {
            resultado = false;
        }
    });
    
    console.log(resultado);
    
    if (!$.isEmptyObject(gruposacesso)) {
        $.each(gruposacesso, function (index, value) {


        $('<tr>', {
            id: 'grupoacesso-' + index
        }).appendTo('#listar-grupoacesso');

            $('<td>', {
                text: value.nome
            }).appendTo('#grupoacesso-' + index);



            if(value.aprova_pedido == 1){
                icon = "check";
                color = "green";
            }else{
                icon = "times";
                color = "red";
            }$('<td class="text-center"><i class="fa fa-lg fa-'+icon+'" style="color:'+color+'">').appendTo('#grupoacesso-' + index);
            
            
            if(value.relatorio_consumo == 1){
                icon = "check";
                color = "green";
            }else{
                icon = "times";
                color = "red";
            }$('<td class="text-center"><i class="fa fa-lg fa-'+icon+'" style="color:'+color+'">').appendTo('#grupoacesso-' + index);
            

            if(value.relatorio_aprovacao == 1){
                icon = "check";
                color = "green";
            }else{
                icon = "times";
                color = "red";
            }$('<td class="text-center"><i class="fa fa-lg fa-'+icon+'" style="color:'+color+'">').appendTo('#grupoacesso-' + index);
            

            if(value.cria_template == 1){
                icon = "check";
                color = "green";
            }else{
                icon = "times";
                color = "red";
            }$('<td class="text-center"><i class="fa fa-lg fa-'+icon+'" style="color:'+color+'">').appendTo('#grupoacesso-' + index);


            if(value.cria_requisicao == 1){
                icon = "check";
                color = "green";
            }else{
                icon = "times";
                color = "red";
            }$('<td class="text-center"><i class="fa fa-lg fa-'+icon+'" style="color:'+color+'">').appendTo('#grupoacesso-' + index);

            
            if(value.cria_usuario == 1){
                icon = "check";
                color = "green";
            }else{
                icon = "times";
                color = "red";
            }$('<td class="text-center"><i class="fa fa-lg fa-'+icon+'" style="color:'+color+'">').appendTo('#grupoacesso-' + index);

            
            if(value.cria_grupoacesso == 1){
                icon = "check";
                color = "green";
            }else{
                icon = "times";
                color = "red";
            }$('<td class="text-center"><i class="fa fa-lg fa-'+icon+'" style="color:'+color+'">').appendTo('#grupoacesso-' + index);

            
            if(value.cria_aviso == 1){
                icon = "check";
                color = "green";
            }else{
                icon = "times";
                color = "red";
            }$('<td class="text-center"><i class="fa fa-lg fa-lg fa-'+icon+'" style="color:'+color+'">').appendTo('#grupoacesso-' + index);

            
            if(value.responde_sugestao == 1){
                icon = "check";
                color = "green";
            }else{
                icon = "times";
                color = "red";
            }$('<td class="text-center"><i class="fa fa-lg fa-'+icon+'" style="color:'+color+'">').appendTo('#grupoacesso-' + index);
           
         



        if (resultado == true || resultado == 1){

            $('<td>', {
                class: 'text-center',
                append: $('<a>', {
                    href: '#',
                    'data-toggle': 'modal',
                    'data-target': '#change-grupoacesso',
                    style: 'cursor: pointer;',
                    text: ' Editar ',
                    click: function (e) {
                        e.preventDefault();
                        
                        $('#txtGrupoAcesso2').val(value.nome);
                        console.log(value);
                     
                        var rl_c = false;
                        var rl_a = false;
                        var ap_p = false;
                        var c_tp = false;
                        var c_rq = false;
                        var c_us = false;
                        var c_ga = false;
                        var c_av = false;
                        var r_su = false;
                                         

                        if(value.relatorio_consumo == true){
                            document.getElementById('relatorio-consumo2').checked = true;
                            rl_c = true;
                        }
                        if(value.relatorio_aprovacao == true){
                            document.getElementById('relatorio-aprovacao2').checked = true;
                            rl_a = true;
                        }
                        if(value.aprova_pedido == true){
                            document.getElementById('aprova-pedido2').checked = true;
                            ap_p = true;
                        }
                        if(value.cria_template == true){
                            document.getElementById('cria-template2').checked = true;
                            c_tp = true;
                        }
                        if(value.cria_requisicao == true){
                            document.getElementById('cria-requisicao2').checked = true;
                            c_rq = true;
                        }
                        if(value.cria_usuario == true){
                            document.getElementById('cria-usuario2').checked = true;
                            c_us = true;
                        }
                        if(value.cria_grupoacesso == true){
                            document.getElementById('cria-grupoacesso2').checked = true;
                            c_ga = true;
                        }
                        if(value.cria_aviso == true){
                            document.getElementById('cria-aviso2').checked = true;
                            c_av = true;
                        }
                        if(value.responde_sugestao == true){
                            document.getElementById('responde-sugestao2').checked = true;
                            r_su = true;
                        }
                        
                        temp = [];
                        temp.push({
                            'nome': value.nome,
                            'rel_consumo': rl_c,
                            'rel_aprovacao': rl_a,
                            'aprova_pedido': ap_p,
                            'cria_template': c_tp,
                            'cria_requisicao': c_rq,
                            'cria_usuario': c_us,
                            'cria_grupoacesso': c_ga,
                            'cria_aviso': c_av,
                            'responde_sugestao': r_su
                        });
                }})
            }).appendTo('#grupoacesso-' + index);   
        }
    })}}


    
    // $('#change-grupoacesso, ').change(function(e){ //verificar se mudou algo pra tirar o disabled do botao editar    
    function verificarEditar(e){   
        // e.preventDefault();
        console.log("CHANGE");
        temp2 = [];        
        
        var rl_c = false;
        var rl_a = false;
        var ap_p = false;
        var c_tp = false;
        var c_rq = false;
        var c_us = false;
        var c_ga = false;
        var c_av = false;
        var r_su = false;   
        
        var nom = document.getElementById('txtGrupoAcesso2').value;

        if(document.getElementById('relatorio-consumo2').checked)
            rl_c = true;     
        
        if(document.getElementById('relatorio-aprovacao2').checked)
            rl_a = true;     
        
        if(document.getElementById('aprova-pedido2').checked)
            ap_p = true;

        if(document.getElementById('cria-template2').checked)
            c_tp = true;     
        
        if(document.getElementById('cria-requisicao2').checked)
            c_rq = true;     
        
        if(document.getElementById('cria-usuario2').checked)
            c_us = true;

        if(document.getElementById('cria-grupoacesso2').checked)
            c_ga = true;     
        
        if(document.getElementById('cria-aviso2').checked)
            c_av = true;     
        
        if(document.getElementById('responde-sugestao2').checked)
            r_su = true;
      
        temp2.push({
            'nome': nom,
            'rel_consumo': rl_c,
            'rel_aprovacao': rl_a,
            'aprova_pedido': ap_p,
            'cria_template': c_tp,
            'cria_requisicao': c_rq,
            'cria_usuario': c_us,
            'cria_grupoacesso': c_ga,
            'cria_aviso': c_av,
            'responde_sugestao': r_su
        });

        if (JSON.stringify(temp) !== JSON.stringify(temp2)){
            $('#editar-grupoacesso').prop('disabled', false); //MM2
        }else{
            $('#editar-grupoacesso').prop('disabled', true); //MM2
        }
    };


    
    $('#listar-gruposacesso').click(function(e){ //MM // CLICK DO BOTAO LISTAR
        e.preventDefault();

        var grupoacesso = new GrupoAcesso();
        var resultado = grupoacesso.listar();
        montarGruposAcesso(resultado);
    });






function zerarCampos(){
    
    $("#txtGrupoAcesso").val(''); 

    $("#aprova-pedido").prop('checked', false);  
    $("#cria-template").prop('checked', false);  
    $("#cria-requisicao").prop('checked', false);  
    
    $("#cria-usuario").prop('checked', false);  
    $("#cria-grupoacesso").prop('checked', false);  
    
    $("#cria-aviso").prop('checked', false);  
    $("#responde-sugestao").prop('checked', false);  
    
    $("#relatorio-consumo").prop('checked', false);  
    $("#relatorio-aprovacao").prop('checked', false);  
}




$('#salvar-grupoacesso').click(function(e){ //MM //salvar novo grupo
    e.preventDefault();
   
    // var usuario = new Usuario();
    var Nome = $('#txtGrupoAcesso').val();

    var Aprova_pedido = false;
    var Cria_template = false;
    var Cria_requisicao = false;
    
    var Cria_usuario = false;
    var Cria_grupoacesso = false;

    var Cria_aviso = false;
    var Responde_sugestao = false;
    
    var Relatorio_consumo = false;
    var Relatorio_aprovacao = false;
    // var Relatorio_comparacao = false;
    
    
    // console.log(Usuario);

    // var x = document.getElementsByName('nivel-acesso'); //get nivel de acesso
    // for (var i=0;i<x.length;i++){
    //     if ( x[i].checked ) {
    //         var Grupo_acesso = x[i].value;
    //     }
    // }
    
    if(document.getElementById('aprova-pedido').checked)
    Aprova_pedido = true;

    if(document.getElementById('cria-template').checked)
    Cria_template = true;

    if(document.getElementById('cria-requisicao').checked)
    Cria_requisicao = true;

    if(document.getElementById('cria-usuario').checked)
    Cria_usuario = true;

    if(document.getElementById('cria-grupoacesso').checked)
    Cria_grupoacesso = true;

    if(document.getElementById('cria-aviso').checked)
    Cria_aviso = true;

    if(document.getElementById('responde-sugestao').checked)
    Responde_sugestao = true;

    if(document.getElementById('relatorio-consumo').checked)
    Relatorio_consumo = true;

    if(document.getElementById('relatorio-aprovacao').checked)
    Relatorio_aprovacao = true;

    // if(document.getElementById('relatorio-comparacao').checked)
    // Relatorio_comparacao = true;

    var grupoacesso = new GrupoAcesso();
    var resultado = grupoacesso.criar(Nome, Aprova_pedido, Cria_template, Cria_requisicao, Cria_usuario, Cria_grupoacesso, Cria_aviso, Responde_sugestao, Relatorio_consumo, Relatorio_aprovacao);


    if (resultado.status == true){          
        zerarCampos();

        bootbox.alert({
            size: "small",
            title: "Sucesso",
            message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Grupo de acesso criado com sucesso!</div>",
            // callback: function () {
            //     limparStorage();
            //     $(location).attr('href', link);
            // },
            closeButton: false
        });

    } else {
        zerarCampos();

        bootbox.alert({
            size: "small",
            title: "Erro",
            message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> "+resultado.msg+" </div>",
            // callback: function () {
            //     limparStorage();
            // }
        }); 
    }

});




$('#excluir-grupoacesso').click(function(e){ 
    
    e.preventDefault();
    
    var nome = temp[0].nome;
    var grupoacesso = new GrupoAcesso();
    var resultado = grupoacesso.excluir(nome);
    console.log(resultado);
    console.log((resultado));
    // console.log(json_encode(resultado));

    if (resultado.status == true) { //if (JSON.parse(resultado.callback)) {
        bootbox.alert({
            size: "small",
            title: "Sucesso",
            message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Grupo de acesso excluido com sucesso.</div>",
            // callback: function () {
            //     limparStorage();
            //     $(location).attr('href', link);
            // },
            closeButton: false
        });
    } 
    
    else if (resultado.msg !== undefined) {
        bootbox.alert({
            size: "small",
            title: "Erro",
            message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> "+resultado.msg+" </div>",
            // callback: function () {
            //     limparStorage();
            // }
        });
    }
    else{
        bootbox.alert({
            size: "small",
            title: "Erro",
            message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> Para excluir um grupo de acesso primeiro remova os funcionários pertencentes à aquele grupo! </div>",
            // callback: function () {
            //     limparStorage();
            // }
        });
    }

    
})




$('#editar-grupoacesso').click(function(e){ //MM //editar grupo acesso    
    e.preventDefault();

    novoNome = '';
    novoRel_aprovacao = '';
    novoRel_consumo = '';
    novoAprova_pedido = '';
    novoCria_template = '';
    novoCria_requisicao = '';
    novoCria_usuario = '';
    novoCria_grupoacesso = '';
    novoCria_aviso = '';
    novoResponde_sugestao = '';

    
    if(temp[0].nome !== temp2[0].nome){
        novoNome = temp2[0].nome;
    } 
    if(temp[0].rel_aprovacao !== temp2[0].rel_aprovacao){
        novoRel_aprovacao = temp2[0].rel_aprovacao;
    }
    if(temp[0].rel_consumo !== temp2[0].rel_consumo){
        novoRel_consumo = temp2[0].rel_consumo;
    } 
    if(temp[0].aprova_pedido !== temp2[0].aprova_pedido){
        novoAprova_pedido = temp2[0].aprova_pedido;
    }
    if(temp[0].cria_template !== temp2[0].cria_template){
        novoCria_template = temp2[0].cria_template;
    }
    if(temp[0].cria_requisicao !== temp2[0].cria_requisicao){
        novoCria_requisicao = temp2[0].cria_requisicao;
    } 
    if(temp[0].cria_usuario !== temp2[0].cria_usuario){
        novoCria_usuario = temp2[0].cria_usuario;
    }
    if(temp[0].cria_grupoacesso !== temp2[0].cria_grupoacesso){
        novoCria_grupoacesso = temp2[0].cria_grupoacesso;
    }
    if(temp[0].cria_aviso !== temp2[0].cria_aviso){
        novoCria_aviso = temp2[0].cria_aviso;
    }
    if(temp[0].responde_sugestao !== temp2[0].responde_sugestao){
        novoResponde_sugestao = temp2[0].responde_sugestao;
    }
    
    var nome = temp[0].nome;
    
    var grupoacesso = new GrupoAcesso();
    var resultado = grupoacesso.editar(nome, novoNome, novoRel_aprovacao, novoRel_consumo, novoAprova_pedido, novoCria_template, novoCria_requisicao, novoCria_usuario, novoCria_grupoacesso, novoCria_aviso, novoResponde_sugestao);


   
    console.log(resultado);

    if (resultado.status == true) { //if (JSON.parse(resultado.callback)) {
        bootbox.alert({
            size: "small",
            title: "Sucesso",
            message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Grupo de acesso editado com sucesso.</div>",
            // callback: function () {
            //     limparStorage();
            //     $(location).attr('href', link);
            // },
            closeButton: false
        });
    } else {
        bootbox.alert({
            size: "small",
            title: "Erro",
            message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> "+resultado.msg+" </div>",
            // callback: function () {
            //     limparStorage();
            // }
        });
    }

});


    
$('#txtGrupoAcesso').keyup(function(){ //MM
    if($(this).val() && $(this).val().length > 4)
    {
        $('#salvar-grupoacesso').prop('disabled', false);
    }else{
        $('#salvar-grupoacesso').prop('disabled', true);
    }        
});









