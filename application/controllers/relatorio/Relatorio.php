<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {

    public function index(){
        if( ! $this->session->has_userdata('logado'))
            redirect(base_url('webpedidos/'));

            $data['title'] = 'Relatório';
            $data['usuario'] = $this->session->usuario_nome;
            $data['relatorios'] = array(
                        filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
                        filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
                        filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
                );
            $data['script'] = array(
                    '<script src="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.js').'"></script>',
                    '<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>',                    
                '<script src="'.base_url('webpedidos/assets/js/actions/relatorio/relatorio.js').'"></script>'
            );
            $data['css'] = array(
                    '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
                    '<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
                    '<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
            );
            $this->load->view('templates/header', $data);
            $this->load->view('relatorios/relatorio');
            $this->load->view('templates/footer');
    }



    public function gerarConsumo(){
        $retorno = array();
        
        // $usuarioId =  $this->session->usuario_id;
        $num_inicial = $this->input->post('num_inicial');
        $num_final = $this->input->post('num_final');
        $data_inicial = $this->input->post('data_inicial');
        $data_final = $this->input->post('data_final');
        $matricula = $this->input->post('matricula');
        $nome = $this->input->post('nome');
        $turno = $this->input->post('turno');
        $setor = $this->input->post('setor');
        $status_apr = $this->input->post('status_apr');
        $status_req = $this->input->post('status_req');

        $this->load->model('relatorio/relatorio_model', 'relatorio');

        
        $relatorio = $this->relatorio->gerarConsumo($num_inicial, $num_final, $data_inicial, $data_final, $matricula, $nome, $turno, $setor, $status_apr, $status_req); 
        $this->output
                ->set_content_type('application/json')
                        ->set_output(json_encode($relatorio));
        }
    

}