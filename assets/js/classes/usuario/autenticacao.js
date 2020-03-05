/**
 * Pseudo-classe responsável por realizar a autenticação do usuário do sistema.
 */
(function () {
    this.Autenticacao = function () {
        /**
         * Setup inicial para requisições ajax no Controller de Autenticação
         * REMOVER: Desecorajado pela Documentação jQuery
         */
        $.ajaxSetup({
            url: 'autenticacao/logar',
            type: 'POST',
            dataType: 'JSON'
        });

        /**
         * Usuario : Username de acesso
         * Senha: Senha de acesso
         * Log: JSON/Array contendo informações de erro
         */
        this.Usuario = "";
        this.Senha = "";
        this.Acesso = null;
        this.Log = [];

        /**
         * Pseudo-método setter para pegar o "Username"
         */
        this.setUsuario = function (vusuario) {
            if (vusuario !== "") {
                this.Usuario = vusuario;
            } else {
                this.Log.push('Usuário');
            }
        }

        /**
         * Pseudo-método setter para pegar a "Senha"
         */
        this.setSenha = function (vsenha) {
            if (vsenha !== "") {
                this.Senha = vsenha;
            } else {
                this.Log.push("Senha");
            }
        }

        /**
         * Quem faz a atualização do usuário é o pseud-método que está dentro da pseudo-classe Usuario. 
         * A autenticação não sabe como é feita, mas ela retorna o resultado da pseudo-classe Usuário
         */
        this.NovaSenha = function (login, dados) {

            var usuario = new Usuario();
            var resultado = usuario.atualizar(login, dados);
            return resultado;

        }

      

        /**
         * Pseudo-método  de autenticação.
         */
        this.Acessar = function () {
            var result = null;

            if ($.isEmptyObject(this.Log)) {
                $.ajax({
                    async: false,
                    type: 'POST',
                    url: 'autenticacao/logar',
                    dataType: 'JSON',
                    data: {
                        usuario: this.Usuario,
                        senha: this.Senha
                    },
                    success: function(data){
                        result = data;
                    },
                    error: function (data) {
                        result = data;
                    },
                    statusCode: {
                        500: function (xhr) {
                            result =  xhr.status
                        }
                    }
                })
                return result;
            } else {
                return this.Log;
            }
        }

        this.EsqueciSenha = function (vemail) {
            var result = null;
            if ($.isEmptyObject(this.Log)) {
                $.ajax({
                    async: false,
                    url: 'autenticacao/recuperarsenha',
                    data: {
                        usuario: this.Usuario,
                        email: vemail
                    },
                    success: function (data) {
                        result = data;
                    },
                    error: function (data) {
                        result = data;
                    }
                });
                return result;
            } else {
                return this.Log;
            }
        }
    }
}());