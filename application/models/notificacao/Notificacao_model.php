<?php

class Notificacao_model extends CI_Model {

     
    public function __construct(){
        $this->load->database();
    }


    // private $database;

    // public function __construct(){
        
    //     $this->database = $this->load->database($this->session->pasta, TRUE);
    // }
    
    public function manutencao(){
        $this->db->select('mensagem, dtpublicacao, dtexpiracao');
        $this->db->from('web_mensagens');
        $this->db->where('empresasiteid', (int)$this->session->fiscal_empresa);
        $this->db->where('dtexpiracao >= ', date('Y-m-d'));
        $this->db->order_by('dtpublicacao', 'DESC');
        $this->db->limit(3);
        return $this->db->get()->result();
    }

    
    public function salvar($mensagem){   

        $data['empresasiteid'] = $this->session->fiscal_empresa;
        $data['dtpublicacao'] = date('d/m/y');

        // $dataEx = date('d/m/y'); 
        $data['dtexpiracao'] = date('d/m/Y', strtotime('+ 1 month'));

        // $data['dtexpiracao'] = $dataEx;
        $data['mensagem'] = $mensagem;
        // echo date('d/m/Y', strtotime("+2 days",strtotime($dataEx))); 

        // echo '<pre>';
        // print_r($data);




        try{
            $this->db->trans_start();
            $this->db->insert('web_mensagens', $data);
            // $this->database->insert_batch('templates_funcionarios', $template_funcionarios);
            // $this->database->insert_batch('template_funcionarios_itens', $template_funcionarios_itens); //arrumei aqui o 's'
            $this->db->trans_complete();
            
            $trans = $this->db->trans_status();

            return array(
                'status' => $trans
                );
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return FALSE;
        }
    }
}