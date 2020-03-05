$(function() {

    var notificacao = new Notificacao();
    var mensagem = notificacao.listarManutencao();
    if (!$.isEmptyObject(mensagem)) {


        
        $.each(mensagem, function (index, mensagem) {          




                        $('<article>', {
                            id: 'mensagem-aviso',
                            style: 'margin-bottom: 10px !important',
                            append: $('<bloquote>', {
                                append: $('<p>', {
                                    text: ' ' + mensagem.mensagem,
                                    prepend: $('<i>', {
                                        class: 'fa fa-exclamation-triangle',
                                        'aria-hidden': true
                                    })
                                })
                            })
                        }).append($('<footer>', {
                            append: $('<small>', {
                                append: $('<strong>', {
                                    text: ' Publicado em :'
                                })
                            }).append(' ' + mensagem.publicacao + ' - ')
                            .prepend(
                                $('<i>', {
                                    class: 'fa fa-calendar-o',
                                    'aria-hidden' : true,
                                })
                            )
                            .append($('<strong>', {
                                    text: 'Expira em : '
                                })).append(' ' + mensagem.expiracao)
                        }))
                            .appendTo('#quadro-avisos');
        });
        
        $('article').addClass('alert alert-warning');
    } 
    else {
        $('#quadro-avisos').addClass('alert alert-info');

        $('<p>', {
            text: ' Não existem avisos no momento.',
            prepend: $('<i>', {
                class: 'fa fa-flag',
                'aria-hidden': true
            })
        }).appendTo('#quadro-avisos');
    }





    $('#enviar_aviso').click(function (e) { //MM
        e.preventDefault();
        var msg = $('#txtMessageAviso').val();
        var notificacao = new Notificacao();
        var resultado = notificacao.enviarAviso(msg);
console.log(resultado);
        if (resultado.status == 200) { //if (JSON.parse(resultado.callback)) {
                bootbox.alert({
                size: "small",
                title: "Sucesso",
                message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Mensagem enviada com sucesso.</div>",
                // callback: function () {
                //     limparStorage();
                //     $(location).attr('href', link);
                // },
                closeButton: false
            });
        } else {
            bootbox.alert({
                size: "small",
                title: "Erro",
                message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> Ocorreu um problema ao enviar a mensagem.</div>",
                // callback: function () {
                //     limparStorage();
                // }
            });
        }

    })

    $('#txtMessageAviso').keyup(function(){
        $('#txtAvisoCaracter').html($(this).val().length)
        if($(this).val() && $(this).val().length > 4)
        {
            $('#enviar_aviso').prop('disabled', false);
        }else{
            $('#enviar_aviso').prop('disabled', true);
        }
    });

});
