/**
 * Pseudo-classe responsável por realizar a autenticação do usuário do sistema.
 */
(function () {
    this.Recebimento = function () {
        /**
         * Setup inicial para requisições ajax no Controller de Autenticação
         * REMOVER: Desecorajado pela Documentação jQuery
         */
        // $.ajaxSetup({
        //     dataType: 'JSON',
        //     type: 'POST'
        // });

        /**
         * Usuario : Username de acesso
         * Senha: Senha de acesso
         * Log: JSON/Array contendo informações de erro
         */
        // this.Usuario = "";
        // this.Senha = "";
        // this.Acesso = null;
        // this.Log = [];

        /**
         * Pseudo-método setter para pegar o "Username"
         */
        // this.setUsuario = function (vusuario) {
        //     if (vusuario !== "") {
        //         this.Usuario = vusuario;
        //     } else {
        //         this.Log.push('Usuário');
        //     }
        // }

        // /**
        //  * Pseudo-método setter para pegar a "Senha"
        //  */
        // this.setSenha = function (vsenha) {
        //     if (vsenha !== "") {
        //         this.Senha = vsenha;
        //     } else {
        //         this.Log.push("Senha");
        //     }
        // }

      
        /**
         * Pseudo-método  de autenticação.
         */
        // this.Acessar = function () {
        //     var result = null;

        //     if ($.isEmptyObject(this.Log)) {
        //         $.ajax({
        //             async: false,
        //             type: 'POST',
        //             url: 'autenticacao/logar',
        //             dataType: 'JSON',
        //             data: {
        //                 usuario: this.Usuario,
        //                 senha: this.Senha
        //             },
        //             success: function(data){
        //                 result = data;
        //             },
        //             error: function (data) {
        //                 result = data;
        //             },
        //             statusCode: {
        //                 500: function (xhr) {
        //                     result =  xhr.status
        //                 }
        //             }
        //         })
        //         return result;
        //     } else {
        //         return this.Log;
        //     }
        // }

        Recebimento.prototype.enviarToken = function (filial, matricula, cnpj) {
            var result = null;
            $.ajax({
                async: false,
                type: 'POST',
                url: 'recebimento/recebimento/enviarToken',
                data: {
                    filial: filial,
                    matricula: matricula,
                    cnpj: cnpj
                },
                success: function (data) {
                    // console.log(data);
                    result = data;
                },
                error: function (data) {
                    // console.log(data);
                    result = data;
                }
            });
            return result;
        }

        // Recebimento.prototype.entrarRecebimento = function (token, token_cookie) {
        //     var result = null;
        //     $.ajax({
        //         async: false,
        //         type: 'POST',
        //         url: 'recebimento/recebimento/painel_recebimento',
        //         data: {
        //             token: token,
        //             token_cookie: token_cookie
        //         },
        //         success: function (data) {
        //             // console.log(data);
        //             result = data;
        //         },
        //         error: function (data) {
        //             // console.log(data);
        //             result = data;
        //         }
        //     });
        //     return result;
        // }

        Recebimento.prototype.buscarRecebimento = function (filial, matricula, cnpj) {
            var result = null;
            $.ajax({
                async: false,
                type: 'POST',
                url: 'recebimento/recebimento/buscarRecebimento',
                data: {
                    filial: filial,
                    matricula: matricula,
                    cnpj: cnpj
                },
                success: function (data) {
                    // console.log(data);
                    result = data;
                },
                error: function (data) {
                    // console.log(data);
                    result = data;
                }
            });
            return result;
        }

        Recebimento.prototype.buscarEmpresas = function () {
            var result = null;
            $.ajax({
                url: 'recebimento/recebimento/buscarEmpresas',
                async: false,
                success: function (data) {
                    result = data;
                },
                error: function (data) {
                    result = data;
                }
            });
            // console.log(result);
            return result;
        }

        Recebimento.prototype.buscarSubEmpresas = function (filial) {
            var result = null;
            $.ajax({
                url: 'recebimento/recebimento/buscarSubEmpresas',
                async: false,
                type: 'POST',
                data: {
                    filial: filial
                },
                success: function (data) {
                    result = data;
                },
                error: function (data) {
                    result = data;
                }
            });
            // console.log(result);
            return result;
        }


        // Recebimento.prototype.recebe = function (cod) {  NAO TA USANDO
        //     var result = null;
        //     $.ajax({
        //         url: 'recebimento/recebimento/recebe',
        //         async: false,
        //         type: 'POST',
        //         data: {
        //             cod: cod
        //         },
        //         success: function (data) {
        //             result = data;
        //         },
        //         error: function (data) {
        //             result = data;
        //         }
        //     });
        //     // console.log(result);
        //     return result;
        // }

        
    }
}());