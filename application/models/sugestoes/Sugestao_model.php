<?php

class Sugestao_model extends CI_Model {
   
    private $database;
    

    public function __construct(){
        $this->database = $this->load->database($this->session->pasta, TRUE);
        
    }
    /**
     *  $tipo resposta/pergunta
     */
    public function ocorrencias($tipo){
        $this->database->select('codigo, matricula, setor, sugestao, dtsugestao, status, resposta, dtresposta, tipo');
        $this->database->from('sugestoes');
        $this->database->where($tipo);
        
        if($this->session->respondesugestao !== true) {
            $this->database->where('matricula', $this->session->userdata('key_funcionarios'));
        }
        
        $this->database->order_by('codigo', 'DESC');
        return $this->database->get()->result();
    }
    
    public function criar($sugestao){
        return $this->database->insert('sugestoes', $sugestao);
    }

    public function responder($resposta){

        $data = array();
        $data['resposta'] = $resposta['resposta'];
        $data['status'] = 'Respondido';
        $data['dtresposta'] = date('d/m/Y');
        
        $this->database->trans_start();
        $this->database->where('codigo', $resposta['codigo']);    
        $this->database->update('sugestoes', $data);
        
        $this->database->trans_complete();

        $return = $this->database->trans_status();
     
        // echo"1--------------------------";
        // print_r($this->database->trans_status());
        // echo"2--------------------------";
        // print_r($this->database->get()->result());
        

        return $return;
    }
}