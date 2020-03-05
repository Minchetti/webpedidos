(function () {
    this.Funcionario = function () {
        $.ajaxSetup({
            type: 'POST',
            dataType: 'JSON'
        });
        console.log('VVVVVVVVVVVVVVVVVVVVVVVVVVVVV');

        //Inicializa sessionStorage Funcionarios
        //pseudo - constructor
        Funcionario.prototype.init = function () {
            console.log('KKKKKKKKKKKKKKKKKKKKK222KKKKKKKKKKKKKKKKKK');
            sessionStorage.setItem('funcionarios', JSON.stringify([]));
        }

        Funcionario.prototype.listar = function (funcionario) {
            
            console.log('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
            var funcionarios = null;
            $.ajax({
                url: 'funcionario/funcionario/listar',
                async: false,
                data: {
                    funcionario: funcionario
                },
                success: function (data) {
                    funcionarios = data;
                },
                error: function (data) {
                    console.log(data);
                }
            });

            return funcionarios;
        }


        
        Funcionario.prototype.adicionar = function (funcionario) {
            // console.log('QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQ');
            /**
             * Array temporário
             */
            var temp = [];
            var validacao = false;
            /**
             * Parseando antiga lista
             */
            
            $.each($.parseJSON(sessionStorage.getItem('funcionarios')), function (index, value) {
                temp.push({
                    'matricula': value.matricula,
                    'nome': value.nome,
                    'setor': value.setor,
                    'ghe': value.ghe,
                    'local': value.local,
                    'turno': value.turno,
                    'cliente': value.cliente,
                    'cc': value.cc
                });

                console.log(temp);
            });
            /**
             * Verificando se o cliente já existe no grid
             * Adicionando novo funcionário
             */
            if ($.isEmptyObject(temp) || (temp[0].cliente === funcionario[0].cliente)) {
                $.each(funcionario, function (index, value) {

                    
            console.log('YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY');
                    /**
                     * Realiza a comparação de arrays para não deixar inserir matriculas duplicadas
                     * ou Setores diferentes
                     */
                    var inserir = true;
                    var matricula = value.matricula;
                    var setor = value.setor;
                    /**
                     * Busca do storage para comparar os registros
                     */
                    var comparar = $.parseJSON(sessionStorage.getItem('funcionarios'));
                    if (!$.isEmptyObject(comparar)) {
                        $.each(comparar, function (index, value) {
                            if (value.matricula === matricula)
                                inserir = false;
                            
                            if(value.setor !== setor)
                                inserir = false;
                        })
                    }
                    /**
                     * Verifica se de fato vai haver inserção
                     */
                    if (inserir) {
                        temp.push({
                            'matricula': value.matricula,
                            'nome': value.nome,
                            'setor': value.setor,
                            'ghe': value.ghe,
                            'local': value.local,
                            'turno': value.turno,
                            'cliente': value.cliente,
                            'cc': value.cc
                        });
                    }
                });
                console.log('GGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG');
                sessionStorage.setItem('funcionarios', JSON.stringify(temp));
            } else {
                validacao = true;
            }
            return validacao;
        }

        Funcionario.prototype.listarPorSetor = function (setor, depto) {
            
            console.log('BBBBBBBBBBBBBBBBBBBBBBBBBB');
            console.log('chegou2');
            console.log(setor);
            console.log(depto);
            var funcionarios = null;
            $.ajax({
                url: 'funcionario/funcionario/listarporsetor',
                async: false,
                beforeSend: function () {
                    $('#btn-adicionarSetor')
                        .text(' Carregando')
                        .prepend($('<i>', {
                            class: 'fa fa-hourglass-half',
                            'aria-hidden': true
                        }))
                },
                data: {
                    setor: setor,
                    depto: depto
                },
                success: function (data) {
                    $('#btn-adicionarSetor')
                        .text(' Adicionar')
                        .prepend($('<i>', {
                            class: 'fa fa-plus',
                            'aria-hidden': true
                        }))
                        console.log(data);
                    funcionarios = data;
                },
                error: function (data) {
                    console.log(data);
                }
            })

            console.log('chegou2-1');
            return funcionarios;

        }

        
        Funcionario.prototype.getFuncionarioFromStorage = function () {
            console.log('FFFFFFFFFFFFFFFFFFFFFFFFFFFFFF');
            return $.parseJSON(sessionStorage.getItem('funcionarios'));
        }

        /**
        * Remove um item da lista selecionada
        * Param: id = Matricula funcionário
        */
        Funcionario.prototype.remover = function (id) {
            var colecao = this.getFuncionarioFromStorage();
            funcionarios = $.grep(colecao, function (funcionario) {
                return funcionario.matricula !== id;
            });
            sessionStorage.removeItem('funcionarios');
            this.adicionar(funcionarios);
        }
    }
} ());