$(function(){

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
    }


  
    var matricula = getCookie('_Matricula_Access');
    var cnpj = getCookie('_CNPJ_Access');
    var cnpjOK = cnpj.replace("%2F", "/");
    var filial = getCookie('_Filial_Access');

    var recebimento = new Recebimento();    
    var vendas = recebimento.buscarRecebimento(filial, matricula, cnpjOK);
    montarRecebimento(vendas);

   



    



    function montarRecebimento(vendas){ //MM

        console.log(vendas);
        // vendas = [{cod: "12945", emissao: "2016-08-01 14:17:00", recebido: ""}];
        $('#listar-recebimento > *').remove();

        
        // // if(typeof $nome !== "undefined"){ //verificar se tem algum nome no input de pesquisa
        // //     var nome = $nome;
        // // }
        // console.log(usuarios);
        
        if (!$.isEmptyObject(vendas)) {
            $('#tableRecebimento').show();

            $.each(vendas, function (index, value) {
    
                // console.log(index);
                // console.log(value);
                // <form method="post" action="recebe" enctype="multipart/form-data" >   
    
            //   $('<form>', {
            //     method: 'POST',
            //     action: 'recebe',
            //     enctype: 'multipart/form-data'
            //     id: 'venda-' + index
            // }).appendTo('#listar-recebimento');


            $('<form>', {
                style: 'display: flex; justify-content:space-around; padding-top: 3px; padding-bottom: 3px;',
                id: 'venda-' + index,
                method: 'POST',
                action: 'recebe',
                enctype: 'multipart/form-data'
            }).appendTo('#listar-recebimento');
                
                $('<div>', {
                  class: 'text-center',
                  append: $('<input>', {
                      type: 'text',
                      name: 'cod',
                      class: 'text-center',
                      value: value.cod,
                      text: value.cod
                  })
                }).appendTo('#venda-' + index);
      
                // $('<td>', {
                //     class: 'text-center',
                //     text: value.emissao,
                // }).appendTo('#venda-' + index);
                
                if(value.recebido == ''){
                  $('<div>', {
                      style: 'width:200px',
                      class: 'text-center',
                      append: $('<i>', {
                        style: 'cursor: pointer; color:red; vertical-align: sub;',
                        class: 'fa fa-lg fa-times'
                      })
                  }).appendTo('#venda-' + index);
                }
                else{                                                  
                  $('<div>', {
                    style: 'width:200px',
                    class: 'text-center',
                    append: $('<i>', {
                      style: 'cursor: pointer; color:green; vertical-align: sub;',
                      class: 'fa fa-lg fa-check'
                    })
                  }).appendTo('#venda-' + index); 
                }

                if(value.recebido == ''){
                  $('<div>', {
                    style: ' width:310px;',
                    class: 'text-center',
                    append: $('<input>', {
                      style: 'cursor: pointer;',
                      type: 'file',
                      text: ' Confirmar Recebimento ',
                      name: 'venda', 
                      change: function(){

                      },
                      click: function (e) {
                          
                      }
                    })   
                  }).appendTo('#venda-' + index);        
                }
                else{
                  $('<div>', {
                    style: 'width:310px;',
                    class: 'text-center',
                    text: "Arquivo Recebido!"
                  }).appendTo('#venda-' + index);
                }

              if(value.recebido == ''){
                $('<div>', {
                  style: 'width:350px;',
                  class: 'text-center',
                  append: $('<input>', {
                    style: 'cursor: pointer;' ,
                    type: 'submit',
                    text: ' Enviar '
                    // change: function(){},
                    // click: function (e) {       
                    // }
                  })
                    
                }).appendTo('#venda-' + index);
              }
              else{
                $('<div>', {
                  class: 'text-center',
                  style: 'width:350px;',
                  text: "Nenhuma Ação Necessária!"
                }).appendTo('#venda-' + index);
              }
                

        })}


    }
    















});



