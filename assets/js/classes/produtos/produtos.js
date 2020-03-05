(function () {
    this.Produtos = function () {
        /**
         * Definir os produtos permitidos
         */
        $.ajaxSetup({
            dataType: 'JSON',
            type: 'POST'
        });

        this.Itens = [];

        Produtos.prototype.init = function () {
            sessionStorage.setItem('items', JSON.stringify([]));
            sessionStorage.setItem('template_funcionarios_itens', JSON.stringify([]));
        }

        Produtos.prototype.Luciano = function(LucianoData){
            alert(LucianoData);
        }

        Produtos.prototype.listar = function (cliente, setor, ghe, produto, pagina) {
            console.log(cliente);
            console.log(setor);
            console.log(ghe);
            console.log(produto);
            console.log(pagina);
            var resultado = null;
            $.ajax({
                url: 'produto/produto/permitidos',
                async: false,
                data: {
                    cliente: cliente,
                    setor: setor,
                    ghe: ghe,
                    produto: produto,
                    pagina: pagina
                },
                success: function (data) {
                    console.log(data);
                    resultado = data;
                },
                error: function (data) {
                    console.log(data);
                    resultado = data;
                }
            })

            console.log(resultado);
            return resultado;
        }

        Produtos.prototype.getProdutoFromStorage = function () {
            return $.parseJSON(sessionStorage.getItem('items'));
        }

        Produtos.prototype.getProdutosTemplateFromStorage = function () {
            return $.parseJSON(sessionStorage.getItem('template_funcionarios_itens'));
        }

        Produtos.prototype.adicionar = function (produto) {
            /**
            * Array temporário
            */
            var temp = [];
            var colecao = $.parseJSON(sessionStorage.getItem('items'));

            /**
             * Montando nova lista
             */
            $.each(produto, function (index, value) {
                var inserir = true;
                var codigo = value.item.codigo;
                if (!$.isEmptyObject(colecao)) {
                    $.each(colecao, function (index, value) {
                        if (value.item.codigo === codigo) {
                            inserir = false;
                        }
                    });
                }

                if (inserir) {
                    temp.push({
                        'item': {
                            'codigo': value.item.codigo,
                            'descricao': value.item.descricao,
                            'ca': value.item.ca,
                            'unidade': value.item.unidade,
                            'quantidade': value.item.quantidade,
                            'partnumber': value.item.partnumber,
                            'valor': value.item.valor
                        }
                    });
                }
            });

            var newvalue = [];
            if (!$.isEmptyObject(colecao)) {
                newvalue = colecao.concat(temp);
            } else {
                newvalue = temp;
            }

            sessionStorage.setItem('items', JSON.stringify(newvalue));
        }

        /**
         * Adiciona produtos da template 
         */
        Produtos.prototype.produtosTemplate1 = function (matricula, produto) {
            var temp = [];
            var colecao = [];
            if (!$.isEmptyObject(this.getProdutosTemplateFromStorage())) {
                colecao = this.getProdutosTemplateFromStorage();
                $.each(colecao.matricula, function (index, value) {
                    var matricula = value.matricula;
                    var temp_itens = [];
                    $.each(value.itens, function (index, value) {
                        temp_itens = {
                            'codigo': value.codigo,
                            'descricao': value.descricao,
                            'ca': value.ca,
                            'unidade': value.unidade,
                            'quantidade': value.quantidade,
                            'partnumber': value.partnumber,
                            'valor': value.valor
                        }
                    });

                    temp.push({
                        'matricula': matricula,
                        'itens': temp_itens
                    });
                });
            }

            /**
            * Montando nova lista
            */
            $.each(produto, function (index, value) {
                var inserir = true;
                var codigo = value.codigo;
                var itens = [];
                var comparar = [];
                if (!$.isEmptyObject($.parseJSON(sessionStorage.getItem('template_funcionarios_itens')))) {
                    comparar = $.parseJSON(sessionStorage.getItem('template_funcionarios_itens'));

                    $.each(comparar.itens, function (index, value) {
                        if (value.codigo === codigo && matricula === comparar.matricula) {
                            inserir = false;
                        }
                    });
                }

                /**
                 * A inserção está sendo duplicada ou limpando o storage / Verificar
                 */
                if (inserir) {
                    $.each(produto, function (index, value) {
                        itens = {
                            'codigo': value.item.codigo,
                            'descricao': value.item.descricao,
                            'ca': value.item.ca,
                            'unidade': value.item.unidade,
                            'quantidade': value.item.quantidade,
                            'partnumber': value.item.partnumber,
                            'valor': value.item.valor
                        };
                    });

                    if (!$.isEmptyObject(comparar)) {
                        var selecionado_item = [];
                        $.each(comparar, function (index, value) {
                            var sel_matricula = value.matricula;
                            if (value.itens.codigo !== itens.codigo && sel_matricula === matricula) {
                                console.log(value.itens.codigo, ' - ', itens.codigo, ' - ', sel_matricula, ' - ', matricula);
                                selecionado_item.push({
                                    'codigo': value.itens.codigo,
                                    'descricao': value.itens.descricao,
                                    'ca': value.itens.ca,
                                    'unidade': value.itens.unidade,
                                    'quantidade': value.itens.quantidade,
                                    'partnumber': value.itens.partnumber,
                                    'valor': value.itens.valor
                                });
                            } else {
                                selecionado_item.push(value.itens);
                            }

                            temp.push({
                                'matricula': sel_matricula,
                                'itens': selecionado_item
                            })
                        });
                    } else {
                        temp.push({
                            'matricula': matricula,
                            'itens': itens
                        });
                    }


                }
            });

            sessionStorage.setItem('template_funcionarios_itens', JSON.stringify(temp));
        }

        Produtos.prototype.concluirItens = function (matricula) {
            var temp = [];
            if (matricula !== undefined) {
                varnewvalue = [];
                temp.push({
                    template: {
                        'matricula': matricula,
                        'itens': this.Itens
                    }
                });

                if (!$.isEmptyObject(this.getProdutosTemplateFromStorage())) {
                    colecao = this.getProdutosTemplateFromStorage();
                    newvalue = colecao.concat(temp);
                } else {
                    newvalue = temp;
                }

                sessionStorage.setItem('template_funcionarios_itens', JSON.stringify(newvalue));
                this.Itens = [];
            }

        }

        Produtos.prototype.produtosTemplate = function (produto) {
            var itens = [];
            $.each(produto, function (index, value) {
                itens.push({
                    'codigo': value.item.codigo,
                    'descricao': value.item.descricao,
                    'ca': value.item.ca,
                    'unidade': value.item.unidade,
                    'quantidade': value.item.quantidade,
                    'partnumber': value.item.partnumber,
                    'valor': value.item.valor
                });
            });

            this.Itens.push(itens);
        }

        /**
         * Edita o item que está no objeto salvo no sessionStorage
         * Param: id = Codigo do produto, quantidade = nova quantidade
         */
        Produtos.prototype.editar = function (id, quantidade) {
            var produto = 0;
            var editar = this.getProdutoFromStorage();
            $.each(editar, function (index, value) {
                produto = index;
                $.each(value.item, function (index, item) {
                    if (index === 'codigo' && item === id)
                        editar[produto].item.quantidade = quantidade;
                });
            });
            sessionStorage.removeItem('items');
            this.adicionar(editar);
        }

        /**
         * Remove um item da lista selecionada
         * Param: id = Codigo do produto
         */
        Produtos.prototype.remover = function (id) {

            var colecao = this.getProdutoFromStorage();
            sessionStorage.removeItem('items');
            console.log(colecao);
            items = $.grep(colecao, function (produtos) {
                console.log((produtos.item.codigo !== id) ? true : false);
                console.log(produtos.item.codigo, id);
                return produtos.item.codigo !== id;
            });
            this.adicionar(items);

        }

        /**
         * Produtos do pedido
         */
        Produtos.prototype.recuperar = function (requisicao) {
            var resultado = null;
            $.ajax({
                url: 'produto/produto/requisicaoitens',
                async: false,
                beforeSend: function () {
                    $('<div>', {
                        id: 'loader-itens',
                        title: 'Carregando...',
                        append: $('<p>', {
                            class: 'text-center',
                            text: 'Aguarde enquanto os detalhes são carregados.'
                        })
                    }).appendTo('body');

                    $('#loader-itens').dialog({
                        modal: true
                    });
                },
                data: {
                    requisicao: requisicao
                },
                success: function (itens) {
                    $('#loader-itens').dialog('close');
                    $('#loader-itens').remove();
                    resultado = itens;
                },
                error: function (error) {
                    console.log(error);
                }
            });

            return resultado;
        }

        /**
         * Produtos da solicitacao
         */
        Produtos.prototype.solicitacaoItens = function (solicitacao) {
            var resultado = null;
            $.ajax({
                url: 'produto/produto/solicitacaoitens',
                async: false,
                beforeSend: function () {
                    $('<div>', {
                        id: 'loader-itens',
                        title: 'Carregando...',
                        append: $('<p>', {
                            class: 'text-center',
                            text: 'Aguarde enquanto os detalhes são carregados.'
                        })
                    }).appendTo('body');

                    $('#loader-itens').dialog({
                        modal: true
                    });
                },
                data: {
                    requisicao: solicitacao
                },
                success: function (itens) {
                    $('#loader-itens').dialog('close');
                    $('#loader-itens').remove();
                    resultado = itens;
                },
                error: function (error) {
                    console.log(error);
                }
            });

            return resultado;
        }
    }
} ());