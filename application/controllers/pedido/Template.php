<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gerenciamento de templates
 */

class Template extends CI_Controller {

    public function index(){

        if( ! $this->session->has_userdata('logado'))
            redirect(base_url('webpedidos/'));

        $data['title'] = 'Templates';
        $data['usuario'] = $this->session->usuario_nome;

        $data['relatorios'] = array(
            filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
            filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
            filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
        );

        $data['script'] = array(
              '<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>',
            '<script src="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.js').'"></script>',
            '<script src="'.base_url('webpedidos/assets/js/classes/produtos/produtos.js').'"></script>',
            '<script src="'.base_url('webpedidos/assets/js/classes/usuario/funcionario.js').'"></script>', //tirei o min
            '<script src="'.base_url('webpedidos/assets/js/classes/pedidos/template.js').'"></script>',//tirei o min
            '<script src="'.base_url('webpedidos/assets/js/actions/pedidos/template.js').'"></script>'//tirei o min
        );

         $data['css'] = array(
            '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('pedidos/templates');
        $this->load->view('templates/footer');
    }









    public function criar(){
        $this->load->model('pedido/template_model', 'template');
        $this->load->model('funcionario/funcionario_model', 'funcionario');
        $departamento = $this->funcionario->listarMatricula($this->session->key_funcionarios);
        $numero_template = $this->template->getNumeroTemplate();
        $funcionarios = json_decode($this->input->post('funcionarios'), TRUE);
        $partnumber = '';
        $quantidade = 0;
        $nova_template = array();
        $template_funcionarios = array();
        $template_itens = array();

        // echo '<pre>';
        // print_r($numero_template[0]->codigo);
        // echo '<pre>';
        // print_r((string) $this->session->key_funcionarios);
        // echo '<pre>';
        // print_r((string) $departamento[0]->cliente);

    //    echo "---> DEPARTAMENTO ";
    //     echo "<pre>";
    //     print_r($departamento);

    //    echo "--->  Session ";
    //     echo "<pre>";
    //     print_r($this->session);

    foreach($funcionarios AS $funcionario):
        $departamento = $this->funcionario->listarMatricula($funcionario['template']['matricula']);
    endforeach;

        $nova_template = array(
            'numero' => $numero_template[0]->codigo,   //add essa varaivel pra pegar mesmo valor do codigo
            // 'descricao' => strtoupper(trim(utf8_decode($this->input->post('observacao')))), //add essa variavel pra pegar mesmo valor da Obs


            // 'codigo' => $numero_template[0]->codigo,
            // 'key_funcionarios' => (string) $this->session->key_funcionarios,
            // 'key_usuario' => (string) $this->session->key_funcionarios,
            'key_usuario' => (string) $this->session->funcionarioID,
            'key_clientes' => (string) $departamento[0]->cliente,
            
            'descricao' => strtoupper(trim(utf8_decode($this->input->post('nome')))),
            'obs' => strtoupper(trim(utf8_decode($this->input->post('observacao')))),
            'id_centro_custo' => $departamento[0]->cc,
            'id_depto' => $departamento[0]->cliente
        );

        // echo "---> CRAZY SETOR ";
        // echo "<pre>";
        // print_r(strtoupper(trim(utf8_decode($this->input->post('setor')))) );

        // echo "---> CRAZY CC ";
        // echo "<pre>";
        // print_r(strtoupper(trim(utf8_decode($this->input->post('cc')))) );

        // echo "---> CRAZY POST ()";
        // echo "<pre>";
        // print_r($this->input->post());

        // echo "---> CRAZY POST ";
        // echo "<pre>";
        // print_r($this->input->post );


        // $nova_template = array(
        //     'codigo' => $numero_template[0]->codigo,
        //     'key_funcionarios' => (string) $this->session->key_funcionarios,
        //     'key_clientes' => (string) $departamento[0]->cliente,
        //     'nome' => strtoupper(trim(utf8_decode($this->input->post('nome')))),
        //     'obs' => strtoupper(trim(utf8_decode($this->input->post('observacao'))))
        // );

        // echo "---> NOVA TEMPLATE ";
        // echo "<pre>";
        // print_r($nova_template);

        foreach($funcionarios AS $funcionario):
            $departamento = $this->funcionario->listarMatricula($funcionario['template']['matricula']);
            $funcionarios_codigo = $this->template->getTemplateFuncionarios();
            $template_funcionarios[] = array(
                'codigo' => $funcionarios_codigo[0]->codigo,
                'key_templates' => $numero_template[0]->codigo,
                // 'key_clientes' => $departamento[0]->cliente,
                'key_funcionarios' => $funcionario['template']['matricula']
            );
            
            foreach($funcionario['template']['itens'] AS $key => $itens):
                foreach($itens AS $item):
                    $template_itens[] = array(
                        'numero_item' => ($key + 1), //teste
                        'key_clientes' => $departamento[0]->cliente,//teste
                        'valor' => $item['valor'], //teste                        

                        'key_templates_funcionarios' => $funcionarios_codigo[0]->codigo,
                        'key_produtos' => $item['codigo'], 
                        'key_partnumber' => $item['partnumber'], 
                        'quantidade' => $item['quantidade'] 
                    );
                endforeach;
            endforeach;
        endforeach;
        
        // echo '<pre>Template_funcionarios -> ';
        // print_r($template_funcionarios);
        // echo '<pre>Template_itens -> ';
        // print_r($template_itens);

        $this->
            output->set_content_type('application/json')
		              ->set_output(json_encode($this->template->criar($nova_template, $template_funcionarios, $template_itens)));

    }





