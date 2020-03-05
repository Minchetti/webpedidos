<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Recebimento extends CI_Controller {
	public function index()
	{
		$data['title'] = 'Recebimento De Mercadorias';
		// $data['usuario'] = $this->session->usuario_nome;
		$data['relatorios'] = array(
			filter_var($this->session->relatorio_consumo, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_pedidos, FILTER_VALIDATE_BOOLEAN),
			filter_var($this->session->relatorio_comparacao, FILTER_VALIDATE_BOOLEAN)
        );
		$data['script'] = array(
			// '<script src="'.base_url('webpedidos/assets/js/classes/grupoacesso/grupoacesso.min.js').'"></script>',
			// '<script src="'.base_url('webpedidos/assets/js/actions/grupoacesso/grupoacesso.min.js').'"></script>'
			'<script src="'.base_url('webpedidos/assets/js/classes/recebimento/recebimento.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/actions/recebimento/recebimento.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>'
		);

		$data['css'] = array( //MM
				'<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
				'<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
				'<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
		);
		$this->load->view('templates/header_inicial', $data);
		$this->load->view('recebimento/recebimento');
		$this->load->view('templates/footer');
	}



	public function recebe(){ 	//NAO TA USANDO
		// $this->load->model('recebimento/recebimento_model', 'recebimento');
		// $empresas = $this->recebimento->buscarEmpresas(); 
		
		$cod = $this->input->post('cod');

		echo("ENTREI BITCHSSS");
		//   $nome = $_POST['nome'];
		// O nome original do venda no computador do usuário
		// $arqName = $_FILES['venda']['name'];
		// // O tipo mime do venda. Um exemplo pode ser "image/gif"
		// $arqType = $_FILES['venda']['type'];
		// // O tamanho, em bytes, do venda
		// $arqSize = $_FILES['venda']['size'];
		// // O nome temporário do venda, como foi guardado no servidor
		// $arqTemp = $_FILES['venda']['tmp_name'];
		// // O código de erro associado a este upload de venda
		// $arqError = $_FILES['venda']['error'];
		// if ($arqError == 0) {
		// 	$pasta = __DIR__ . '\uploads/';
		// 	$upload = move_uploaded_file($arqTemp, $pasta . $arqName . $cod);
		// }
	
		// $colecao = array();
		
		// foreach($empresas AS $empresa):	
		// 	$colecao[] = array(
		// 		'nome' => utf8_encode($empresa->fantasia),
		// 		'filial' => $empresa->filiais_servidor_db
		// 	);	
		// endforeach;		
	
		$this->output->set_content_type('application/json')->set_output(json_encode($colecao));
	}
	




	public function buscarEmpresas(){ 	
		$this->load->model('recebimento/recebimento_model', 'recebimento');
        $empresas = $this->recebimento->buscarEmpresas(); 
	
		$colecao = array();
		
		foreach($empresas AS $empresa):	
			$colecao[] = array(
				'nome' => utf8_encode($empresa->fantasia),
				'filial' => $empresa->filiais_servidor_db
			);	
		endforeach;		
	
		$this->output->set_content_type('application/json')->set_output(json_encode($colecao));
	}

	
	public function buscarSubEmpresas(){ 	
		$this->load->model('recebimento/recebimento_model', 'recebimento');
		
		$filial = $this->input->post('filial');
        $subEmpresas = $this->recebimento->buscarSubEmpresas($filial); 
	
		$colecao = array();
		
		foreach($subEmpresas AS $subEmpresa):	
			$colecao[] = array(
				'nome' => utf8_encode($subEmpresa->nome),
				'fantasia' => utf8_encode($subEmpresa->fantasia),
				'cnpj' => utf8_encode($subEmpresa->cnpj)
			);	
		endforeach;		
	
		$this->output->set_content_type('application/json')->set_output(json_encode($colecao));
	}


	
	public function buscarRecebimento(){ 	
		$this->load->model('recebimento/recebimento_model', 'recebimento');
		
		$filial = $this->input->post('filial');
		$matricula = $this->input->post('matricula');
		$cnpj = $this->input->post('cnpj');

        $vendas = $this->recebimento->buscarRecebimento($filial, $matricula, $cnpj); 
	
		$colecao = array();
		
		foreach($vendas AS $venda):	
			$colecao[] = array(
				'cod' => utf8_encode($venda->rm),
				// 'emissao' => utf8_encode($venda->data_emissao),
				'recebido' => utf8_encode($venda->recebido)
			);	
		endforeach;		
	
		$this->output->set_content_type('application/json')->set_output(json_encode($colecao));
	}


	// public function entrarRecebimento(){		
		
	// 	$token = $this->input->post('token');
	// 	$token_cookie = $this->input->post('token_cookie');
		
	// 	if($token == $token_cookie){
			
	// 		// print(json_encode(array('acesso' => TRUE, 'url' => 'painel_recebimento')));
			
	// 		$resultado = array(
	// 			'callback' => "Token FOI!!",
	// 			'cod' => 1
	// 		);  
	// 		$this->output
	// 		->set_content_type('application/json')
	// 			->set_output(json_encode($resultado));
	// 		// $(location).attr('href', 'painel_recebimento');
	// 		// $this->load->model('recebimento/recebimento_model', 'recebimento');
	// 		// $vendas = $this->recebimento->buscarVendas($filial, $matricula);

	// 	}
	// 	else{
	// 		$resultado = array(
	// 			'callback' => "Token Incorreto!",
	// 			'cod' => 0
	// 		);  
	// 		$this->output
	// 		->set_content_type('application/json')
	// 			->set_output(json_encode($resultado));

	// 	}
	
	// }



	public function painel_recebimento()
	{
		// echo ("AHAHHAHAH");
		// echo ($_COOKIE['Acess']);
		if(! $_COOKIE['_Token_Access'])
		redirect(base_url('webpedidos/recebimento'));

		$data['title'] = 'X Recebimento De Mercadorias';
		$data['script'] = array(
			// '<script src="'.base_url('webpedidos/assets/js/classes/grupoacesso/grupoacesso.min.js').'"></script>',
			// '<script src="'.base_url('webpedidos/assets/js/actions/grupoacesso/grupoacesso.min.js').'"></script>'
			'<script src="'.base_url('webpedidos/assets/js/classes/recebimento/recebimento.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/actions/recebimento/painel_recebimento.js').'"></script>',
			'<script src="'.base_url('webpedidos/assets/js/lib/easyautocomplete/jquery.easy-autocomplete.min.js').'"></script>'
		);

		$data['css'] = array( //MM
				'<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.min.css').'" rel="stylesheet" type="text/css">',
				'<link href="'.base_url('webpedidos/assets/js/lib/easyautocomplete/easy-autocomplete.themes.min.css').'" rel="stylesheet" type="text/css">',
				'<link href="'.base_url('webpedidos/assets/js/lib/jquery-ui-1.12.1/jquery-ui.min.css').'" rel="stylesheet" type="text/css">'
		);
		$this->load->view('templates/header_inicial', $data);
		$this->load->view('recebimento/painel_recebimento');
		$this->load->view('templates/footer');
		
	}



	
	public function enviarToken(){
		$filial = strtolower($this->input->post('filial'));
		$cnpj = $this->input->post('cnpj');
		$matricula = strtolower($this->input->post('matricula'));

			$this->load->model('recebimento/recebimento_model', 'recebimento');
			$email = $this->recebimento->buscarEmail($filial, $matricula);
			
			// $dados = $this->recebimento->buscar($busca);

			if( !empty($email) && $email !== false && $email !== null && $email !== 'undefined'){
				function generateRandomString($length = 10) {
					$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$charactersLength = strlen($characters);
					$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
					return $randomString;
				}
				$token = generateRandomString();

				setcookie("_Token_Access", $token, time()+13600, "/"); 
				setcookie("_Matricula_Access", $matricula, time()+13600, "/"); 
				setcookie("_CNPJ_Access", $cnpj, time()+13600, "/"); 	
				setcookie("_Filial_Access", $filial, time()+13600, "/"); 					
				setcookie("_Acess", TRUE, time()+13600, "/"); 

				include_once __DIR__ . '\..\usuario\phpmailer\phpMailerAutoload.php';
				// require __DIR__ . '\..\usuario\phpmailer\phpMailerAutoload.php';
				// include_once __DIR__ . '\..\usuario\phpmailer\phpMailerAutoload.php';

				$bodyMail = '<!DOCTYPE html>';
				$bodyMail .= '<html>';
				$bodyMail .='<head>';
				$bodyMail .='<title>.:: Token de Acesso ::.</title>';
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
				$bodyMail .= 'Você está recebendo um token de acesso para o sistema de recebimento WEB da Fitassul.';
				$bodyMail .='</p>';
				$bodyMail .= '<p>';
				$bodyMail .= '<strong>Token: </strong>' . $token;
				$bodyMail .= '</p>';
				$bodyMail .= '</div>';
				$bodyMail .= '<footer class="footer-mail">';
				$bodyMail .= '<p><strong>Fitassul Matriz – (35) 3629-5353 </strong></p>';
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
				// $mail->SMTPDebug = 2;				
				// verá o que o servidor SMTP remoto diz

				if($mail->Send()){
					$resultado = array(
						'callback' => 'Token enviado com sucesso! Verifique seu email para acesso!',
						'cod' => 1
					);  
					// print_r($resultado);
					$this->output
					->set_content_type('application/json')
						->set_output(json_encode($resultado));
				}
				else{
					$resultado = array(
						'callback' => "Erro ao enviar email! " . $mail->ErrorInfo
					);  
					// print_r($resultado);
					$this->output
					->set_content_type('application/json')
						->set_output(json_encode($resultado));
				} 						
			}
			else{	     
				$resultado = array(
					'callback' => "Funcionário não encontrado!"
				);
				// print_r($resultado);
				$this->output
				->set_content_type('application/json')
					->set_output(json_encode($resultado));
			}
	}
	
}