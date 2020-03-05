<?php

class Setor_model extends CI_Model {

    private $database;

    public function __construct(){
        $this->database = $this->load->database($this->session->pasta, TRUE);
    }

    /**
     * GET/Action
     */
    public function listar($setor){
        $this->database->select('s.nome, s.id_centro_custo as cc, c.cnpj, c.fantasia, s.id_depto');
        $this->database->from('setor s');
        $this->database->join('clientes c', 'c.cnpj = s.id_depto');
        $this->database->where('s.id_depto IN (SELECT cnpj FROM clientes WHERE mostra_site = true)', NULL, FALSE);
        $this->database->where('s.nome LIKE ', $setor.'%');
        $this->database->order_by('s.nome');
        $this->database->limit(10);
        $query = $this->database->get();
        return $query->result();
    }

    /**
     * Retorna o centro de custo do funcionário
     */
    public function subSetor($matricula, $setor = null){
        $this->database->select('s.id_centro_custo AS centro_custo');
        $this->database->from('setor s');
        $this->database->join('funcionarios f', 'f.key_setor = s.id_centro_custo');
        if(is_null($setor))
            $this->database->join('subsetor sb', 'sb.id_sub_centro_custo = s.id_centro_custo');
        $this->database->where($matricula);
        $this->database->limit(1);
        return $this->database->get()->result();
    }
}