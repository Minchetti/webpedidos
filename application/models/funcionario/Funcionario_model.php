<?php

class Funcionario_model extends CI_Model {
    
    private $database;

    public function __construct(){
        $this->database = $this->load->database($this->session->pasta, TRUE);
    }

    /**
     * GET or POST/Action
     */
    public function listarNomeMatricula($funcionario){
        // echo ("funcionariosTemplate");
        $this->database->select('f.id, f.email, f.nome, f.matricula, s.id_centro_custo as cc, s.nome as setor, f.cargo, f.data_admissao, f.key_clientes as cliente, s.id_centro_custo AS cc, key_ghe');
        $this->database->from('funcionarios f');
        $this->database->join('setor s', '(s.id_depto, s.id_centro_custo) = (f.key_clientes, f.key_setor)');
        $this->database->where('f.key_clientes IN (SELECT cnpj FROM clientes WHERE mostra_site=true)', NULL, FALSE);
        $this->database->where('f.ativo', TRUE); //MM
//$this->database->where('f.data_demissao IS NULL');        
//       $this->database->or_where('f.nome', $funcionario);
        $this->database->group_start();
        $this->database->or_where('f.matricula LIKE ', $funcionario.'%');
        $this->database->or_where('f.nome LIKE ', $funcionario.'%');
        $this->database->group_end();
        $this->database->order_by('f.nome');
        
        $this->database->limit(10);
        $query = $this->database->get();
        return $query->result();
    }




    public function listarNome($id){
        $this->database->select('f.nome');
        $this->database->from('funcionarios f');
        $this->database->where('f.matricula', $id);        
        $query = $this->database->get();
        
        return $query->result();
    }


    

    public function listarEmails(){
        $this->database->select('email');
        $this->database->from('funcionarios');     
        $query = $this->database->get();
        return $query->result();
    }


    /**
     * GET or POST/Action
     */
    public function listarMatricula($funcionario){//PODER SER DAQUI A PEGA O POST FUNCIONARIOS
        // echo ("--- funcionario_model/listarMatricula/$ funcionario ---");
        // print_r ($funcionario);       

        $this->database->select('f.id, f.nome, f.matricula, s.id_centro_custo as cc, s.nome as setor, f.cargo, f.data_admissao, f.key_clientes as cliente, s.id_centro_custo AS cc, key_ghe');
        $this->database->from('funcionarios f');
        $this->database->join('setor s', '(s.id_depto, s.id_centro_custo) = (f.key_clientes, f.key_setor)');
        $this->database->where('f.key_clientes IN (SELECT cnpj FROM clientes WHERE mostra_site=true)', NULL, FALSE);
        $this->database->where('f.matricula', $funcionario);
        $this->database->limit(1);      

        $query = $this->database->get();
        // echo 'GGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG';
        // $array =;
        // print_r (json_decode(json_encode($query->result()[0]), True));
        // print_r ([0]);
        // echo 'RRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR';
        // return json_decode(json_encode($query->result()[0]), True);
        return $query->result();

    }


    /**
     * GET or POST/Action
     */
    public function listarPorSetor($setor, $depto){
        // echo ("funcionariosTemplate3");
        // print_r($setor);
        // echo "________";
        // print_r($depto);
        $this->database->select('f.id, f.nome as nome, f.matricula, f.cargo, s.id_centro_custo as cc, s.nome as setor, f.key_ghe');
        $this->database->from('funcionarios f');
        $this->database->join('setor s', '(s.id_depto, s.id_centro_custo) = (f.key_clientes, f.key_setor)');
        $this->database->where('s.id_depto', $depto);
        $this->database->where('s.nome', $setor);
        $this->database->where('f.ativo', TRUE); //MM
        $this->database->order_by('f.nome');
        $query = $this->database->get();

        //    print_r($query->result());
    // echo "---> queryXXX ";
    // echo "<pre>";
    // print_r($query->result());
        
        return $query->result();
    }

}