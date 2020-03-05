<?php

class Usuario_model extends CI_Model {
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
        // echo ("verificaDados");
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
        // echo ("verificaSenhasAnteriores");
        $this->db->where(array('webloginid' => $usuarioId, 'senha' => $senha));
        $this->db->from('web_login_senhas_anteriores');
        return ($this->db->count_all_results() === 0) ? TRUE : FALSE; 
    }






    //$usuario = string
    public function buscar($empresa){      
        $condicao = $empresa;       
        $query = $this->db->get_where('vw_web_login', $condicao);    
        return $query->result();
    }









    //$usuario = string
    public function buscarID($empresa, $id){     
            $condicao = $empresa + $id;       
            $query = $this->db->get_where('vw_web_login', $condicao);   
        return $query->result();
    }






     //$usuario, $novaSenha = string
     public function recuperar($usuario, $novaSenha){

        $nova_senha = array(
            'senha' => $novaSenha
        );

            $this->db->trans_start();
                // $this->db->where('webloginid', $usuarioId);  //MM
                // $this->db->where('usuario', $usuarioId);    //MM
                $this->db->where('usuario', ''.$usuario.'');  //MM
                $this->db->update('web_login', $nova_senha['senha']);
                // $this->db->from('web_login_senhas_anteriores');
                // $this->db->where('webloginid', $weblogin_id);  //MM

                
                $this->db->trans_complete(); 

                $inseriu = $this->db->trans_status();
    
            return 'SENHA ALTERADA';
    }










    //$usuario, $novaSenha = string
    public function atualizar($usuarioId, $novaSenha){
        // print_r($usuarioId);
        // print_r($novaSenha);
        // usuari
        $this->db->select('webloginid');
        $this->db->where('senha', $novaSenha);
        $this->db->where('webloginid', $usuarioId);
        $this->db->from('web_login_senhas_anteriores');
        $ja_tem_senha = $this->db->get()->result();
        // print_r($ja_tem_senha);


        $historico_senha = array(
            'webloginid' => $usuarioId,
            'senha' => $novaSenha
        );   


        // print_r($stringHistorico);
        // echo"----";

        // print_r($stringHistorico["webloginid"]);
        // print_r($stringHistorico);
        // print_r($stringHistorico->webloginid);
        // print_r($historico_senha);
        // echo"----";
        // print_r(json_decode($historico_senha));

        $nova_senha = array(
            'senha' => $novaSenha,
            'senhavalidade' => date('d/m/Y', strtotime('+ 1 year'))
        );

        if($ja_tem_senha == '' || $ja_tem_senha == null){
            // echo "entrou if";
            $this->db->trans_start();
                // $this->db->where('webloginid', $usuarioId);  //MM
                // $this->db->where('usuario', $usuarioId);    //MM
                $this->db->where('webloginid', ''.$usuarioId.'');  //MM
                $this->db->update('web_login', $nova_senha);
                // $this->db->from('web_login_senhas_anteriores');
                // $this->db->where('webloginid', $weblogin_id);  //MM

                
                $this->db->trans_complete(); 

                $inseriu = $this->db->trans_status();
                // $inseriu = $this->db->get()->result();

                print_r($inseriu);

                if($inseriu == TRUE){
                    $senha = array();
                    $senha["webloginid"] = $historico_senha['webloginid'];
                    $senha["senha"] = $historico_senha['senha'];
                    $this->db->insert("web_login_senhas_anteriores", $senha);
                }
            
                // if($this->db->count_all_results() === 6):
                //     $this->db->where('webloginid', $weblogin_id);  //MM
                //     // $this->db->where('webloginid', $usuarioId);  //MM
                //     $this->db->select_min('websenhasanterioresid');
                //     $result = $this->db->get('web_login_senhas_anteriores')->result();
                //     $x = array();
                //     $x['websenhasanterioresid'] = $result[0]->websenhasanterioresid;
                    
                //     $this->db->delete('web_login_senhas_anteriores', $x);
                // endif;

            //     $this->db->trans_complete();
            // return $this->db->trans_status();
            return 'SENHA ALTERADA';
            
        }else{
            return 'Senha já usada, inválida!';
        }
    }

    
    // //$usuario, $novaSenha = string
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






    public function criar($matricula, $id, $nome, $grupo_acesso, $email, $senha){ //MM $matricula, $cnpj, $nome, $grupo_acesso, $email

        $this->db->select('funcionarioid, usuario'); //verificar se ja tem esse usuario
        $this->db->from('web_login');
        $this->db->where('funcionarioid', $id);
        $this->db->or_where('usuario', $nome);
        // $this->db->order_by('codigo', 'DESC');
        $result = $this->db->get()->result();  
        // print_r($result);
        

        
        if(!$result){
            $data['empresasiteid'] = $this->session->fiscal_empresa;

            // $data['funcionariofilialid'] = $matricula; //arrumar
            $data['funcionarioid'] = $id; //MM
            $data['funcionariofilialmatricula'] = $matricula;
            $data['grupoacessoid'] = $grupo_acesso;
    
            $data['usuario'] = $nome;
            $data['senha'] = md5($senha);
            
            $data['senhavalidade'] = date('d/m/Y', strtotime('+ 1 year'));
            $data['email'] = $email;
            $data['ativo'] = 'true';

            // $data2['webloginid'] = $grupo_acesso;
    
            // $data['usuario'] = $nome;
            // $data['senha'] = md5($senha);
            
            // $data['senhavalidade'] = date('d/m/Y', strtotime('+ 1 year'));

            // $data['dtcadastro'] =  new DateTime();
    
            // print_r($data);
            // print_r($senha);
               
        
            try{
                $this->db->trans_start(); //PARA ADICIONAR NOVO USER
                $this->db->insert('web_login', $data);
                // $this->db->insert('web_login_senhas_anteriores', $data2);
                $this->db->trans_complete(); 

                $trans = $this->db->trans_status();
                $erro = $this->db->error();
                // $returning = pg_fetch_array($trans);
                    // print_r($teste);
                if($trans === true){
                    // print_r('TRUE');

                    $this->db->select('webloginid'); //PARA DESCOBRIR O WEBLOGINID E COLOCAR NA TABELA DE SENHAS ANTERIORES
                    $this->db->from('web_login');            
                    $this->db->where('funcionariofilialmatricula', $matricula);
                    $this->db->where('empresasiteid', $this->session->fiscal_empresa);

                    $webloginid = $this->db->get()->result()[0]->webloginid;
                    
                    // print_r($webloginid);

                    $data3['webloginid'] = $webloginid;
                    $data3['senha'] = md5($senha);
                    $data3['dtinsercao'] = date('Y-m-d');

                    // print_r($data3);

                    $this->db->insert('web_login_senhas_anteriores', $data3); //PARA ADICIONAR NA TABELA DE SENHAS ANTERIORES
                   
                } 
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
            foreach($result AS $key){
                // print_r ($key);
                if ($key->funcionarioid === $id)  {                
                    return array(
                        'status' => FALSE,
                        'msg' => "Funcionário ja cadastrado no sistema!"
                    );        
                } 
                else if($key->usuario === $nome)   {
                    return array(
                        'status' => FALSE,
                        'msg' => "Usuário ja cadastrado no sistema!"
                    );        
                }      

            }

        }           

    }





    


    public function editar($id, $novoNivel, $novoLogin){ //MM  

        $this->db->select('usuario'); //verificar se ja tem esse nome
        $this->db->from('web_login');
        $this->db->where('usuario', $novoLogin);
        $result = $this->db->get()->result(); 

 

        if(!$result || $result[0]->usuario == null){
            $data = array();
            
            if($novoNivel !== ''){
                $data['grupoacessoid'] = $novoNivel;
            }
    
            if($novoLogin !== ''){
                $data['usuario'] = $novoLogin;
            }
    
            try{
                $this->db->trans_start();
                $this->db->where('funcionarioid', $id); 
                $this->db->update('web_login', $data);
                
                $this->db->trans_complete();
                $trans = $this->db->trans_status();
                
                $erro = $this->db->error();
                return array(
                    'status' => $trans,
                    'msg' => $erro
                );
            }
            catch(Exception $e){
                log_message('error', $e->getMessage());
                return FALSE;
            }    

        }                 
        else{                   
            return array(
                'status' => FALSE,
                'msg' => "Usuário Indisponível!"
            );       
        } 
    }


    
    public function excluir($id){

        $this->db->select('webloginid'); 
        $this->db->from('web_login');
        $this->db->where('funcionarioid', $id);         
        $result = $this->db->get()->result(); 
        $web_login_id = json_encode($result[0]->webloginid);


        $delete = array();
        $delete['webloginid'] = $web_login_id;

        $this->db->delete('web_login_senhas_anteriores', $delete);       

        $data = array();            
        $data['funcionarioid'] = $id;

            
        try{
            $this->db->trans_start();
            
            $this->db->delete('web_login', $data);

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
       

  
    public function descobrirId($login){

        $this->db->select('webloginid'); 
        $this->db->from('web_login');
        $this->db->where('usuario', $login);         
        $result = $this->db->get()->result(); 
        // echo ("MODEL");
        // print_r($result);
        $web_login_id = $result[0]->webloginid;
        // echo ("MODEL2");
        // print_r($web_login_id);

        return  $web_login_id;    
    }  
    

}