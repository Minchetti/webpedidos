<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sugestao extends CI_Controller {

   

    public function index(){
        if( ! $this->session->has_userdata('logado'))
            redirect(base_url('webpedidos/'));
            
        if($this->session->respondesugestao !== true){  //ocultar o campo de resposta caso n tiver permissao
            echo '<style>.divResposta { visibility: hidden; }</style>';
        }

         $data['title'] = 'Sugestões';
                $data['usuario'] = $this->session->usuario_nome;
                $data['relatorios'] = array(
                    filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
                    filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
                    filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
                );
                $data['today'] = date('d/m/Y');
                $data['script'] = array(
                        '<script src="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.js').'"></script>',
                        // '<script src="'.base_url('webpedidos/assets/js/classes/sugestoes/sugestao.min.js').'"></script>',
                        // '<script src="'.base_url('webpedidos/assets/js/actions/sugestoes/sugestao.min.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/classes/sugestoes/sugestao.js').'"></script>',
                        '<script src="'.base_url('webpedidos/assets/js/actions/sugestoes/sugestao.js').'"></script>',
                );
        $data['css'] = array();
        $this->load->view('templates/header', $data);
        $this->load->view('sugestoes/sugestoes');
        $this->load->view('templates/footer');
    }

    public function listar(){
        $sugestoes = array();
        $status = array();
        $this->load->model('sugestoes/sugestao_model', 'sugestao');

        switch((int)$this->input->post('status')):
            case 1:
                $status[] = array(
                    'status' => 'Aguardando'
                );
            break;
            case 2:
                $status[] = array(
                    'status' => 'Respondido'
                );
            break;
            case 0:
                $status[] = array(
                    'status !=' => ''
                );
            break;
        endswitch;

        foreach($this->sugestao->ocorrencias($status[0]) AS $sugestao):
            $sugestoes[] = array(
                'codigo' => (int) $sugestao->codigo,
                'matricula' => (string) utf8_encode($sugestao->matricula),
                'sugestao' => (string) utf8_encode($sugestao->sugestao),
                'data_sugestao' => date('d/m/Y', strtotime($sugestao->dtsugestao)),
                'status' => (string) utf8_encode($sugestao->status),
                'resposta' => (string) utf8_encode($sugestao->resposta),
                'data_resposta' => date('d/m/Y', strtotime($sugestao->dtresposta)),
                'setor' => (string) utf8_encode($sugestao->setor),
                'tipo_ocorrencia' => (int) $sugestao->tipo
            );
        endforeach;

        $this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($sugestoes));
    }

    public function criar(){
        $this->load->model('sugestoes/sugestao_model', 'sugestao');
        $this->load->model('funcionario/funcionario_model', 'funcionario');
        $funcionario_dado = $this->funcionario->listarMatricula($this->session->key_funcionarios);
        $dados = json_decode($this->input->post('sugestao'), TRUE);

        // echo "---> key_f ";
        // echo "<pre>";
        // print_r($this->session->key_funcionarios);

        // echo "---> funcionario_dado ";
        //     echo "<pre>";
        //     print_r($funcionario_dado);

        $solicitar = array(
            'matricula' => $this->session->key_funcionarios,
            'setor' => $funcionario_dado[0]->setor,
            'dtsugestao' => date('Y-m-d'),
            'status' => 'Aguardando',
            'sugestao' => utf8_decode($dados['sugestao']),
            'tipo' => (int) $dados['tipo']
        );

        // print_r ($solicitar);

         $this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($this->sugestao->criar($solicitar)));
    }



    public function responder(){
        
        $this->load->model('sugestoes/sugestao_model', 'sugestao');
        
        $codigo = $this->input->post('codigo');
        $resposta = trim($this->input->post('resposta'));

        // echo "---> key_f ";
        // echo "<pre>";
        // print_r($this->session->key_funcionarios);

        // echo "---> funcionario_dado ";
        //     echo "<pre>";
        //     print_r($funcionario_dado);

        $responder = array(
            'codigo' => $codigo,
            'resposta' => $resposta
            // 'matricula' => $this->session->key_funcionarios,
            // 'setor' => $funcionario_dado[0]->setor,
            // 'dtsugestao' => date('Y-m-d'),
            // 'status' => 'Aguardando',
            // 'sugestao' => utf8_decode($dados['sugestao']),
            // 'tipo' => (int) $dados['tipo']
        );

        // print_r ($solicitar);

         $this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($this->sugestao->responder($responder)));
    }





}