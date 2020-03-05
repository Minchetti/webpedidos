(function () {
    this.GrupoAcesso = function () {
        $.ajaxSetup({
            dataType: 'JSON',
            type: 'POST'
        });

        this.UsuarioSistema = "";
        this.Email = "";
        this.RelComparacao = false;
        this.RelAprovados = false;
        this.RelConsumo = false;
        this.Log = [];



        GrupoAcesso.prototype.criar = function (Nome, Aprova_pedido, Cria_template, Cria_requisicao, Cria_usuario, Cria_grupoacesso, Cria_aviso, Responde_sugestao, Relatorio_consumo, Relatorio_aprovacao) { //MM
            // console.log("CHEGOU");
            var resultado = false;
            $.ajax({
                url: 'grupoacesso/grupoacesso/novo',
                async: false,
                data: {
                    nome: Nome,
                    aprova_pedido: Aprova_pedido,
                    cria_template: Cria_template,
                    cria_requisicao: Cria_requisicao,
                    cria_usuario: Cria_usuario,
                    cria_grupoacesso: Cria_grupoacesso,
                    cria_aviso: Cria_aviso,
                    responde_sugestao: Responde_sugestao,
                    relatorio_consumo: Relatorio_consumo,
                    relatorio_aprovacao: Relatorio_aprovacao
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (error) {
                    resultado = error;
                }
            })
            return resultado;
        }



        GrupoAcesso.prototype.setUsuario = function (vusuario) {
            if (vusuario !== "") {
                this.UsuarioSistema = vusuario;
            } else {
                this.Log.push('Usuário vazio');
            }
        }

        GrupoAcesso.prototype.setEmail = function (vemail) {
            if (vemail !== "") {
                this.Email = vemail;
            } else {
                this.Log.push("Email vazio");
            }
        }

        GrupoAcesso.prototype.setRelComparacao = function (vrelcomparacao) {
            this.RelComparacao = vrelcomparacao;
        }

        GrupoAcesso.prototype.setRelAprovados = function (vrelaprovados) {
            this.RelAprovados = vrelaprovados;
        }

        GrupoAcesso.prototype.setRelConsumo = function (vrelconsumo) {
            this.RelConsumo = vrelconsumo;
        }

        GrupoAcesso.prototype.verificarUsuario = function (vusuario) {
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

        GrupoAcesso.prototype.atualizar = function (vsenha) {
            var resultado = null;
            $.ajax({
                async: false,
                url: document.location.origin + '/webpedidos/usuario/usuario/atualizar',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    senha: vsenha
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

        GrupoAcesso.prototype.cadastrar = function (vmatricula) {
            if ($.isEmptyObject(this.Log)) {
                return true;
            } else {
                return this.Log;
            }
        }


        
        GrupoAcesso.prototype.listar = function () {
            var resultado = null;
            $.ajax({
                url: 'grupoacesso/grupoacesso/buscar',
                async: false,
                success: function (data) {
                    resultado = data;
                },
                error: function (data) {
                    resultado = data;
                }
            });

            return resultado;
        }

        
        GrupoAcesso.prototype.editar = function (nome, novoNome, novoRel_aprovacao, novoRel_consumo, novoAprova_pedido, novoCria_template, novoCria_requisicao, novoCria_usuario, novoCria_grupoacesso, novoCria_aviso, novoResponde_sugestao) {
            var resultado = null;
            $.ajax({
                url: 'grupoacesso/grupoacesso/editar',
                async: false,
                data: {
                    nome: nome,
                    novoNome: novoNome,
                    novoRel_aprovacao: novoRel_aprovacao,
                    novoRel_consumo: novoRel_consumo,
                    novoAprova_pedido: novoAprova_pedido,
                    novoCria_template: novoCria_template,
                    novoCria_requisicao: novoCria_requisicao,
                    novoCria_usuario: novoCria_usuario,
                    novoCria_grupoacesso: novoCria_grupoacesso,
                    novoCria_aviso: novoCria_aviso,
                    novoResponde_sugestao: novoResponde_sugestao
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (error) {
                    resultado = false;
                }
            });
            return resultado;
        }



        GrupoAcesso.prototype.excluir = function (nome) {
            var resultado = null;
            $.ajax({
                url: 'grupoacesso/grupoacesso/excluir',
                async: false,
                data: {
                    nome: nome,
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