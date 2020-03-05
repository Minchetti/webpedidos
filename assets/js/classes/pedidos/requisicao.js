(function () {
    this.Requisicao = function () {
        this.Produtos = [];
        this.Funcionarios = [];
        this.Emissao = (new Date()).toISOString().substring(0, 10); //Recupera a data corrente,
        this.Log = [];
        this.Observacao = "";
        $.ajaxSetup({
            dataType: 'JSON',
            type: 'POST'
        });
        /**
         * Recebe todos os produtos selecionados para criar o pedido
         */
        Requisicao.prototype.produtos = function (vprodutos) {
            this.Produtos = vprodutos;
        }

        /**
         * Recebe todos os funcionarios selecionados para criar o pedido
         */
        Requisicao.prototype.funcionarios = function (vfuncionarios) {
            this.Funcionarios = vfuncionarios;
        }

        Requisicao.prototype.observacao = function (vobservacao) {
            this.Observacao = vobservacao;
        }


        Requisicao.prototype.localEntregaExterno = function (ventregaexterno) {
            this.LocalEntregaExterno = ventregaexterno;
        }





        /**
         * Retorna o número do pedido
         */
        Requisicao.prototype.gerarPedido = function () {
            var resultado = null;
            if ((!$.isEmptyObject(this.Produtos)) && (!$.isEmptyObject(this.Funcionarios))) {                
                $.ajax({
                    url: 'pedido/requisicao/nova',
                    async: false,
                    data: {
                        produtos: this.Produtos,
                        funcionarios: this.Funcionarios,
                        emissao: this.Emissao,
                        observacao: this.Observacao.toUpperCase(),
                        localEntregaExterno: this.LocalEntregaExterno
                    },
                    success: function (data) {
                        resultado = data;
                        console.log(resultado);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {                       
                        switch (xhr.status) {
                            case 200:
                                resultado = { callback: false };
                                console.log(resultado);
                                break;
                            case 500:
                                resultado = { callback: false };
                                console.log(thrownError);
                                break;
                        }
                    }
                });
            } else {
                console.log("ENTROU2");
                if ($.isEmptyObject(this.Produtos)) {
                    resultado = {
                        'callback': false,
                        'Produtos': 'Não pode ser vazio'
                    }
                }

                if ($.isEmptyObject(this.Funcionarios)) {
                    resultado = {
                        'callback': false,
                        'Funcionarios': 'Não pode ser vazio'
                    }
                }
            }
            return resultado;
        }



        Requisicao.prototype.localizarPedido = function (vdados, vpagina) {
            var resultado = null;
            $.ajax({
                url: 'pedido/requisicao/procurar',
                async: false,
                beforeSend: function () {
                    $('<div>', {
                        title: 'Carregando dados...',
                        id: 'loader',
                        append: $('<p>', {
                            class: 'text-center',
                            text: 'Por favor, aguarde até que os dados sejam carregados.'
                        })
                    }).appendTo('body');

                    $('#loader').dialog({
                        modal: true
                    });

                },
                data: {
                    criteria: JSON.stringify(vdados),
                    pagina: vpagina
                },
                success: function (data) {
                    $('#loader').dialog('close');
                    $('#loader').remove();
                    resultado = data;
                },
                error: function (data) {
                    resultado = data;
                }
            });
            return resultado;
        }

        Requisicao.prototype.listarPendentes = function (vdados, vpagina) {
            var resultado = null;
            $.ajax({
                url: 'pedido/requisicao/listarsolicitacoes',
                async: false,
                beforeSend: function () {
                    $('<div>', {
                        title: 'Carregando dados...',
                        id: 'loader',
                        append: $('<p>', {
                            class: 'text-center',
                            text: 'Por favor, aguarde até que os dados sejam carregados.'
                        })
                    }).appendTo('body');

                    $('#loader').dialog({
                        modal: true
                    });

                },
                data: {
                    criteria: JSON.stringify(vdados),
                    pagina: vpagina
                },
                success: function (data) {
                    $('#loader').dialog('close');
                    $('#loader').remove();
                    resultado = data;
                },
                error: function (data) {
                    resultado = data;
                }
            });
            return resultado;
        }

        Requisicao.prototype.aprovar = function (vsolicitacao, vaprovacao, vmotivo) {
            var resultado = null;
            $.ajax({
                url: 'pedido/requisicao/aprovar',
                async: false,
                data: {
                    solicitacao: parseInt(vsolicitacao, 10),
                    aprovacao: vaprovacao,
                    motivo: vmotivo.toUpperCase()
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    switch (xhr.status) {
                        case 200:
                            resultado = { callback: false };
                            break;
                        case 500:
                            resultado = { callback: false };
                            break;
                    }
                }
            });

            return resultado;
        }




        
        Requisicao.prototype.contarRequisicoes = function (mes, ano) {
            var resultado = null;
            $.ajax({
                url: 'pedido/requisicao/contarRequisicoes',
                async: false,
                data: {
                    mes: mes,
                    ano: ano
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (data) {
                    resultado = data;
                }
            });
            return resultado;
        }    




    }

} ());