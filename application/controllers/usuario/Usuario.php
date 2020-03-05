<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Usuario extends CI_Controller {
	public function index()
	{
		
		
        // echo 'CHEGOU AQUI4';
		if( ! $this->session->has_userdata('logado'))
            redirect(base_url('webpedidos/'));

		$data['title'] = 'Usuário';
		$data['usuario'] = $this->session->usuario_nome;
		$data['relatorios'] = array(
			filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
        );
		$data['script'] = array(
			// '<script src="'.base_url('webpedidos/assets/js/classes/usuario/usuario.min.js').'"></script>',
			// '<script src="'.base_url('webpedidos/assets/js/actions/usuario/usuario.min.js').'"></script>'
			'<script src="'.base_url('webpedidos/assets/js/classes/usuario/usuario.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/actions/usuario/usuario.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>'
		);

		$data['css'] = array( //MM
				'<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
				'<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
				'<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
		);
		$this->load->view('templates/header', $data);
		$this->load->view('usuario/usuario');
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
		$matricula = trim($this->input->post('matricula'));

		if(!trim($this->input->post('id'))){
			$id = trim($this->input->get('id'));
		}
		else{
			$id = trim($this->input->post('id'));
		}
			
        $cnpj =  trim($this->input->post('cnpj'));
        $nome = trim($this->input->post('nome'));
		$grupo_acesso =  trim($this->input->post('grupo_acesso'));
        $email = trim($this->input->post('email'));
		// $senha =  trim($this->input->post('senha'));
		// $senha = geraSenha(8); //Senha aleatória, para aumentar a quantidade - altere o parametro


// GERAR SENHA
		$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZabcdefghijklmnopqrstuvxwyz0123456789';
		$QuantidadeCaracteres = strlen($Caracteres);
		$QuantidadeCaracteres--;
	
		$senha = NULL;
		for ($x = 1; $x <= 8; $x++) {
			$Posicao = rand(0, $QuantidadeCaracteres);
			$senha .= substr($Caracteres, $Posicao, 1);
		}


		
		$relatorio_consumo = trim($this->input->post('rel_consumo'));
		$relatorio_aprovacao = trim($this->input->post('rel_aprovacao'));
		$relatorio_comparacao = trim($this->input->post('rel_comparacao'));	
		
		// // if (isset($_POST['nivel-acesso'])) {
		// 	$tpadmi = filter_input(INPUT_POST, 'cbBasico', FILTER_SANITIZE_STRING);
		// 	echo '<pre> FUNCIONssssssARIOS----> ';
		// 	print_r($tpadmi);
		// // }
		
		if (isset($_POST['campo'])){
			$codFun = utf8_decode(filter_input(INPUT_POST, 'campo', FILTER_SANITIZE_NUMBER_INT));

		} 

		$this->load->model('usuario/usuario_model', 'usuario');
		
		// $data['title'] = 'Usuário';
		// $data['usuario'] = $this->session->usuario_nome;
		
		// $this->form_validation->set_rules('nome', 'Nome', 'required');
		// // $this->form_validation->set_rules('senha', 'Senha', 'required|min_lenght[6]', array(
		// // 	'required' => '%s',
		// // 	'min_length' => '%s deve conter no mínimo 5 caracteres'
		// // ));
		// $this->form_validation->set_rules('grupo_acesso', 'Grupo de Acesso', 'required|integer');
		// $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email', array(
		// 	'required' => '%s',
		// 	'valid_email' => '%s deve ser um endereço válido'
		// ));
		// if($this->form_validation->run()){
			// $this->load->model('usuario/usuario_model', 'usuario');


			$this->usuario->setNome(trim($this->input->post('nome')));
			$this->usuario->setSenha(trim($this->input->post('senha')));
			$this->usuario->setGrupoAcesso($this->input->post('grupo_acesso'));
			$this->usuario->setPrimeiroAcesso(TRUE);
			$this->usuario->setEmail(trim($this->input->post('email')));
			$this->usuario->setRelConsumo($this->input->post('rel_consumo'));
			$this->usuario->setRelPedidos($this->input->post('rel_pedidos'));
			// $this->setValidadeSenha(date('Y-m-d'));


			$result = $this->usuario->criar($matricula, $id, $nome, $grupo_acesso, $email, $senha);

			if($result['status'] === TRUE){
// print_r( __DIR__ .'/phpmailer/phpMailerAutoload.php');
		
			include_once __DIR__ . '/phpmailer/phpMailerAutoload.php';
				
	
				/*
				* Envio de email com senha para o usuário
				*/	
			
				$bodyMail = '<!DOCTYPE html>';
				$bodyMail .= '<html>';
				$bodyMail .='<head>';
				$bodyMail .='<title>.:: Senha de acesso ::.</title>';
				$bodyMail .= '<meta charset="UTF-8">';
				$bodyMail .='<meta name="viewport" content="width=device-width, initial-scale=1.0">';
				$bodyMail .= '<style>';
				$bodyMail .= ' body{line-height: 1.5;}';
				$bodyMail .= '.container{margin: 0 auto;width: 67.5%;border: solid 1px #E60404;border-radius: 4px 4px;background: #F1F1F1;font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;font-size: 14px;}';
				$bodyMail .= '.section-email article{margin: 10px 26px;padding: 10px 10px;}';
				$bodyMail .= '.body-mail p, .footer-mail p{margin-left: 10px;}';
				$bodyMail .= '</style> ';
				$bodyMail .= '</head>';
				$bodyMail .= '<body>';
				$bodyMail .= '<div class="container">';
				$bodyMail .= '<section class="section-email">';
				$bodyMail .= '<article>';
				$bodyMail .= '<div class="body-mail">';
				$bodyMail .='<p>';
				$bodyMail .= $nome . ' , seja bem-vindo. <br />';
				$bodyMail .= 'Você está recebendo sua senha de acesso para o sistema de requisições WEB da Fitassul.';
				$bodyMail .='</p>';
				$bodyMail .= '<p>';
				$bodyMail .= '<strong>Usuário: </strong>' . $nome . '<br />';
				$bodyMail .= '<strong>Senha: </strong>' . $senha;
				$bodyMail .= '</p>';
				$bodyMail .= '<p>';
				$bodyMail .= 'Seguem os endereços de acesso: <br />';
				$bodyMail .= '<strong>Produção:</strong> <a href="https://www.fitassul.com.br/siemens">https://www.fitassul.com.br/siemens</a><br />
				<strong>Área de testes:</strong> <a href="https://www.fitassul.com.br/teste/siemens">https://www.fitassul.com.br/teste/siemens</a>';
				$bodyMail .= '</p>';
				$bodyMail .= '</div>';
				$bodyMail .= '<footer class="footer-mail">';
				$bodyMail .= '<p>Dúvidas entre em contato conosco: <br /> <strong>Loja Fitassul Siemens – (11) 4585-3148</strong><br /><strong>Fitassul Matriz – (35) 3629-5353 </strong></p>';
				$bodyMail .= '<p>';
				$bodyMail .='Atenciosamente, <br />';
				$bodyMail .= '<strong>Fitassul</strong>';
				$bodyMail .='</p>';
				$bodyMail .= '</footer>';
				$bodyMail .= '</article>';
				$bodyMail .= '</section>';
				$bodyMail .= '</div>';
				$bodyMail .= '</body>';
				$bodyMail .='</html>';
					
				// log_page($cmd, $result);
					// $logger->message('IP :' . $_SERVER['REMOTE_ADDR'] . ' | Usuário: ' . $nmusua . ' | teve a senha alterada! ')->write();
					
// Instância do objeto PHPMailer
$mail = new PHPMailer;
	
// Configura para envio de e-mails usando SMTP
$mail->isSMTP();
 
// Servidor SMTP
$mail->Host = 'webmail.fitassul.com.br';
 
// Usar autenticação SMTP
$mail->SMTPAuth = false;
 
// $mail->SMTPDebug = 2;

// Usuário da conta
$mail->Username = 'siemens@fitassul.com.br';

// Porta do servidor SMTP
$mail->Port = 25;
 
// Informa se vamos enviar mensagens usando HTML
$mail->IsHTML(true);
 
// Email do Remetente
$mail->From = 'siemens@fitassul.com.br';
 
// Nome do Remetente
$mail->FromName = 'Loja Fitassul';
 
// Endereço do e-mail do destinatário
$mail->addAddress($email);
 
// Assunto do e-mail
$mail->Subject = 'Acesso ao sistema';
 
// Mensagem que vai no corpo do e-mail
$mail->Body = $bodyMail;
 
// Envia o e-mail e captura o sucesso ou erro
if($mail->Send()):
	echo 'Enviado com sucesso !';
else:
	echo 'Erro ao enviar Email:' . $mail->ErrorInfo;
endif;
					

					
					
					// $altbody = "Seus dados para acesso ao sistema são: Usuário: $nome e Senha: $senha.<br /> Atenciosamente, Fitassul.";
					
					// if ($mailer->sendMail($emailFun, strtoupper($nome), "Senha de acesso", $bodyMail, $altbody)) {
					// 	echo json_encode('SALVO'); // array retorna em variavel data no jquery
					// } else {
					// 	// $logger->message('IP :' . $_SERVER['REMOTE_ADDR'] . ' | Usuário: ' . $_SESSION["usernomeus"] . ' | ' . $mail->ErrorInfo)->write();
					// }

					
					// // // Always set content-type when sending HTML email
					// $headers = "MIME-Version: 1.0" . "\r\n";
					// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// // More headers
					// $headers .= 'From: <fitassul@fitassul.com.br>' . "\r\n";
					// // $headers .= 'Cc: myboss@example.com' . "\r\n";
					// // print_r($message);
					// mail($to,$subject,$message,$headers);
					
					

					
					

					
					/*
					* Fim envio de email.
					*/

				}
				
			// print_r($result);
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		// }else{
		// 	print(json_encode(validation_errors()));
		// }

	}







	//Atualização de dados do usuário	
	public function atualizar(){
		
		$retorno = array();

		$this->load->model('usuario/usuario_model', 'usuario');

	
		$login = $this->input->post('login');
		// print_r ($login);
		
		$usuarioId = $this->usuario->descobrirId($login);
		if ($usuarioId == null || $usuarioId == ''){
			$usuarioId =  $this->session->usuario_id;
		}

		$novaSenha = md5($this->input->post('senha'));


		if($this->usuario->verificaSenhasAnteriores($usuarioId, $novaSenha)):
			$retorno = array(
				'status' => $this->usuario->atualizar($usuarioId, $novaSenha),
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

	
	// //Atualização de dados do usuário	
	// public function recuperar(){
	// 	$retorno = array();
		
	// 	$usuarioId =  $this->session->usuario_id;
	// 	$novaSenha =  md5($this->input->post('senha'));

	// 	$this->load->model('usuario/usuario_model', 'usuario');

	// 	if($this->usuario->verificaSenhasAnteriores($usuarioId, $novaSenha)):
	// 		$retorno = array(
	// 			'status' => $this->usuario->atualizar($usuarioId, $novaSenha),
	// 			'log' => ''
	// 		);
	// 	else:
	// 		$retorno = array(
	// 			'status' => FALSE,
	// 			'log' => 'Coloque uma senha diferente das últimas 6 cadastradas'
	// 		);
	// 	endif;

	// 	$this->output
    //         ->set_content_type('application/json')
	// 			->set_output(json_encode($retorno));
	// }











	public function alterarDados(){
		
		if( ! $this->session->has_userdata('logado'))
            redirect(base_url('webpedidos/'));

		$data['title'] = 'Alterar dados';
		$data['usuario'] = $this->session->usuario_nome;
		$data['relatorios'] = array(
			filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
        );
		$data['email'] = $this->session->usuario_email;

		$data['script'] = array(
			'<script src="'.base_url('webpedidos/assets/js/classes/usuario/usuario.min.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/actions/usuario/alterar_dados.min.js').'"></script>'
		);

		$this->load->view('templates/header', $data);
		$this->load->view('usuario/alterar_dados');
		$this->load->view('templates/footer');
	}












	// public function buscar2(){ //CRIANDO MM // ARRUMAR PARA QNDO O USUARIO FOR DE FILIAIS //ARRUMAR QUERY //CLICK BOTAO BUSCAR
		
	// 	if( ! $this->session->has_userdata('logado'))
	// 		redirect(base_url('webpedidos/'));

	// 	if($this->input->get('id'))
	// 		$id = trim($this->input->get('id'));
		
	// 	if($this->input->post('id'))
	// 		$id = trim($this->input->post('id'));
		


	// 	$this->load->model('usuario/usuario_model', 'usuario');
		
	// 	$busca['funcionarioid ='] = $id;
		
	// 	$usuarios = $this->usuario->buscar($busca);

	
		
	// 	$this->load->model('funcionario/funcionario_model', 'funcionario'); //MM2

		
	// 	$colecao = array();
		
	// 	foreach($usuarios AS $user):
	// 		$nome = $this->funcionario->listarNome(utf8_encode($user->funcionariofilialmatricula));
			
	
	// 		$colecao[] = array(
	// 			'codigo' => utf8_encode($user->webloginid),
	// 			'funcionario' => $nome[0]->nome,
	// 			'login' => utf8_encode($user->usuario),
	// 			'id' => utf8_encode($user->funcionarioid),
	// 			'nivel' => utf8_encode($user->grupoacessoid),
	// 			'matricula' => utf8_encode($user->funcionariofilialmatricula),
	// 			'grupoacesso' => utf8_encode($user->grupoacessoid),
	// 			'rel_consumo' => utf8_encode($user->relconsumo),
	// 			'rel_comparacao' => utf8_encode($user->relcomparacao),
	// 			'rel_aprovacao' => utf8_encode($user->relpedidosaprovados),
	// 			'email' => utf8_encode($user->email)
	// 		);

	// 	endforeach;


	// 	$this->output
	// 	->set_content_type('application/json')
	// 		->set_output(json_encode($colecao));
	// }








	public function buscar(){ //MM //VEIO DE TEMPLATE TEM Q EDITAR //CLICK BOTAO LISTAR e BUSCAR

		if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
			
		$this->load->model('usuario/Usuario_model', 'usuario');
		$this->load->model('funcionario/funcionario_model', 'funcionario'); //MM2
		
		$buscaEmpresa = array();
		$buscaId = array();
		
		
		
		if($this->input->post('id')){
			$id = null;
			$id = trim($this->input->post('id'));
			$buscaId['funcionarioid ='] = $id;
			$usuarios = $this->usuario->buscarID($buscaEmpresa, $buscaId); 
		}
		else{
			$buscaEmpresa['empresasiteid ='] = $this->session->fiscal_empresa;					
			$usuarios = $this->usuario->buscar($buscaEmpresa); 
		}
	
		$colecao = array();
		
		foreach($usuarios AS $user):
			
			$nome = $this->funcionario->listarNome(utf8_encode($user->funcionariofilialmatricula)); //chegando vazio o id
	
			$colecao[] = array(
				'codigo' => utf8_encode($user->webloginid),
				'funcionario' => $nome[0]->nome,
				'login' => utf8_encode($user->usuario),
				'id' => utf8_encode($user->funcionarioid),
				'nivel' => utf8_encode($user->grupoacessoid),
				'matricula' => utf8_encode($user->funcionariofilialmatricula),
				'grupoacesso' => utf8_encode($user->grupoacessoid),
				'rel_consumo' => utf8_encode($user->relconsumo),
				'rel_comparacao' => utf8_encode($user->relcomparacao),
				'rel_aprovacao' => utf8_encode($user->relpedidosaprovados),
				'email' => utf8_encode($user->email),
				'nomeGrupoacesso' => utf8_encode($user->grupoacessonome)
			);
	
		endforeach;		
	
		$this->output->set_content_type('application/json')->set_output(json_encode($colecao));
	}












	public function editar(){ //MM  //CLICK BOTAO EDITAR

		if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
			
		$this->load->model('usuario/Usuario_model', 'usuario');
		
		$id = trim($this->input->post('id'));
		$novoNivel = trim($this->input->post('novoNivel'));	
		$novoLogin = trim($this->input->post('novoLogin'));	

		
		$editado = $this->usuario->editar($id, $novoNivel, $novoLogin  );
	
		$this->output->set_content_type('application/json')->set_output(json_encode($editado));
	}







	public function excluir(){ 
		
		if( ! $this->session->has_userdata('logado'))
			redirect(base_url('webpedidos/'));
			
		$this->load->model('usuario/Usuario_model', 'usuario');				
		
		$id = trim($this->input->post('id'));		

		// print_r($id);
		$excluido = $this->usuario->excluir($id);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($excluido));
	}













}