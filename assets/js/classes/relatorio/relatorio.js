$(function () {
    this.Relatorio = function () {
        $.ajaxSetup({
            dataType: 'JSON',
            type: 'POST'
        });


        Relatorio.prototype.gerarConsumo = function (num_inicial, num_final, data_inicial, data_final, matricula, nome, turno, status_apr, status_req) {
            var resultado = null;
            $.ajax({
                async: false,
                url: 'relatorio/relatorio/gerarConsumo',
                data: {
                    num_inicial: num_inicial,
                    num_final: num_final,
                    data_inicial: data_inicial,
                    data_final: data_final,
                    matricula: matricula,
                    nome: nome,
                    turno: turno,
                    status_apr: status_apr,
                    status_req: status_req
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





        

    }
});