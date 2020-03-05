$(function () {
    var url = document.location.origin + '/webpedidos/assets';
    montarEntregaExterna();






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

    sessionStorage.removeItem('pedido');












    $('#btn-efetuar-solicitacao').click(function (e) { //trampo //finalizar req
        e.preventDefault();
        var produtos = new Produtos();
        var funcionarios = new Funcionario();
        var requisicao = new Requisicao();


        if ((!$.isEmptyObject(produtos.getProdutoFromStorage())) && (!$.isEmptyObject(funcionarios.getFuncionarioFromStorage()))) {
            requisicao.produtos(JSON.stringify(produtos.getProdutoFromStorage()));
            requisicao.funcionarios(JSON.stringify(funcionarios.getFuncionarioFromStorage()));
            requisicao.observacao($('#txtObservacao').val());            

            if ($('#cbLocalExterno option:selected').text() === "CEP..."){ 
                var localentrega = {
                    'cep': $('#txtCEP').val(),
                    'rua': $('#txtRua').val(),
                    'numero': $('#txtNum').val(),
                    'bairro': $('#txtBairro').val(),
                    'cidade': $('#txtCidade').val(),
                    'estado': $('#txtEstado').val()
                }    
                
                
            console.log('LOCAL JS');
            console.log(localentrega);
                
                // verificar se ja tem esse cep
                var local = new Local();
                var verificar_local = local.verificarEntrega(localentrega.cep, localentrega.numero);
        
                if(verificar_local == ''){ //se nao tiver entao cadastrar novo local
                    var cadastrar_local = local.cadastrarEntrega(localentrega);
                    console.log(cadastrar_local);
                }
            }else{
                var localentrega = $('#cbLocalExterno option:selected').text();
            }

            requisicao.localEntregaExterno(localentrega);     


            var resultado = requisicao.gerarPedido();

            // console.log('RESULTADOOOOO');
            // console.log(resultado);
            // console.log('MONTOU');

            if (JSON.parse(resultado.callback)) {
                $.each(resultado.resumo, function (index, resumo) {
                    $('<tr>', {
                        id: 'pedido-' + index
                    }).appendTo('#resumo-pedido-funcionarios');
                    $('<td>', {
                        class: 'text-center',
                        text: resumo.pedido.pedido
                    }).appendTo('#pedido-' + index);
                    $('<td>', {
                        class: 'text-center',
                        text: resumo.pedido.matricula
                    }).appendTo('#pedido-' + index);
                    $('<td>', {
                        text: resumo.pedido.nome
                    }).appendTo('#pedido-' + index);
                    $('<td>', {
                        text: resumo.pedido.entrega
                    }).appendTo('#pedido-' + index);
                    $('<td>', {
                        text: resumo.pedido.turno
                    }).appendTo('#pedido-' + index);
                    if (index === 0) {
                        $.each(resumo.pedido.produto, function (index, produto) {
                            $('<tr>', {
                                id: 'resumo-produtos-' + index
                            }).appendTo('#resumo-pedido-produtos');
                            $('<td>', {
                                class: 'text-center',
                                text: produto.codigo_produto
                            }).appendTo('#resumo-produtos-' + index);
                            $('<td>', {
                                text: '  ' + produto.descricao,
                                'data-image': '',
                                'data-partnumber': produto.partnumber,
                                prepend: $('<img>', {
                                    src: url + '/images/produtos/' + produto.partnumber + '.jpg',
                                    width: '30',
                                    heigth: '30'
                                })
                            }).appendTo('#resumo-produtos-' + index);
                            $('<td>', {
                                class: 'text-center',
                                text: produto.quantidade
                            }).appendTo('#resumo-produtos-' + index);
                        });
                    }
                });
                $('#resumo-data-emissao').html(resultado.resumo[0].data_emissao);
                if (resultado.resumo[0].obs !== "") {
                    $('#alert-observacao').addClass('alert-info');
                    $('#resumo-observacao').html(resultado.resumo[0].obs);
                    $('.wrapper-observacao').css('display', 'block');
                }
                tooltip();
                $('#status-abertura-requisicao')
                    .html('<i class="glyphicon glyphicon-thumbs-up"></i> Requisição realizada com sucesso!')
                    .addClass('alert alert-success');
                $('#resumo-pedido').modal('toggle');
                // $('#tabFuncionario').trigger('click');
                $('#btn-cancelar-requisicao').trigger('click');
                $('#tabFuncionario').tab('show')

                // LIMPAR CEP E ESCONDER
                $('#cep').hide();
                limpa_formulário_cep();


            } else {
                console.log(resultado);
                bootbox.alert({
                    size: "small",
                    title: "<i class='glyphicon glyphicon-exclamation-sign'></i> Atenção",
                    message: "Não foi possível concluir a requisição.",
                    locale: "pt"
                });
            }
        } else {
            bootbox.alert({
                size: "small",
                title: "<i class='glyphicon glyphicon-exclamation-sign'></i> Atenção",
                message: "Selecione ao menos um funcionário e um item",
                locale: "pt"
            });
        }
    })




















    $('#btn-cancelar-requisicao').click(function (e) {
        e.preventDefault();

        
        $('#btn-cancelar-requisicao').hide(); //esconder ele mesmo
        $('.rowFuncionarios').hide(); //esconder tabela funcionarios

        sessionStorage.removeItem('items');
        sessionStorage.removeItem('funcionarios');
        $('#funcionarios-selecionados > *').remove();
        $('#produtos-selecionados > *').remove();
        $('#reutilizar-pedido').parent().removeClass('active');
        $('#sel-lote').parent().removeClass('active');
        $('#sel-template').parent().removeClass('active');
        $('#sel-funcionarios').parent().removeClass('active');
        $('#txtObservacao').val('');
    });

    $('#lista-funcionarios').click(function (e) {
        e.preventDefault();
    });

    $('#sel-funcionarios').click(function (e) {
        console.log('AAAAAAA');
        e.preventDefault();
        $(this).parent().toggleClass('active');
        $('#sel-lote').parent().removeClass('active');
        $('#sel-template').parent().removeClass('active');
        $('#reutilizar-pedido').parent().removeClass('active');
        setTimeout(function () {
            $('#txtFuncionario').focus();
        }, 1000);
    });

    $('#sel-lote').click(function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('active');
        $('#sel-funcionarios').parent().removeClass('active');
        $('#sel-template').parent().removeClass('active');
        $('#reutilizar-pedido').parent().removeClass('active');
        setTimeout(function () {
            $('#txtSetor').focus();
        }, 1000);

    })

    $('#sel-template').click(function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('active');
        $('#sel-lote').parent().removeClass('active');
        $('#sel-funcionarios').parent().removeClass('active');
        $('#reutilizar-pedido').parent().removeClass('active');
        $('#btn-buscarTemplate').trigger('click');
    });

    $('#reutilizar-pedido').click(function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('active');
        $('#sel-lote').parent().removeClass('active');
        $('#sel-template').parent().removeClass('active');
        $('#sel-funcionarios').parent().removeClass('active');
    })

    $('#resumo-pedido').on('hidden.bs.modal', function () {
        $('#resumo-pedido-funcionarios > *').remove();
        $('#resumo-pedido-produtos > *').remove();
        $('#alert-observacao').removeClass('alert-info');
        $('#resumo-observacao').html('');
        $('#resumo-data-emissao').html('');
        $('#status-abertura-requisicao')
            .html('')
            .removeClass('alert alert-success');
    });

    $('#detalhes-pedido').on('hidden.bs.modal', function () {
        $('#avisos-aprovar')
            .removeClass('alert alert-success')
            .removeClass('alert alert-danger');
        $('#avisos-aprovar > * ').remove();
        $('#motivo-nao-aprovado > *').remove();
        $('#acao-nao-aprovado > *').remove();
        $('#txtObservacao-caracter').html(0);
    });

    $('#btn-aprovar').click(function (e) {
        e.preventDefault();
        var aprovar = new Requisicao();
        var requisicao = aprovar.aprovar($('#num-pedido-detalhe').text(), true, '');

        if (JSON.parse(requisicao.callback)) {
            $('#avisos-aprovar').addClass('alert alert-success');
            $('<p>', {
                class: 'text-center'
            }).html('<i class="fa fa-check" aria-hidden="true"></i> Solicitação aprovada com sucesso.<br /> Número do pedido <strong>' + requisicao.reserva + '</strong>. <br /><small>O pedido poderá ser consultado no menu <strong><a href="localizar_requisicao">Pedidos</a></strong></small>').appendTo('#avisos-aprovar');

            $(this).prop('disabled', true);
            $('#btn-nao-aprovar').prop('disabled', true);
            $('*[data-solicitacao="' + parseInt(requisicao.solicitacao, 10) + '"]').parent().remove();
            sessionStorage.setItem('pedido', requisicao.reserva);
        } else {
            $('#avisos-aprovar').addClass('alert alert-danger');
            $('<p>', {
                class: 'text-center'
            }).html('<i class="fa fa-times" aria-hidden="true"></i> Ocorreu um erro, por favor, informe o suporte técnico. <br /> Data e hora do ocorrido: ' + (new Date()).toLocaleString('pt-BR')).appendTo('#avisos-aprovar');
        }

    });

    $('#btn-nao-aprovar').click(function (e) {
        e.preventDefault();

        $('<label>', {
            text: 'Motivo'
        }).appendTo('#motivo-nao-aprovado');

        $('<textarea>', {
            id: 'txtMotivoNaoAprovado',
            class: 'form-control',
            style: 'resize: none; text-transform: uppercase;'
        }).appendTo('#motivo-nao-aprovado');

        $('<label>', {
            text: ' ',
        }).appendTo('#acao-nao-aprovado')

        $('<button>', {
            id: 'btnNaoAprovado',
            class: 'btn btn-primary pull-right',
            text: ' Confirmar',
            style: 'margin: 15px',
            click: function () {
                var aprovar = new Requisicao();
                var solicitacao = aprovar.aprovar($('#num-pedido-detalhe').text(), false, $('#txtMotivoNaoAprovado').val());

                if (JSON.parse(solicitacao.callback)) {
                    $('#avisos-aprovar').addClass('alert alert-success');
                    $('<p>', {
                        class: 'text-center'
                    }).html('<i class="fa fa-check" aria-hidden="true"></i> Solicitação de Nº ' + solicitacao.solicitacao + ' não aprovada.').appendTo('#avisos-aprovar');

                    $('#btn-aprovar').prop('disabled', true);
                    $('#btn-nao-aprovar').prop('disabled', true);
                    $('*[data-solicitacao="' + parseInt(solicitacao.solicitacao, 10) + '"]').parent().remove();
                    $('#btnNaoAprovado').prop('disabled', true);
                    $('#txtMotivoNaoAprovado').prop('readonly', true);
                } else {
                    $('#avisos-aprovar').addClass('alert alert-danger');
                    $('<p>', {
                        class: 'text-center'
                    }).html('<i class="fa fa-times" aria-hidden="true"></i> Ocorreu um erro, por favor, informe o suporte técnico. <br /> Data e hora do ocorrido: ' + (new Date()).toLocaleString('pt-BR')).appendTo('#avisos-aprovar');
                }

            },
            prepend: $('<i>', {
                class: 'fa fa-check',
                'aria-hidden': true
            })
        }).appendTo('#acao-nao-aprovado');

        $('#txtMotivoNaoAprovado').focus();

    });

    $('#txtObservacao').keyup(function (e) {
        if ($(this).val().length >= 0 && $(this).val().length <= 1000)
            $('#txtObservacao-caracter').html($(this).val().length);
    });

    $('#exportar-pdf').click(function () {
        /**
         * Verficar as margens na impressão
         */
        var doc = new jsPDF('p', 'pt', 'a4');
        var funcionarios = doc.autoTableHtmlToJson($('#pdf-resumo-funcionarios').get(0));
        var produtos = doc.autoTableHtmlToJson($('#pdf-resumo-produtos').get(0));
        doc.setFontSize(12);
        doc.text('Emissão: ' + $('#resumo-data-emissao').text(), 50, 30);
        doc.text('Observação: ' + $('#resumo-observacao').text(), 50, 60);
        doc.autoTable(funcionarios.columns, funcionarios.data, {
            startY: 100,
            headerStyles: {
                fillColor: [188, 0, 9],
                fontSize: 12
            }
        });
        doc.autoTable(produtos.columns, produtos.data, {
            startY: doc.autoTable.previous.finalY + 10,
            headerStyles: {
                fillColor: [188, 0, 9],
                fontSize: 12
            }

        });
        doc.save('Resumo-' + (new Date()).toLocaleString('pt-BR') + '.pdf');
    });














        

    // COMEÇO FUNÇÔES RELACIONADAS AO CEP NO LOCAL DE ENTREGA EXTERNO
    function montarEntregaExterna(){
        var local = new Local();     
        var entregas = local.listarEntregaExterna();    
        console.log(entregas);

        $('<option>', {
            value: 'LOJA',
            text: 'LOJA'
        }).appendTo('#cbLocalExterno');
        
        $.each(entregas, function (index, value) {       
            var local = value.rua+', '+value.numero+', '+value.bairro+', '+value.cidade+', '+value.estado;        
            $('<option>', {
                value: local,
                text: local
            }).appendTo('#cbLocalExterno');
        });
            
        $('<option>', {
            value: 'CEP',
            text: 'CEP...'
        }).appendTo('#cbLocalExterno');
    }


    $('#cbLocalExterno').change(function() { //qndo mudar o valor do local d entrega //CEP
        if ($(this).val() === 'CEP') {
            $('#cep').show();
            $("#btn-efetuar-solicitacao").prop('disabled', true);
        }else{            
            $('#cep').hide();
            $("#btn-efetuar-solicitacao").prop('disabled', false);
        }
    });



    $('#cep').keyup(function() { //qndo digitar no campo cep  //CEP
        if ($('#txtCEP').val() != '' && $('#txtNum').val() != '' && $('#txtRua').val() != '' && $('#txtBairro').val() != '' && $('#txtCidade').val() != '' && $('#txtEstado').val() != ''){
            $("#btn-efetuar-solicitacao").prop('disabled', false);
        }else{            
            $("#btn-efetuar-solicitacao").prop('disabled', true);
        }
    });



    // $('#fecharaddfunc').click(function (e) { //qndo fechar modal de add func //acho q n vai precisar mais
    //     e.preventDefault();
    //     $('#cep').hide();
    //     limpa_formulário_cep();
    // })



    // COMEÇO CEP
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#txtRua").val("");
        $("#txtBairro").val("");
        $("#txtCidade").val("");
        $("#txtEstado").val("");
        $("#txtNum").val("");
        // $("#ibge").val("");
    }

    //Quando o campo cep perde o foco.
    $("#txtCEP").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#txtRua").val("...");
                $("#txtBairro").val("...");
                $("#txtCidade").val("...");
                $("#txtEstado").val("...");
                // $("#ibge").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#txtRua").val(dados.logradouro);
                        $("#txtBairro").val(dados.bairro);
                        $("#txtCidade").val(dados.localidade);
                        $("#txtEstado").val(dados.uf);
                        // $("#ibge").val(dados.ibge);

                        if($("#txtRua").val() == ''){
                            $("#txtRua").prop('disabled', false);
                        }else{                        
                            $("#txtRua").prop('disabled', true);
                        }

                        if($("#txtBairro").val() == ''){
                            $("#txtBairro").prop('disabled', false);
                        }else{
                            $("#txtBairro").prop('disabled', true);
                        }

                        if($("#txtCidade").val() == ''){
                            $("#txtCidade").prop('disabled', false);
                        }else{
                            $("#txtCidade").prop('disabled', true);
                        }

                        if($("#txtEstado").val() == ''){
                            $("#txtEstado").prop('disabled', false);
                        }else{
                            $("#txtEstado").prop('disabled', true);
                        }
                        $("#txtNum").prop('disabled', false);

                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });

    // FIM CEP



    // FIM FUNÇÔES RELACIONADAS AO CEP NO LOCAL DE ENTREGA













});