
$(function () {
    var sugestoes = new Sugestao();
    
    // var responder = "<?php echo $this->session->respondesugestao ?>";
    // console.log(responder);

    function listarSugestoes(colecao) {
        $('#lista-sugestoes > *').remove();
        if (!$.isEmptyObject(colecao)) {
            $.each(colecao, function (index, sugestao) {
                var classe = '';
                if (sugestao.status === 'Respondido')
                    classe = 'success';
                else
                    classe = 'warning'

                $('<tr>', {
                    class: classe,
                    id: 'sugestao-' + index,
                }).appendTo('#lista-sugestoes');

                $('<td>', {
                    append: $('<i>', {
                        class: 'glyphicon glyphicon-time'
                    })
                }).appendTo('#sugestao-' + index);

                $('<td>', {
                    text: sugestao.matricula
                }).appendTo('#sugestao-' + index);

                $('<td>', {
                    text: sugestao.setor
                }).appendTo('#sugestao-' + index);

                $('<td>', {
                    class: 'text-justify',
                    text: sugestao.sugestao.toUpperCase()
                }).appendTo('#sugestao-' + index);

                $('<td>', {
                    text: sugestao.data_sugestao
                }).appendTo('#sugestao-' + index);

                $('<td>', {
                    text: sugestao.status.toUpperCase()
                }).appendTo('#sugestao-' + index);


                if (sugestao.status === 'Respondido') {
                    $('<td>', {
                        class: 'text-center',
                        append: $('<a>', {
                            style: 'cursor: pointer;',
                            text: 'Visualizar',
                            click: function (e) {
                                e.preventDefault();
                                bootbox.alert({
                                    title: 'Respondido em: ' + sugestao.data_resposta,
                                    message: sugestao.resposta.toUpperCase()
                                });
                            }
                        })
                    }).appendTo('#sugestao-' + index);
                } else {
                    $('<td>', {
                        class: 'text-center',
                        append: $('<i>', {
                            class: 'glyphicon glyphicon-time'
                        })
                    }).appendTo('#sugestao-' + index);
                }

                

            
                if (sugestao.status === 'Respondido') {
                    $('<td>', {
                        class: 'text-center divResposta',
                        append: $('<i>', {
                            class: 'glyphicon glyphicon-ok'
                        })
                    }).appendTo('#sugestao-' + index);                    
                } else {
                    $('<td>', {
                        class: 'text-center divResposta',
                        append: $('<a>', {
                            style: 'cursor: pointer;',
                            text: 'Responder',
                            click: function (e) {
                                e.preventDefault();
                                $('#responde-sugestao').modal('show');

                                $codigo = sugestao.codigo;      
                                
                                // bootbox.alert({
                                //     title: 'Respondido em: ' + sugestao.data_resposta,
                                //     message: sugestao.resposta.toUpperCase()
                                // });
                                
                                // $('#responde-sugestao').show();
                                
                            }
                        })
                    }).appendTo('#sugestao-' + index);
                }
                
            });
        } else {
            $('<tr>', {
                class: 'info',
                id: 'sugestao-vazia'
            }).appendTo('#lista-sugestoes');

            $('<td>', {
                colspan: 7,
                text: 'Não há mensagens!'
            }).appendTo('#sugestao-vazia');
        }
    }



    listarSugestoes(sugestoes.listar(parseInt($('.listar-por-sugestoes:checked').val(), 10)));

    $('.listar-por-sugestoes').change(function () {
        listarSugestoes(sugestoes.listar(parseInt($(this).val(), 10)));
    });

    $('#txtMessage').keyup(function (e) {
        if ($(this).val().length >= 0 && $(this).val().length <= 2000)
            $('#txtMessageCaracter').html($(this).val().length);

        if ($.trim($(this).val()))
            $('#enviar-sugestao').prop('disabled', false);
        else
            $('#enviar-sugestao').prop('disabled', true);
    });

    $('#enviar-sugestao').click(function (e) {
        e.preventDefault();

        var tipo = parseInt($('#cbTipoReclamacao option:selected').val(), 10);
        var mensagem = $.trim($('#txtMessage').val());
        var matricula = $.trim($('#txtMatricula').val());

        var sugestao = {
            'tipo': tipo,
            'matricula': matricula,
            'sugestao': mensagem.toUpperCase()
        }
        if (JSON.parse(sugestoes.criar(sugestao))) {
            $('#aviso-sugestoes > *').remove();
            $('#aviso-sugestoes')
                .removeClass('alert')
                .removeClass('alert-success')
                .removeClass('alert-danger');

            $('<p>', {
                text: ' Mensagem enviada com sucesso!',
                prepend: $('<i>', {
                    class: 'glyphicon glyphicon-ok'
                })
            }).appendTo('#aviso-sugestoes');

            $('#cbTipoReclamacao').prop('selectedIndex', 5);
            $('#txtMessage').val('');

            $('#aviso-sugestoes').addClass('alert alert-success');
            $('#enviar-sugestao').prop('disabled', true);
            listarSugestoes(sugestoes.listar(parseInt($('.listar-por-sugestoes:checked').val(), 10)));
            $('#txtMessageCaracter').html(0);
            setTimeout(function () {
                $('#aviso-sugestoes > *').remove();
                $('#aviso-sugestoes')
                    .removeClass('alert')
                    .removeClass('alert-success')
                    .removeClass('alert-danger');
            }, 5000);
        } else {
            $('<p>', {
                text: ' Ocorreu um erro, contate o suporte!',
                prepend: $('<i>', {
                    class: 'glyphicon glyphicon-remove'
                })
            }).appendTo('#aviso-sugestoes');
            $('#aviso-sugestoes').addClass('alert alert-danger');
            setTimeout(function () {
                $('#aviso-sugestoes > *').remove();
                $('#aviso-sugestoes')
                    .removeClass('alert')
                    .removeClass('alert-success')
                    .removeClass('alert-danger');
            }, 5000);
        }
    });

    $('#zerar-resposta').click(function (e) {
        e.preventDefault();

        $('#txtResposta').val('');
    })


    
    $('#enviar-resposta').click(function (e) {
        e.preventDefault();
        
        $resposta = $('#txtResposta').val();      

        var sugestoes = new Sugestao();
        var resultado = sugestoes.responder($codigo, $resposta);


        if (resultado == true) { //if (JSON.parse(resultado.callback)) {
          
            // console.log(resultado);
            
            // $("#txtFuncionario").val(''); 
            // $("#txtMatricula").val(''); 
            // $("#txtEmail").val('');
            // $("#txtUsuario").val('');
            
            // $('#txtUsuario').prop('disabled', true); //MM
            // $('#txtEmail').prop('disabled', true); //MM
    
            bootbox.alert({
                size: "small",
                title: "Sucesso",
                message: "<div class='alert alert-success'><i class='fa fa-info' aria-hidden='true'></i> Resposta enviada com sucesso!</div>",
                // callback: function () {
                //     limparStorage();
                //     $(location).attr('href', link);
                // },
                closeButton: false
            });
    
    
        } else {
    
            // console.log(resultado);
    
            // $('#txtUsuario').prop('disabled', true); //MM
    
            // $("#txtFuncionario").val(''); 
            // $("#txtMatricula").val(''); 
            // $("#txtEmail").val('');
            // $("#txtUsuario").val('');
    
            bootbox.alert({
                size: "small",
                title: "Erro",
                message: "<div class='alert alert-danger'><i class='fa fa-info' aria-hidden='true'></i> Ocorreu um problema ao enviar a resposta! </div>",
                // callback: function () {
                //     limparStorage();
                // }
            });   
    
    
        }



    });

    $('#txtResposta').keyup(function(){
        $('#txtRespostaCaracter').html($(this).val().length)
        if($(this).val() && $(this).val().length > 4)
        {
            $('#enviar-resposta').prop('disabled', false);
        }else{
            $('#enviar-resposta').prop('disabled', true);
        }
    });


});