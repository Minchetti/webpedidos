<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Local extends CI_Controller {

    public function listar_entrega(){
        $setor = trim(strtoupper($this->input->post('setor')));
        // $id = trim(strtoupper($this->input->post('id')));
        $this->load->model('local/local_model', 'local');

        $this->output->set_content_type('application/json')
        ->set_output(json_encode($this->local->listar_entrega($setor)));   
            // ->set_output(json_encode($entregas));  
    }





    public function listar_entregaExterna(){
        $id = $this->session->funcionarioID;

        $this->load->model('local/local_model', 'local');
        $entregas = $this->local->listar_entregaExterna($id);
// print_r($entregas);
        foreach($entregas AS $key => $entrega):			
				$result[] = array(
					'rua' => utf8_encode($entrega->rua),
					'numero' => utf8_encode($entrega->numero),
					'cidade' => utf8_encode($entrega->cidade),
					'bairro' => utf8_encode($entrega->bairro),
					'estado' => utf8_encode($entrega->estado)
				);
		endforeach;

        // echo '<pre>ENTREGAS-';
        // print_r ($entregas);          
        $this->output->set_content_type('application/json')
            ->set_output(json_encode($result));  
    }






    public function verificar_entrega(){
        $cep = trim(strtoupper($this->input->post('cep')));
        $numero = trim(strtoupper($this->input->post('numero')));
        // $id = trim(strtoupper($this->input->post('id')));
        
            $id = $this->session->funcionarioID;
        // echo '<pre>local-';
        // print_r ($setor);
        $this->load->model('local/local_model', 'local');

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($this->local->verificar_entrega($cep, $numero, $id)));                     
    
    }

    
  

    public function cadastrar_entrega(){
        $cep = trim(strtoupper($this->input->post('cep')));
        $numero = trim(strtoupper($this->input->post('numero')));
        $rua = trim(strtoupper($this->input->post('rua')));
        $bairro = trim(strtoupper($this->input->post('bairro')));
        $cidade = trim(strtoupper($this->input->post('cidade')));
        $estado = trim(strtoupper($this->input->post('estado')));
        // $id = trim(strtoupper($this->input->post('id')));
        
        $id = $this->session->funcionarioID;
        // echo '<pre>local-';
        // print_r ($setor);
        $this->load->model('local/local_model', 'local');

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($this->local->cadastrar_entrega($cep, $numero, $rua, $bairro, $cidade, $estado, $id)));                     
    
    }
    
    

}