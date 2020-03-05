<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacao extends CI_Controller {

    public function listar_manutencao(){
        $this->load->model('notificacao/notificacao_model', 'notificacao');
        $mensagem = $this->notificacao->manutencao();
        if( ! empty($mensagem)){
            $mensagem = array(
                'mensagem' => ucfirst(utf8_encode($mensagem[0]->mensagem)),
                'publicacao' => date('d/m/Y', strtotime($mensagem[0]->data_publicacao)),
                'expiracao' => date('d/m/Y', strtotime($mensagem[0]->data_expiracao))
            );
        }
        $this->output
		->set_content_type('application/json')
		->set_output(json_encode($mensagem));
    }

}