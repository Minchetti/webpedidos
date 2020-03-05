$(function () {
    // console.log('---- TEMPLATE.JS ACTION 1 ----');
    var contador = 1;
    var total = 0;
    var retornado = 0;
    var url = document.location.origin + '/webpedidos/assets';
    var temp = [];
    var produtos = new Produtos();
    sessionStorage.setItem('template_funcionarios_itens', JSON.stringify([]));
    sessionStorage.removeItem('template_funcionarios', []);
    sessionStorage.removeItem('cliente');
    sessionStorage.removeItem('centro_custo');

    function mensagensTela(titulo, mensagem, tipo) {
        $('<div>', {
            id: 'alerta-template',
            title: titulo,
            append: $('<p>', {
                class: 'text-center',
                text: mensagem
            })
        }).appendTo('body');

        $('#alerta-template').dialog({
            modal: true,
            buttons: {
                OK: function () {
                    $('#alerta-template').dialog('close');
                    if (tipo) {
                        $('#txtTemplateDescricao').focus();
                    }
                    $('#alerta-template').remove();
                }
            }
        });

    }

    function limparStorage() {
        console.log("LIMPOU STORAGE");
        sessionStorage.removeItem('template_funcionarios');
        sessionStorage.removeItem('numero_template');
        sessionStorage.removeItem('template_observacao');
        sessionStorage.removeItem('template_centro_custo');
        sessionStorage.removeItem('template_funcionarios_itens');
    }

    function limparCampos() {
        $('#txtObservacaoTemplate').val('');
        $('#txtTemplateDescricao').val('');
        $('#txtSetor').val('');
        $('#spSetorFantasia').html('');
        $('#spSetorNome').html('');
        $('#cb-check-todos')
            .prop('checked', false)
            .prop('disabled', false);
        $('#txtObservacaoCaracter').html(0);
        $('#txtDescricao-caracter').html(0);
        $('#lista-funcionarios-setor > *').remove();
    }

    function gridFuncionarios(lista) {
        // console.log('---- TEMPLATE ACTION - gridFuncionarios ----');
        $('#lista-funcionarios-setor > *').remove();
        if (!$.isEmptyObject(lista)) {
            $.each(lista, function (index, value) {
                $('<tr>', {
                    id: 'funcionarios-' + index
                }).appendTo('#lista-funcionarios-setor');

                $('<td>', {
                    append: $('<input>', {
                        id: 'seleciona-funcionario-' + index,
                        name: 'seleciona-funcionario',
                        type: 'checkbox'
                    })
                }).appendTo('#funcionarios-' + index);

                $('<td>', {
                    text: value.matricula,
                    'data-centrocusto': value.cc,
                    'data-cliente': value.cliente,
                    'data-matricula': value.matricula
                }).appendTo('#funcionarios-' + index);

                $('<td>', {
                    text: value.nome
                }).appendTo('#funcionarios-' + index);

                $('<td>', {
                    text: value.cargo
                }).appendTo('#funcionarios-' + index);

            });
        } else {
            $('<tr>', {
                id: 'funcionarios-vazio',
                class: 'info'
            }).appendTo('#lista-funcionarios-setor');

            $('<td>', {
                colspan: 4,
                text: 'Não existem funcionários alocados nesse setor'
            }).appendTo('#funcionarios-vazio');
        }

    }

    function produtosGrid() {
        
        // console.log('---- TEMPLATE ACTION - produtosGrid ----');
        $('#produtos-selecionados > *').remove();
        if ($.isEmptyObject(produtos.getProdutosTemplateFromStorage())) {
            var itens = produtos.getProdutosTemplateFromStorage();
            $.each(itens.template, function (index, value) {
                $('<tr>', {
                    id: 'sel-' + value.item.codigo
                }).appendTo('#produtos-selecionados');

                $('<td>', {
                    text: value.item.codigo,
                }).appendTo('#sel-' + value.item.codigo);

                $('<td>', {
                    text: '  ' + value.item.descricao,
                    'data-partnumber': value.item.partnumber,
                    'data-image': '',
                    prepend: $('<img>', {
                        src: url + '/images/produtos/' + value.item.partnumber + '.jpg',
                        width: '30',
                        heigth: '30'
                    })
                }).appendTo('#sel-' + value.item.codigo);

                $('<td>', {
                    text: value.item.ca,
                }).appendTo('#sel-' + value.item.codigo);

                $('<td>', {
                    class: 'text-center',
                    text: value.item.unidade,
                }).appendTo('#sel-' + value.item.codigo);

                $('<td>', {
                    class: 'text-center',
                    text: value.item.quantidade
                }).appendTo('#sel-' + value.item.codigo);

                $('<td>', {
                    class: 'text-center',
                    append: $('<a>', {
                        text: 'Editar',
                        click: function (e) {
                            e.preventDefault();
                            $('#editar-quantidade-produto').modal('toggle');
                            $('<input>', {
                                type: 'hidden',
                                id: 'edit-codigo-qty',
                                value: value.item.codigo
                            }).appendTo('body');
                            setTimeout(function () {
                                $('#txtQuantidadeEdicao').select();
                            }, 1000);
                        }
                    })
                }).appendTo('#sel-' + value.item.codigo);

                $('<td>', {
                    class: 'text-center',
                    append: $('<a>', {
                        text: 'Excluir',
                        click: function (e) {
                            e.preventDefault();
                            produtos.remover($('#cod-' + index).text());
                            $(this).parent().parent().remove();
                        }
                    })
                }).appendTo('#sel-' + value.item.codigo);
            });
            tooltip();
        }
    }

    function tooltip() {
        /**
        * Alterar caminho das imagens
        */
        $(document).tooltip({
            items: "[data-image]",
            track: true,
            content: function () {
                var element = $(this);
                var codigo = $.trim(element.data('partnumber').toString());
                if (element.is("[data-image]")) {
                    var text = $.trim(element.text());
                    return '<figure>' +
                        '<img class="img-responsive img-thumbnail" src="' + url + '/images/produtos/' + codigo + '.jpg" alt="' + text + '">' +
                        '<figcaption><small>' + text + '</small></figcaption>' +
                        '</figure>';
                }
            }
        });
    }

    function paginacao() {
        
        // console.log('---- TEMPLATE ACTION - paginacao ----');

        if ((retornado >= 0) && (retornado <= 10)) {
            $('#paginacao-produtos > *').remove();
            $('<nav>', {
                class: 'text-center',
                'aria-label': 'Paginação',
                append: $('<ul>', {
                    id: 'pag',
                    class: 'pager'
                })
            }).appendTo('#paginacao-produtos');

            var visivel = (contador <= 1) ? 'none' : '';

            $('<li>', {
                id: 'p-produto',
                style: 'display: ' + visivel,
                append: $('<a>', {
                    'style': 'cursor : pointer',
                    'aria-label': 'Anterior',
                    text: ' Anterior ',
                    click: function (e) {
                        e.preventDefault();
                        var resultado = (contador - 1);
                        var comparar = produtos.getProdutosTemplateFromStorage();
                        contador = (resultado <= 1) ? 1 : resultado;
                        if (contador === 0) {
                            $('#p-produto').css('display', 'none');
                        } else {
                            $('#p-produto').css('display', '');
                        }

                        // console.log("HAHAHAH");

                        var ghe = funcionario[0].ghe; //MODELO CERTO
        
                        if(JSON.parse(sessionStorage.getItem('funcionarios')).length  != 0){
                            ghe = JSON.parse(sessionStorage.getItem('funcionarios')[0]['ghe']);  
                        }
        
                       
                        var itens = produtos.listar(sessionStorage.getItem('cliente'), sessionStorage.getItem('centro_custo'), ghe, $.trim($('#txtProduto').val()), contador);
                        // var itens = produtos.listar(sessionStorage.getItem('cliente'), sessionStorage.getItem('centro_custo'), $.trim($('#txtProduto').val()), contador); //qui
                        
                        produtosLista(itens, comparar);
                    },
                    prepend: $('<i>', {
                        class: 'fa fa-arrow-left',
                        'aria-hidden': true
                    })
                }),
            }).prepend()
                .appendTo('#pag');

            if (retornado >= 10) {
                $('<li>', {
                    id: 'n-produto',
                    append: $('<a>', {
                        'style': 'cursor : pointer',
                        'aria-label': 'Próximo',
                        text: ' Próximo ',
                        click: function (e) {
                            var ghe = funcionario[0].ghe; //MODELO CERTO
                            e.preventDefault();
                            var resultado = (contador + 1);
                            var comparar = produtos.getProdutosTemplateFromStorage();
                            contador = (resultado === total) ? total : resultado;
                            if (resultado === total) {
                                $('#n-produto').css('display', 'none');
                            } else {
                                $('#n-produto').css('display', '');
                            }
                            // console.log("HEHEHEHEH");
                            
                            if(JSON.parse(sessionStorage.getItem('funcionarios')).length != 0){
                                ghe = JSON.parse(sessionStorage.getItem('funcionarios')[0]['ghe']);  
                            }
    
                            // var itens = produtos.listar(sessionStorage.getItem('cliente'), sessionStorage.getItem('centro_custo'), $.trim($('#txtProduto').val()), contador); //original
                            var itens = produtos.listar(sessionStorage.getItem('cliente'), sessionStorage.getItem('centro_custo'), ghe,  $.trim($('#txtProduto').val()), contador);
                            produtosLista(itens, comparar);
                        },
                        append: $('<i>', {
                            class: 'fa fa-arrow-right',
                            'aria-hidden': true
                        })
                    })
                }).appendTo('#pag');
            }
        }
    }

    function produtosLista(itens, comparar) {
        // console.log('---- TEMPLATE ACTION - produtosLista ----');
        $('#selecionar-produtos > *').remove();
        /**
         * percorre a lista de produtos vindas do banco de dados
         */
        total = parseInt(itens.total, 10);
        retornado = parseInt(itens.retornado, 10);
        if (!$.isEmptyObject(itens.produtos)) {

            $.each(itens.produtos, function (index, value) {
                var desabilitar = false;
                var codigo = value.codigo;
                var icon = 'fa-plus';
                var qty = 0;
                if (!$.isEmptyObject(comparar)) {
                    $.each(comparar, function (index, value) {
                        if (value.item.codigo === codigo) {
                            desabilitar = true;
                            icon = 'fa-check';
                            qty = value.item.quantidade;
                        }
                    });
                }

                $('<tr>', {
                    id: 'item-' + index
                }).appendTo('#selecionar-produtos');

                $('<td>', {
                    id: 'cod-' + index,
                    text: value.codigo
                }).appendTo('#item-' + index);

                $('<td>', {
                    id: 'descricao-' + index,
                    text: '  ' + value.descricao,
                    'data-image': '',
                    'data-partnumber': value.partnumber,
                    prepend: $('<img>', {
                        src: url + '/images/produtos/' + value.partnumber + '.jpg',
                        width: '30',
                        heigth: '30'
                    })
                }).appendTo('#item-' + index);

                $('<td>', {
                    id: 'ca-' + index,
                    text: value.ca
                }).appendTo('#item-' + index);

                $('<td>', {
                    id: 'un-' + index,
                    class: 'text-center',
                    text: value.unidade
                }).appendTo('#item-' + index);

                $('<td>', {
                    class: 'text-center',
                    append: $('<input>', {
                        id: 'qty-' + index,
                        class: 'form-control text-center',
                        disabled: desabilitar,
                        type: 'text',
                        name: 'quantidade',
                        value: qty,
                        click: function (e) {
                            e.preventDefault();
                            $('#qty-' + index).select();
                        }
                    }),
                }).appendTo('#item-' + index);

                /**
                 * Botão de ação para seleção de produtos
                 */
                $('<td>', {
                    class: 'text-center',
                    append: $('<button>', {
                        class: 'btn btn-success',
                        append: $('<i>', {
                            class: 'fa ' + icon,
                            'aria-hidden': true,
                        }),
                        disabled: desabilitar,
                        click: function (e) {
                            e.preventDefault();
                            if ($('#qty-' + index).val() !== '0') {
                                /**
                                * Envia o item selecionado para a tabela de Produtos selecionados
                                */
                                var item_selecionado = [];
                                item_selecionado.push({
                                    'item': {
                                        'codigo': value.codigo,
                                        'descricao': value.descricao,
                                        'ca': value.ca,
                                        'unidade': value.unidade,
                                        'quantidade': parseInt($('#qty-' + index).val(), 10),
                                        'partnumber': value.partnumber,
                                        'valor': value.preco
                                    }
                                });

                                produtos.produtosTemplate(item_selecionado);

                                $('#qty-' + index).prop('disabled', true);
                                $(this).prop('disabled', true);
                                $(this).children().removeClass('fa-plus').addClass('fa-check');
                            } else {
                                bootbox.alert("A quantidade mínima é de <strong>1 (Um) item </strong>.");
                                $('#qty-' + index).select();
                            }
                        }
                    })
                }).appendTo('#item-' + index);
            })

            tooltip();

            $('#selecionar-produtos td input').keyup(function () {
                // console.log('aquii4');
                if (!$.isNumeric($(this).val()))
                    $(this).val(0).select();
            });

            paginacao();

            /**
             * End Listar-produtos
             */
        } else {
            $('<tr>', {
                id: 'lista-vazia',
                class: 'info'
            }).appendTo('#selecionar-produtos');

            $('<td>', {
                text: 'Não há produtos',
                colspan: 6
            }).appendTo('#lista-vazia');
        }
    }

    $('#txtTemplateParam').keypress(function (e) {
        if (e.which == 13) {
            $('#btn-buscarTemplate').trigger('click');
        }
    });

    /**
     * Busca para uso do template
     */
    $('#btn-buscarTemplate').click(function (e) {

        // console.log(' ------------ BTN BUSCAR TEMPLATE EM TEMPLATE.JS - action --------------');
        e.preventDefault();

        var template_param = {
            'num_inicial': $.trim($('#txtTemplateNumero').val()),
            'descricao': $.trim($('#txtTemplateDescricao').val())
        }

        var template = new Template();
        var resultado = template.buscar(template_param);
        
        // console.log('resultado do template->');
        // console.log(resultado);
        $('#selecionar-template > *').remove();
        $('#txtTemplateParam').val('');

        if (!$.isEmptyObject(resultado)) {
            $.each(resultado, function (index, value) {
                $('<tr>', {
                    id: 'template-' + index
                }).appendTo('#selecionar-template');

                $('<td>', {
                    text: value.numero
                }).appendTo('#template-' + index);

                $('<td>', {
                    text: value.descricao
                }).appendTo('#template-' + index);

                $('<td>', {
                    text: value.setor
                }).appendTo('#template-' + index);

                $('<td>', {
                    class: 'text-center',
                    text: value.usuario
                }).appendTo('#template-' + index);

                $('<td>', {
                    class: 'text-center',
                    append: $('<a>', {
                        text: 'Utilizar',
                        style: 'cursor: pointer;',
                        click: function (e) {
                            e.preventDefault();

                            // console.log(' ------------ AQUI COMEÇA A FUNCTION UTiLIZAR - Action --------------');
                            var template = new Template();
                            sessionStorage.setItem('numero_template', parseInt(value.numero, 10));
                            
                            // console.log(parseInt(value.numero, 10));

                            sessionStorage.setItem('template_observacao', value.obs);  
                            // console.log('value.obs ->')                          
                            // console.log(value.obs);
                            sessionStorage.setItem('template_centro_custo', value.cc);                             
                            // console.log('value.cc ->')                          
                            // console.log(value.cc);
                            // console.log('maoi');
                            sessionStorage.setItem('template_funcionarios', JSON.stringify(template.funcionariosTemplate(parseInt(value.numero, 10))));
                            // console.log('maoi2');
                             
                            // console.log(' ---------------> ');                      
                            // console.log((parseInt(value.numero, 10)));         
                            // console.log("<pre> ACTION =============== "+JSON.stringify(template.funcionariosTemplate(parseInt(value.numero, 10))));
                            
                            // console.log(' <--------------- ');
// console.log(sessionStorage);
                            $('#lista-templates').modal('toggle');
                            bootbox.confirm({
                                message: "<div class='alert alert-info'><i class='glyphicon glyphicon-exclamation-sign'></i> Serão entregues no mesmo lugar?</div>",
                                buttons: {
                                    confirm: {
                                        label: 'SIM',
                                        className: 'btn-success'
                                    },
                                    cancel: {
                                        label: 'NÃO',
                                        className: 'btn-danger'
                                    }
                                },
                                callback: function (result) {
                                    if (result) {
                                        
        // console.log('MESMO LOCAL');
                                        var local = new Local();
                                        // console.log(local);
                                        var temp = [];
                                        var setor = '';
                                        var funcionario = $.parseJSON(sessionStorage.getItem('template_funcionarios'));

                                        $.each(funcionario, function (index, value) {

                                            if (value.setor !== 'DESLIGADOS') {
                                                temp.push({
                                                    'id': value.id,
                                                    'cliente': value.cliente,
                                                    'nome': value.nome,
                                                    'matricula': value.matricula
                                                });
                                                setor = value.setor;
                                            }
                                        });
                                        sessionStorage.setItem('template_funcionarios', JSON.stringify(temp));
                                        // console.log(sessionStorage);
                                        var colecao_local = local.listarEntrega(setor); //troquei pra testar era setor //75008280
                                        // console.log('colecao_local:::');
                                        // console.log(local);
                                        // console.log(setor);
                                        // console.log(colecao_local);

                                        $('<div>', {
                                            id: 'lista-funcionario-todos',
                                            class: 'row'
                                        }).appendTo('#lista-local-entrega-todos');

                                        //Local de entrega
                                        $('<div>', {
                                            class: 'col-lg-8',
                                            append: $('<select>', {
                                                class: 'form-control',
                                                id: 'local-entrega-todos'
                                            })
                                        }).appendTo('#lista-funcionario-todos');

                                        //Preenche select local
                                        $.each(colecao_local, function (index, local) {
                                            var entrega = local.local; //troquei local po Local, mas voltei


                                            $('<option>', {
                                                text: entrega, //era  entrega.toUpperCase() troquei.
                                                value: entrega //era  entrega.toUpperCase() troquei.
                                            }).appendTo('#local-entrega-todos');
                                        }
                                        );
                                        
                                        

                                        $('<div>', {
                                            class: 'col-lg-4',
                                            append: $('<select>', {
                                                class: 'form-control',
                                                id: 'turno-entrega-todos'
                                            })
                                        }).appendTo('#lista-funcionario-todos');

                                        $.each(['PRIMEIRO', 'SEGUNDO', 'TERCEIRO', 'ADMINISTRATIVO'], function (index, value) {
                                            $('<option>', {
                                                text: value,
                                                value: value
                                            }).appendTo('#turno-entrega-todos');
                                        });

                                        $('#selecionar-local-entrega-todos').modal('toggle');
                                    } else {
                                        // console.log('OUTRO LOCAL');
                                        var local = new Local();
                                        var temp = [];
                                        var setor = '';
                                        var funcionario = $.parseJSON(sessionStorage.getItem('template_funcionarios'));
                                        // console.log(funcionario);
                                        $.each(funcionario, function (index, value) {
                                            if (value.setor !== 'DESLIGADOS') {
                                                temp.push({
                                                    'id': value.id,
                                                    'cliente': value.cliente,
                                                    'nome': value.nome,
                                                    'matricula': value.matricula

                                                    
                                                    // 'id': 'TESTING',
                                                    // 'cliente': 'TESTING',
                                                    // 'nome': 'TESTING',
                                                    // 'matricula': 'TESTING'
                                                });
                                                setor = value.setor;
                                            }
                                        });
                                        sessionStorage.setItem('template_funcionarios', JSON.stringify(temp));
                                        // console.log((temp));
                                        var colecao_local = local.listarEntrega(setor);
                                        //  console.log(colecao_local);
                                        $.each(temp, function (index, value) {
                                            $('<div>', {
                                                id: 'lista-funcionario-' + index,
                                                class: 'row'
                                            }).appendTo('#lista-funcionarios-template');

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
                                        $('#selecionar-local-entrega-template').modal('toggle');
                                    }
                                }
                            });
                        }





                    })
                }).appendTo('#template-' + index);
            });
        } else {
            $('<tr>', {
                id: 'template-mensagem',
                class: 'info'
            }).appendTo('#selecionar-template');

            $('<td>', {
                colspan: 5,
                text: ' Não há templates cadastradas com estes critérios',
                prepend: $('<i>', {
                    class: 'glyphicon glyphicon-exclamation-sign'
                })
            }).appendTo('#template-mensagem');
        }
    })

    $('#txtTemplateNumero').keypress(function (e) {
        if (e.which == 13)
            $('#btn-buscarTemplate').trigger('click');
    });

    $('#num-inicial, #num-final, #txtDescricao').keypress(function (e) {
        if (e.which == 13)
            $('#btn-listarTemplate').trigger('click');
    });

    $('#txtTemplateDescricao, #txtTemplateSetor').keypress(function (e) {
        if (e.which == 13)
            $('#btn-buscarTemplate').trigger('click');
    });

    $('#lista-templates').on('hidden.bs.modal', function () {
        $('#selecionar-template > *').remove();
    });

    /**
     * Contagem descricao
     */
    $('#txtTemplateDescricao').keyup(function (e) {
        if ($(this).val().length >= 0 && $(this).val().length <= 50)
            $('#txtDescricao-caracter').html($(this).val().length);
    });

    /**
     * Contagem observação
     */
    $('#txtObservacaoTemplate').keyup(function (e) {
        if ($(this).val().length >= 0 && $(this).val().length <= 150)
            $('#txtObservacaoCaracter').html($(this).val().length);
    });

    /**
     * Autocomplete setor
     */
    var options = {
        url: function (termo) {
            return 'setor/setor/listar/' + termo
        },

        getValue: function (element) {
            return element.nome;
        },

        ajaxSettings: {
            type: 'GET',
            dataType: 'JSON'
        },

        template: {
            type: "description",
            fields: {
                description: "fantasia"
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
                console.log('AQUII');
                var selectedItemValue = $("#txtSetor").getSelectedItemData();
                var setor = selectedItemValue.nome;
                $('#spSetorNome').html(setor);
                $('#spSetorFantasia').html(selectedItemValue.fantasia);

                var lista = [];
                var cliente = $.trim(selectedItemValue.cnpj);
                funcionario = [];
                //Loader aqui
                var funcionarios = new Funcionario();
                lista = funcionarios.listarPorSetor(setor, cliente);
                console.log('aqui4');
                console.log(lista);

                // var ghe = 'asdasd';

                $.each(lista, function (index, value) {
                    funcionario.push({
                        'matricula': value.matricula,
                        'nome': value.nome,
                        'cargo': value.cargo,
                        'cliente': cliente,
                        'cc': value.cc,
                        'ghe': value.ghe
                    });
                    
                console.log(funcionario);
                });

                gridFuncionarios(funcionario);

                $('#funcionarios-lista thead tr th input').prop('checked', false).prop('disabled', false);
                $('#funcionarios-lista thead tr th:nth-child(5)').remove();
                $('#btn-confirmar-selecionados').css('display', 'block');
            },

            match: {
                enabled: true
            }
        }
    };
    // var options2 = { //dupliquei a var options
        
    //     url: function (termo) {console.log('chegou 6-0');
    //         return '../setor/setor/listar/' + termo
    //     },

    //     getValue: function (element) {
    //         return element.nome;
    //     },

    //     ajaxSettings: {
    //         type: 'GET',
    //         dataType: 'JSON'
    //     },

    //     template: {
    //         type: "description",
    //         fields: {
    //             description: "fantasia"
    //         }
    //     },

    //     list: {
    //         showAnimation: {
    //             type: "fade", //normal|slide|fade
    //             time: 400,
    //             callback: function () { }
    //         },

    //         hideAnimation: {
    //             type: "normal", //normal|slide|fade
    //             time: 400,
    //             callback: function () { }
    //         },
    //         maxNumberOfElements: 10,
    //         onSelectItemEvent: function () { },
    //         onHideListEvent: function () { },
    //         onChooseEvent: function () {
    //             var selectedItemValue = $("#txtSetor").getSelectedItemData();
    //             var setor = selectedItemValue.nome;
    //             $('#spSetorNome').html(setor);
    //             $('#spSetorFantasia').html(selectedItemValue.fantasia);

    //             var lista = [];
    //             var cliente = $.trim(selectedItemValue.cnpj);
    //             funcionario = [];
    //             //Loader aqui
    //             var funcionarios = new Funcionario();
    //             lista = funcionarios.listarPorSetor(setor, cliente);
    //             console.log('chegou 6');
    //             $.each(lista, function (index, value) {
    //                 funcionario.push({
    //                     'matricula': value.matricula,
    //                     'nome': value.nome,
    //                     'cargo': value.cargo,
    //                     'cliente': cliente,
    //                     'cc': value.cc
    //                 });
    //             });

    //             gridFuncionarios(funcionario);

    //             $('#funcionarios-lista thead tr th input').prop('checked', false).prop('disabled', false);
    //             $('#funcionarios-lista thead tr th:nth-child(5)').remove();
    //             $('#btn-confirmar-selecionados').css('display', 'block');
    //         },

    //         match: {
    //             enabled: true
    //         }
    //     }
    // };
    $("#txtSetor").easyAutocomplete(options);
    // $("#txtSetorEditarTemplate").easyAutocomplete(options);
    
    $('#cb-check-todos').click(function (e) {
        var table = $(e.target).closest('#funcionarios-lista');
        $('td input:checkbox', table).prop('checked', this.checked);
    });

    var matriculas = [];
    $('#btn-confirmar-selecionados').click(function (e) {
        e.preventDefault();


        $('<th>', {
            colspan: 2,
            class: 'text-center',
            text: 'Ações'
        }).appendTo('#funcionarios-lista thead tr');

        matriculas = $('input:checkbox:checked', $('#lista-funcionarios-setor')).map(function () {
            $(this).closest('tr').append($('<td>', {
                append: $('<button>', {
                    class: 'btn btn-success',
                    text: ' Produtos',
                    prepend: $('<i>', {
                        class: 'fa fa-shopping-basket',
                        'aria-hidden': true
                    }),
                    click: function (e) {
                        e.preventDefault();
                        var produtos = new Produtos();
                        var centro_custo = $(this).closest('tr').find('td:nth-child(2)').data('centrocusto');
                        var cliente = $(this).closest('tr').find('td:nth-child(2)').data('cliente');
                        var matricula = $(this).closest('tr').find('td:nth-child(2)').data('matricula');
                        var ghe = funcionario[0].ghe; //MODELO CERTO

                        console.log(funcionario);
                        console.log(funcionario[0].ghe);
                    

                        sessionStorage.setItem('cliente', cliente);
                        sessionStorage.setItem('centro_custo', centro_custo);


                        $('<input>', {
                            id: 'matricula-funcionario-template',
                            type: 'hidden',
                            name: 'matricula-funcionario',
                            value: matricula
                        }).appendTo('body');
                        //Recupera os valores do data-attribute
                        // var itens = produtos.listar(cliente, centro_custo, '', '', paginacao-produtos1);

                        
                        console.log(sessionStorage);
                        // console.log(sessionStorage.getItem('funcionarios'));
                        
                        // if(JSON.parse(sessionStorage.getItem('funcionarios'))  != null ){
                        //     console.log("KKKKKKKKKKKKKKK");
                        //     ghe = JSON.parse(sessionStorage.getItem('funcionarios')[0]['ghe']);  
                        // }


                        // var itens = produtos.listar(cliente, centro_custo, '', '',  1);
                        var itens = produtos.listar(cliente, centro_custo, ghe, '',  1);

                        produtosLista(itens, []);
                        $('#lista-produtos').modal('toggle');
                    }
                })
            }));
            var matricula = $(this).closest('tr').find('td:nth-child(2)').text();

            $(this).closest('tr').append($('<td>', {
                append: $('<button>', {
                    class: 'btn btn-primary',
                    text: ' Visualizar',
                    disabled: false,
                    prepend: $('<i>', {
                        class: 'fa fa-eye',
                        'aria-hidden': true
                    }),
                    click: function (e) {
                        e.preventDefault();
                        var modal = false;
                        var itens = JSON.parse(sessionStorage.getItem('template_funcionarios_itens'));
                        $('#visualizar-produtos > *').remove();

                        $.each(itens, function (index, value) {
                            if (value.template.matricula === matricula) {
                                modal = true;
                                $.each(value.template.itens, function (index, value) {
                                    $('<tr>', {
                                        id: 'visualizar-produtos-' + index
                                    }).appendTo('#visualizar-produtos');

                                    $('<td>', {
                                        text: value[0].codigo
                                    }).appendTo('#visualizar-produtos-' + index);

                                    $('<td>', {
                                        text: value[0].descricao
                                    }).appendTo('#visualizar-produtos-' + index);

                                    $('<td>', {
                                        text: value[0].ca
                                    }).appendTo('#visualizar-produtos-' + index);

                                    $('<td>', {
                                        class: 'text-center',
                                        text: value[0].unidade
                                    }).appendTo('#visualizar-produtos-' + index);

                                    $('<td>', {
                                        class: 'text-center',
                                        text: value[0].quantidade
                                    }).appendTo('#visualizar-produtos-' + index);

                                });
                            }
                        });
                        if (modal)
                            $('#lista-produtos-visualizacao').modal('toggle');
                    }
                })
            }));
            return matricula;
        });

        $('input:checkbox', $('#lista-funcionarios-setor')).map(function () {
            if (!$(this).is(':checked'))
                $(this).parent().parent().remove();
            else
                $(this).prop('disabled', true);
        });

        $('#funcionarios-lista thead tr th input').prop('checked', true).prop('disabled', true);
        $(this).css('display', 'none');

    });

















    $('#lista-produtos').on('hidden.bs.modal', function () {
        //Compreender o object aqui
        produtos.concluirItens($('#matricula-funcionario-template').val());
        $('#matricula-funcionario-template').remove();
    });

    $('#selecionar-local-entrega-todos').on('hidden.bs.modal', function () {
        $('#lista-local-entrega-todos > *').remove();
        sessionStorage.removeItem('template_funcionarios');
    });


    
    /**
     * Listagem do menu template
     */
    $('#btn-listarTemplate').click(function (e) {
        e.preventDefault();

        var template_param = {
            'num_inicial': $.trim($('#num-inicial').val()),
            'num_final': $.trim($('#num-final').val()),
            'descricao': $.trim($('#txtDescricao').val())
        }

        var template = new Template();
        var resultado = template.buscar(template_param);
        $('#selecionar-template > *').remove();

        if (!$.isEmptyObject(resultado)) {
            $.each(resultado, function (index, value) {

                $('<tr>', {
                    id: 'template-' + index
                }).appendTo('#selecionar-template');

                $('<td>', {
                    id: 'template-' + value.numero,
                    text: value.numero
                }).appendTo('#template-' + index);

                $('<td>', {
                    text: value.descricao
                }).appendTo('#template-' + index);

                // $('<td>', {
                //     text: value.setor
                // }).appendTo('#template-' + index);

                $('<td>', {
                    class: 'text-center',
                    text: value.usuario
                }).appendTo('#template-' + index);

                $('<td>', {
                    class: 'text-center',
                    append: $('<a>', {
                        text: 'Exibir',
                        style: 'cursor: pointer;',
                        click: function (e) {
                            e.preventDefault();
                            var template = new Template();
                            console.log('LISTAR 3');
                            var funcionario = template.detalhes(value.numero);
                            // var funcionarioFUNC = template.detalhes(value.numero);

                            console.log(funcionario);

                            $('#visualizar-funcionarios > *').remove();
                            $('#deletar-template #deletar').remove();
                            $('#atualizar-template #atualizar').remove();
                            $('<button>', {
                                id: 'deletar',
                                class: 'btn btn-danger pull-left',
                                text: ' Apagar template',
                                prepend: $('<i>', {
                                    class: 'glyphicon glyphicon-trash'
                                }),
                                click: function (e) {
                                    e.preventDefault();
                                    /**
                                     * Ação para deletar a template
                                     */
                                    $('#detalhes-template-fechar').trigger('click');
                                    $('<div>', {
                                        id: 'confirma-deletar',
                                        title: 'Confirmação',
                                        append: $('<p>', {
                                            text: ' Deseja realmente deletar esta template?'
                                        })
                                    }).appendTo('body');

                                    $("#confirma-deletar").dialog({
                                        resizable: false,
                                        height: "auto",
                                        width: 400,
                                        modal: true,
                                        buttons: {
                                            "Deletar": function () {
                                                var deletar = new Template();
                                                if (deletar.deletar(value.numero)) {
                                                    $('#template-' + value.numero).parent().remove();
                                                    $('<div>', {
                                                        id: 'deletar-sucesso',
                                                        title: 'Sucesso',
                                                        append: $('<p>', {
                                                            class: 'text-center',
                                                            text: ' Template deletada com sucesso!',
                                                            prepend: $('<i>', {
                                                                class: 'glyphicon glyphicon-ok'
                                                            })
                                                        })
                                                    }).appendTo('body');

                                                    $('#deletar-sucesso').dialog({
                                                        modal: true,
                                                        buttons: {
                                                            "OK": function () {
                                                                $(this).dialog('close');
                                                                $('#deletar-sucesso').remove();
                                                            }
                                                        }
                                                    });
                                                }
                                                $(this).dialog("close");
                                                $("#confirma-deletar").remove();
                                            },
                                            "Cancelar": function () {
                                                $(this).dialog("close");
                                                $("#confirma-deletar").remove();
                                            }
                                        }
                                    });

                                }
                            }).appendTo('#deletar-template');

                            // $('<button>', { //tirei o botao de atualizar
                            //     id: 'atualizar',
                            //     class: 'btn btn-warning center-block',
                            //     text: ' Atualizar template',
                            //     prepend: $('<i>', {
                            //         class: 'glyphicon glyphicon-pencil'
                            //     }),
                            //     click: function (e) {
                            //         e.preventDefault();
                            //         $(location).attr('href', 'atualizar_template/' + value.numero);
                            //     }
                            // }).appendTo('#atualizar-template');

                            $.each(funcionario, function (index, value) {
                                
                                // console.log("VALUEEEEEEEEEEEEEEEEEEEEEEEEEEE ->");
                                // console.log(value);
                                // console.log("INDEXXXXXXXXXXXXXXXXXXXXXXX ->");
                                // console.log(index);

                                $('<tr>', {
                                    id: 'funcionarios-template-' + index
                                }).appendTo('#visualizar-funcionarios');

                                $('<td>', {
                                    text: value.funcionario.matricula //era value.funcionario.matricula
                                }).appendTo('#funcionarios-template-' + index);

                                $('<td>', {
                                    text: value.funcionario.nome //era value.funcionario.nome
                                }).appendTo('#funcionarios-template-' + index);

                                /**
                                 * Célula onde ocorre os eventos de visualização de produtos por matricula
                                 */
                                $('<td>', {
                                    class: 'text-center',
                                    append: $('<a>', {
                                        text: 'Visualizar',
                                        style: 'cursor: pointer',
                                        click: function (e) {
                                            e.preventDefault();
                                            $('#visualizar-produtos > *').remove();
                                            /**
                                             * Iterando a lista de produtos por funcionário
                                             */
                                            $.each(value.funcionario.produtos, function (index, value) {
                                                $('<tr>', {
                                                    id: 'produtos-template-' + index
                                                }).appendTo('#visualizar-produtos');
                                                $('<td>', {
                                                    text: value.codigo
                                                }).appendTo('#produtos-template-' + index);
                                                $('<td>', {
                                                    text: value.descricao
                                                }).appendTo('#produtos-template-' + index);
                                                $('<td>', {
                                                    text: value.ca
                                                }).appendTo('#produtos-template-' + index);
                                                $('<td>', {
                                                    class: 'text-center',
                                                    text: value.unidade
                                                }).appendTo('#produtos-template-' + index);
                                                $('<td>', {
                                                    class: 'text-center',
                                                    text: value.quantidade
                                                }).appendTo('#produtos-template-' + index);
                                            });
                                        }
                                    })
                                }).appendTo('#funcionarios-template-' + index);
                            });
                            $('#lista-detalhes-template').modal('toggle');
                        }
                    })
                }).appendTo('#template-' + index);
            });
        } else {
            $('<tr>', {
                id: 'template-mensagem',
                class: 'info'
            }).appendTo('#selecionar-template');

            $('<td>', {
                colspan: 5,
                text: ' Não há templates cadastradas com estes critérios',
                prepend: $('<i>', {
                    class: 'glyphicon glyphicon-exclamation-sign'
                })
            }).appendTo('#template-mensagem');
        }
    });

    $('#lista-detalhes-template').on('hidden.bs.modal', function () {
        console.log("alaaaaaaaaaaaaa");
        $('#visualizar-produtos > *').remove();
        $('#visualizar-funcionarios > *').remove();
        $('#deletar-template #deletar').remove();
    });



































    /**
     * Seleção de turno único para todos os funcionários****************************************************************************
     */
    $('#btn-local-entrega-selecionado-todos').click(function (e) { //TRAMPO

        console.log('---------- STORAGE --------->>');
        console.log(sessionStorage);
        // console.log('---------- ENTROU NO CLICK CONFIRMAR ---------');
        e.preventDefault();
        var temp = [];


        // console.log('--------- ANTES DO EACH LA VEM TEST ------------'); 
        // console.log($.parseJSON(sessionStorage.getItem('template_funcionarios')));

        $.each($.parseJSON(sessionStorage.getItem('template_funcionarios')), function (index, value) {
            console.log("CLICOU AQUI!!!xxxxxxxx");
        // console.log('---------- CHEGO NO TEMP.PUSH  ---------');
            temp.push({
                'id': value.id,
                'cliente': value.cliente,
                'nome': value.nome,
                'matricula': value.matricula,
                'local': $('#local-entrega-todos option:selected').val(),
                'turno': $('#turno-entrega-todos option:selected').val()
            });
        });
        
        // console.log('---------- TEMP ---------');
        // console.log(temp);
        console.log("FECHOU");
        $('#selecionar-local-entrega-todos').modal('toggle');
        // sessionStorage.removeItem('template_funcionarios'); //tirei p testar

        var template = new Template();
        
        console.log('---------- TEMPLATEE --------->>');
        console.log(template);
        
        // console.log('---------- TESTES ---------');
        // console.log(sessionStorage.getItem('numero_template'));
        // console.log(sessionStorage.getItem('template_observacao'));
        // console.log(sessionStorage.getItem('template_centro_custo'));








        
        
        
        
        
        
        
        
        var resultado = template.utilizarTemplate(parseInt(sessionStorage.getItem('numero_template'), 10), temp, sessionStorage.getItem('template_observacao'), sessionStorage.getItem('template_centro_custo'));




        if (resultado.callback) { //if (JSON.parse(resultado.callback)) {//CERTO

                var detalhes = template.detalhes(sessionStorage.getItem('numero_template'));
                console.log('---------- DETALHESS chegando de template CLASS JS --------->');
                console.log(detalhes);
        
                $.each(detalhes, function (index, value) { //trouxe da outra ffunc ali em cima //teste //trampo    
                    $('<tr>', {
                        id: 'funcionarios-template-' + index
                    }).appendTo('#visualizar-funcionarios');
        
                    $('<td>', {
                        text: value.funcionario.matricula //era value.funcionario.matricula
                    }).appendTo('#funcionarios-template-' + index);
        
                    $('<td>', {
                        text: value.funcionario.nome //era value.funcionario.nome
                    }).appendTo('#funcionarios-template-' + index);
        
                    /**
                     * Célula onde ocorre os eventos de visualização de produtos por matricula
                     */
                    $('<td>', {
                        class: 'text-center',
                        append: $('<a>', {
                            text: 'Visualizar',
                            style: 'cursor: pointer',
                            click: function (e) {
                                e.preventDefault();
                                $('#visualizar-produtos > *').remove();
                                /**
                                 * Iterando a lista de produtos por funcionário
                                 */
                                $.each(value.funcionario.produtos, function (index, value) {
                                    $('<tr>', {
                                        id: 'produtos-template-' + index
                                    }).appendTo('#visualizar-produtos');
                                    $('<td>', {
                                        text: value.codigo
                                    }).appendTo('#produtos-template-' + index);
                                    $('<td>', {
                                        text: value.descricao
                                    }).appendTo('#produtos-template-' + index);
                                    $('<td>', {
                                        text: value.ca
                                    }).appendTo('#produtos-template-' + index);
                                    $('<td>', {
                                        class: 'text-center',
                                        text: value.unidade
                                    }).appendTo('#produtos-template-' + index);
                                    $('<td>', {
                                        class: 'text-center',
                                        text: value.quantidade
                                    }).appendTo('#produtos-template-' + index);
                                });
                            }
                        })
                    }).appendTo('#funcionarios-template-' + index);
                });
                $('#lista-detalhes-template').modal('toggle');
                limparStorage();

        } else {
            bootbox.alert({
                size: "small",
                title: "Erro",
                message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> Ocorreu um problema ao utilizar a template.</div>",
                callback: function () {
                    limparStorage();
                }
            });
        }






        
       



        //CERTO ANTIGO
        // var resultado = template.utilizarTemplate(parseInt(sessionStorage.getItem('numero_template'), 10), temp, sessionStorage.getItem('template_observacao'), sessionStorage.getItem('template_centro_custo'));
        // if (resultado.callback) { //if (JSON.parse(resultado.callback)) {
        //     console.log("TRIGOU AQUI!!!");
        //     // $('#btn-efetuar-solicitacao').trigger('click'); //TESTE
        //     // console.log('IF FOIII CALLBACK UHUL');
        //     var link = (resultado.tipo === 'SOLICITAÇÃO') ? 'listar_solicitacoes' : 'localizar_requisicao';
        //     bootbox.alert({
        //         size: "small",
        //         title: "Sucesso",
        //         message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Template foi utilizada com sucesso.</div>",
        //         callback: function () {
        //             limparStorage();
        //             $(location).attr('href', link);
        //         },
        //         closeButton: false
        //     });
        // } else {
        //     // console.log('ELSE FOI =(');
        //     bootbox.alert({
        //         size: "small",
        //         title: "Erro",
        //         message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> Ocorreu um problema ao utilizar a template.</div>",
        //         callback: function () {
        //             limparStorage();
        //         }
        //     });
        // }









    });
























    $('#btn-local-entrega-template').click(function (e) {
        console.log("ENTROU NO SEGUNDO");
        e.preventDefault();
        var temp = [];
        $.each($.parseJSON(sessionStorage.getItem('template_funcionarios')), function (index, value) {
            console.log(value);
            temp.push({
                'id':value.id,
                'cliente': value.cliente,
                'matricula': value.matricula,
                'nome': value.nome,
                'local': $.trim($('#localFuncionario-' + value.matricula + ' option:selected').text()),
                'turno': $.trim($('#turnoFuncionario-' + value.matricula + ' option:selected').text())
            });
        });
        // console.log(temp);

        /*DAQUI PRA BBAIXO EU CRIEI */
        $('#selecionar-local-entrega-template').modal('toggle');
        var template = new Template();
        var resultado = template.utilizarTemplate(parseInt(sessionStorage.getItem('numero_template'), 10), temp, sessionStorage.getItem('template_observacao'), sessionStorage.getItem('template_centro_custo'));

        // console.log((resultado));

        if (resultado.callback) { //if (JSON.parse(resultado.callback)) {
            var link = (resultado.tipo === 'SOLICITAÇÃO') ? 'listar_solicitacoes' : 'localizar_requisicao';
            bootbox.alert({
                size: "small",
                title: "Sucesso",
                message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Template foi utilizada com sucesso.</div>",
                callback: function () {
                    limparStorage();
                    $(location).attr('href', link);
                },
                closeButton: false
            });
        } else {
            // console.log('ELSE FOI =(');
            bootbox.alert({
                size: "small",
                title: "Erro",
                message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> Ocorreu um problema ao utilizar a template.</div>",
                callback: function () {
                    limparStorage();
                }
            });
        }

        /*DAQUI PRA CIMA EU CRIEI */
        

        // $('#selecionar-local-entrega-template').modal('toggle'); //COMENTEI AQUI E CRIEI ALI EM CIMA
        // bootbox.alert({
        //     size: "small",
        //     title: "Sucesso",
        //     message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Template foi utilizada com sucesso.</div>",
        //     callback: function () {
        //         limparStorage();
        //     }
        // })

    });




    $('#selecionar-local-entrega-template').on('hidden.bs.modal', function () {
        $('#lista-funcionarios-template > *').remove();
        sessionStorage.removeItem('template_funcionarios');
    });






    
    $('#btn-salvar-template').click(function (e) {
        e.preventDefault();

        var template = new Template();
        var observacao = $('#txtObservacaoTemplate').val();
        var nome = $.trim($('#txtTemplateDescricao').val());
        /**
         * Validar as coleções também.
         */
        if (!$.isEmptyObject(JSON.parse(sessionStorage.getItem('template_funcionarios_itens')))) {
            if ($.trim($('#txtTemplateDescricao').val())) {
                var resultado = template.criar(sessionStorage.getItem('template_funcionarios_itens'), nome.toUpperCase(), observacao.toUpperCase());

                if (JSON.parse(resultado.status)) {
                    mensagensTela('Sucesso', 'Template de numero ' + resultado.template + ' criada com sucesso!', false);
                    limparStorage();
                    limparCampos();
                } else {
                    mensagensTela('Erro', 'Ocorreu um erro. Por favor tente mais tarde ou informe para o suporte técnico.');
                }
            } else {
                /**
                 * Validando o nome da template
                 */
                mensagensTela('Atenção', 'É obrigatório acrescentar um nome para template.', true);
            }
        } else {
            mensagensTela('Atenção', 'Você deve acrescentar ao menos 1 produto a uma matricula.', true);
        }


    });

















    $('#btn-buscarProdutoTemplate').click(function (e) {
        e.preventDefault();
        var produto = $.trim($('#txtProduto').val());
        var comparar = produtos.getProdutoFromStorage();
        funcionarios = new Funcionario();
        lista = funcionarios.getFuncionarioFromStorage();

        var ghe = funcionario[0].ghe; //MODELO CERTO

        if(JSON.parse(sessionStorage.getItem('funcionarios')).length  != 0){
            ghe = JSON.parse(sessionStorage.getItem('funcionarios')[0]['ghe']);  
        }
        
        // var itens = produtos.listar(lista[0].cliente, lista[0].cc, lista[0].ghe, produto, contador);
        var itens = produtos.listar(sessionStorage.getItem('cliente'), sessionStorage.getItem('centro_custo'), ghe, produto, contador);
        // console.log("PRODUTO TEMPLATE");
        // console.log(itens);
        // console.log("Cliente ");
        // console.log(sessionStorage.getItem('cliente'));
        // console.log("Centro Custo");
        // console.log(sessionStorage.getItem('centro_custo'));
        console.log("PRODUTO");
        console.log(produto);
        console.log("contador");
        console.log(contador);
        // console.log("COMPARAR");
        // console.log(comparar);

        produtosLista(itens, comparar);
    });

    $('#txtProduto').keyup(function (e) {
        // console.log('aquii');
        var key = $(this).val().length;
        if (e.which === 13 || (key >= 3 || key === 0)) {
            contador = 1;
            $('#btn-buscarProdutoTemplate').trigger('click');
        }
    });

    $('#btn-cancelar').click(function (e) {
        limparStorage();
        limparCampos();
    });

    $('#btn-listarTemplate').trigger('click');

    /**
     * Adicionar validação de produtos já cadastrados
     * Add, Del
     */

    if ($('input[name="template-atualiza-descricao"]').val()) {
        $('#txtObservacaoTemplate').trigger('keyup');

        var template = new Template();
        console.log('LISTAR 4');
        var funcionario = template.detalhes($('#txtTemplateDescricao').data('codigo'));

        // console.log("CHEGOUUUUUUUUU");
        // console.log(funcionario);

        /**
         * Armazena o cliente e o setor no webstorage
         */
        // console.log(funcionario);
        sessionStorage.setItem('cliente', funcionario[0].funcionario.cliente);
        sessionStorage.setItem('setor', funcionario[0].funcionario.setor);

        /**
         * Remove os itens do webStorage antes de sair da pagina
         */
        $(window).on("beforeunload", function (e) {
            sessionStorage.removeItem('cliente');
            sessionStorage.removeItem('setor');
        });
        

    }

});