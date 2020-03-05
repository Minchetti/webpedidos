<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisicao extends CI_Controller {

	public function index()
	{
                // echo "---> SESSION ";
                // echo '<pre>';
                // print_r($this->session);
                
                if( ! $this->session->has_userdata('logado'))
                        redirect(base_url('webpedidos/'));

                $data['title'] = 'Requisição';
                $data['relatorios'] = array(
                        filter_var($this->session->has_userdata('relatorio_consumo'), FILTER_VALIDATE_BOOLEAN),
                        filter_var($this->session->has_userdata('relatorio_pedidos'), FILTER_VALIDATE_BOOLEAN),
                        filter_var($this->session->has_userdata('relatorio_comparacao'), FILTER_VALIDATE_BOOLEAN)
                );
                $data['usuario'] = $this->session->usuario_nome;
                $data['today'] = date('d/m/Y');
                $data['script'] = array(
                        '<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>',
                        '<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.0/jspdf.plugin.autotable.js"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/classes/local/local.js').'"></script>', /*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/actions/usuario/setor.js').'"></script>',  /*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/classes/usuario/funcionario.js').'"></script>', //tirei o min
                        '<script src="'.base_url('webpedidos/assets/js/actions/usuario/funcionario.js').'"></script>', //tirei o min
                        '<script src="'.base_url('webpedidos/assets/js/classes/produtos/produtos.js').'"></script>', /*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/actions/produtos/produtos.js').'"></script>', /*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/classes/pedidos/template.js').'"></script>',/*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/actions/pedidos/template.js').'"></script>',/*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/classes/pedidos/requisicao.js').'"></script>',/*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/actions/pedidos/requisicao.js').'"></script>',/*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>'
                );
                $data['css'] = array(
                        '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
                );
                $this->load->view('templates/header', $data);
                $this->load->view('pedidos/requisicao');
                $this->load->view('templates/footer');
	}






        /**
         * Gera nova requisição ou solicitação
         */
        public function Nova(){ //TRAMPO
                if( ! $this->session->has_userdata('logado'))
                        redirect(base_url('webpedidos/'));

                $pedido = array();
                $produto = array();
                $entrega = array();
                $aprovar = FALSE;
                $aprovador = NULL;
                $departamento_aprovador = NULL;
                $reserva = NULL;
                $data_aprovacao = NULL;
                $data_fechado = NULL;
                $resumo_pedido = array();
                $resumo_produto = array();
                $resumo_entrega = array();
                
                $this->load->model('pedido/requisicao_model', 'requisicao');

                $produtos = json_decode($this->input->post('produtos'), TRUE);
                $funcionarios = json_decode($this->input->post('funcionarios'), TRUE);
                $emissao = trim($this->input->post('emissao'));
                $observacao = trim(strtoupper(utf8_decode($this->input->post('observacao'))));
                $localEntregaExterno = $this->input->post('localEntregaExterno');
echo("<pre>");
print_r(implode(", ", $localEntregaExterno));

                $this->load->model('funcionario/funcionario_model', 'funcionario');
                // echo "---> KEY ";
                // echo "<pre>";
                // print_r($this->session->key_funcionarios);

                $departamento = $this->funcionario->listarMatricula($this->session->key_funcionarios); //$this->session->key_funcionarios

                // echo "---> Departamento ";
                // echo "<pre>";
                // print_r($departamento);

                if(filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)){
                        $aprovador = (string) $this->session->key_funcionarios;
                        $data_aprovacao = date('Y-m-d H:i:s');
                        if (isset ($departamento[0]->cliente)){
                                $departamento_aprovador = (string) $departamento[0]->cliente; 
                        }
                        $aprovar = TRUE;
                }

                foreach($funcionarios AS $key => $funcionario) :

                        $reserva = (filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)) ? $this->requisicao->getPedido() : $this->requisicao->getReserva();

                        $turno = 0;
                        //Aloca os respectivos inteiros para os turnos vindos via post
                        switch($funcionario['turno']) :
                                case 'PRIMEIRO':
                                        $turno = 1;
                                break;
                                case 'SEGUNDO' :
                                        $turno = 2;
                                break;
                                case 'TERCEIRO' :
                                        $turno = 3;
                                break;
                                case 'ADMINISTRATIVO' :
                                        $turno = 4;
                                break;
                         endswitch;

                        if(filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)){
                                /**
                                 * Efetivação de pedidos
                                 */

                         
                                // $cliente_solicitante; $funcionario_solicitante; $cliente_aprovador; $funcionario_aprovador;

                                // echo "<pre>";
                                // print_r($departamento->cliente);
                                // exit();

                                // if((string) $departamento[0]->cliente == NULL):
                                //         $cliente_solicitante = $funcionario['key_clientes'];
                                // else:
                                //         $cliente_solicitante = (string) $departamento[0]->cliente;
                                // endif;
                                                                
                                // if((string) $this->session->key_funcionarios == NULL):
                                //         $funcionario_solicitante = $funcionario['matricula'];
                                // else:
                                //         $funcionario_solicitante = (string) $this->session->key_funcionarios;
                                // endif;

                                // if($departamento_aprovador == NULL):
                                //         $cliente_aprovador = $funcionario['key_clientes'];
                                // else:
                                //         $cliente_aprovador = $departamento_aprovador;
                                // endif;

                                // if($aprovador == NULL):
                                //         $funcionario_aprovador = $funcionario['matricula'];
                                // else:
                                //         $funcionario_aprovador = $aprovador;
                                // endif;
                                //   echo 'LOCAL';
                                //   echo '<pre>';
                                // print_r($funcionario['local']);
                                
                                // if(is_array($funcionario['local'])){
                                //         $local = $funcionario['local'];
                                // }else{
                                //         $local = utf8_decode($funcionario['local']);
                                // }

                                $pedido[] = array( /*AQUI NA HORA D CRIAR NOVA REQ E CLICA NO BOTAO APROVAR - teste1*/
                                        'numero' => $reserva[0]->numero,
                                        'key_clientes' => $funcionario['cliente'],
                                        'data_emissao' => $emissao,
                                        'id_depto' => $funcionario['cliente'],
                                        'id_centro_custo' => $funcionario['cc'],
                                        'key_funcionarios' => $funcionario['matricula'],
                                        'key_clientes_solicitante' => $departamento[0]->cliente,                 /*aqui */
                                        'key_funcionarios_solicitante' => $this->session->key_funcionarios,          /*aqui *******/
                                        'key_clientes_aprovador' => $departamento_aprovador,                     /*aqui */
                                        'key_funcionarios_aprovador' => $this->session->key_funcionarios,                /*aqui *******/
                                        'obs' => $observacao,
                                        'dh_aprovacao' => $data_aprovacao,
                                        'data_fechado' => $data_fechado,
                                        'aprovar' => strtoupper($aprovar),
                                        'entrega_turno' => $turno,
                                        'entrega_local' => $local,
                                        'entrega_externo' => implode(", ", $localEntregaExterno)
                                );
                                
                                // echo "---> Pedido ";
                                // echo '<pre>';
                                // print_r($pedido);
                                // echo ("daisjdiajsdasd");
                                // echo $this->session->key_funcionarios;


                                // Array ( 
                                //         [0] => Array (  [numero] => 49519 
                                //                         [key_clientes] => 44.013.159/0031-31 
                                //                         [data_emissao] => 2018-08-31 
                                //                         [id_depto] => 44.013.159/0031-31 
                                //                         [id_centro_custo] => 75008280 
                                //                         [key_funcionarios] => 33021887 
                                //                         [key_clientes_solicitante] => 
                                //                         [key_funcionarios_solicitante] => 0 
                                //                         [key_clientes_aprovador] => 
                                //                         [key_funcionarios_aprovador] => 0 
                                //                         [obs] => [dh_aprovacao] => 2018-08-31 15:43:35 
                                //                         [data_fechado] => [aprovar] => 1 
                                //                         [entrega_turno] => 1 
                                //                         [entrega_local] => )
                                // )



                                // {
                                //         "callback":true,
                                //         "resumo":[
                                //                 {"pedido":
                                //                         {"matricula":"33021887",
                                //                         "nome":"ABAETE DE BARROS CORREIA FILHO",
                                //                         "pedido":"0000049525",
                                //                         "produto":[
                                //                                 {"codigo_produto":"001818",
                                //                                 "descricao":"ABAFADOR AUDT H10B HASTE NUCA PELTOR",
                                //                                 "quantidade":"1",
                                //                                 "partnumber":"9001818"}],
                                //                         "turno":"PRIMEIRO","entrega":""},
                                //                 "data_emissao":"31\/08\/2018",
                                //                 "obs":""}
                                //         ]
                                // }



                                foreach($produtos AS $key => $item) :
                                        $produto[] = array(
                                                'key_pedidos' => $reserva[0]->numero,
                                                'key_clientes' => $funcionario['cliente'],
                                                'key_produtos' => $item['item']['codigo'],
                                                'key_partnumber' => $item['item']['partnumber'],
                                                'quantidade' => $item['item']['quantidade'],
                                                'valor' => $item['item']['valor'],
                                                'numero_item' => ($key + 1)
                                        );
                                        //Apenas para resumo
                                        $resumo_produto [] = array(
                                                'codigo_produto' => $item['item']['codigo'],
                                                'descricao' => $item['item']['descricao'], 
                                                'quantidade' => $item['item']['quantidade'],
                                                'partnumber' => $item['item']['partnumber']
                                        );
                                endforeach;
                        }else{
                                /**
                                 * Solicitação de pedidos
                                 */
                                $pedido[] = array(
                                        'solicitacaoid' => $reserva[0]->numero,
                                        'key_clientes' => $funcionario['cliente'],
                                        'data_emissao' => $emissao,
                                        'id_depto' => $funcionario['cliente'],
                                        'id_centro_custo' => $funcionario['cc'],
                                        'key_funcionarios' => $funcionario['matricula'],
                                        'key_clientes_solicitante' => (string) $departamento[0]->cliente,
                                        'key_funcionarios_solicitante' => (string) $this->session->key_funcionarios,
                                        'key_clientes_aprovador' => $departamento_aprovador,
                                        'key_funcionarios_aprovador' => $aprovador,
                                        'obs' => $observacao,
                                        'dh_aprovacao' => $data_aprovacao,
                                        'data_fechado' => $data_fechado,
                                        'entrega_turno' => $turno,
                                        'entrega_local' => utf8_decode($funcionario['local']),                                        
                                        'entrega_externo' => implode(", ", $localEntregaExterno)
                                );

                                
                                // echo "---> Pedido2 ";
                                // echo '<pre>';
                                // print_r($pedido);

                                

                                foreach($produtos AS $key => $item) :
                                        $produto[] = array(
                                                'fk_solicitacaoid' => $reserva[0]->numero,
                                                'key_produtos' => $item['item']['codigo'],
                                                'key_partnumber' => $item['item']['partnumber'],
                                                'quantidade' => $item['item']['quantidade'],
                                                'numero_item' => ($key + 1)
                                        );
                                        //Apenas para resumo
                                        $resumo_produto [] = array(
                                                'codigo_produto' => $item['item']['codigo'],
                                                'descricao' => $item['item']['descricao'], 
                                                'quantidade' => $item['item']['quantidade'],
                                                'partnumber' => $item['item']['partnumber']
                                        );
                                endforeach;
                        }

                        //Resumo do pedido por matricula
                        $resumo_pedido[] = array(
                                        'pedido' => array(
                                        'matricula' => $funcionario['matricula'],
                                        'nome' => $funcionario['nome'],
                                        'pedido' => str_pad($reserva[0]->numero, 10, '0',STR_PAD_LEFT),
                                        'produto' => $resumo_produto,
                                        'turno' => strtoupper($funcionario['turno']),
                                        'entrega' => $funcionario['local'],                                        
                                        'entrega_externo' => implode(", ", $localEntregaExterno)
                                ),
                                'data_emissao' => date('d/m/Y', strtotime($emissao)),
                                'obs' => utf8_encode($observacao)
                        );
                endforeach;

                
                $resultado = array(
                        'callback' => (filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)) ? $this->requisicao->pedido($pedido, $produto) : $this->requisicao->solicitacao($pedido, $produto),
                        'resumo' => $resumo_pedido
                );

                
        // echo '<pre>resultado -------> ';
        // print_r($resultado);
                $this->output->set_content_type('application/json')
		             ->set_output(json_encode($resultado));
        }




        
        /**
         *  Carrega a View localizar pedido
         */
        public function localizar(){
                if( ! $this->session->has_userdata('logado'))
                        redirect(base_url('webpedidos/'));

                $data['title'] = 'Localizar';
                $data['usuario'] = $this->session->usuario_nome;
                $data['relatorios'] = array(
                        filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
                        filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
                        filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
                );
                $data['script'] = array(
                        '<script src="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/classes/produtos/produtos.min.js').'"></script>', /*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/classes/pedidos/requisicao.min.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/actions/pedidos/localizar.min.js').'"></script>'
                        
                );
                $data['css'] = array(
                        '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
                );
                $this->load->view('templates/header', $data);
                $this->load->view('pedidos/localizar');
                $this->load->view('templates/footer');
        }

        /**
         *  Carrega o model pedido
         */
        public function Procurar(){
                $busca = array();
                $lista_pedidos = array();

                if( ! $this->session->has_userdata('logado'))
                        redirect(base_url('webpedidos/'));
                
                $criteria = json_decode($this->input->post('criteria'), TRUE);
                // print_r($criteria);

                if( ! empty($criteria['num-final'])){
                        $busca['CAST(numero AS INTEGER) >='] = $criteria['num-inicial'];
                        $busca['CAST(numero AS INTEGER) <='] = $criteria['num-final'];
                }else if( ! empty($criteria['num-inicial'])){
                        $busca['numero'] = $criteria['num-inicial'];
                }

                if( ! empty($criteria['data-final'])){
                        $busca['data_emissao >='] = $criteria['data-inicial'];
                        $busca['data_emissao <='] = $criteria['data-final'];
                }else if( ! empty($criteria['data-inicial'])){
                        $busca['data_emissao'] = $criteria['data-inicial'];
                }

                if(filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)){
                        if( ( ! empty($criteria['matricula'])) && ( ! empty($criteria['nome']) )){
                                $busca['key_funcionarios'] = $criteria['matricula'];
                        }
                }

                if($criteria['requisicao']  !== 'Todos'){
                        $busca['pe.status'] = $criteria['requisicao'];
                }

                if((int)$criteria['turno'] !== 0){
                        $busca['pe.entrega_turno'] = (int) $criteria['turno'];
                }
                /**
                 * Limitando a visualização do pedido somente ao solicitante
                 */
                $busca['pe.key_funcionarios_solicitante'] = (string) $this->session->key_funcionarios;
                $this->load->model('pedido/requisicao_model', 'requisicao');
                $pedidos = $this->requisicao->localizar($busca, (int) $this->input->post('pagina'));
                foreach($pedidos[0] AS $pedido):
                        //Aloca os respectivos inteiros para os turnos vindos via post
                        switch( (int) $pedido->turno ) :
                                case 1:
                                        $turno = '1º TURNO';
                                break;
                                case 2 :
                                        $turno = '2º TURNO';
                                break;
                                case 3 :
                                        $turno = '3º TURNO';
                                break;
                                case 4 :
                                        $turno = 'ADMINISTRATIVO';
                                break;
                                default :
                                        $turno = 'NÃO DEFINIDO';
                         endswitch;
                         //Apenas 3 status são permitidos Aberto/Carrinho/Fechado
                         switch((string) strtoupper($pedido->status)):
                                case 'FECHADO':
                                        $status = 'FECHADO';
                                break;
                                case 'CARRINHO' : 
                                        $status = 'CARRINHO';
                                break;
                                default :
                                        $status = 'ABERTO';
                         endswitch;
                        $lista_pedidos[] = array(
                                'numero' => $pedido->numero,
                                'funcionario' => utf8_encode($pedido->nome),
                                'emissao' => utf8_encode(date('d/m/Y', strtotime($pedido->data_emissao))),
                                'status_pedido' => $status,
                                'observacao' => utf8_encode(strtoupper($pedido->obs)),
                                'local_entrega' => utf8_encode($pedido->entrega),
                                'turno' => $turno,
                                'solicitante' => utf8_encode($pedido->solicitante),
                                'aprovador' => utf8_encode($pedido->aprovador),
                                'cc' => utf8_encode($pedido->cc),
                                'setor' => utf8_encode($pedido->setor)
                        );
                        // echo ('<pre>');
                        // print_r($lista_pedidos);
                endforeach;
                $this->output
                        ->set_content_type('application/json')
		        ->set_output(json_encode(
                                array(
                                        'pedidos' => $lista_pedidos,
                                        'retornado' => $pedidos[1],
                                        'total' => $this->requisicao->total($busca)
                                )
                        ));
        }

        //Carrega view de aprovar
        public function listarPendentes(){
                if( ! $this->session->has_userdata('logado'))
                        redirect(base_url('webpedidos/'));

                $data['title'] = 'Aprovar requisições';
                $data['usuario'] = $this->session->usuario_nome;
                $data['relatorios'] = array(
                        filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
                        filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
                        filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
                );
                $data['script'] = array(
                        '<script src="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/classes/produtos/produtos.js').'"></script>', /*TIREI .min*/ 
                        '<script src="'.base_url('webpedidos/assets/js/classes/pedidos/requisicao.min.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/actions/pedidos/requisicao.min.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/actions/pedidos/localizar.min.js').'"></script>'
                );
                $data['css'] = array(
                        '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
                );
                $this->load->view('templates/header', $data);
                $this->load->view('pedidos/aprovar');
                $this->load->view('templates/footer');
        }

        //Lista todas as solicitações pendentes
        public function listarSolicitacoes(){
                $busca = array();
                $lista_pedidos = array();

                if( ! $this->session->has_userdata('logado'))
                        redirect(base_url('webpedidos/'));
                
                $criteria = json_decode($this->input->post('criteria'), TRUE);

                if( ! empty($criteria['num-final'])){
                        $busca['ps.solicitacaoid >='] = (string) $criteria['num-inicial'];
                        $busca['ps.solicitacaoid <='] = (string) $criteria['num-final'];
                }else if( ! empty($criteria['num-inicial'])){
                        $busca['ps.solicitacaoid'] = (string) $criteria['num-inicial'];
                }

                if( ! empty($criteria['data-final'])){
                        $busca['ps.data_emissao >='] = $criteria['data-inicial'];
                        $busca['ps.data_emissao <='] = $criteria['data-final'];
                }else if( ! empty($criteria['data-inicial'])){
                        $busca['ps.data_emissao'] = $criteria['data-inicial'];
                }

                if(filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)){
                        if( ( ! empty($criteria['matricula'])) && ( ! empty($criteria['nome']) )){
                                $busca['fs.matricula'] = $criteria['matricula'];
                        }
                }

                if((int)$criteria['turno'] !== 0){
                        $busca['ps.entrega_turno'] = (int) $criteria['turno'];
                }

                if(ucfirst($criteria['requisicao']) !== 'TODOS'){
                        $busca['ps.naoaprovado'] = (utf8_encode(ucfirst($criteria['requisicao'])) === 'AGUARDANDO') ? FALSE : TRUE;
                }

                if((int)$criteria['aprovacao'] !== -1){
                        switch((int) $criteria['aprovacao']):
                                case 0 :
                                        $busca['ps.naoaprovado'] = TRUE;
                                break;
                                case 1: 
                                        $busca['ps.naoaprovado'] = FALSE;
                                break;
                        endswitch;
                }

                $this->load->model('pedido/requisicao_model', 'solicitacao');
                $pedidos = $this->solicitacao->solicitacoesPendentes($busca, (int) $this->input->post('pagina'));
                foreach($pedidos[0] AS $pedido):
                         //Aloca os respectivos inteiros para os turnos vindos via post
                        switch( (int) $pedido->turno ) :
                                case 1:
                                        $turno = '1º TURNO';
                                break;
                                case 2 :
                                        $turno = '2º TURNO';
                                break;
                                case 3 :
                                        $turno = '3º TURNO';
                                break;
                                case 4 :
                                        $turno = 'ADMINISTRATIVO';
                                break;
                                default :
                                        $turno = 'NÃO DEFINIDO';
                         endswitch;

                        $lista_pedidos[] = array(
                                'numero' => str_pad($pedido->numero, 10, '0', STR_PAD_LEFT),
                                'funcionario' => utf8_encode($pedido->nome),
                                'emissao' => utf8_encode(date('d/m/Y', strtotime($pedido->data_emissao))),
                                'observacao' => utf8_encode(strtoupper($pedido->obs)),
                                'aprovacao' => filter_var($pedido->naoaprovado, FILTER_VALIDATE_BOOLEAN),
                                'local_entrega' => utf8_encode($pedido->entrega),
                                'turno' => $turno,
                                'solicitante' => utf8_encode($pedido->solicitante),
                                'cc' => utf8_encode($pedido->cc),
                                'setor' => utf8_encode($pedido->setor),
                                'aprovador' => utf8_encode($pedido->aprovador),
                                'naoaprovado' => filter_var($pedido->naoaprovado, FILTER_VALIDATE_BOOLEAN),
                                'motivo_nao_aprovado' => utf8_encode(strtoupper($pedido->naoaprovado_motivo))
                        );
                endforeach;

                $this->output
                        ->set_content_type('application/json')
		        ->set_output(json_encode(
                                array(
                                        'solicitacoes' => $lista_pedidos,
                                        'retornado' => $pedidos[1],
                                        'total' => $this->solicitacao->totalSolicitacao($busca)
                                )
                        ));
        }

        public function Aprovar(){
                $this->load->model('pedido/requisicao_model', 'requisicao');
                $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($this->requisicao->aprovar($this->input->post('solicitacao'),$this->input->post('aprovacao'), utf8_decode($this->input->post('motivo')))));
        }
        




        public function contarRequisicoes(){                 
                $mes = $this->input->post('mes');    
                $ano = $this->input->post('ano');

                $this->load->model('pedido/requisicao_model', 'requisicao');

                $dados = $this->requisicao->contarRequisicoes($this->session->key_funcionarios, $mes, $ano);

                $feito = array();
                $recebido = array();

                foreach($dados AS $dado):
                        if ($dado->key_funcionarios_solicitante == $this->session->key_funcionarios){
                                array_push($feito,$dado);
                        }
                        else if ($dado->key_funcionarios == $this->session->key_funcionarios){
                                array_push($recebido, $dado);
                        }
                endforeach;
                
                $quantidades = array(
                        'feito' => count($feito),
                        'recebido' => count($recebido)
                );

                $this->output->set_content_type('application/json')->set_output(json_encode($quantidades)); 
        }
        



}
