$(function () {

    var url = document.location.origin + '/webpedidos/assets';
    var localizar = new Requisicao();
    var retornado = 0;
    var total = 0;
    var contador = 1;





    
    function pager() {
        if ((retornado >= 0) && (retornado <= 10)) {
            $('#paginacao-pedidos > *').remove();
            $('<nav>', {
                class: 'text-center',
                'aria-label': 'Paginação',
                append: $('<ul>', {
                    id: 'pag',
                    class: 'pager'
                })
            }).appendTo('#paginacao-pedidos');

            var visivel = (contador <= 1) ? 'none' : '';

            $('<li>', {
                id: 'p-pedidos',
                style: 'display: ' + visivel,
                append: $('<a>', {
                    'style': 'cursor : pointer',
                    'aria-label': 'Anterior',
                    text: ' Anterior ',
                    click: function (e) {
                        e.preventDefault();
                        var resultado = (contador - 1);
                        contador = (resultado <= 1) ? 1 : resultado;
                        if (contador === 0) {
                            $('#p-pedidos').css('display', 'none');
                        } else {
                            $('#p-pedidos').css('display', '');
                        }
                        var pedidos = localizar.localizarPedido(criteria(), contador);
                        listarPedidos(pedidos);
                    },
                    prepend: $('<i>', {
                        class: 'fa fa-arrow-left',
                        'aria-hidden': true
                    })
                })
            }).appendTo('#pag');

            if (retornado >= 10) {
                $('<li>', {
                    id: 'n-pedidos',
                    append: $('<a>', {
                        'style': 'cursor : pointer',
                        'aria-label': 'Próximo',
                        text: ' Próximo ',
                        click: function (e) {
                            e.preventDefault();
                            var resultado = (contador + 1);
                            contador = (resultado === total) ? total : resultado;
                            if (resultado === total) {
                                $('#n-pedidos').css('display', 'none');
                            } else {
                                $('#n-pedidos').css('display', '');
                            }
                            var pedidos = localizar.localizarPedido(criteria(), contador);
                            listarPedidos(pedidos);
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






    function pagerSolicitacoes() {
        if ((retornado >= 0) && (retornado <= 10)) {
            $('#paginacao-pedidos > *').remove();
            $('<nav>', {
                class: 'text-center',
                'aria-label': 'Paginação',
                append: $('<ul>', {
                    id: 'pag',
                    class: 'pager'
                })
            }).appendTo('#paginacao-pedidos');

            var visivel = (contador <= 1) ? 'none' : '';

            $('<li>', {
                id: 'p-pedidos',
                style: 'display: ' + visivel,
                append: $('<a>', {
                    'style': 'cursor : pointer',
                    'aria-label': 'Anterior',
                    text: ' Anterior ',
                    click: function (e) {
                        e.preventDefault();
                        var resultado = (contador - 1);
                        contador = (resultado <= 1) ? 1 : resultado;
                        if (contador === 0) {
                            $('#p-pedidos').css('display', 'none');
                        } else {
                            $('#p-pedidos').css('display', '');
                        }
                        var pedidos = localizar.listarPendentes(criteria(), contador);
                        listarSolicitacoes(pedidos);
                    },
                    prepend: $('<i>', {
                        class: 'fa fa-arrow-left',
                        'aria-hidden': true
                    })
                })
            }).appendTo('#pag');

            if (retornado >= 10) {
                $('<li>', {
                    id: 'n-pedidos',
                    append: $('<a>', {
                        'style': 'cursor : pointer',
                        'aria-label': 'Próximo',
                        text: ' Próximo ',
                        click: function (e) {
                            e.preventDefault();
                            var resultado = (contador + 1);
                            contador = (resultado === total) ? total : resultado;
                            if (resultado === total) {
                                $('#n-pedidos').css('display', 'none');
                            } else {
                                $('#n-pedidos').css('display', '');
                            }
                            var pedidos = localizar.listarPendentes(criteria(), contador);
                            listarSolicitacoes(pedidos);
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

    function listarPedidos(colecao) {
        $('#resultado-consulta > *').remove();

        total = parseInt(colecao.total, 10);
        retornado = parseInt(colecao.retornado, 10);

        if (!$.isEmptyObject(colecao.pedidos)) {
            $.each(colecao.pedidos, function (index, pedido) {
                $('<tr>', {
                    id: 'lista-pedidos-' + index
                }).appendTo('#resultado-consulta');

                $('<td>', {
                    text: pedido.numero
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.funcionario
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.turno
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.cc
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.setor
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.emissao
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.status_pedido
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.solicitante
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    append: $('<a>', {
                        href: '#',
                        'data-toggle': 'modal',
                        'data-target': '#detalhes-pedido',
                        style: 'cursor: pointer;',
                        text: ' Visualizar ',
                        click: function (e) {
                            e.preventDefault();
                            $('#num-pedido-detalhe').html(pedido.numero);
                            $('#observacao-detalhe').html(pedido.observacao);
                            $('#funcionario-detalhe').html(pedido.funcionario);
                            $('#emissao-detalhe').html(pedido.emissao);
                            $('#entrega-detalhe').html(pedido.local_entrega.toUpperCase());
                            $('#turno-detalhe').html(pedido.turno);

                            var itens = new Produtos();
                            var requisicao_itens = itens.recuperar(pedido.numero);

                            if (!$.isEmptyObject(requisicao_itens)) {
                                $('#detalhes-itens > *').remove();
                                $.each(requisicao_itens, function (index, item) {
                                    $('<tr>', {
                                        id: 'itens-' + index
                                    }).appendTo('#detalhes-itens');

                                    $('<td>', {
                                        text: item.codigo
                                    }).appendTo('#itens-' + index);

                                    $('<td>', {
                                        text: item.descricao + ' ',
                                        'data-partnumber': item.partnumber,
                                        'data-image': '',
                                        prepend: $('<img>', {
                                            src: url + '/images/produtos/' + item.partnumber + '.jpg',
                                            width: '30',
                                            heigth: '30'
                                        })
                                    }).appendTo('#itens-' + index);

                                    $('<td>', {
                                        text: item.ca
                                    }).appendTo('#itens-' + index);

                                    $('<td>', {
                                        text: item.unidade
                                    }).appendTo('#itens-' + index);

                                    $('<td>', {
                                        class: 'text-center',
                                        text: item.qty
                                    }).appendTo('#itens-' + index);

                                });

                                tooltip();
                            }

                        },
                        append: $('<i>', {
                            class: 'fa fa-hand-pointer-o',
                            'aria-hidden': true
                        })
                    })
                }).appendTo('#lista-pedidos-' + index);
            });
        } else {
            $('#resultado-consulta > *').remove();

            $('<tr>', {
                id: 'lista-pedidos-info',
                class: 'info'
            }).appendTo('#resultado-consulta');

            $('<td>', {
                text: 'Não existem pedidos com estes critérios',
                colspan: 10
            }).appendTo('#lista-pedidos-info');
        }
        pager();
    }

    function listarSolicitacoes(colecao) {
        $('#resultado-consulta > *').remove();

        total = parseInt(colecao.total, 10);
        retornado = parseInt(colecao.retornado, 10);

        if (!$.isEmptyObject(colecao.solicitacoes)) {
            $.each(colecao.solicitacoes, function (index, pedido) {
                $('<tr>', {
                    id: 'lista-pedidos-' + index
                }).appendTo('#resultado-consulta');

                $('<td>', {
                    id: 'n-solicitacao',
                    'data-solicitacao': parseInt(pedido.numero, 10),
                    text: pedido.numero
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.funcionario
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.turno
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.cc
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.setor
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.emissao
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: (JSON.parse(pedido.aprovacao)) ? 'NÃO APROVADO' : 'AGUARDANDO'
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.solicitante
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    text: pedido.aprovador
                }).appendTo('#lista-pedidos-' + index);

                $('<td>', {
                    append: $('<a>', {
                        href: '#',
                        'data-toggle': 'modal',
                        'data-target': '#detalhes-pedido',
                        style: 'cursor: pointer;',
                        text: ' Visualizar ',
                        click: function (e) {
                            e.preventDefault();
                            $('#btn-aprovar').prop('disabled', false);
                            $('#btn-nao-aprovar').prop('disabled', false);
                            $('#num-pedido-detalhe').html(pedido.numero);
                            $('#observacao-detalhe').html(pedido.observacao);
                            $('#funcionario-detalhe').html(pedido.funcionario);
                            $('#emissao-detalhe').html(pedido.emissao);
                            $('#entrega-detalhe').html(pedido.local_entrega.toUpperCase());
                            $('#turno-detalhe').html(pedido.turno);

                            if (JSON.parse(pedido.naoaprovado)) {
                                $('#nao-aprovado-wrapper').css('display', 'block');
                                $('#motivo-nao-aprovacao').html(pedido.motivo_nao_aprovado);
                                $('#btn-nao-aprovar').prop('disabled', true);
                                $('#btn-aprovar').prop('disabled', true);
                            } else {
                                $('#nao-aprovado-wrapper').css('display', 'none');
                                $('#motivo-nao-aprovacao').html('');
                            }

                            var itens = new Produtos();
                            var requisicao_itens = itens.solicitacaoItens(pedido.numero);
                            if (!$.isEmptyObject(requisicao_itens.itens)) {
                                var parametros = requisicao_itens.parametros;
                                if (JSON.parse(parametros)) {
                                    $('#total-solicitacao').html('R$ ' + requisicao_itens.total);
                                    $('#valor-total-solicitacao').css('display', 'block');
                                } else {
                                    $('#total-solicitacao').remove();
                                    $('#valor-total-solicitacao').remove();
                                }
                                $('#detalhes-itens > *').remove();

                                $.each(requisicao_itens.itens, function (index, item) {
                                    $('<tr>', {
                                        id: 'itens-' + index
                                    }).appendTo('#detalhes-itens');

                                    $('<td>', {
                                        text: item.codigo
                                    }).appendTo('#itens-' + index);

                                    $('<td>', {
                                        text: item.descricao + ' ',
                                        'data-partnumber': item.partnumber,
                                        'data-image': '',
                                        prepend: $('<img>', {
                                            src: url + '/images/produtos/' + item.partnumber + '.jpg',
                                            width: '30',
                                            heigth: '30'
                                        })
                                    }).appendTo('#itens-' + index);

                                    $('<td>', {
                                        text: item.ca
                                    }).appendTo('#itens-' + index);

                                    $('<td>', {
                                        text: item.unidade
                                    }).appendTo('#itens-' + index);

                                    $('<td>', {
                                        class: 'text-center',
                                        text: item.qty
                                    }).appendTo('#itens-' + index);

                                    if (JSON.parse(parametros)) {
                                        $('<td>', {
                                            class: 'text-center',
                                            text: 'R$ ' + item.valor_exibicao_item
                                        }).appendTo('#itens-' + index);
                                    }


                                });

                                tooltip();
                            }

                        },
                        append: $('<i>', {
                            class: 'fa fa-hand-pointer-o',
                            'aria-hidden': true
                        })
                    })
                }).appendTo('#lista-pedidos-' + index);
            });
        } else {
            $('#resultado-consulta > *').remove();

            $('<tr>', {
                id: 'lista-pedidos-info',
                class: 'info'
            }).appendTo('#resultado-consulta');

            $('<td>', {
                text: 'Não existem pedidos com estes critérios',
                colspan: 10
            }).appendTo('#lista-pedidos-info');
        }
        pagerSolicitacoes();
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

    function validaData(data) {
        var formata = data.split('/').map(Number);
        var resultado = false;
        var valida_data = null;

        if (formata[1] > 12 || formata[0] > 31) {
            resultado = false;
        } else {
            valida_data = new Date(formata[2], formata[1], formata[0]);
            if (valida_data.toDateString() !== 'Invalid Date') {
                resultado = true;
            }
        }
        return resultado;
    }

    function formataData(data) {
        var formata = data.split('/').map(Number);
        var isoFormato = new Date(formata[2], (formata[1] - 1), formata[0]);
        return isoFormato.toISOString().substring(0, 10);
    }

    function criteria() {
        var num_inicial = $('#num-inicial').val();
        var num_final = $('#num-final').val();
        var data_inicial = $('#data-inicial').val();
        var data_final = $('#data-final').val();
        var matricula = $('#txtFuncionario').val();
        var nome_funcionario = $('#txtNomeFuncionario').val();
        var turno = $('#cbTurno option:selected').val();
        var status_aprovacao = $('#cbStatusAprovacao option:selected').val();
        var status_requisicao = $('#cbStatusRequisicao option:selected').val();
        var pedido = [];

        if ($.trim(data_inicial)) {
            data_inicial = formataData(data_inicial);
        }

        if ($.trim(data_final)) {
            data_final = formataData(data_final);
        }

        pedido = {
            'num-inicial': num_inicial,
            'num-final': num_final,
            'data-inicial': data_inicial,
            'data-final': data_final,
            'matricula': matricula,
            'nome': nome_funcionario,
            'turno': turno,
            'requisicao': status_requisicao,
            'aprovacao': status_aprovacao
        }

        return pedido;
    }

    $('[title]').tooltip({
        position: {
            my: "center bottom-20",
            at: "center top"
        }
    });
    
    /**
     * Apenas recupera a data corrente para alocar no placeholder
     */
    var placeholder = (new Date()).toLocaleString('pt-BR').substring(0, 10);
    $('#data-inicial, #data-final').attr('placeholder', placeholder);
    $('#data-final').prop('disabled', true);
    $('#num-final').prop('disabled', true);

    $('#num-inicial, #num-final, #data-inicial, #data-final').keyup(function () {
        if (!$.isNumeric($(this).val()))
            $(this).select();
    });

    $('#num-inicial').keyup(function () {
        if ($.trim($(this).val())) {
            $('#num-final').prop('disabled', false);
        } else {
            $('#num-final').prop('disabled', true);
        }
    });

    $('#data-inicial, #data-final').keyup(function () {
        if ($(this).val()) {
            $(this).attr('maxlength', 8);
        }
    });

    $('#data-inicial, #data-final').focusout(function () {
        var formatada = $(this).val().replace(/(\d{2})(\d{2})(\d{4})/g, "\$1/\$2/\$3");
        $(this).attr('maxlength', 10).val(formatada);
    });

    $('#data-inicial').change(function () {
        var formatada = $(this).val().replace(/(\d{2})(\d{2})(\d{4})/g, "\$1/\$2/\$3");
        if ($(this).val()) {
            if (validaData(formatada)) {
                $('#data-final').prop('disabled', false);
            } else {
                bootbox.alert({
                    size: "small",
                    title: "ATENÇÃO",
                    message: "Data inválida, por favor, adicione uma data válida!",
                    callback: function () {
                        $('#data-inicial')
                            .val('')
                            .attr('maxlength', 8);
                        $('#data-final').prop('disabled', true);
                    }
                })


            }
        } else {
            $('#data-final').prop('disabled', true);
        }
    });

    $('#data-final').change(function () {
        var formatada = $(this).val().replace(/(\d{2})(\d{2})(\d{4})/g, "\$1/\$2/\$3");
        if ($(this).val()) {
            if (!validaData(formatada)) {
                bootbox.alert({
                    size: "small",
                    title: "ATENÇÃO",
                    message: "Data inválida. Por favor, adicione uma data válida!",
                    callback: function () {
                        $('#data-final')
                            .val('')
                            .attr('maxlength', 8);
                    }
                });
            }
        } else {
            $('#data-final').prop('disabled', true);
        }
    });

    var dateFormat = "dd/mm/yy",
        from = $("#data-inicial")
            .datepicker({
                showAnim: 'slideDown',
                maxDate: "+0M",
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                selectOtherMonths: true,
                numberOfMonths: 2,
                dateFormat: 'dd/mm/yy',
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                nextText: 'Próximo',
                prevText: 'Anterior'
            })
            .on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
                $('#data-final').prop('disabled', false);
            }),
        to = $("#data-final").datepicker({
            showAnim: 'slideDown',
            maxDate: "+0M",
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            numberOfMonths: 2,
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior'
        })
            .on("change", function () {
                from.datepicker("option", "maxDate", getDate(this));
            });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }
        return date;
    }

    /**
     * Autocomplete Funcionário Matricula
     */
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
                var selectedItemValue = $("#txtFuncionario").getSelectedItemData();
                $('#txtNomeFuncionario').val(selectedItemValue.nome);
            },

            match: {
                enabled: true
            }
        }
    };

    /**
    * Autocomplete Funcionário Nome
    */
    var oNome = {
        url: function (termo) {
            type = ($.isNumeric(termo)) ? true : false;
            return 'funcionario/funcionario/listar/' + termo
        },

        getValue: function (element) {
            return (type) ? element.matricula : element.nome;
        },

        requestDelay: 750,

        ajaxSettings: {
            type: 'GET',
            dataType: 'JSON'
        },

        template: {
            type: "description",
            fields: {
                description: "matricula"
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
                var selectedItemValue = $("#txtNomeFuncionario").getSelectedItemData();
                $('#txtFuncionario').val(selectedItemValue.matricula);
            },

            match: {
                enabled: true
            }
        }
    };

    $("#txtFuncionario").easyAutocomplete(options);
    $("#txtNomeFuncionario").easyAutocomplete(oNome);

    $('#btnBuscar').click(function (e) {
        e.preventDefault();
        var pedidos = localizar.localizarPedido(criteria(), 1);
        listarPedidos(pedidos);
    });

    $('#btnBuscarSolicitacoes').click(function (e) {
        e.preventDefault();
        var pedidos = localizar.listarPendentes(criteria(), 1);
        listarSolicitacoes(pedidos);
    });

    $('#detalhes-pedido').on('hidden.bs.modal', function () {
        $('#num-pedido-detalhe').html('');
        $('#observacao-detalhe').html('');
        $('#funcionario-detalhe').html('');
        $('#emissao-detalhe').html('');
        $('#entrega-detalhe').html('');
        $('#turno-detalhe').html('');
        $('#detalhes-itens > *').remove();
        $('#motivo-nao-aprovacao').html('');
        $('#valor-total-solicitacao').css('display', 'none');
        $('#total-solicitacao').html('');
    });

    /**
     * Trigger para listar todos os pedidos e/ou solicitações
     */
    if ($('#btnBuscar').length)
        $('#btnBuscar').trigger('click');
    else
        $('#btnBuscarSolicitacoes').trigger('click');


    /**
     * Permite fazer a busca usando somente a tecla enter
     */
    $(document).keypress(function (e) {
        if (e.which == 13) {
            if ($('#btnBuscar').length)
                $('#btnBuscar').trigger('click');
            else
                $('#btnBuscarSolicitacoes').trigger('click');
        }
    });

    if (sessionStorage.getItem('pedido') !== null) {
        $('#num-inicial').val(sessionStorage.getItem('pedido'));
        $('#btnBuscar').trigger('click');
        sessionStorage.removeItem('pedido');
    }

});