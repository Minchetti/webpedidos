<?php

class Recebimento_model extends CI_Model {
    // private $matricula;
    // private $nome;
    // private $senha;
    // private $validade_senha;
    // private $email;
    // private $grupo_acesso;
    // private $primeiro_acesso;
    // private $rel_consumo;
    // private $rel_pedidos;

    // public function setMatricula($maticula){
    //     $this->matricula = (string) $matricula;
    // }
    // public function setNome($nome){
    //     $this->nome = (string)$nome;
    // }
    // public function setSenha($senha){
    //     $this->senha = (string) $senha;
    //     // echo '<pre>---$$$$-> ';
    //     // echo($this->senha);
    // }
    // public function setGrupoAcesso($grupo_acesso){
    //     $this->grupo_acesso = (int)$grupo_acesso;
        
    // }
    // public function setPrimeiroAcesso($primeiro_acesso){
    //     $this->primeiro_acesso = filter_var($primeiro_acesso, FILTER_VALIDATE_BOOLEAN);
    // }
    // public function setEmail($email){
    //     $this->email = (string) $email;
    // }
    // public function setRelConsumo($rel_consumo){
    //     $this->rel_consumo = filter_var($rel_consumo, FILTER_VALIDATE_BOOLEAN);
    // }
    // public function setRelPedidos($rel_pedidos){
    //     $this->rel_pedidos = filter_var($rel_pedidos, FILTER_VALIDATE_BOOLEAN);
    // }
    // public function setValidadeSenha($validade_senha){
    //     $this->validade_senha = $validade_senha;
    // }

    public function __construct(){
        $this->load->database();
    }

   

    public function buscarEmpresas(){             
        $this->db->select('fantasia, filiais_servidor_db'); 
        $this->db->from('fiscal_empresas');
        // $this->db->where('cnpj_cpf', $busca['cnpj']);
        $db = $this->db->get()->result();

        return $db;
    }

    
    public function buscarSubEmpresas($filial){    
        $dbX = $this->load->database($filial, TRUE);        
        $dbX->select('nome, fantasia, cnpj'); 
        $dbX->from('clientes');
        $subEmpresas = $dbX->get()->result();
        return $subEmpresas;
    }

    
    public function buscarEmail($filial, $matricula){ 
        $dbX = $this->load->database($filial, TRUE);        
        $dbX->select('email'); 
        $dbX->from('funcionarios f');
        $dbX->where('f.matricula', $matricula);
        $dbX->where('f.ativo', true);
        $email = $dbX->get()->result();

        if (isset($email[0])){
            return $email[0]->email;        
        }
        else{
            return false;
        }
    }  
        
    public function buscarRecebimento($filial, $matricula, $cnpj){ 
        $dbX = $this->load->database($filial, TRUE);        
        $dbX->distinct();
        $dbX->select('rm, recebido'); 
        $dbX->from('vendas v');
        $dbX->where('v.key_funcionarios', $matricula);
        $dbX->where('v.key_clientes', $cnpj);
        $vendas = $dbX->get()->result();

        return $vendas;
    }  
        
    public function setarRecebido($cod){ 
        $filial = $_COOKIE['_Filial_Access'];

        $data['recebido'] = TRUE;
        
        $dbX = $this->load->database($filial, TRUE);        
        
        $dbX->trans_start();
        $dbX->where('rm', $cod);    
        $dbX->update('vendas', $data);        
        $dbX->trans_complete();
                
        return $dbX->trans_status();
    }  
    
 


    // public function buscar($grupoacessoid){      

    //     $this->db->select('aprovapedido, relconsumo, relpedidosaprovados, criatemplate, criarequisicao, criausuario, criagrupoacesso'); //verificar se ja tem esse nome
    //     $this->db->from('web_grupos_acesso');
    //     $this->db->where('grupoacessonome', $nome);

    //     return $query->result();
    // }



    //$usuario = string
    // public function buscarID($empresa, $id){
        
    //         $condicao = $empresa + $id;       
    //         $query = $this->db->get_where('vw_web_login', $condicao);    
            
    //     return $query->result();
    // }

    //$usuario, $novaSenha = string
    // public function atualizar($usuarioId, $novaSenha){
    //     $historico_senha = array(
    //         'webloginid' => $usuarioId,
    //         'senha' => $novaSenha
    //     );        

    //     $this->db->trans_start();
    //         $this->db->where('webloginid', $usuarioId);
    //         $this->db->update('web_login', array('senha' => $novaSenha));
    //         $this->db->where('webloginid', $usuarioId);
    //         $this->db->from('web_login_senhas_anteriores');
    //         if($this->db->count_all_results() === 6):
    //             $this->db->where('webloginid', $usuarioId);
    //             $this->db->select_min('webSenhasAnterioresID');
    //             $result = $this->db->get('web_login_senhas_anteriores')->result();
    //             $this->db->delete('web_login_senhas_anteriores', array('webSenhasAnterioresID' => $result[0]->webSenhasAnterioresID));
    //         endif;
    //         $this->db->insert('web_login_senhas_anteriores', $historico_senha);
    //     $this->db->trans_complete();

    //     return $this->db->trans_status();
    // }





}