    public function buscar(){

         if( ! $this->session->has_userdata('logado'))
                redirect(base_url('webpedidos/'));

        $this->load->model('pedido/Template_model', 'template');
        $criteria = json_decode($this->input->post('param'), TRUE);
        $busca = array();
        
        if(empty($criteria['num_final']) && ! empty($criteria['num_inicial'])){
         
            $busca['tm.numero'] = $criteria['num_inicial'];
        }else if ( ! empty($criteria['num_inicial']) && ! empty($criteria['num_final']) ){
            
            $busca['tm.numero >='] = $criteria['num_inicial'];
            $busca['tm.numero <='] = $criteria['num_final'];
        }


        if( ! empty($criteria['descricao']))
            $busca['tm.descricao LIKE'] = '%'.strtoupper($criteria['descricao']).'%';
        
        // if( ! empty($criteria['setor']))
        //     $busca['s.nome'] = strtoupper($criteria['setor']);

        // $busca['tm.key_usuario'] = $this->session->key_funcionarios;
        $busca['tm.key_usuario'] = $this->session->funcionarioID;

        //  echo "---> Busca ";
        //         echo "<pre>";
        //         print_r($busca);

        $templates = $this->template->buscar($busca);

        //  echo "---> Templates ";
        //         echo "<pre>";
        //         print_r($templates);

        $colecao = array();
        
        foreach($templates AS $temp):
            $colecao[] = array(
                'numero' => utf8_encode($temp->numero),
                'descricao' => utf8_encode($temp->descricao),
                'data_cadastro' => date('d/m/Y', strtotime($temp->data_cadastro)),
                'obs' => utf8_encode($temp->obs),
                'setor' => utf8_encode($temp->setor),
                'usuario' => utf8_encode($temp->funcionario),
                'cc' => utf8_encode($temp->setor)
            );

            // $colecao[] = array(
            //     'numero' => utf8_encode($temp->codigo),
            //     'descricao' => utf8_encode($temp->descricao),
            //     'data_cadastro' => date('d/m/Y', strtotime($temp->data_cadastro)),
            //     'obs' => utf8_encode($temp->obs),
            //     'setor' => utf8_encode($temp->setor),
            //     'usuario' => utf8_encode($temp->funcionario),
            //     'cc' => utf8_encode($temp->cc)
            // );


            // echo "---> Colecao ";
            //     echo "<pre>";
            //     print_r($colecao);
        endforeach;

        $this->output->set_content_type('application/json')->set_output(json_encode($colecao));
    }
















