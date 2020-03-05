$(function () {
    var index = 0;

    /**
    * Autocomplete
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
                console.log("SELECIOASD");
                var selectedItemValue = $("#txtSetorFuncionario").getSelectedItemData();
                var setor = selectedItemValue.nome;
                $('#spSetorNome').html(setor);
                $('#spSetorFantasia').html(selectedItemValue.fantasia);
                $("#txtSetorFuncionario").val('');
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

    $("#txtSetorFuncionario").easyAutocomplete(options);

    $('#btnListarSetor').click(function (e) {
        e.preventDefault();

        $('#frmSetor > *').remove();

        $('<input>', {
            id: 'txtListarSetor',
            type: 'text',
            class: 'form-control',
            placeholder: 'Buscar setor'
        }).appendTo('#frmSetor');
    });

    $('#lista-setor-funcionarios').on('hidden.bs.modal', function () {
        $('#spSetorNome').html(' - ');
        $('#spSetorFantasia').html(' - ');
        $("#txtSetor").val('');
        $('#frmLocalEntregaSetor').css('display', '');
        $('#verifica-local-default').prop('checked', true);
        $('#aviso-local-setor > * ').remove();
        $('#aviso-local-setor').removeClass('alert alert-info');
        $('#setor-depto').remove();
        $('#cbLocalSetor').prop('selectedIndex', 0);
        $('#cbTurnoSetor').prop('selectedIndex', 0);
        $('#cbLocalSetor > *').remove();
        $('#btn-adicionarSetor').prop('disabled', true);
    });

    $('input[type=radio][name=verifica-local]').change(function () {
        if (JSON.parse($(this).val())) {
            $('#frmLocalEntregaSetor').css('display', '');
            $('#aviso-local-setor > * ').remove();
            $('#aviso-local-setor').removeClass('alert alert-info');
        } else {
            $('#aviso-local-setor > * ').remove();
            $('#frmLocalEntregaSetor').css('display', 'none');
            $('#aviso-local-setor').addClass('alert alert-info');
            $('<p>', {
                text: ' Será necessário acrescentar local e turno individualmente.',
                prepend: $('<i>', {
                    class: 'glyphicon glyphicon-exclamation-sign'
                })
            }).appendTo('#aviso-local-setor');
        }
    });

});