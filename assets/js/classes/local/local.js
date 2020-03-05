(function () {
    // console.log('AQUI RESULTADO 22222 LOCAL.js')

    this.Local = function () {
        $.ajaxSetup({
            dataType: 'JSON',
            type: 'POST'
        });

        Local.prototype.listarEntrega = function (setor) { //MM
            // Local.prototype.listarEntrega = function (id) {
            var resultado = null;
            $.ajax({
                url: 'local/local/listar_entrega',
                async: false,
                data: {
                    setor: setor
                    // id: id
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (data) {
                    resultado = data
                }
            })
            // console.log('AQUI RESULTADO LOCAL.js')
            // console.log(resultado);
            return resultado;
        }
        
        Local.prototype.listarEntregaExterna = function () {
            var resultado = null;
            $.ajax({
                url: 'local/local/listar_entregaExterna',
                async: false,
                data: {
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (data) {
                    resultado = data
                }
            })
            return resultado;
        }


        Local.prototype.cadastrarEntrega = function (local) {
            console.log(local);
            var resultado = null;
            $.ajax({
                url: 'local/local/cadastrar_entrega',
                async: false,
                data: {
                    cep: local.cep,
                    numero: local.numero,
                    rua: local.rua,
                    bairro: local.bairro,
                    cidade: local.cidade,
                    estado: local.estado
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (data) {
                    resultado = data
                }
            })
            return resultado;
        }


        Local.prototype.verificarEntrega = function (cep, numero) {
            var resultado = null;
            $.ajax({
                url: 'local/local/verificar_entrega',
                async: false,
                data: {
                    cep: cep,
                    numero: numero
                },
                success: function (data) {
                    resultado = data;
                },
                error: function (data) {
                    resultado = data
                }
            })
            return resultado;
        }

        

    }

} ());