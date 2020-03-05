<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setor extends CI_Controller {

    public function listar($setor = null){
        if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
        $locais = array();
        $setor = ( ! is_null($setor)) ? urldecode($setor) : $this->input->post_get('setor');
        $this->load->model('setor/setor_model', 'setor');
        foreach($this->setor->listar(strtoupper($setor)) AS $key => $local):
            if(!empty($local->nome)):
                $locais[] = array(
                    'nome' => utf8_encode($local->nome),
                    'cc' => $local->cc,
                    'cnpj' => $local->cnpj,
                    'fantasia' => utf8_encode($local->fantasia),
                    'id_depto' => $local->id_depto
                );

            endif;

        endforeach;
        $this->output->set_content_type('application/json')
		    ->set_output(json_encode($locais));
    }

}
