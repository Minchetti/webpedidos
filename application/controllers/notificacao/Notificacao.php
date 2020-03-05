<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacao extends CI_Controller {    
    
    public function listar_manutencao(){
        
        $this->load->model('notificacao/notificacao_model', 'notificacao');
        
        $query = $this->notificacao->manutencao();
        
        // echo "<pre>";
        // print_r($query);
        // echo "<----";

        $mensagem = null;
        

        if( ! empty($query)){

            foreach($query AS $key => $aviso) :
                $mensagem[] = array(                        
                    'mensagem' => ucfirst(utf8_encode($aviso->mensagem)),
                    'publicacao' => date('d/m/Y', strtotime($aviso->dtpublicacao)),
                    'expiracao' => date('d/m/Y', strtotime($aviso->dtexpiracao))
                );
            endforeach;



            // $mensagem = array(
            //     'mensagem' => ucfirst(utf8_encode($query[0]->mensagem)),
            //     'publicacao' => date('d/m/Y', strtotime($query[0]->dtpublicacao)),
            //     'expiracao' => date('d/m/Y', strtotime($query[0]->dtexpiracao))
            // );
        } 
        // echo "<pre>";
        // print_r($mensagem);
        // echo "<----";
        // echo "<pre>";
        // print_r($query);
        // echo "<----";
        $this->output
		     ->set_content_type('application/json')
		     ->set_output(json_encode($mensagem));
    } 
    



    
    public function enviar_msg(){ //MM

        $mensagem = trim(strtoupper(utf8_decode($this->input->post('mensagem'))));
        // echo "<pre>";
        // print_r($mensagem);
        // echo $mensagem;
        // echo "<----";



        // $funcionarios = json_decode($this->input->post('funcionarios'), TRUE);
        // $emissao = trim($this->input->post('emissao'));
        // $observacao = trim(strtoupper(utf8_decode($this->input->post('observacao'))));
        
        $this->load->model('notificacao/notificacao_model', 'notificacao');
        
        $query = $this->notificacao->salvar($mensagem);

        if($query['status'] == 1){


            $this->load->model('funcionario/funcionario_model', 'funcionario');
            
            $emails = $this->funcionario->listarEmails();
$emailsX = array();
$emailsX[0]->email = 'minchettimarcello@gmail.com' ;
$emailsX[1]->email = 'informatica@fitassul.com.br' ;
 $emailsX[2]->email = 'paulo@fitassul.com.br' ;
$emailsX[3]->email = 'natanael@fitassul.com.br' ;

// print_r($emails);
     

            
        include_once __DIR__. '/../usuario/phpmailer/phpMailerAutoload.php';				
	
				/*
				* Envio de email com senha para o usuário
				*/	
			
				$bodyMail = '<!DOCTYPE html>';
				$bodyMail .= '<html>';
				$bodyMail .='<head>';
				$bodyMail .='<title>.:: Mensagem de Aviso ::.</title>';
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
				$bodyMail .= 'Uma mensagem de aviso foi publicada no quadro de avisos do sistema.';
				$bodyMail .='</p>';
				$bodyMail .= '<p>';
				$bodyMail .= '<strong>Mensagem: </strong>' . $mensagem;
				// $bodyMail .= '<strong>Senha: </strong>' . $senha;
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
 
foreach($emailsX AS $email){    
    // Endereço do e-mail do destinatário
    $mail->addAddress($email->email);
}
 
// Assunto do e-mail
$mail->Subject = 'Aviso do sistema';
 
// Mensagem que vai no corpo do e-mail
$mail->Body = $bodyMail;
 
// Envia o e-mail e captura o sucesso ou erro
if($mail->Send()):
	echo 'Enviado com sucesso !';
else:
	echo 'Erro ao enviar Email:' . $mail->ErrorInfo;
endif;



        }

        // if( ! empty($query)){
        //     $mensagem = array(
        //         'mensagem' => ucfirst(utf8_encode($query[0]->mensagem)),
        //         'publicacao' => date('d/m/Y', strtotime($query[0]->dtpublicacao)),
        //         'expiracao' => date('d/m/Y', strtotime($query[0]->dtexpiracao))
        //     );
        // }        
        // $this->output
		//      ->set_content_type('application/json')
		//      ->set_output(json_encode($mensagem));
    }    

}