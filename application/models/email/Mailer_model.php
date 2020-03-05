<?php

class Mailer_model extends CI_Model {
    private $mailer; //Recebe o objeto pronto via Injeção de dependência
    private $nome;
    private $assunto;
    private $mensagem;
    private $email;

    //Construtor
    public function __construct()
    {
        parent::__construct();
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setAssunto($assunto){
        $this->assunto = $assunto;
    }

    public function setMensagem($mensagem){
        $this->mensagem = $mensagem;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    // É obrigatório passar uma instância de PHPMailer, caso contrário haverá uma exception
    public function setMailer(\PHPMailer $mailer){
        $this->mailer = $mailer;
    }

    // Configuração para envio de e-mails
    public function setupMailer(){
        //$this->mailer->SMTPDebug = 3;                      // Enable verbose debug output
        $this->mailer->IsSMTP();                             // Set mailer to use SMTP
        $this->mailer->SMTPAutoTLS = false;
        //Desabilita verificação ssl para poder rodar no php5.6
        $this->mailer->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
        $this->mailer->Host = 'webmail.fitassul.com.br';  // Specify main and backup SMTP servers
        $this->mailer->SMTPSecure = 'tls';                   // Enable TLS encryption, `ssl` also accepted
        $this->mailer->Port = 465;                           // TCP port to connect to
        $this->mailer->isHTML(true);                         // Set email format to HTML
        $this->mailer->CharSet = 'utf-8'; 
    }

    // Não importa se a mensagem de resposta não tenha email ou assunto, só estão sendo substituidos valores caonhecidos
    private function generateHTML($mensagem, $assunto, $nome, $email, $tipo){
        $html = str_replace("[tp.assunto]", $assunto, file_get_contents(base_url('application/views/templates/email/'.$tipo.'.html')));
        $html = str_replace("[tp.mensagem]", $mensagem, $html);
        $html = str_replace("[tp.nome]", $nome, $html);
        $html = str_replace("[tp.email]", $email, $html);
        $html = str_replace("[tp.data_envio]", date('d/m/Y H:i:s'), $html);
        $html = str_replace("[tp.url]", base_url('webpedidos/'), $html);
        return $html;
    }

    // O parametro "$tipo" recebe uma string com o nome do layout a ser carregado pelo file_get_contents()
    // Exemplo: layout_envio, layout_resposta
    public function enviarEmail($tipo){
        $this->setupMailer();
        switch($tipo) :
            case "layout_recupera_senha" :
                $this->mailer->setFrom('fitassul@fitassul.com.br', 'Fitassul');
                $this->mailer->addAddress($this->email, $this->nome); // Add a recipient
            break;

        endswitch;
        $this->mailer->Subject = $this->assunto;
        $this->mailer->Body    = $this->generateHTML($this->mensagem, $this->assunto, $this->nome, $this->email, $tipo);
        $this->mailer->AltBody = 'Você está recebendo o link de acesso para recuperação da senha para acesso ao sistema, clique no link '. $this->mensagem .' ou copie o endereço no navegador.  Caso não tenha solicitado a recuperação da senha, desconsidere esse e-mail.';
        if( ! $this->mailer->send()) {
            log_message('error', $this->mailer->ErrorInfo);
            return FALSE;
        } else {
            $this->mailer->ClearAllRecipients();
            return TRUE;
        }
    }


}