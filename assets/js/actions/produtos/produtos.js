$(function () {
    var temp = [];
    var produtos = new Produtos();
    var contador = 1;
    var total = 0;
    var retornado = 0;
    var url = document.location.origin + '/webpedidos/assets';
    var lista = [];

    function tooltip() {
        
        // console.log('tooltip()');
        /**
        * Alterar caminho das imagens
        */
        $(document).tooltip({
            items: "[data-image]",
            track: true,
            content: function () {
                // console.log('saiu8712221110');
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

    function produtosGrid() {
        console.log("CLICOU PRA ADD");
        if(produtos.getProdutoFromStorage() != ''){
            console.log("MOSTRA TABELA");
            $('.rowProdutos').show(); //mostra a tabela se n ta vazio produto
        }

        // console.log('produtosGrid()');
        $('#produtos-selecionados > *').remove();
        $.each(produtos.getProdutoFromStorage(), function (index, value) {
            $('<tr>', {
                id: 'sel-' + value.item.codigo
            }).appendTo('#produtos-selecionados');

            $('<td>', {
                text: value.item.codigo,
            }).appendTo('#sel-' + value.item.codigo);

            $('<td>', {
                text: value.item.partnumber,
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
                        
        // console.log('saiu87123');
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
                        produtos.remover(value.item.codigo);
                        
                        if(produtos.getProdutoFromStorage() == ''){
                            console.log("ESCOND TABELA n tem nenhum");
                            $('.rowProdutos').hide(); //escond a tabela se n ta vazio produto
                        }
                        else{
                            $(this).parent().parent().remove();
                        }
                        
                    }
                })
            }).appendTo('#sel-' + value.item.codigo);
        });

        tooltip();
    }

    function paginacao() {
        // console.log('saiu5');
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
                        
        // console.log('saiu80907');
                        e.preventDefault();
                        var resultado = (contador - 1);
                        var comparar = produtos.getProdutoFromStorage();
                        contador = (resultado <= 1) ? 1 : resultado;
                        if (contador === 1) {
                            $('#p-produto').css('display', 'none');
                        } else {
                            $('#p-produto').css('display', '');
                        }
                        
                        var itens = produtos.listar(lista[0].cliente, lista[0].cc, lista[0].ghe, $.trim($('#txtProduto').val()), contador);
                        
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
                            
        // console.log('saiu8117');
                            e.preventDefault();
                            var resultado = (contador + 1);
                            var comparar = produtos.getProdutoFromStorage();
                            contador = (resultado === total) ? total : resultado;
                            if (resultado === total) {
                                $('#n-produto').css('display', 'none');
                            } else {
                                $('#n-produto').css('display', '');
                            }
                            var itens = produtos.listar(lista[0].cliente, lista[0].cc,lista[0].ghe, $.trim($('#txtProduto').val()), contador);
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
        // console.log('prdutos lista - percorre a lista de produtos vindas do banco de dados');
        // console.log(itens.produtos);
        // console.log(itens.retornado);
        // console.log(itens.total);
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
                    id: 'cod-' + index,
                    text: value.partnumber
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
                            
        // console.log('saiu8217');
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
                            
        // console.log('saiu227');
                            e.preventDefault();
                            if ($('#qty-' + index).val() !== '0') {
                                /**
                                * Envia o item selecionado para a tabela de Produtos selecionados
                                */
                                temp.push({
                                    'item': {
                                        'codigo': value.codigo,
                                        'descricao': value.descricao,
                                        'ca': value.ca,
                                        'unidade': value.unidade,
                                        'quantidade': $('#qty-' + index).val(),
                                        'partnumber': value.partnumber,
                                        'valor': value.preco
                                    }
                                });
                                produtos.adicionar(temp);
                                produtosGrid();
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
                
        // console.log('saiu587');
                if (!$.isNumeric($(this).val()))
                    $(this).val(0).select();
            });

            paginacao();

            /**
             * Limpa variável temporária assim que o modal é "Fechado"
             */
            $('#lista-produtos').on('hidden.bs.modal', function () {
                
        // console.log('saiu827');
                temp = [];
            });
            /**
             * End Listar-produtos
             */
        } else {
            $('<tr>', {
                id: 'lista-vazia',
                class: 'info'
            }).appendTo('#selecionar-produtos');

            $('<td>', {
                text: 'Não há produtos aqui',
                colspan: 6
            }).appendTo('#lista-vazia');
        }
    }

    $('#btnConfirmaQty').click(function (e) {
        // console.log('saiu9');
        e.preventDefault();
        var produtos = new Produtos();
        if (parseInt($('#txtQuantidadeEdicao').val(), 10) !== 0) {
            produtos.editar($.trim($('#edit-codigo-qty').val()), parseInt($('#txtQuantidadeEdicao').val(), 10));
            produtosGrid();
            $('#editar-quantidade-produto').modal('toggle');
        } else {
            $('#txtQuantidadeEdicao').select();
        }

    });

    $('#editar-quantidade-produto').on('hidden.bs.modal', function () {
        
        // console.log('saiu872');
        $('#edit-codigo-qty').remove();
        $('#txtQuantidadeEdicao').val(0);
    });

    $('#txtQuantidadeEdicao').keyup(function () {
        
        // console.log('saiu57');
        if (!$.isNumeric($(this).val()))
            $(this).val(0).select();
    });

    $('#listar-produtos').click(function (e) {
        // console.log('listar produtos');
        e.preventDefault();
        $('#selecionar-produtos > *').remove();
        funcionarios = new Funcionario();
        lista = funcionarios.getFuncionarioFromStorage();
        
        /**
         * Alterar cliente e setor
         */
        if (!$.isEmptyObject(lista)) {
            // console.log('empty lista');
            console.log(lista);
            console.log("****");
            var itens = produtos.listar(lista[0].cliente, lista[0].cc, lista[0].ghe, '', 1);
            console.log(itens);
            var comparar = produtos.getProdutoFromStorage();
            produtosLista(itens, comparar);
            $('#lista-produtos').modal('toggle');
        } else {
            // console.log('no empity lista');
            $('#avisos-add-produtos > *').remove();

            $('<hr>', {
                class: 'invisible'
            }).prependTo('#avisos-add-produtos');

            $('<div>', {
                class: 'alert alert-danger',
                append: $('<p>', {
                    text: ' Adicione ao menos 1 (um) funcionário para poder listar os produtos.',
                    prepend: $('<i>', {
                        class: 'glyphicon glyphicon-warning-sign'
                    })
                })
            }).appendTo('#avisos-add-produtos');

            setTimeout(function () {
                
        // console.log('saiu875');
                $('#avisos-add-produtos > *').remove();
            }, 6000);
        }

    });

    $('#btn-buscarProduto').click(function (e) {    
        e.preventDefault();
        var produto = $.trim($('#txtProduto').val());
        var comparar = produtos.getProdutoFromStorage();
        funcionarios = new Funcionario();
        lista = funcionarios.getFuncionarioFromStorage();
        var itens = produtos.listar(lista[0].cliente, lista[0].cc, lista[0].ghe, produto, contador);
      
//         console.log("GHE BLA");
// console.log(sessionStorage.getItem('ghe'));
// console.log(sessionStorage.getItem('gaidhe'));
// console.log(lista);
// console.log(sessionStorage);


        produtosLista(itens, comparar);     
    });

    $('#txtProduto').keyup(function (e) {
        // console.log('txtProduto keyup');
        var key = $(this).val().length;
        if (e.which === 13 || (key >= 3 || key === 0)) {
            contador = 1;
            $('#btn-buscarProduto').trigger('click');
        }
    });

    produtos.init();
    produtosGrid();

});