<?php

class Local_model extends CI_Model {

    private $database;

    public function __construct(){
        $this->database = $this->load->database($this->session->pasta, TRUE);
    }

    /** 
     *   ERRO - Retorna os locais de entrega para o SETOR, mas não vincula o CNPJ do cliente. Refazer tabela de locais de entrega
     */

    public function listar_entrega($setor){
        $this->database->distinct(); //Verificar se o distinct permanece
        $this->database->select('le.localent AS local');
        //$this->database->from('localentrega le');
	// Alterado para View Inclui local entrega LOJA qualquer CC
        $this->database->from('vw_local_entrega le');
        //$this->database->join('setor s', 's.id_centro_custo = le.centro_custo');
        //$this->database->where('le.centro_custo', 'LOJA'); 
        //$this->database->where('s.nome', $setor);
        $this->database->order_by('le.localent', 'ASC');
        $query = $this->database->get();        
        return $query->result();     
    }
    // public function listar_entrega($id){
    //     // $this->database->distinct(); //Verificar se o distinct permanece
    //     $this->database->select('rua as local');   
    //     $this->database->select('numero as numero');   
    //     $this->database->select('cidade as cidade');   
    //     $this->database->select('bairro as bairro');  
    //     $this->database->select('estado as estado');        
    //     $this->database->from('localentrega_externo');
    //     $this->database->where('funcionarioid', $id);
    //     $query = $this->database->get();        
    //     // echo("MODEL");
    //     // echo ("<pre>");
    //     // print_r($query->result());
    //     return $query->result();     
    // }






    public function cadastrar_entrega($cep, $numero, $rua, $bairro, $cidade, $estado, $id){
        $data['localent'] = "CEP";
        $data['cep'] = $cep;
        $data['numero'] = $numero; 
        $data['rua'] = $rua; 
        $data['bairro'] = $bairro;
        $data['cidade'] = $cidade;
        $data['estado'] = $estado;
        $data['funcionarioid'] = $id;
    
        $this->database->insert('localentrega_externo', $data);
        $query = $this->database->get();
        
        return $query->result();
        
    }






    public function verificar_entrega($cep, $numero, $id){
        $this->database->select('codigo');     
        $this->database->from('localentrega_externo');
        $this->database->where('cep', $cep);
        $this->database->where('numero', $numero);
        $this->database->where('funcionarioid', $id);
        $query = $this->database->get();
        
        return $query->result();
        
    }

    public function listar_entregaExterna($id){
        // $this->database->distinct(); //Verificar se o distinct permanece
        $this->database->select('rua, numero, cidade, bairro, estado');   
        // $this->database->select('numero');   
        // $this->database->select('lex.cidade AS cidade');   
        // $this->database->select('lex.bairro AS bairro');  
        // $this->database->select('lex.estado AS estado');        
        $this->database->from('localentrega_externo lex');
        $this->database->where('funcionarioid', $id);
        $this->database->order_by('lex.numero', 'ASC');
        $query = $this->database->get();  
        return $query->result(); 
        
        // $this->database->distinct(); //Verificar se o distinct permanece
        // $this->database->select('le.localent AS local');
        // $this->database->from('localentrega le');
        // $this->database->order_by('le.localent', 'ASC');
        // $query = $this->database->get();        
        // return $query->result();  
    }




}
