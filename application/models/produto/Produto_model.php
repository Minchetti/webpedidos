<?php

class Produto_model extends CI_Model {

    private $database;

    public function __construct(){
        
        $this->database =  $this->load->database($this->session->pasta, TRUE);
    }
    /*
    public function B($cliente, $setor, $produto, $pagina = 1){
        $this->database->select('key_produtos AS codigo, key_partnumber AS partnumber, unidade, descricao, op_ca AS ca, preco');
        $this->database->from("fc_web_produtos_permitidos('{$cliente}', '{$setor}')");
        $this->database->where('descricao LIKE ' , $produto.'%');
        $this->database->limit(10, (($pagina - 1) * 10) );
        $query = $this->database->get();
        return array(
            $query->result(),
            $query->num_rows()
        );
    }
    */
    // PRODUTOS PERMITIDOS PARA GHE
    public function permitidos($cliente, $setor, $ghe, $produto, $pagina = 1){
    // echo "test de fogo";

    // echo " PRODUTO MODEL ";
    // echo "---> cliente ";
    // echo "<pre>";
    // print_r($cliente);
    
    // echo "---> setor ";
    // echo "<pre>";
    // print_r($setor);
    
    // echo "---> ghe ";    
    // echo "<pre>";
    // print_r($ghe);
    
    // echo "---> produto ";
    // echo "<pre>";
    // print_r($produto);
    
    // echo "---> pagina ";
    // echo "<pre>";
    // print_r($pagina);

        // if($produto != NULL)
        // $pagina = $produto;

        
        // if($pagina != NULL)
        // $produto = $pagina;
      

        // $pagina = 1;  //adicionaie para forçar
        
        if ($pagina == 0 || $pagina == 1){ //TESTE MIKA
            $offset = 0;
        }
        else if($pagina > 1){
            $offset = ($pagina - 1) * 10;
        }
        
        
        
        // if ($produto >= 1){ //adicionaie para forçar
        //     $produto = null;
        // }
        // $ghe = null;


        if ($ghe == NULL){ //adicionei essa logica para funcionar com SETOR tambem /ERRO AQUI
            $this->database->select('key_produtos AS codigo, key_partnumber AS partnumber, unidade, descricao, op_ca AS ca, preco');
            $this->database->from("fc_web_produtos_permitidos2('{$cliente}', '{$setor}')");
            $this->database->where('descricao LIKE ' , $produto.'%');
            $this->database->limit(10, $offset);  
            $query = $this->database->get();

            // echo "---> query";
            // echo "<pre>";
            // print_r($query);
            
            return array(
                $query->result(),
                $query->num_rows()
            );
        }
        else{
            $this->database->select('key_produtos AS codigo, key_partnumber AS partnumber, unidade, descricao, op_ca AS ca, preco');
            $this->database->from("fc_web_produtos_permitidos_ghe2('{$cliente}', '{$ghe}')");
            $this->database->where('descricao LIKE ' , $produto.'%');
            $this->database->limit(10, $offset); //trocar $pagina por 1 ou - por +
            $query = $this->database->get();

            // echo "---> query 2";
            // echo "<pre>";
            // print_r($query);

            return array(
                $query->result(),
                $query->num_rows()
            );
        }        
        
        
    }
    // cliente: 44.013.159/0031-31
    // setor: 75008280
    // produto: 
    // pagina: 1
    // cliente: 44.013.159/0031-31
    // setor: 75008280
    // ghe: 
    // produto: 1
    /*
    public function total($cliente, $setor, $produto){
        $this->database->where('descricao LIKE ' , $produto.'%');
        $query = $this->database->get("fc_web_produtos_permitidos('{$cliente}', '{$setor}')");
        return $query->num_rows();
    }
    */

    public function total($cliente, $ghe, $produto){
        // echo "test de fogo2";
        $this->database->where('descricao LIKE ' , $produto.'%');
        $query = $this->database->get("fc_web_produtos_permitidos_ghe2('{$cliente}', '{$ghe}')");
        return $query->num_rows();
    }


    public function itensRequisicao($numero){
        // echo "test de fogo3";
        $this->database->select('p.codigo, p.descricao, p.op_ca AS ca ,pi.key_pedidos, pi.key_clientes, pi.key_partnumber, p.unidade, pi.quantidade, pi.valor');
        $this->database->from('pedidos_itens pi');
        $this->database->join('produtos p', 'p.codigo = pi.key_produtos');
        $this->database->where($numero);
        return $this->database->get()->result();
    }

    public function itensSolicitacao($solicitacao){
        // echo "test de fogo4";
        $this->database->select('p.descricao, p.unidade, p.preco, p.op_ca AS ca, psi.numero_item, psi.key_produtos AS codigo,  psi.key_partnumber, psi.quantidade, SUM(psi.quantidade * p.preco) as valor_total_item');
        $this->database->from('pedidos_solicitacao_itens psi');
        $this->database->join('produtos p', 'p.codigo = psi.key_produtos');
        $this->database->where($solicitacao);
        $this->database->group_by('1,2,3,4,5,6,7,8');
        $this->database->order_by('psi.numero_item', 'ASC');
        return $this->database->get()->result();
    }

    /**
     *  Retorna todos os itens da template vinculados a determinado usuário
     */
    public function itensTemplate($template_funcionarios){ //AQUIIIIII
        // echo "*************** ENTROU EM ITENS TEMPLATE ************";

        
        // echo '<pre> --- TEMPLATE_FUNCIONARIOS ---> ';
        // print_r($template_funcionarios);

        
        // echo '<pre> --- TEMPLATE_FUNCIONARIOS [ID] ---> ';
        // print_r($template_funcionarios[id]);

        $this->database->select('key_produtos AS codigo, quantidade, key_partnumber AS partnumber,(SELECT preco FROM produtos WHERE codigo = key_produtos LIMIT 1) AS preco');
        $this->database->from('template_funcionarios_itens'); //tireio o S
        $this->database->where('key_templates_funcionarios', $template_funcionarios['id']);
        // echo ($this->database->get()->result());
        return $this->database->get()->result();
    }

}