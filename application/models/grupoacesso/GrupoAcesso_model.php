<?php

class GrupoAcesso_model extends CI_Model {
    private $matricula;
    private $nome;
    private $senha;
    private $validade_senha;
    private $email;
    private $grupo_acesso;
    private $primeiro_acesso;
    private $rel_consumo;
    private $rel_pedidos;

    public function setMatricula($maticula){
        $this->matricula = (string) $matricula;
    }
    public function setNome($nome){
        $this->nome = (string)$nome;
    }
    public function setSenha($senha){
        $this->senha = (string) $senha;
        // echo '<pre>---$$$$-> ';
        // echo($this->senha);
    }
    public function setGrupoAcesso($grupo_acesso){
        $this->grupo_acesso = (int)$grupo_acesso;
        
    }
    public function setPrimeiroAcesso($primeiro_acesso){
        $this->primeiro_acesso = filter_var($primeiro_acesso, FILTER_VALIDATE_BOOLEAN);
    }
    public function setEmail($email){
        $this->email = (string) $email;
    }
    public function setRelConsumo($rel_consumo){
        $this->rel_consumo = filter_var($rel_consumo, FILTER_VALIDATE_BOOLEAN);
    }
    public function setRelPedidos($rel_pedidos){
        $this->rel_pedidos = filter_var($rel_pedidos, FILTER_VALIDATE_BOOLEAN);
    }
    public function setValidadeSenha($validade_senha){
        $this->validade_senha = $validade_senha;
    }

    public function __construct(){
        $this->load->database();
    }

    /**
     * Verifica dados de acesso - Data Validade é a data máxima de permissão.
     */
    public function verificaDados($validade){
        $dtAtual = new DateTime();
        $dtValidade = new DateTime($validade);
        $expirada = FALSE;
        //$dias = $atual->diff($data_registro);
        //if($dias->days > 90)
        if($dtAtual > $dtValidade)
            $expirada = TRUE;
        
        if($expirada){
            $dados_verificados = array('expirada'=> TRUE, 'acesso' => FALSE);
        // }else if($dados['primeiro_acesso']){
        //     $dados_verificados = array('primeiro_acesso' => TRUE, 'acesso' => FALSE));
        // }
        }else{
            $dados_verificados = array('acesso' => TRUE);
        }
        return $dados_verificados;
    }

    /**
     *  Verifica se a senha a ser atualizada não está entre as já cadastradas anteriormente
     */
    public function verificaSenhasAnteriores($usuarioId, $senha){
        $this->db->where(array('webloginid' => $usuarioId, 'senha' => $senha));
        $this->db->from('web_login_senhas_anteriores');
        return ($this->db->count_all_results() === 0) ? TRUE : FALSE; 
    }





    public function buscar(){     
        $empresa['empresasiteid ='] = $this->session->fiscal_empresa;  
        $query = $this->db->get_where('web_grupos_acesso', $empresa);   

        // print_r($query->result());
        return $query->result();
    }



    // public function buscar($grupoacessoid){      

    //     $this->db->select('aprovapedido, relconsumo, relpedidosaprovados, criatemplate, criarequisicao, criausuario, criagrupoacesso'); //verificar se ja tem esse nome
    //     $this->db->from('web_grupos_acesso');
    //     $this->db->where('grupoacessonome', $nome);

    //     return $query->result();
    // }



    //$usuario = string
    public function buscarID($empresa, $id){
        
            $condicao = $empresa + $id;       
            $query = $this->db->get_where('vw_web_login', $condicao);    
            
        return $query->result();
    }

