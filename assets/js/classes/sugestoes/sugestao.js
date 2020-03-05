(function () {
    this.Sugestao = function () {
        $.ajaxSetup({
            type: 'POST',
            dataType: 'JSON'
        });

        /**
         * Enviando sugestões
         */
        Sugestao.prototype.criar = function (vsugestao) {
            var resultado = null;
            $.ajax({
                url: 'sugestoes/sugestao/criar',
                async: false,
                data: {
                    sugestao: JSON.stringify(vsugestao)
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    switch (xhr.status) {
                        case 200:
                            resultado = thrownError;
                            break;
                        case 500:
                            resultado = false;
                            break;
                    }
                }
            });
            return resultado;
        }

        /**
         * Listando ocorrencias
         */
        Sugestao.prototype.listar = function (vstatus) {
            var resultado = null;
            $.ajax({
                url: 'sugestoes/sugestao/listar',
                async: false,
                data: {
                    status: vstatus
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


        
        Sugestao.prototype.responder = function (codigo, resposta) {
            var resultado = null;
            $.ajax({
                url: 'sugestoes/sugestao/responder',
                async: false,
                data: {
                    codigo: codigo,
                    resposta: resposta
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