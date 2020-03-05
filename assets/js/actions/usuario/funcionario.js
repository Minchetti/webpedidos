$(function () {
    /**
     * Autocomplete
     */

    function funcionarioGrid() {
        $('#funcionarios-selecionados > *').remove();
        $.each($.parseJSON(sessionStorage.getItem('funcionarios')), function (index, value) {
            $('<tr>', {
                id: 'funcionario-sel-' + index
            }).appendTo('#funcionarios-selecionados');

            $('<td>', {
                text: value.matricula,
            }).appendTo('#funcionario-sel-' + index);

            $('<td>', {
                text: value.nome,
            }).appendTo('#funcionario-sel-' + index);

            $('<td>', {
                text: (!value.setor) ? 'N/D' : value.setor,
            }).appendTo('#funcionario-sel-' + index);

            $('<td>', {
                text: (!value.ghe) ? 'N/D' : value.ghe,
            }).appendTo('#funcionario-sel-' + index);

            $('<td>', {
                class: 'text-center',
                text: (value.local == "[object Object]") ? 'CEP' : value.local,
            }).appendTo('#funcionario-sel-' + index);

            $('<td>', {
                class: 'text-center',
                text: value.turno
            }).appendTo('#funcionario-sel-' + index);

            $('<td>', {
                class: 'text-center',
                append: $('<a>', {
                    text: 'Excluir',
                    click: function (e) {
                        e.preventDefault();

                        var funcionario = new Funcionario();
                        funcionario.remover(value.matricula);

                        if(funcionario.getFuncionarioFromStorage() == ''){
                            $('.rowFuncionarios').hide(); //mostra a tabela se n ta vazio func
                        }
                        else{
                            $(this).parent().parent().remove();
                        }


                    }
                })
            }).appendTo('#funcionario-sel-' + index);
        });
    }
    var type = null; //Define se é numerico ou não, para buscar a lista correta
    var temp = [];
    var funcionario = [];
    var funcionarios = new Funcionario();
    funcionarios.init();
    if (parseInt(sessionStorage.getItem('tipo'), 10) === 2) {
        $('#cbTurno option').slice(0, 3).remove();
        $('#cbTurnoSetor option').slice(0, 3).remove();
    }
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
                
                $('#btnAdicionarFuncionario').prop('disabled', false); //temporario até arrumar o CEP
                
                temp = []; //Sempre limpar o objeto antes de inserir um novo.
                var selectedItemValue = $("#txtFuncionario").getSelectedItemData();

                console.log(selectedItemValue);

                var id = selectedItemValue.id;

                var setor = (!selectedItemValue.setor) ? 'N/D' : selectedItemValue.setor;
                var ghe = (!selectedItemValue.ghe) ? 'N/D' : selectedItemValue.ghe;
                $('#txtNomeFuncionario').val(selectedItemValue.nome);
                $('#spNome').html(selectedItemValue.nome);
                $('#spSetor').html(setor);
                temp.push({
                    'matricula': selectedItemValue.matricula,
                    'nome': selectedItemValue.nome,
                    'setor': selectedItemValue.setor,
                    'ghe': selectedItemValue.ghe,
                    'cliente': selectedItemValue.cliente,
                    'cc': selectedItemValue.cc,
                    'id': selectedItemValue.id
                });
                $('#cbLocal > *').remove();
                $('<option>', {
                    value: 'Carregando ...',
                    text: 'Carregando ...'
                }).appendTo('#cbLocal');
                var local = new Local();
                /**
                 * 1 segundo de delay para fazer a busca, sem ela a página se reinicia
                 * Tem tudo a ver com o evento em que está setado o trigger "onChooseEvent"
                 */
                setTimeout(function () {
                    $('#cbLocal > *').remove();

                    
                    var entregas = local.listarEntrega(setor);
                    console.log(entregas);
                    // var test = JSON.parse(entregas.responseText);
                    // console.log(test);
                    
                    $.each(entregas, function (index, value) { //MM
                    // $.each(entregas, function (index, value) {                        
                        
                        var local = value.local;
                        // console.log(local);
                        // var local = value.local+', '+value.numero+', '+value.bairro+', '+value.cidade+', '+value.estado ;
                    
                        $('<option>', {
                            value: local.toUpperCase(),
                            text: local.toUpperCase()
                        }).appendTo('#cbLocal');
                        $('#btnAdicionarFuncionario').prop('disabled', false);
                    });

                    // $('<option>', {
                    //     value: 'LOJA',
                    //     text: 'LOJA'
                    // }).appendTo('#cbLocal');
                    
                    // $('<option>', {
                    //     value: 'CEP',
                    //     text: 'CEP...'
                    // }).appendTo('#cbLocal');



                }, 1000);
            },

            match: {
                enabled: true
            }
        }
    };
    $("#txtFuncionario").easyAutocomplete(options);


   
























    $('#btnAdicionarFuncionario').click(function (e) {
        // console.log("LLLLLLLLLLLLLLLLLLLLL");
        e.preventDefault();
        funcionario = [];   
        
        var local = $('#cbLocal option:selected').text();
        var turno = $('#cbTurno option:selected').text();

        $.each(temp, function (index, value) {
            funcionario.push({
                'matricula': value.matricula,
                'nome': value.nome,
                'setor': value.setor,
                'ghe': value.ghe,
                'local': local,
                'turno': turno,
                'cliente': value.cliente,
                'cc': value.cc,
                'id': value.id
            });
            console.log(funcionario);
        });
        if (!funcionarios.adicionar(funcionario)) {
            funcionarioGrid();
            /**
             * Resetando o objeto temporário
             */
            temp = [];
            $('#txtFuncionario').val('');
            $('#spNome').html('');
            $('#spSetor').html('');
            $('#cbLocal').prop('selectedIndex', 0);
            $('#cbTurno').prop('selectedIndex', 0);
            $('#lista-funcionarios').modal('toggle');
            
            $('.rowFuncionarios').show(); //mostrar tabela apenas se adicionou funcionario
            $('#btn-cancelar-requisicao').show(); //mostrar botao cancelar apenas se adicionou funcionario
        } else {
            $('#funcionarios-avisos > *').remove();
            $('#funcionarios-avisos').addClass('alert alert-warning');
            $('<p>', {
                text: ' Não é possível adicionar funcionários de centro de custos diferentes na requisição.',
                prepend: $('<i>', {
                    class: 'glyphicon glyphicon-exclamation-sign'
                })
            }).appendTo('#funcionarios-avisos');
            setTimeout(function () {
                $('#funcionarios-avisos')
                    .removeClass('alert alert-warning');
                $('#funcionarios-avisos > *').remove();
            }, 6000);
            $('#txtFuncionario').val('').focus();
            $('#spNome').html('');
            $('#spSetor').html('');
            $('#cbLocal').prop('selectedIndex', 0);
            $('#cbTurno').prop('selectedIndex', 0);
        }


        // $('#cep').hide();
        // limpa_formulário_cep();
    });

    funcionarioGrid();





    $('#lista-funcionarios').on('hidden.bs.modal', function () {
        $('#spNome').html('');
        $('#spSetor').html('');
        $("#txtFuncionario").val('');
        $('#cbLocal > *').remove();
        $('#btnAdicionarFuncionario').prop('disabled', true);
    });






    $('#btn-adicionarSetor').click(function (e) {
        e.preventDefault();
        console.log('chegou 3');
        //Adicionar loader aqui

        var lista = [];
        var local = $.trim($('#cbLocalSetor option:selected').text());
        var turno = $.trim($('#cbTurnoSetor option:selected').text());
        var mesmoLocal = ($('#verifica-local-default').is(':checked')) ? true : false;
        var cliente = $.trim($('#setor-depto').val());
        var setor = $.trim($('#spSetorNome').text());
        funcionario = [];

        //Loader aqui
        lista = funcionarios.listarPorSetor(setor, cliente);
        console.log(lista);
        $.each(lista, function (index, value) {
            funcionario.push({
                'matricula': value.matricula,
                'nome': value.nome,
                'setor': value.setor,
                'local': local,
                'turno': turno,
                'cliente': cliente,
                'cc': value.cc
            });
        });

        $('#lista-setor-funcionarios').modal('toggle');

        if (mesmoLocal) {
            if (funcionarios.adicionar(funcionario)) {
                $('#aviso-local-setor > *').remove();
                $('#aviso-local-setor').addClass('alert alert-warning');
                $('<p>', {
                    text: ' Não é permitido acrescentar setores ou usuários de centro de custos diferentes na mesma requisição.',
                    prepend: $('<i>', {
                        class: 'glyphicon glyphicon-exclamation-sign'
                    })
                }).appendTo('#aviso-local-setor');
                setTimeout(function () {
                    $('#aviso-local-setor').removeClass('alert alert-warning');
                    $('#aviso-local-setor > *').remove();
                }, 6000);
            } else {
                $('#lista-setor-funcionarios .close').trigger('click');
            }
        } else {
            var valida_colecao = funcionarios.getFuncionarioFromStorage();
            if ($.isEmptyObject(valida_colecao) || (valida_colecao[0].cliente === funcionario[0].cliente)) {
                $('#lista-funcionarios-setor > *').remove();
                var local = new Local();
                var colecao_local = local.listarEntrega(funcionario[0].setor);

                $.each(funcionario, function (index, value) {
                    $('<div>', {
                        id: 'lista-funcionario-' + index,
                        class: 'row'
                    }).appendTo('#lista-funcionarios-setor');

                    $('<div>', {
                        class: 'col-lg-4',
                        append: $('<strong>', {
                            text: ' ' + value.nome
                        }),
                        prepend: $('<i>', {
                            class: 'fa fa-user-circle'
                        })
                    }).append($('<span>', {
                        id: 'spFuncionarioEntrega-' + value.matricula
                    })).appendTo('#lista-funcionario-' + index)

                    //Local de entrega
                    $('<div>', {
                        class: 'col-lg-4',
                        append: $('<select>', {
                            class: 'form-control',
                            id: 'localFuncionario-' + value.matricula
                        })
                    }).appendTo('#lista-funcionario-' + index);

                    //Preenche select local
                    $.each(colecao_local, function (index, local) {
                        var entrega = local.local;
                        $('<option>', {
                            text: entrega.toUpperCase(),
                            value: entrega.toUpperCase()
                        }).appendTo('#localFuncionario-' + value.matricula)
                    });

                    //Turno
                    $('<div>', {
                        class: 'col-lg-4',
                        append: $('<select>', {
                            class: 'form-control',
                            id: 'turnoFuncionario-' + value.matricula
                        })
                    }).appendTo('#lista-funcionario-' + index);

                    //Preenche select turno
                    $.each(['PRIMEIRO', 'SEGUNDO', 'TERCEIRO', 'ADMINISTRATIVO'], function (index, turno) {
                        $('<option>', {
                            text: turno,
                            value: turno
                        }).appendTo('#turnoFuncionario-' + value.matricula)
                    });

                });
                $('#selecionar-local-entrega').modal('toggle');
            } else {
                $('#aviso-local-setor > *').remove();
                $('#aviso-local-setor').addClass('alert alert-warning');
                $('<p>', {
                    text: ' Não é permitido acrescentar setores ou usuários de centro de custos diferentes na mesma requisição.',
                    prepend: $('<i>', {
                        class: 'glyphicon glyphicon-exclamation-sign'
                    })
                }).appendTo('#aviso-local-setor');
                setTimeout(function () {
                    $('#aviso-local-setor').removeClass('alert alert-warning');
                    $('#aviso-local-setor > *').remove();
                }, 6000);
            }
            $("#txtSetor").focus();
        }

        funcionarioGrid();

        $('#spSetorNome').html(' - ');
        $('#spSetorFantasia').html(' - ');
        $("#txtSetor").val('');
        $('#frmLocalEntregaSetor').css('display', '');
        $('#verifica-local-default').prop('checked', true);
        $('#setor-depto').remove();
        $('#cbLocalSetor').prop('selectedIndex', 0);
        $('#cbTurnoSetor').prop('selectedIndex', 0);
    });

    $('#btn-localEntregaSelecionado').click(function (e) {
        e.preventDefault();
        temp = [];
        $.each(funcionario, function (index, value) {
            temp.push({
                'matricula': value.matricula,
                'nome': value.nome,
                'setor': value.setor,
                'local': $.trim($('#localFuncionario-' + value.matricula + ' option:selected').text()),
                'turno': $.trim($('#turnoFuncionario-' + value.matricula + ' option:selected').text()),
                'cc': value.cc,
                'cliente': value.cliente
            });
        });

        funcionarios.adicionar(temp);
        funcionarioGrid();
        $('#selecionar-local-entrega .close').trigger('click');
    });

    $('#selecionar-local-entrega').on('hidden.bs.modal', function () {
        temp = [];
        funcionario = [];
        $('#lista-funcionarios-setor > *').remove();
    });

});