    //$usuario, $novaSenha = string
    public function atualizar($usuarioId, $novaSenha){
        $historico_senha = array(
            'webloginid' => $usuarioId,
            'senha' => $novaSenha
        );        

        $this->db->trans_start();
            $this->db->where('webloginid', $usuarioId);
            $this->db->update('web_login', array('senha' => $novaSenha));
            $this->db->where('webloginid', $usuarioId);
            $this->db->from('web_login_senhas_anteriores');
            if($this->db->count_all_results() === 6):
                $this->db->where('webloginid', $usuarioId);
                $this->db->select_min('webSenhasAnterioresID');
                $result = $this->db->get('web_login_senhas_anteriores')->result();
                $this->db->delete('web_login_senhas_anteriores', array('webSenhasAnterioresID' => $result[0]->webSenhasAnterioresID));
            endif;
            $this->db->insert('web_login_senhas_anteriores', $historico_senha);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }





    
    public function editar($nome, $novoNome, $novoRel_aprovacao, $novoRel_consumo, $novoAprova_pedido, $novoCria_template, $novoCria_requisicao, $novoCria_usuario, $novoCria_grupoacesso, $novoCria_aviso, $novoResponde_sugestao){ 

        $this->db->select('grupoacessonome'); //verificar se ja tem esse nome
        $this->db->from('web_grupos_acesso');
        $this->db->where('grupoacessonome', $novoNome);
        $result = $this->db->get()->result();          

        
        if(!$result){
    
            if($novoNome !== ''){
                $data['grupoacessonome'] = $novoNome;
            }
    
            if($novoRel_aprovacao !== ''){
                $data['relpedidosaprovados'] = $novoRel_aprovacao;
            }
    
            if($novoRel_consumo !== ''){
                $data['relconsumo'] = $novoRel_consumo;
            }
    
            if($novoAprova_pedido !== ''){
                $data['aprovapedido'] = $novoAprova_pedido;
            }
    
            if($novoCria_template !== ''){
                $data['criatemplate'] = $novoCria_template;
            }

            if($novoCria_requisicao !== ''){
                $data['criarequisicao'] = $novoCria_requisicao;
            }

            if($novoCria_usuario !== ''){
                $data['criausuario'] = $novoCria_usuario;
            }

            if($novoCria_grupoacesso !== ''){
                $data['criagrupoacesso'] = $novoCria_grupoacesso;
            }

            if($novoCria_aviso !== ''){
                $data['criaaviso'] = $novoCria_aviso;
            }

            if($novoResponde_sugestao !== ''){
                $data['respondesugestao'] = $novoResponde_sugestao;
            }


        
            try{
                $this->db->trans_start(); //PARA ADICIONAR NOVO GACCESS
                $this->db->where('grupoacessonome', $nome);
                $this->db->update('web_grupos_acesso', $data);
                
                $this->db->trans_complete(); 

                $trans = $this->db->trans_status();
                $erro = $this->db->error();

                return array(
                    'status' => $trans,
                    'msg' => $erro
                );
            }catch(Exception $e){
                log_message('error', $e->getMessage());
                return FALSE;
            }    
        }                 
        else{                      
            return array(
                'status' => FALSE,
                'msg' => "Nome Indisponível!"
            );       
        }           

    }





    public function criar($nome, $aprova_pedido, $cria_template, $cria_requisicao, $cria_usuario, $cria_grupoacesso, $cria_aviso, $responde_sugestao, $relatorio_consumo, $relatorio_aprovacao){ 

        $this->db->select('grupoacessonome'); //verificar se ja tem esse nome
        $this->db->from('web_grupos_acesso');
        $this->db->where('grupoacessonome', $nome);
        $result = $this->db->get()->result();          

        
        if(!$result){
            $data['empresasiteid'] = $this->session->fiscal_empresa;
            $data['grupoacessonome'] = $nome; 
            $data['aprovapedido'] = $aprova_pedido;
            $data['relconsumo'] = $relatorio_consumo;
            $data['relpedidosaprovados'] = $relatorio_aprovacao;
            $data['criatemplate'] = $cria_template;
            $data['criarequisicao'] = $cria_requisicao;
            $data['criausuario'] = $cria_usuario;
            $data['criagrupoacesso'] = $cria_grupoacesso;
            $data['criaaviso'] = $cria_aviso;
            $data['respondesugestao'] = $responde_sugestao;
        
            try{
                $this->db->trans_start(); //PARA ADICIONAR NOVO GACCESS
                $this->db->insert('web_grupos_acesso', $data);
                $this->db->trans_complete(); 

                $trans = $this->db->trans_status();
                $erro = $this->db->error();

                return array(
                    'status' => $trans,
                    'msg' => $erro
                );
            }catch(Exception $e){
                log_message('error', $e->getMessage());
                return FALSE;
            }    
        }                 
        else{                      
            return array(
                'status' => FALSE,
                'msg' => "Nome Indisponível!"
            );       
        }           

    }





    


    public function excluir($nome){

        $data = array();            
        $data['grupoacessonome'] = $nome;

            
        try{
            $this->db->trans_start();
            
            $this->db->delete('web_grupos_acesso', $data);

            $this->db->trans_complete();
            
            $trans = $this->db->trans_status();                

            $erro = $this->db->error();
            return array(
                'status' => $trans,
                'msg' => $erro
                );
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return FALSE;
        }  
    }  
       
    






}



