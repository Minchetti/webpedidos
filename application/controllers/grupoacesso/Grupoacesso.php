<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class GrupoAcesso extends CI_Controller {
	public function index()
	{
		
		
        // echo 'CHEGOU AQUI4';
		if( ! $this->session->has_userdata('logado'))
            redirect(base_url('webpedidos/'));

		$data['title'] = 'Grupos de Acesso';
		$data['usuario'] = $this->session->usuario_nome;
		$data['relatorios'] = array(
			filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
        );
		$data['script'] = array(
			// '<script src="'.base_url('webpedidos/assets/js/classes/grupoacesso/grupoacesso.min.js').'"></script>',
			// '<script src="'.base_url('webpedidos/assets/js/actions/grupoacesso/grupoacesso.min.js').'"></script>'
			'<script src="'.base_url('webpedidos/assets/js/classes/grupoacesso/grupoacesso.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/actions/grupoacesso/grupoacesso.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>'
		);

		$data['css'] = array( //MM
				'<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
				'<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
				'<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
		);
		$this->load->view('templates/header', $data);
		$this->load->view('grupoacesso/grupoacesso');
		$this->load->view('templates/footer');
	}





	



	function geraSenha($qtd) //NAO TA USANDO
	{
		//Abaixo a string $Caracteres gera aleatóriamente todos os caracteres.
		$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZabcdefghijklmnopqrstuvxwyz0123456789';
		$QuantidadeCaracteres = strlen($Caracteres);
		$QuantidadeCaracteres--;
	
		$senha = NULL;
		for ($x = 1; $x <= $qtd; $x++) {
			$Posicao = rand(0, $QuantidadeCaracteres);
			$senha .= substr($Caracteres, $Posicao, 1);
		}
	
		return $senha;
	}









	public function novo(){	

        $nome = trim($this->input->post('nome'));
		$aprova_pedido = trim($this->input->post('aprova_pedido'));			
        $cria_template =  trim($this->input->post('cria_template'));		
        $cria_requisicao =  trim($this->input->post('cria_requisicao'));
		$cria_usuario =  trim($this->input->post('cria_usuario'));
		$cria_grupoacesso =  trim($this->input->post('cria_grupoacesso'));
		$cria_aviso =  trim($this->input->post('cria_aviso'));
		$responde_sugestao =  trim($this->input->post('responde_sugestao'));
		$relatorio_consumo =  trim($this->input->post('relatorio_consumo'));
		$relatorio_aprovacao =  trim($this->input->post('relatorio_aprovacao'));
        


		$this->load->model('grupoacesso/grupoacesso_model', 'grupoacesso');
			// $this->grupoacesso->setNome(trim($this->input->post('nome')));
			// $this->grupoacesso->setSenha(trim($this->input->post('senha')));
			// $this->grupoacesso->setGrupoAcesso($this->input->post('grupo_acesso'));
			// $this->grupoacesso->setPrimeiroAcesso(TRUE);
			// $this->grupoacesso->setEmail(trim($this->input->post('email')));
			// $this->grupoacesso->setRelConsumo($this->input->post('rel_consumo'));
			// $this->grupoacesso->setRelPedidos($this->input->post('rel_pedidos'));
			// $this->setValidadeSenha(date('Y-m-d'));


			$result = $this->grupoacesso->criar($nome, $aprova_pedido, $cria_template, $cria_requisicao, $cria_usuario, $cria_grupoacesso, $cria_aviso, $responde_sugestao, $relatorio_consumo, $relatorio_aprovacao);
//  print_r($result.status);

			$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}







	//Atualização de dados do usuário	
	public function atualizar(){
		$retorno = array();
		
		$usuarioId =  $this->session->usuario_id;
		$novaSenha =  md5($this->input->post('senha'));

		$this->load->model('grupoacesso/grupoacesso_model', 'grupoacesso');

		if($this->grupoacesso->verificaSenhasAnteriores($usuarioId, $novaSenha)):
			$retorno = array(
				'status' => $this->grupoacesso->atualizar($usuarioId, $novaSenha),
				'log' => ''
			);
		else:
			$retorno = array(
				'status' => FALSE,
				'log' => 'Coloque uma senha diferente das últimas 6 cadastradas'
			);
		endif;

		$this->output
            ->set_content_type('application/json')
				->set_output(json_encode($retorno));
	}










	public function alterarDados(){
		
		if( ! $this->session->has_userdata('logado'))
            redirect(base_url('webpedidos/'));

		$data['title'] = 'Alterar dados';
		$data['grupoacesso'] = $this->session->usuario_nome;
		$data['relatorios'] = array(
			filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
        );
		$data['email'] = $this->session->usuario_email;

		$data['script'] = array(
			'<script src="'.base_url('webpedidos/assets/js/classes/grupoacesso/grupoacesso.min.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/actions/grupoacesso/alterar_dados.min.js').'"></script>'
		);

		$this->load->view('templates/header', $data);
		$this->load->view('grupoacesso/alterar_dados');
		$this->load->view('templates/footer');
	}






	public function buscar(){ //MM //CLICK BOTAO LISTAR

		if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
			
		$this->load->model('grupoacesso/GrupoAcesso_model', 'grupoacesso');

        $gruposacesso = $this->grupoacesso->buscar(); 		
	
		$colecao = array();
		
		foreach($gruposacesso AS $grupoacesso):	
			$colecao[] = array(
				'nome' => utf8_encode($grupoacesso->grupoacessonome),
				'aprova_pedido' => utf8_encode($grupoacesso->aprovapedido),
				'relatorio_consumo' => utf8_encode($grupoacesso->relconsumo),
				'relatorio_aprovacao' => utf8_encode($grupoacesso->relpedidosaprovados),
				'cria_template' => utf8_encode($grupoacesso->criatemplate),
				'cria_requisicao' => utf8_encode($grupoacesso->criarequisicao),
				'cria_usuario' => utf8_encode($grupoacesso->criausuario),
				'cria_grupoacesso' => utf8_encode($grupoacesso->criagrupoacesso),
				'cria_aviso' => utf8_encode($grupoacesso->criaaviso),
				'responde_sugestao' => utf8_encode($grupoacesso->respondesugestao),
				'grupoacessoid' => utf8_encode($grupoacesso->grupoacessoid)
			);	
		endforeach;		
	
		$this->output->set_content_type('application/json')->set_output(json_encode($colecao));
	}












	public function editar(){ //MM  //CLICK BOTAO EDITAR
		if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
			
		$this->load->model('grupoacesso/GrupoAcesso_model', 'grupoacesso');
		
		$nome = trim($this->input->post('nome'));
		$novoNome = trim($this->input->post('novoNome'));
		$novoAprova_pedido = trim($this->input->post('novoAprova_pedido'));
		$novoRel_aprovacao = trim($this->input->post('novoRel_aprovacao'));
		$novoRel_consumo = trim($this->input->post('novoRel_consumo'));		
		
		$novoCria_template = trim($this->input->post('novoCria_template'));	
		$novoCria_requisicao = trim($this->input->post('novoCria_requisicao'));	
		$novoCria_usuario = trim($this->input->post('novoCria_usuario'));	
		$novoCria_grupoacesso = trim($this->input->post('novoCria_grupoacesso'));	
		$novoCria_aviso = trim($this->input->post('novoCria_aviso'));	
		$novoResponde_sugestao = trim($this->input->post('novoResponde_sugestao'));		


		
		$editado = $this->grupoacesso->editar($nome, $novoNome, $novoRel_aprovacao, $novoRel_consumo, $novoAprova_pedido, $novoCria_template, $novoCria_requisicao, $novoCria_usuario, $novoCria_grupoacesso, $novoCria_aviso, $novoResponde_sugestao);
		// echo"SAIU CONTROLL";
		
		$this->output->set_content_type('application/json')->set_output(json_encode($editado));
	}








	public function excluir(){ 
		
		if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
			
		$this->load->model('grupoacesso/GrupoAcesso_model', 'grupoacesso');				
		
		$nome = trim($this->input->post('nome'));		

		
		$excluido = $this->grupoacesso->excluir($nome);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($excluido));
	}











}