<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
       
       public function index(){

           if( ! $this->session->has_userdata('logado'))
                redirect(base_url('webpedidos/'));

            $data['title'] = 'Principal';
            $data['database'] = $this->session->pasta;
            $data['usuario'] = $this->session->usuario_nome;

            $data['relatorios'] = array(
                filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
                filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
                filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
            );

            $data['script'] = array(
                // '<script src="'.base_url('webpedidos/assets/js/classes/notificacoes/notificacoes.min.js').'"></script>',
                // '<script src="'.base_url('webpedidos/assets/js/actions/notificacoes/notificacoes.min.js').'"></script>' MMMMMMMMMMMMMM
                '<script src="'.base_url('webpedidos/assets/js/classes/notificacoes/notificacoes.js').'"></script>',
                '<script src="'.base_url('webpedidos/assets/js/actions/notificacoes/notificacoes.js').'"></script>',
                '<script src="'.base_url('webpedidos/assets/js/actions/dashboard/dashboard.js').'"></script>',
                '<script src="'.base_url('webpedidos/assets/js/classes/pedidos/requisicao.js').'"></script>'
            );

            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/dashboard');
            $this->load->view('templates/footer');

            // $dbX = $this->load->database($filial, TRUE);        
            // $dbX->select('nome, fantasia, cnpj'); 
            // $dbX->from('clientes');
            // $subEmpresas = $dbX->get()->result();
       }

}
?>