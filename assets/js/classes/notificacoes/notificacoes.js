(function () {

    this.Notificacao = function () {
        $.ajaxSetup({
            dataType: 'JSON',
            type: 'POST'
        });

        Notificacao.prototype.listarManutencao = function () {
            var resultado = '';
            $.ajax({
                url: 'notificacao/notificacao/listar_manutencao',
                async: false,
                success: function (data) {
                    resultado = data;
                },
                error: function (error) {
                    resultado = error;
                }
            });
            return resultado;
        }




        Notificacao.prototype.enviarAviso = function (msg) {
            
            var resultado = '';
            $.ajax({
                url: 'notificacao/notificacao/enviar_msg',
                async: false,
                data: {
                    mensagem: msg
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