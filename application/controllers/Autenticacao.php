<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autenticacao extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Autenticação';
		$data['script'] = array(
			// '<script src="'.base_url('webpedidos/assets/js/classes/usuario/usuario.min.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/classes/usuario/usuario.js').'"></script>',
			// '<script src="'.base_url('webpedidos/assets/js/classes/usuario/autenticacao.min.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/classes/usuario/autenticacao.js').'"></script>',
			// '<script src="'.base_url('webpedidos/assets/js/actions/autenticacao/login.min.js').'"></script>'
			'<script src="'.base_url('webpedidos/assets/js/actions/autenticacao/login.js').'"></script>'
		);
		$this->load->view('templates/header_inicial', $data);
		$this->load->view('autenticacao/login');
		$this->load->view('templates/footer');
	}

	public function pegarGA(){
		echo $this->session->criagrupoacesso; //se tirar o echo ppara d retornar
		 return $this->session->criagrupoacesso;
	}


	public function logar(){
		$this->form_validation->set_rules('usuario', 'Usuario', 'required', array('required' => ucfirst('%s')));
		$this->form_validation->set_rules('senha', 'Senha', 'required', array('required' => ucfirst('%s')));

		if($this->form_validation->run()){
			$this->load->model('usuario/usuario_model', 'usuario');
			
			// echo "---> THIS Usuario ";
			// 		echo '<pre>';
			// 		print_r($this->usuario);


			$autenticado = $this->usuario->buscar(array(
				'usuario' => $this->input->post('usuario'),
				 //alterado campo senha_md5 para senha
				'senha' => md5($this->input->post('senha')) 
			));
			
			


			// echo "---> Autenticado ";
			// 		echo '<pre>';
			// 		print_r(autenticado);
			// 		print_r(md5($this->input->post('senha')));



			if( ! empty($autenticado)){  
				
				/*
				$dados = array(
					'validadeSenha' => (string) $autenticado[0]->senhavalidade,
					//'primeiro_acesso' => filter_var($autenticado[0]->primacesso, FILTER_VALIDATE_BOOLEAN),
					'usuario' => (string) strtoupper($autenticado[0]->usuario)
				);
				*/

				$dtValidadeSenha = (string) $autenticado[0]->senhavalidade;

				$dados_verificados = $this->usuario->verificaDados($dtValidadeSenha);

				if( ! $dados_verificados['acesso']){
					print(json_encode($dados_verificados));
				}else{

					/* Váriáveis de Sessão
					 *
					 */
					// echo '1-';
					// echo $autenticado[0]->funcionariofilialmatricula;
					
					// echo "---> Autenticado ";
					// echo '<pre>';
					// print_r($autenticado);
					

					$session = array(
						'usuario_id' => (int) $autenticado[0]->webloginid,
						'usuario_nome' => (string) $autenticado[0]->usuario,
						'usuario_email' => $autenticado[0]->email,
						'email' => $autenticado[0]->email,
						
						'fiscal_empresa' => (int) $autenticado[0]->empresasiteid,

						'grupo_acesso' => (int) $autenticado[0]->grupoacessoid,

						'aprovador' => filter_var($autenticado[0]->aprovapedido, FILTER_VALIDATE_BOOLEAN),
						'criatemplate' => filter_var($autenticado[0]->criatemplate, FILTER_VALIDATE_BOOLEAN),
						'criarequisicao' => filter_var($autenticado[0]->criarequisicao, FILTER_VALIDATE_BOOLEAN),
						'criausuario' => filter_var($autenticado[0]->criausuario, FILTER_VALIDATE_BOOLEAN),
						'criagrupoacesso' => filter_var($autenticado[0]->criagrupoacesso, FILTER_VALIDATE_BOOLEAN),
						'criaaviso' => filter_var($autenticado[0]->criaaviso, FILTER_VALIDATE_BOOLEAN),
						'respondesugestao' => filter_var($autenticado[0]->respondesugestao, FILTER_VALIDATE_BOOLEAN),
						'relatorio_consumo' => filter_var($autenticado[0]->relconsumo, FILTER_VALIDATE_BOOLEAN),
						'relatorio_pedidos' => filter_var($autenticado[0]->relpedidosaprovados, FILTER_VALIDATE_BOOLEAN),
						'relatorio_comparacao' => filter_var($autenticado[0]->relcomparacao, FILTER_VALIDATE_BOOLEAN),
						
						'pasta' => (string) $autenticado[0]->filiais_servidor_db,
						
						// Novo Campo ID do Funcionario a ser inserido nos relacionamentos ao invés da matricula VARCHAR
						'funcionarioID' => $autenticado[0]->funcionarioid,  
						'key_funcionarios' => (string) $autenticado[0]->funcionariofilialmatricula,
						
						'logado' => TRUE,
						
						// Parametros
						'mostrar_valores' => filter_var($autenticado[0]->mostrarvalorpedido, FILTER_VALIDATE_BOOLEAN)
					);

					// echo "<script> sessionStorage.setItem('criarGA', '" . $session['criagrupoacesso'] . "'); </script>";
					// echo $session['criagrupoacesso'];


					$this->session->set_userdata($session);
					print(json_encode(array('acesso' => TRUE, 'url' => 'principal')));
				}

			}else{
				print(json_encode(array('acesso' => FALSE, 'motivo' => 'Usuário ou Senha incorreto')));
			}
		}else{
			print(json_encode(validation_errors()));
		}
	}
	
	public function esqueciSenha(){
		$data['title'] = 'Esqueci senha';
		$data['script'] = array(
			// '<script src="'.base_url('webpedidos/assets/js/classes/usuario/autenticacao.min.js').'"></script>',
			// '<script src="'.base_url('webpedidos/assets/js/actions/autenticacao/esqueci_senha.min.js').'"></script>'
			'<script src="'.base_url('webpedidos/assets/js/classes/usuario/autenticacao.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/actions/autenticacao/esqueci_senha.js').'"></script>'
		);
		
		$this->load->view('templates/header_inicial', $data);
		$this->load->view('autenticacao/esqueci_senha');
		$this->load->view('templates/footer');
	}









	public function recuperarSenha(){
		// $this->form_validation->set_rules('usuario', 'Nome', 'required');
		// $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email', array(
		// 	'required' => '%s',
		// 	'valid_email' => '%s deve ser um endereço válido'
		// ));
		$email = strtolower($this->input->post('email'));

		// if($this->form_validation->run()){ //MM
			$resultado = false;
			$this->load->helper('string');
			$this->load->model('usuario/usuario_model', 'usuario');
			$recupera = array(
				'usuario' => $this->input->post('usuario'),
				'email' => $email
			);
			// print_r($recupera);

			// print_r($recupera);
			$dados = $this->usuario->buscar($recupera);
			// echo "      DADOS ->>>>>";
			// print_r($dados);
			// echo "      #############";

			// print_r($dados);
			if( ! empty($dados)){
				$nova_senha = random_string('alnum', 8);
				
				$novo = array(
					'senha' => md5(trim($nova_senha)),
					'senhavalidade' => date('Y-m-d', strtotime('+ 1 year')),
					'senhatoken' => trim(random_string('alnum', 9))
				);

				
			// print_r($novo);

				//Criar o controller para dois parametros
				// $link = '<a href="'.base_url('webpedidos/recuperasenha/'.$novo['senhatoken'].'/'.$dados[0]->usuario.'/'.$dados[0]->email.'/').'">'.base_url('webpedidos/recuperasenha/'.$novo['senhatoken'].'/'.$dados[0]->usuario.'/'.$dados[0]->email.'/').'</a>';
				// echo "usuario *************** ";
				// print_r($dados[0]->usuario);

				// echo "                              NOVO *************** ";
				// print_r($novo); 
				
				if($this->usuario->recuperar($dados[0]->usuario, $novo)){
					

					include_once __DIR__ . '/usuario/phpmailer/phpMailerAutoload.php';
				
	
					/*
					* Envio de email com senha para o usuário
					*/	
				
					$bodyMail = '<!DOCTYPE html>';
					$bodyMail .= '<html>';
					$bodyMail .='<head>';
					$bodyMail .='<title>.:: Nova Senha ::.</title>';
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
					// $bodyMail .= $nome . ' , seja bem-vindo. <br />';
					$bodyMail .= 'Você está recebendo uma nova senha de acesso para o sistema de requisições WEB da Fitassul.';
					$bodyMail .='</p>';
					$bodyMail .= '<p>';
					// $bodyMail .= '<strong>Usuário: </strong>' . $nome . '<br />';
					$bodyMail .= '<strong>Senha: </strong>' . $nova_senha;
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
						
						
	
	// Instância do objeto PHPMailer
	$mail = new PHPMailer;
	
	// Configura para envio de e-mails usando SMTP
	$mail->isSMTP();
	 
	// Servidor SMTP
	$mail->Host = 'webmail.fitassul.com.br';
	 
	// Usar autenticação SMTP
	$mail->SMTPAuth = false;
	 
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
						
						
			// echo"IF";
					// $this->load->model('email/mailer_model', 'mailer');
					// $this->mailer->setMailer(new \PHPMailer());
					// $this->mailer->setNome(ucfirst($dados[0]->usuario));
					// $this->mailer->setAssunto('Recuperação de senha');
					// $this->mailer->setMensagem($link);
					// $this->mailer->setEmail($dados[0]->email);

					// if($this->mailer->enviarEmail('layout_recupera_senha')){
					// 	$resultado = TRUE;
					// }else{
					// 	//Erro ao enviar e-mail [ERMAIL]
					// 	$resultado = "Ocorreu um erro interno, contate o suporte e informe [ERMAIL].";
					// }





				}else{
					
			// echo"ELSE";
					//Erro ao atualizar dados do usuário [ERUP]
					$resultado = "Ocorreu um erro interno, contate o suporte e informe [ERUP].";
				}
			}else{
				$resultado = 'Usuário não encontrado no sistema. Por favor, verifique seus dados!';
			}
			print(json_encode($resultado));
		// }else{
		// 	print(json_encode(validation_errors()));
		// }
	}

	public function recuperandoSenha($token, $usuario){
		$dados = array(
			'senhatoken' => $token,
			'usuario' => strtoupper($usuario)
		);
		$this->load->model('usuario/usuario_model', 'usuario');
		$dados = $this->usuario->buscar($dados);

		if( ! empty($dados)){
			$data['script'] = array(
				'<script src="'.base_url('webpedidos/assets/js/classes/usuario/usuario.min.js').'"></script>',
				'<script src="'.base_url('webpedidos/assets/js/actions/usuario/alterar_dados.min.js').'"></script>'
			);
			$data['fs'] = trim($dados[0]->usuario);
			$data['fslog'] = base_url('webpedidos/');
		}else{
			$data['erro'] = 'Link inválido ou expirado';	
		}

		$this->load->view('templates/header_inicial', $data);
		$this->load->view('autenticacao/recuperando_senha');
		$this->load->view('templates/footer');


	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('webpedidos/'));
	}
}
