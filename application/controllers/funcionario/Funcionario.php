<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionario extends CI_Controller {

	public function index()
	{
		 if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
	}

	public function listar($funcionario = null){		
		// echo "LISTOUUUUUUU";
		
		if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
		
		$colaboradores = array();
		$funcionario = ( ! is_null($funcionario)) ? urldecode($funcionario) : $this->input->post_get('funcionario');

		$this->load->model('funcionario/funcionario_model', 'funcionario');
		$this->load->model('setor/setor_model', 'setor');

		foreach($this->funcionario->listarNomeMatricula(strtoupper($funcionario)) AS $key => $colaborador):
			
			$verifica_local = $this->setor->listar($colaborador->setor);

			if($colaborador->setor !== 'DESLIGADOS' && !empty($verifica_local) ):
				$colaboradores[] = array(
					'nome' => utf8_encode($colaborador->nome),
					'matricula' => utf8_encode($colaborador->matricula),
					'setor' => utf8_encode($colaborador->setor),
					'ghe' => utf8_encode($colaborador->key_ghe),	
					'cargo' => utf8_encode($colaborador->cargo),
					'data_admissao' => $colaborador->data_admissao,
					'cliente' => utf8_encode($colaborador->cliente),
					'cc' => utf8_encode($colaborador->cc),
					'id' => utf8_encode($colaborador->id), //MM
					'email'=> utf8_encode($colaborador->email) //MM
				);
			endif;
		endforeach;

		$this->output->set_content_type('application/json')
		->set_output(json_encode($colaboradores));
	}


	

	public function listarPorSetor(){
		
		// <!-- echo "LISTOU POR SETORRRRR"; -->

		// console.log('dasd2') ;
		if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
		$listando = array();
		$this->load->model('funcionario/funcionario_model', 'funcionario');
		// echo('AAAAAAAAAAAAAAA-');
				// print_r($colaborador);
		foreach ($this->funcionario
				->listarPorSetor(trim(utf8_decode($this->input->post('setor'))), trim(utf8_decode($this->input->post('depto')))) as $lista_funcionario):
				
				if($lista_funcionario->setor !== 'DESLIGADOS'):
					$listando[] = array(
						'nome' => utf8_encode($lista_funcionario->nome),
						'matricula' => utf8_encode($lista_funcionario->matricula),
						'cargo' => utf8_encode($lista_funcionario->cargo),
						'setor' => utf8_encode($lista_funcionario->setor),
						'ghe' => utf8_encode($lista_funcionario->key_ghe), //adicionei essa linha pra ver se chega o ghe
						'cc' => utf8_encode($lista_funcionario->cc),
						'id' => utf8_encode($lista_funcionario->id) //MM
					);
				endif;
		endforeach;
		$this->output
		->set_content_type('application/json')
			->set_output(json_encode($listando));

	}
}


//http://localhost/webpedidos/funcionario/funcionario/listar/a
//http://localhost/webpedidos/produto/produto/permitidos

//http://localhost/webpedidos/setor/setor/listar/75008280
//http://localhost/webpedidos/funcionario/funcionario/listarporsetor

//http://localhost/webpedidos/produto/produto/permitidos
