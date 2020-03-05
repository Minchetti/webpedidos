$(function () {


    $idSetor = '';

    $('#txtNomeFuncionario').keyup(function(){ 
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
                    var selectedItemValue = $("#txtNomeFuncionario").getSelectedItemData();
                    $('#txtNomeFuncionario').val(selectedItemValue.nome);
                    $('#txtFuncionario').val(selectedItemValue.matricula);

                    $idSetor = selectedItemValue.cc;

                    // se selecionar algum func, limpar o setor
                    $('#txtSetorRelatorio').val('');
                                   

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
        $("#txtNomeFuncionario").easyAutocomplete(options);    
    });


    $('#txtSetorRelatorio').keyup(function(){ //fazer a logica do setor com o codigo do nome funcionario       
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
                    var selectedItemValue = $("#txtSetorRelatorio").getSelectedItemData();
                    var setor = selectedItemValue.nome;
                    $idSetor = selectedItemValue.cc;

                    
                    // se selecionar algum setor, limpar o func
                    $('#txtNomeFuncionario').val('');
                    $('#txtFuncionario').val('');

                    $('<input>', {
                        type: 'hidden',
                        value: selectedItemValue.cnpj,
                        id: 'setor-depto'
                    }).appendTo('body');

                    $('#cbLocalSetor > *').remove();
                    $('<option>', {
                        value: 'Carregando ...',
                        text: 'Carregando ...'
                    }).appendTo('#cbLocalSetor');
                    var local = new Local();
                    /**
                     * 1 segundo de delay para fazer a busca, sem ela a página se reinicia
                     * Tem tudo a ver com o evento em que está setado o trigger "onChooseEvent"
                     */
                    setTimeout(function () {
                        $('#cbLocalSetor > *').remove();
                        $.each(local.listarEntrega(setor), function (index, value) {
                            var local = value.local;
                            $('<option>', {
                                value: local.toUpperCase(),
                                text: local.toUpperCase()
                            }).appendTo('#cbLocalSetor');                        
                        });

                        // $('<option>', { //MM
                        //     value: 'LOJA',
                        //     text: 'LOJA'
                        // }).appendTo('#cbLocalSetor');

                        $('#btn-adicionarSetor').prop('disabled', false);

                    }, 1000);
                },

                match: {
                    enabled: true
                }
            }
        };

        $("#txtSetorRelatorio").easyAutocomplete(options);
    });






    $('#btnBuscar').click(function(e){
        e.preventDefault();

        var num_inicial = $('#num-inicial').val();
        var num_final = $('#num-final').val();
        var data_inicial = $('#data-inicial').val();  
        var data_final = $('#data-final').val();  
        var matricula = $('#txtFuncionario').val();  
        var nome = $('#txtNomeFuncionario').val();  
        var turno = $("#cbTurno option:selected").val();
        var setor = '';
        if($idSetor != ''){
            setor = $idSetor;
        }
        var status_apr = $("#cbStatusAprovacao option:selected").val();
        var status_req = $("#cbStatusRequisicao option:selected").val();


        // var relatorio = new Relatorio();
        // var resultado = relatorio.gerarConsumo(num_inicial, num_final, data_inicial, data_final, matricula, nome, turno, status_apr, status_req);

        // Relatorio.prototype.gerarConsumo = function (num_inicial, num_final, data_inicial, data_final, matricula, nome, turno, status_apr, status_req) {
            var resultado = null;
            $.ajax({
                async: false,
                url: 'relatorio/relatorio/gerarConsumo',
                type: 'POST',
                data: {
                    num_inicial: num_inicial,
                    num_final: num_final,
                    data_inicial: data_inicial,
                    data_final: data_final,
                    matricula: matricula,
                    nome: nome,
                    turno: turno,
                    setor: setor,
                    status_apr: status_apr,
                    status_req: status_req
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (data) {
                    resultado = data;
                }
            });            
            // return resultado;
        // }

        console.log(resultado);
        montarRelatorio(resultado);
    
    });










    
function montarRelatorio(dados){ //MM

    console.log(dados);
    $('#listar-relatorio > *').remove();
    $('#tablerelatorios').show();
    
    console.log(dados);

    if (!$.isEmptyObject(dados)) {
        $.each(dados, function (index, value) {

        $('<tr>', {
            id: 'relatorio-' + index
        }).appendTo('#listar-relatorio');

            $('<td>', {
                // id: 'usuario-' + value.webloginid,
                text: value.requisicao,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);

            $('<td>', {
                class: 'text-center',
                text: value.data_entrega,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.data_faturamento,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.CC,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.funcionario,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.matricula,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.Produto,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.Partnumber,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.CA,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.quantidade,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.vl_unit,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            var vl_tot = value.quantidade * value.vl_unit; 

            $('<td>', {
                class: 'text-center',
                text: vl_tot,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.Data_Emissao,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.Solicitante,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.smatricula,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            $('<td>', {
                class: 'text-center',
                text: value.Local_Entrega,
                style: 'font-size: smaller'
            }).appendTo('#relatorio-' + index);
            
            // if(value.nivel === "1")
            // var acesso = 'ADMINISTRATIVO';
            
   
    })}}













})