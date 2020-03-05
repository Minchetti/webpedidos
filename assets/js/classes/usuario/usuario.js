(function () {
    this.Usuario = function () {
        $.ajaxSetup({
            url: 'usuario/usuario/atualizar',
            type: 'POST',
            dataType: 'JSON'
        });

        this.UsuarioSistema = "";
        this.Email = "";
        this.RelComparacao = false;
        this.RelAprovados = false;
        this.RelConsumo = false;
        this.Log = [];



        // Usuario.prototype.criar = function (Matricula, Usuario, Email) { //MM
        //     // console.log("CHEGOU");
        //     var resultado = false;
        //     $.ajax({
        //         url: 'usuario/usuario/novo',
        //         async: false,
        //         data: {
        //             funcionarios: Matricula,
        //             nome: Usuario,
        //             observacao: Email
        //         },
        //         success: function (data) {
        //             resultado = data;
        //         },
        //         error: function (error) {
        //             resultado = false;
        //         }
        //     })
        //     return resultado;
        // }


        Usuario.prototype.setUsuario = function (vusuario) {
            if (vusuario !== "") {
                this.UsuarioSistema = vusuario;
            } else {
                this.Log.push('Usuário vazio');
            }
        }

        Usuario.prototype.setEmail = function (vemail) {
            if (vemail !== "") {
                this.Email = vemail;
            } else {
                this.Log.push("Email vazio");
            }
        }

        Usuario.prototype.setRelComparacao = function (vrelcomparacao) {
            this.RelComparacao = vrelcomparacao;
        }

        Usuario.prototype.setRelAprovados = function (vrelaprovados) {
            this.RelAprovados = vrelaprovados;
        }

        Usuario.prototype.setRelConsumo = function (vrelconsumo) {
            this.RelConsumo = vrelconsumo;
        }

        Usuario.prototype.verificarUsuario = function (vusuario) {
            // Implementar a verificação usando ajax.
            // Setup deve usar ASYNC false, para poder pegar o callback em outro escopo.


            // $.ajax({
            //     async: false,
            //     url: document.location.origin + '/webpedidos/usuario/usuario/atualizar',
            //     type: 'POST',
            //     dataType: 'JSON',
            //     data: {
            //         senha: vsenha
            //     },
            //     success: function (data) {
            //         resultado = data;
            //     },
            //     error: function (data) {
            //         resultado = data;
            //     }
            // });
            return false;
        }

        Usuario.prototype.atualizar = function (login, vsenha) { // era 1 parametro antes apenas (vsenha)
            var resultado = null;
            $.ajax({
                async: false,
                url: document.location.origin + '/webpedidos/usuario/usuario/atualizar',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    login: login,
                    senha: vsenha.senha
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

        Usuario.prototype.cadastrar = function (vmatricula) {
            if ($.isEmptyObject(this.Log)) {
                return true;
            } else {
                return this.Log;
            }
        }


        
        Usuario.prototype.buscar = function (param) {
            var resultado = null;
            $.ajax({
                url: 'usuario/usuario/buscar',
                async: false,
                data: {
                    id: param
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

        
        Usuario.prototype.editar = function ($id, novoNivel, novoLogin) {
            var resultado = null;
            $.ajax({
                url: 'usuario/usuario/editar',
                async: false,
                data: {
                    id: $id,
                    novoNivel: novoNivel,
                    novoLogin: novoLogin
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (error) {
                    resultado = error;
                }
            });

            return resultado;
        }


        Usuario.prototype.excluir = function (id) {
            var resultado = null;
            $.ajax({
                url: 'usuario/usuario/excluir',
                async: false,
                data: {
                    id: id,
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (error) {
                    resultado = error;
                }
            });

            return resultado;
        }



    }
} ());