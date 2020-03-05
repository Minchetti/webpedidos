$(function(){
    var error = false;
    $('#frm-user').click(function(e){
        e.preventDefault();
        setTimeout(function(){
            $('#txtMatricula').focus();
        }, 1500);
    });

    $('#txtMatricula').keyup(function(){
        console.log("THIS VAL --->");
        console.log($(this).val());
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
        console.log('PPPPPPPPPPPPPPP');
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



});





function montarUsers(usuarios){ //MM

    console.log(usuarios);
    $('#listar-usuario > *').remove();
    $('#tableusuarios').show();
    
    // if(typeof $nome !== "undefined"){ //verificar se tem algum nome no input de pesquisa
    //     var nome = $nome;
    // }
    console.log(usuarios);

    if (!$.isEmptyObject(usuarios)) {
        $.each(usuarios, function (index, value) {

            // console.log(index);
            // console.log(value);

        $('<tr>', {
            id: 'usuario-' + index
        }).appendTo('#listar-usuario');

            $('<td>', {
                // id: 'usuario-' + value.webloginid,
                text: value.codigo
            }).appendTo('#usuario-' + index);

            $('<td>', {
                class: 'text-center',
                text: value.funcionario,
            }).appendTo('#usuario-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.login
            }).appendTo('#usuario-' + index);
                        
            $('<td>', {
                class: 'text-center',
                text: value.nomeGrupoacesso
            }).appendTo('#usuario-' + index);
                    

            $('<td>', {
                class: 'text-center',
                append: $('<a>', {
                    href: '#',
                    'data-toggle': 'modal',
                    'data-target': '#change-user',
                    style: 'cursor: pointer;',
                    text: ' Visualizar ',
                    click: function (e) {
                        e.preventDefault();
                        console.log(value);
                        $('#txtFuncionario2').val(value.funcionario);
                        $('#txtMatricula2').val(value.matricula);
                        $('#txtEmail2').val(value.email);
                        $('#txtUsuario2').val(value.login);
                        $id = value.id;
        
                        // var grupoacesso = new GrupoAcesso();
                        // var resultado = grupoacesso.listar();
                
                        var resultado = null;
                        $.ajax({
                            url: 'grupoacesso/grupoacesso/buscar',
                            async: false,
                            success: function (data) {
                                resultado = data;
                            },
                            error: function (data) {
                                resultado = data;
                            }
                        });
                
                        montarGruposAcesso(resultado);

                        var x = document.getElementsByName('grupos-de-acesso2'); //setar nivel de acessos
                        for (var i=0; i<x.length; i++){
                            if(value.grupoacesso == x[i].value ){
                                x[i].selected = true;
                            }
                        }

                        temp = [];
                        temp.push({
                            'nivel': $("#grupos-de-acesso2 option:selected").val(),
                            'login': value.login
                        });                      
                }})
            }).appendTo('#usuario-' + index);
   
    })}}





    

    function montarGruposAcesso(grupos){ //MM
        
    $('#grupos-de-acesso > *').remove();
    $('#grupos-de-acesso2 > *').remove();
    
        if (!$.isEmptyObject(grupos)) {
            $.each(grupos, function (index, value) {

                $('<option>', {          
                    text: value.nome,
                    value: value.grupoacessoid,
                    name: "grupos-de-acesso"
                }).appendTo('#grupos-de-acesso');

                $('<option>', {          
                    text: value.nome,
                    value: value.grupoacessoid,
                    name: "grupos-de-acesso2"
                }).appendTo('#grupos-de-acesso2');
            })
        }
    }

  
    function verificarEditar(e){
        // e.preventDefault();
        temp2 = [];        
            
        temp2.push({
            'nivel': $("#grupos-de-acesso2 option:selected").val(),
            'login': $('#txtUsuario2').val()
        });
        
        if (JSON.stringify(temp) !== JSON.stringify(temp2)){
            $('#editar-usuario').prop('disabled', false); //MM2
        }else{
            $('#editar-usuario').prop('disabled', true); //MM2
        }

    };






    
    $('#listar-usuarios').click(function(e){ //MM // CLICK DO BOTAO LISTAR
        e.preventDefault();
        
        document.getElementById('txtMatUsuario').value = null; //limpar o campo d pesquisa
        $('#buscar_user').prop('disabled', true); //MM2

        var usuario = new Usuario();
        var resultado = usuario.buscar();
        console.log(resultado);
        montarUsers(resultado);
    });



    $('#buscar_user').click(function(e){ //MM2 //buscar usuario pesquisado e montar tabela com ele  // CLICK DO BOTAO BUSCAR
        e.preventDefault();

        document.getElementById('txtMatUsuario').value = null; //limpar o campo d pesquisa
        $('#buscar_user').prop('disabled', true); //MM2
    
      
        var usuario = new Usuario();
        var resultado = usuario.buscar($id);
    
        montarUsers(resultado);
    
    });
    


    



    $('#frm-user').click(function(e){
        e.preventDefault();
        
        // var grupoacesso = new GrupoAcesso();
        // var resultado = grupoacesso.listar();

        var resultado = null;
        $.ajax({
            url: 'grupoacesso/grupoacesso/buscar',
            async: false,
            success: function (data) {
                resultado = data;
            },
            error: function (data) {
                resultado = data;
            }
        });

        // return resultado;
        console.log(resultado);
        montarGruposAcesso(resultado);

        
    });




    // function zerarCampos(){    
    //     $("#txtUsuario2").val(''); 
    //     $("#txtMatricula2").val(''); 
    //     $("#txtFuncionario2").val(''); 
    //     $("#txtEmail2").val(''); 
    // }
    




    
    $('#close-modal').click(function(){ //MM //em LIMPAR MODAL ADD
        console.log('veio');
                // $('#add-user').closemodal();
                $("#txtFuncionario").val(''); 
                $("#txtMatricula").val(''); 
                $("#txtEmail").val('');
                $("#txtUsuario").val('');
                
                $('#txtUsuario').prop('disabled', true); //MM        
                $('#txtEmail').prop('disabled', true); //MM
            });
        



$('#txtFuncionario').keyup(function(){ //MM //em NOVO

    var options = { 
        url: function (termo) {
            type = ($.isNumeric(termo)) ? true : false;
            return 'funcionario/funcionario/listar/' + termo
        },

        getValue: function (element) {
            return (type) ? element.matricula : element.nome;
        },

        ajaxSettings: {
            type: 'GET',
            dataType: 'JSON'
        },

        template: {
            type: "description",
            fields: {
                description: "nome"
            }
        },

        list: {
            showAnimation: {
                type: "fade", //normal|slide|fade
                time: 400,
                callback: function () { }
            },

            hideAnimation: {
                type: "normal", //normal|slide|fade
                time: 400,
                callback: function () { }
            },
            maxNumberOfElements: 10,
            onSelectItemEvent: function () { },
            onHideListEvent: function () { },
            onChooseEvent: function () {
                temp = []; //Sempre limpar o objeto antes de inserir um novo.
                var selectedItemValue = $("#txtFuncionario").getSelectedItemData();
                $('#txtNomeFuncionario').val(selectedItemValue.nome);
                // $('#txtEmail').prop('disabled', false); //MM
                $('#txtUsuario').prop('disabled', false); //MM
                $keyCliente = selectedItemValue.cliente;    //MM
                $id = selectedItemValue.id;    //MM

                $('#txtMatricula').val(selectedItemValue.matricula);//MM
                console.log(selectedItemValue);
                console.log(selectedItemValue.id);
                
           
                $('#txtEmail').val(selectedItemValue.email);//MM   
                // $('#txtEmail').prop('disabled', false); //MM                    
                

                // matriculaUser
                temp.push({
                    'matricula': selectedItemValue.matricula,
                    'nome': selectedItemValue.nome,
                    'setor': selectedItemValue.setor,
                    'ghe': selectedItemValue.ghe,
                    'cliente': selectedItemValue.cliente,
                    'cc': selectedItemValue.cc
                });
                $('#cbLocal > *').remove();
                $('<option>', {
                    value: 'Carregando ...',
                    text: 'Carregando ...'
                }).appendTo('#cbLocal');
               
            },

            match: {
                enabled: true
            }
        }
    };
    $("#txtFuncionario").easyAutocomplete(options);


  
});







$('#txtMatUsuario').keyup(function(){ //MM2 //MESMA FUNCAO SÒ Q PARA O BUSCAR USUARIO

    var options = { 
        url: function (termo) {
            type = ($.isNumeric(termo)) ? true : false;
            return 'funcionario/funcionario/listar/' + termo
        },

        getValue: function (element) {
            return (type) ? element.matricula : element.nome;
        },

        ajaxSettings: {
            type: 'GET',
            dataType: 'JSON'
        },

        template: {
            type: "description",
            fields: {
                description: "nome"
            }
        },

        list: {
            showAnimation: {
                type: "fade", //normal|slide|fade
                time: 400,
                callback: function () { }
            },

            hideAnimation: {
                type: "normal", //normal|slide|fade
                time: 400,
                callback: function () { }
            },
            maxNumberOfElements: 10,
            onSelectItemEvent: function () { },
            onHideListEvent: function () { },
            onChooseEvent: function () {
                temp = []; //Sempre limpar o objeto antes de inserir um novo.
                $id = null;
                var selectedItemValue = $("#txtMatUsuario").getSelectedItemData();
                // $('#txtNomeFuncionario').val(selectedItemValue.nome);
                // $('#txtEmail').prop('disabled', false); //MM
                $('#buscar_user').prop('disabled', false); //MM2
                $keyCliente = selectedItemValue.cliente;    //MM

                console.log("SELECIONOU");
                $id = selectedItemValue.id;    //MM2
                console.log($id);
                
                $nome = selectedItemValue.nome; //MM2

                // matriculaUser
                temp.push({
                    'matricula': selectedItemValue.matricula,
                    'nome': selectedItemValue.nome,
                    'setor': selectedItemValue.setor,
                    'ghe': selectedItemValue.ghe,
                    'cliente': selectedItemValue.cliente,
                    'cc': selectedItemValue.cc
                });
                $('#cbLocal > *').remove();
                $('<option>', {
                    value: 'Carregando ...',
                    text: 'Carregando ...'
                }).appendTo('#cbLocal');

            },
            match: {
                enabled: true
            }
        }
    };

    $("#txtMatUsuario").easyAutocomplete(options);    
});








$('#salvar-usuario').click(function(e){ //MM //salvar novo usuario
    
    console.log('CLICOU SALVAR');
    e.preventDefault();
   
    // var usuario = new Usuario();
    var Matricula = $('#txtMatricula').val();
    var Email = $('#txtEmail').val();
    var Usuario = $('#txtUsuario').val();  

   
    var Grupo_acesso = $("#grupos-de-acesso option:selected").val();

    // var resultado = usuario.criar(Matricula, Usuario, Email);
    var resultado = false;
    $.ajax({
        url: 'usuario/usuario/novo',
        async: false,
        data: {
            matricula: Matricula,
            id: $id,      
            nome: Usuario,
            email: Email,
            cnpj: $keyCliente,
            grupo_acesso: Grupo_acesso,
        },
        success: function (data) {
            // console.log(data);
            resultado = data;
        },
        error: function (error) {
            // console.log(error);
            resultado = error;
        }
    })
    // return resultado;
    console.log(resultado);


    if (resultado.status == true || resultado.status == 200  ) { //if (JSON.parse(resultado.callback)) {
          
        console.log(resultado);
        
        $("#txtFuncionario").val(''); 
        $("#txtMatricula").val(''); 
        $("#txtEmail").val('');
        $("#txtUsuario").val('');
        
        $('#txtUsuario').prop('disabled', true); //MM
        $('#txtEmail').prop('disabled', true); //MM

        bootbox.alert({
            size: "small",
            title: "Sucesso",
            message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Conta criada com sucesso. Senha enviada para o email.</div>",
            // callback: function () {
            //     limparStorage();
            //     $(location).attr('href', link);
            // },
            closeButton: false
        });


    } else {

        console.log(resultado);

        $('#txtUsuario').prop('disabled', true); //MM

        $("#txtFuncionario").val(''); 
        $("#txtMatricula").val(''); 
        $("#txtEmail").val('');
        $("#txtUsuario").val('');

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








$('#editar-usuario').click(function(e){ //MM //editar usuario    
    e.preventDefault();

    novoNivel = '';
    novoLogin = '';

    if(temp[0].nivel !== temp2[0].nivel){
        novoNivel = temp2[0].nivel;
    }    
    if(temp[0].login !== temp2[0].login){
        novoLogin = temp2[0].login;
    }

    
    var usuario = new Usuario();
    var resultado = usuario.editar($id, novoNivel, novoLogin);

    // console.log(resultado);

    if (resultado.status == true) { //if (JSON.parse(resultado.callback)) {
        bootbox.alert({
            size: "small",
            title: "Sucesso",
            message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Usuário editado com sucesso.</div>",
            callback: function () {                    
                // $('#editar-usuario').prop('disabled', true); //MM
                // limparStorage();
                $(location).attr('href', 'usuario');
            },
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







$('#excluir-usuario').click(function(e){ 
    e.preventDefault();
    
    var id = $id;
    var usuario = new Usuario();
    
    var resultado = usuario.excluir(id);

    console.log(resultado);
    

    if (resultado.status == true || resultado.status == 200) { //if (JSON.parse(resultado.callback)) {
        bootbox.alert({
            size: "small",
            title: "Sucesso",
            message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Usuário excluido com sucesso.</div>",
            callback: function () {
                // limparStorage();
                // $(location).attr('href', link);
                $('#change-user').modal('hide');
            },
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
            message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> Erro ao excluir usuário! </div>",
            // callback: function () {
            //     limparStorage();
            // }
        });
    }

    
})







    
$('#txtUsuario').keyup(function(){ //MM
    if($(this).val() && $(this).val().length > 4)
    {
        $('#salvar-usuario').prop('disabled', false);
    }else{
        $('#salvar-usuario').prop('disabled', true);
    }        
});









