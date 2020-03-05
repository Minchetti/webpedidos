(function () {
    this.Template = function () {
        $.ajaxSetup({
            dataType: 'JSON',
            type: 'POST'
        });

        Template.prototype.buscar = function (param) {
            var resultado = null;
            $.ajax({
                url: 'pedido/template/buscar',
                async: false,
                data: {
                    param: JSON.stringify(param)
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



        Template.prototype.funcionariosTemplate = function (template) { //vem pra ca depois de clicar no botao do action //OWOWOWOWOW
            //a variavel template que chega é um numero do template;
            // console.log ("---------- TEMPLATE.JS CLASSES - funcionariosTemplate -------------");
            // console.log(template);

            var resultado = null;

            $.ajax({
                url: 'pedido/template/local_entrega',
                async: false,
                data: {
                    template: template
                },
                success: function (data) {
                    // console.log ('SUCESSO');
                    // console.log(data);
                    resultado = data;
                },
                error: function (data) {
                    
                    // console.log ('ERROR FT');
                    resultado = data;
                    
                    // console.log (resultado);
                    // console.log(data);
                }
            });
            // console.log(resultado); //chega o valor certo na variavel template porem o retorno da função ta vazio 
            return resultado;
        }
        



























        Template.prototype.utilizarTemplate = function (template, funcionarios, observacao, cc) {
            
            // console.log ("---------- TEMPLATE.JS CLASSES utilizarTemplate -------------");
            // console.log (template);
            // console.log (funcionarios);
            // console.log (observacao);
            // console.log (cc);
console.log(this.produtos);
console.log(sessionStorage);

            var resultado = null;
            if (!$.isEmptyObject(funcionarios)) {
                $.ajax({
                    url: 'pedido/template/utilizar',
                    async: false,
                    data: {
                        // produtos: 'hahahah', //testando
                        template: template,
                        funcionarios: JSON.stringify(funcionarios),
                        observacao: observacao,
                        cc: cc
                    },
                    success: function (data) {
                        console.log ('SUCESSO');
                        console.log (data);
                        resultado = data;
                    },
                    error: function (error) {
                        console.log ('ERROR U');
                        console.log (error);
                        resultado = error;
                    }
                });
                // console.log(resultado);
                return resultado;
            } else {
                return false;
            }
        }





        Template.prototype.detalhes = function (template) {
            var resultado = null;
            $.ajax({
                url: document.location.protocol+'//'+document.location.hostname+'/webpedidos/pedido/template/detalhes',
                async: false,
                data: {
                    template: template
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













        

        Template.prototype.criar = function (template, nome, observacao) {
            var resultado = false;
            $.ajax({
                url: 'pedido/template/criar',
                async: false,
                data: {
                    funcionarios: template,
                    nome: nome,
                    observacao: observacao
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (error) {
                    resultado = false;
                }
            })
            return resultado;
        }


        Template.prototype.deletar = function (template) {
            var resultado = null;
            $.ajax({
                url: 'pedido/template/deletar',
                async: false,
                data: {
                    template: template
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

        Template.prototype.alterar = function (template, dados) {
            var resultado = null;
            $.ajax({
                url: 'pedido/template/alterar',
                async: false,
                data: {
                    template: template,
                    dados: JSON.stringify(dados)
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


    };

} ());