    public function template_nova(){
         if( ! $this->session->has_userdata('logado'))
            redirect(base_url('webpedidos/'));

        $data['title'] = 'Templates';
        $data['usuario'] = $this->session->usuario_nome;

        $data['relatorios'] = array(
            filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
            filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
            filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
        );

        $data['script'] = array(
            '<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>',
            '<script src="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.js').'"></script>',
            '<script src="'.base_url('webpedidos/assets/js/classes/produtos/produtos.min.js').'"></script>',
            '<script src="'.base_url('webpedidos/assets/js/classes/usuario/funcionario.js').'"></script>', //tirei o min
            '<script src="'.base_url('webpedidos/assets/js/classes/pedidos/template.js').'"></script>', /*TIREI .min*/ 
            '<script src="'.base_url('webpedidos/assets/js/actions/pedidos/template.js').'"></script>' /*TIREI .min*/ 
        );

        $data['css'] = array(
            '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
                        '<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
        );

        $this->load->view('templates/header', $data);
        $this->load->view('pedidos/templates_nova');
        $this->load->view('templates/footer');
    }




//caminho de usar um template:
//template.js-action / template.js-classes / template.php / template_model.php


    public function local_entrega(){ //chega um numero vindo de template.js - classes

               if( ! $this->session->has_userdata('logado'))
                redirect(base_url('webpedidos/'));

        $funcionarios = array();
        $this->load->model('pedido/template_model', 'template');

        // echo ("TESTE 1 - ".(int) $this->input->post('template'));        
        // echo ("TESTE 2 - ".$funcionarios);
        // echo ("TESTE 3 - ".$funcionarios);
        // echo "<pre>";
        // print_r ((int) $this->input->post('template')) AS $funcionarios);

        // echo '&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&';

        
        // echo " TEST -> ";
        // print_r ((int)$this->input->post('template'));
        // print_r ($this->input->post('template'));
        // print_r ((string)$this->input->post('template'));
        // print_r ($this->input->post('template'));
        // echo " <- FINAL TEST ";

        foreach($this->template->listarFuncionariosTemplate((int)$this->input->post('template')) AS $funcionario):      //((int) $this->input->post('template')) AS $funcionario            
        
            $funcionarios[] = array(
                // 'id' => '123',
                // 'cliente' => '123',
                // 'nome' => 'TESTE', //arrumar aqui
                // 'matricula' => '123',
                // 'setor' => '123'

                'id' => (int) $funcionario->codigo,
                'cliente' => utf8_encode((string) $funcionario->key_clientes),
                'nome' => utf8_encode($funcionario->nome),
                'matricula' => utf8_encode((string) $funcionario->key_funcionarios),
                'setor' => utf8_encode((string) $funcionario->setor)
            );
        endforeach;
        // echo "<pre>FUNCIONARIOS VRAU-)>" ;
        // print_r ($funcionarios);

        // echo " TEST -> ";
        // print_r ($funcionarios);
        // echo " <- FINAL TEST ";


        // print_r ("FUNCIONARIOS **************** -> ".$funcionarios);
        // print_r ((string)$funcionarios);
        
            // $marcello[] = array(
            //     'teste1' => 'marcello1',
            //     'teste2' => 'marcello2'
            // );

        // echo '<pre> - local_entrega - ';
        // print_r($funcionarios);

        $this->output->set_content_type('application/json')->set_output(json_encode($funcionarios));

    }















    







    public function utilizar(){

        // echo 'PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP';
        $this->load->model('pedido/template_model', 'template');
        $this->load->model('funcionario/funcionario_model', 'funcionario');
        $this->load->model('pedido/requisicao_model', 'requisicao');
        $this->load->model('produto/produto_model', 'produto');
        $aprovar = FALSE;
        $aprovador = NULL;
        $departamento_aprovador = NULL;
        $reserva = NULL;
        $data_aprovacao = NULL;
        $data_fechado = NULL;
        $emissao = date('Y-m-d');
        // echo 'UUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUU';
        
       
        // $produtos = json_decode($this->input->post('produtos'), TRUE); //coloquei aqui pra funcionar os detalhes na hora de usar o template
        
            // echo "---> PRODUTOS ";
            //       echo "<pre>";
            //       print_r($produtos);

        $departamento = $this->funcionario->listarMatricula($this->session->key_funcionarios); //erro aqui

        // print_r ($departamento);
        
        // echo 'MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM';
        
        // echo '<pre>';
        // print_r($this->funcionario->listarMatricula($this->session->key_funcionarios));
        

        // $post = array();
        // foreach ( $_POST as $key => $value )
        // {
        //     $post[$key] = $this->input->post($key);
        // }
        // print_r($post); 
        // echo "MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM";
        // var_dump($_POST);
        // die();

        if(filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)){
                        $aprovador = (string) $this->session->key_funcionarios;
                        $data_aprovacao = date('Y-m-d H:i:s');
                        $departamento_aprovador = (string) $departamento[0]->cliente; 
                        $aprovar = TRUE;
        }
        
        // echo 'BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';

        $funcionarios = json_decode($this->input->post('funcionarios'), TRUE); //ta faltando os parametros por isso ta vazio la na frente

        // echo "<pre>FUNCIONARIOS -)>" ;
        // print_r ($funcionarios); //ta RETORNANDO FALTANDO ALGUMNS PARTAMETROS...ENTAO O PROB EH aqui
        // echo "<pre>INPUTS -)>" ;
        // print_r ($this->input->post);
        

        $template = (int) $this->input->post('template');
        $observacao = (string) trim(utf8_decode($this->input->post('observacao')));
        $centro_custo = (string) trim($this->input->post('cc'));

        // echo "---> CC ";
        //     echo "<pre>";
        //     print_r($centro_custo);

            // echo "---> INPUT ";
            // echo "<pre>";
            // print_r($this->input->post);

            // echo "---> INPUT ";
            //       echo "<pre>";
            //       print_r($this->input);
        
        foreach($funcionarios AS $key => $colaborador):  //problema eh q oq ta vindo no parametro ta vazio....em todo lugar o colaborador ta vazio 30/09
            // echo '<pre>COLABORADOR -)>';
            // print_r($colaborador);
            // echo '<pre>FUNCIONARIOS -)>';
            // print_r($funcionarios);
            // echo '<pre>KEY -';
            // print_r($key);

             $reserva = (filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)) ? $this->requisicao->getPedido() : $this->requisicao->getReserva();
             $turno = 0;

            switch($colaborador['turno']) :
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

                // echo "CLICOU NO SIMMMMMMMMMMMMMMMMMMM";
                /**
                    * Efetivação de pedidos
                    */
                
                    // echo '<pre>COLABORADOR -';
                    // print_r($colaborador);

                $pedido[] = array(
                        'numero' => $reserva[0]->numero,
                        'key_clientes' => $colaborador['cliente'],
                        'data_emissao' => $emissao,
                        'id_depto' => $colaborador['cliente'],
                        'id_centro_custo' => $centro_custo,
                        // 'id_centro_custo' => $departamento[0]->cc,
                        'key_funcionarios' => $colaborador['matricula'],
                        'key_clientes_solicitante' => (string) $departamento[0]->cliente,
                        'key_funcionarios_solicitante' => (string) $this->session->key_funcionarios,
                        'key_clientes_aprovador' => $departamento_aprovador,
                        'key_funcionarios_aprovador' => $aprovador,
                        'obs' => $observacao,
                        'dh_aprovacao' => $data_aprovacao,
                        'data_fechado' => $data_fechado,
                        'aprovar' => strtoupper($aprovar),
                        'entrega_turno' => $turno,
                        'entrega_local' => utf8_decode($colaborador['local'])
                );
                //  echo '<pre>PEDIDOOOOOOOOO -';
                //     print_r($pedido);

                foreach($this->produto->itensTemplate($colaborador) AS $key => $item): //$colaborador[id]
                    $produto[] = array(
                            'key_pedidos' => $reserva[0]->numero,
                            'key_clientes' => $colaborador['cliente'],
                            'key_produtos' => $item->codigo,
                            'key_partnumber' => $item->partnumber,
                            'quantidade' => $item->quantidade,
                            'valor' => $item->preco,
                            'numero_item' => ($key + 1)
                    );
                endforeach;
                // echo '<pre>PRODUTOOOOOOOOOOOO -';
                // print_r($produto);
            }           
            else{ 
                // echo '<pre>ELSE  -> ';
                $pedido[] = array(
                        'solicitacaoid' => $reserva[0]->numero,
                        'key_clientes' => $colaborador['cliente'],
                        'data_emissao' => $emissao,
                        'id_depto' => $colaborador['cliente'],
                        'id_centro_custo' => $centro_custo,
                        // 'id_centro_custo' => $departamento[0]->cc,
                        'key_funcionarios' => $colaborador['matricula'],
                        'key_clientes_solicitante' => (string) $departamento[0]->cliente,
                        'key_funcionarios_solicitante' => (string) $this->session->key_funcionarios,
                        'key_clientes_aprovador' => $departamento_aprovador,
                        'key_funcionarios_aprovador' => $aprovador,
                        'obs' => $observacao,
                        'dh_aprovacao' => $data_aprovacao,
                        'data_fechado' => $data_fechado,
                        'entrega_turno' => $turno,
                        'entrega_local' => utf8_decode($colaborador['local'])
                );
                // echo '<pre>PEDIDO ENTREGA SEPARADA -';
                // print_r($pedido);

                /**
                *  Produtos buscar da template
                */ 
                foreach($this->produto->itensTemplate($colaborador) AS $key => $item)://$colaborador[id]
                    $produto[] = array(
                                    'fk_solicitacaoid' => $reserva[0]->numero,
                                    'key_clientes' => $colaborador['cliente'],
                                    'key_produtos' => $item->codigo,
                                    'key_partnumber' => $item->partnumber,
                                    'quantidade' => $item->quantidade,
                                    'valor' => $item->preco,
                                    'numero_item' => ($key + 1)
                                );
                endforeach;
                
                // echo '<pre>PRODUCT ENTREGA SEPARADA-> ';
                // print_r($produto);
            }


            // foreach($produtos AS $key => $item) : //coloquei aqui pra funcionar os detalhes na hora de usar o template
            //     //Apenas para resumo
            //     $resumo_produto [] = array(
            //             'codigo_produto' => $item['item']['codigo'],
            //             'descricao' => $item['item']['descricao'], 
            //             'quantidade' => $item['item']['quantidade'],
            //             'partnumber' => $item['item']['partnumber']
            //     );
            // endforeach;


            // $resumo_pedido[] = array( //coloquei aqui pra funcionar os detalhes na hora de usar o template
            //     'pedido' => array(
            //     'matricula' => $colaborador['matricula'],
            //     'nome' => $colaborador['nome'],
            //     'pedido' => str_pad($reserva[0]->numero, 10, '0',STR_PAD_LEFT),
            //     'produto' => $resumo_produto,
            //     'turno' => strtoupper($colaborador['turno']),
            //     'entrega' => $colaborador['local']
            //         ),
            //         'data_emissao' => date('d/m/Y', strtotime($emissao)),
            //         'obs' => utf8_encode($observacao)
            // );



        endforeach;
        $resultado = array(
            'callback' => (filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)) ? $this->requisicao->pedido($pedido, $produto) : $this->requisicao->solicitacao($pedido, $produto),
            'tipo' => (filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)) ? 'PEDIDO' : utf8_encode('SOLICITAÇÃO')
            // 'resumo' => $resumo_pedido //coloquei aqui pra funcionar os detalhes na hora de usar o template
        );

        // echo '<pre>resultado -------> ';
        // print_r($resultado);

        $this->
            output->set_content_type('application/json')
		              ->set_output(json_encode($resultado));
    }




























    public function detalhes(){
        // echo '<pre>xxxxx-';
        $detalhes = array();
        
        // echo '<pre>xxxxx-';
        if( ! $this->session->has_userdata('logado'))
                redirect(base_url('webpedidos/'));

                
        // echo '<pre>xxxxx-';
        $this->load->model('pedido/template_model', 'template');
        
        // echo '<pre>xxxxx-';
        // print_r($this->input->post('template'));
        $retorno = $this->template->listarFuncionariosProdutos($this->input->post('template'));
        $retornoFUNC = $this->template->listarFuncionariosTemplate($this->input->post('template')); //TESTANDO

        // echo '<pre>xxxxxxxxxxxxxxxxx-';
        // echo '<pre>RETORNO-';
        // print_r($retorno);
        // echo '<pre>RETORNOfunc-';
        // print_r($retornoFUNC);
        // $array = json_decode(json_encode($retorno), True);
        
        // echo '<pre>ARRAY-';
        // print_r($array);
        // print_r($array['funcionarios']);
        // print_r($array['funcionarios'][0]);
        // print_r($array['funcionarios'][0]['key_partnumber']);

        // echo '<pre>zzzzzzzzzzzzzz-';
        foreach($retornoFUNC AS $key => $funcionario): //$retorno['funcionarios']
            // print_r ($retorno['funcionarios']);
            // echo "FUNCIONARIO PORRA ->";
            // echo '<pre>';
            // print_r ($funcionario);

           $produtos = array();
           foreach($retorno['produtos'] AS $key => $produto):
                if($funcionario->codigo === $produto->funcionario) : 
                    // console.log('asdads');
                    $produtos[] = array(
                        'codigo' => $produto->codigo,
                        'descricao' => $produto->descricao,
                        'unidade' => $produto->unidade,
                        'partnumber' => $produto->key_partnumber,
                        'quantidade' => $produto->quantidade,
                        'ca' => $produto->ca
                    );
                endif;
           endforeach;
        //    echo '<pre>FUNCIONARIO-';
        //    print_r($funcionario);
           
           $detalhes[] = array(
               'funcionario' => array(
                   'matricula' => $funcionario->key_funcionarios, //matricula 
                   'nome' => utf8_encode($funcionario->nome),
                   'setor' => utf8_encode($funcionario->setor),
                    'cliente' => utf8_encode($funcionario->key_clientes), //cliente
                   'produtos' => $produtos
               )
           );
           
        endforeach;
        
        // echo '<pre>PRODUTOS->';
        // print_r($produtos);
        // echo '<pre>DETALHES ->';
        // print_r($detalhes);
        // echo '<pre>DETALHES-';
        // print_r($detalhes);

        $this->
            output->set_content_type('application/json')
		                    ->set_output(json_encode($detalhes));
    }













    
    public function deletar(){
        $this->load->model('pedido/template_model', 'template');
        $this->
            output->set_content_type('application/json')
		              ->set_output(json_encode($this->template->deletar(    $this->input->post('template')))); //tirei o (int)
    }

    public function atualizar_template($codigo){
         if( ! $this->session->has_userdata('logado') || empty($codigo))
            redirect(base_url('webpedidos/'));

        $data['title'] = 'Atualizar template';
        $data['usuario'] = $this->session->usuario_nome;

        $data['relatorios'] = array(
            filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
            filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
            filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
        );

        $data['script'] = array(
            '<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>',
            '<script src="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.js').'"></script>',
            '<script src="'.base_url('webpedidos/assets/js/classes/produtos/produtos.min.js').'"></script>',
            '<script src="'.base_url('webpedidos/assets/js/classes/usuario/funcionario.js').'"></script>', //tirei o min
            '<script src="'.base_url('webpedidos/assets/js/classes/pedidos/template.js').'"></script>', /*TIREI .min*/ 
            '<script src="'.base_url('webpedidos/assets/js/actions/pedidos/template.js').'"></script>' /*TIREI .min*/ 
        );

        $data['css'] = array(
            '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
            '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
            '<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
        );

        $this->load->model('pedido/template_model', 'template');
        $dados = $this->template->buscar(array('tm.codigo' => $codigo ));

        $data['template_descricao'] = utf8_encode($dados[0]->descricao);
        $data['codigo'] = $dados[0]->codigo;
        $data['obs'] = utf8_encode($dados[0]->obs);

        $this->load->view('templates/header', $data);
        $this->load->view('pedidos/atualizar_template');
        $this->load->view('templates/footer');
    }



    public function atualizar(){
        // echo "ahhahahahaha";
        #(int) $this->input->post('template');
        $dados = json_decode($this->input->post('dados'), TRUE);

    }


}