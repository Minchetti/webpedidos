<?php

/**
 * Modelo responsável por trabalhar com a requisição
 */
class Requisicao_model extends CI_Model {

    private $database;

    public function __construct(){
        $this->database = $this->load->database($this->session->pasta, TRUE);
    }

    /**
     * Reserva o número da solicitação
     */
    public function getReserva(){
        $this->database->select("nextval('pedidos_solicitacao_solicitacaoid_seq') as numero");
        return $this->database->get()->result();
    }

    /*
     *  Reserva o número do pedido
     */
    public function getPedido(){
        $this->database->select("nextval('numpedido') as numero");
        return $this->database->get()->result();
    }

    public function solicitacao($pedidos, $produtos){
        // echo "CHEGOU2";
        /**
         * Um novo pedido por pessoa, exibir todas as requisições ao final
         */
        $this->database->trans_start();
            $this->database->insert_batch('pedidos_solicitacao', $pedidos);
            $this->database->insert_batch('pedidos_solicitacao_itens', $produtos);
        $this->database->trans_complete();
        return $this->database->trans_status();
    }

































    public function pedido($pedidos, $produtos){
        
        echo "<pre>";
        print_r($pedidos);

        // echo "XXXXXXXXXXXX";
        
        if(is_array($pedidos[0]['entrega_local'])){
            $x = implode($pedidos[0]['entrega_local']); 
            unset($pedidos[0]['entrega_local']);    
            array_push($pedidos[0]['entrega_local'], $x); //arrumar esse push
        }
        
        // echo "<pre>";
        // print_r($pedidos);

        // echo "XXXXXXXXXXXXXXXXXXXXXXx";

        // echo "<pre>";
        // print_r($pedidos);

        // print_r($pedidos[0]['entrega_local']);

        // echo "CHEGOU1----";
        // echo ("CHEGOU FUNCTION PEDIDO ----".$produtos);
        /**
         * Um novo pedido por pessoa, exibir todas as requisições ao final
         */
        $this->database->trans_start();
        // echo "**CHEGOU1XXX2**";
        $this->database->insert_batch('pedidos', $pedidos);
        // echo "++CHEGOU1XXX3++";
        $this->database->insert_batch('pedidos_itens', $produtos); //erro nessa linha
        // echo "##CHEGOU1XXX4##";
        $this->database->trans_complete();
        // echo "@@CHEGOU1XXX5@@";
        return $this->database->trans_status();
    }

















    
    /**
     *  Localiza pedidos efetivados
     */
    public function localizar($param, $pagina){
        // print_r($pagina);
        // echo("------------->   ");
        // echo('<pre>');
        // print_r($param);

            // $this->database->distinct();
        $this->database->select('CAST(pe.numero AS INTEGER) as numero, f.nome, pe.data_emissao, pe.status, pe.obs, pe.aprovar, pe.entrega_turno AS turno, pe.entrega_local AS entrega, fs.nome AS solicitante, fa.nome AS aprovador, pe.id_centro_custo AS cc, s.nome AS setor');
        $this->database->from('pedidos pe');
        $this->database->join('funcionarios f', '(f.matricula, f.key_clientes) = (pe.key_funcionarios, pe.key_clientes)');
        // $this->database->join('funcionarios fa', '(fa.matricula, fa.key_clientes) = (pe.key_funcionarios_aprovador, pe.key_clientes)');
        // $this->database->join('funcionarios fs', '(fs.matricula, fs.key_clientes) = (pe.key_funcionarios_solicitante, pe.key_clientes)');
        // $this->database->join('funcionarios f', 'f.matricula = pe.key_funcionarios');
        $this->database->join('funcionarios fa', '(fa.matricula, fa.ativo) = (pe.key_funcionarios_aprovador, true)');
        $this->database->join('funcionarios fs', '(fs.matricula, fs.ativo) = (pe.key_funcionarios_solicitante, true)');
        $this->database->join('setor s', 's.id_centro_custo = pe.id_centro_custo AND s.id_depto = pe.id_depto');
        if(filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)){
            $this->load->model('setor/setor_model', 'cc');
            $centro_custo = $this->cc->subSetor(array('f.matricula' => $this->session->key_funcionarios));
            if( ! empty($centro_custo[0]->centro_custo)) {
                $this->database->join('subsetor sb', 'sb.id_sub_centro_custo = s.id_centro_custo');
                $this->database->where('sb.id_centro_custo IN (SELECT sv.id_sub_centro_custo FROM subsetor sv WHERE sb.id_centro_custo = sv.id_centro_custo)', NULL, FALSE);
                $this->database->where('sb.id_centro_custo', (string) $centro_custo[0]->centro_custo);
            }
        }else{
            $this->database->where(array('fs.matricula' => $this->session->key_funcionarios));
            // $this->database->where('fs.ativo' => TRUE);
        }
        $this->database->where($param);
        $this->database->limit(10, (($pagina - 1) * 10) );
        $this->database->order_by('numero', 'DESC');
        $query = $this->database->get();
        return array(
            $query->result(),
            $query->num_rows()
        );
    }

    /**
     *  Lista todas as solicitações pendentes
     */
    public function solicitacoesPendentes($param, $pagina){

        $this->database->select('ps.solicitacaoid AS numero, f.nome, ps.data_emissao, ps.entrega_local AS entrega, ps.entrega_turno AS turno, fs.nome AS solicitante, ps.id_centro_custo AS cc, s.nome AS setor, ps.naoaprovado, ps.nooaprovado_motivo, ps.obs, fa.nome AS aprovador, ps.key_clientes, ps.key_funcionarios AS matricula, ps.key_funcionarios_solicitante, ps.key_clientes_solicitante, ps.id_depto AS depto'); //era ps.naoaprovado_motivo
        $this->database->from('pedidos_solicitacao ps');
        $this->database->join('funcionarios f', 'f.matricula = ps.key_funcionarios');
        $this->database->join('funcionarios fs', 'fs.matricula = ps.key_funcionarios_solicitante');
        $this->database->join('funcionarios fa', 'fa.matricula = ps.key_funcionarios_aprovador', 'LEFT');
        $this->database->join('setor s', 's.id_centro_custo = ps.id_centro_custo AND s.id_depto = ps.id_depto');

         if(filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)){
            $this->load->model('setor/setor_model', 'cc');
            $centro_custo = $this->cc->subSetor(array('f.matricula' => $this->session->key_funcionarios));

            if( ! empty($centro_custo[0]->centro_custo)) {
                $this->database->join('subsetor sb', 'sb.id_sub_centro_custo = s.id_centro_custo');
                $this->database->where('sb.id_centro_custo IN (SELECT sv.id_sub_centro_custo FROM subsetor sv WHERE sb.id_centro_custo = sv.id_centro_custo)', NULL, FALSE);
                $this->database->where('sb.id_centro_custo', (string) $centro_custo[0]->centro_custo);
            }
        }else{
            $this->database->where(array('fs.matricula' => $this->session->key_funcionarios));
        }

        $this->database->where($param);
        $this->database->limit(10, (($pagina - 1) * 10) );
        $this->database->order_by('numero', 'DESC');
        $query = $this->database->get();
        return array(
            $query->result(),
            $query->num_rows()
        );
    }

    private function excluirSolicitacao($solicitacao){
        $this->database->trans_start();
            $this->database->delete(array('pedidos_solicitacao_itens'), array('fk_solicitacaoid' => $solicitacao));
            $this->database->delete('pedidos_solicitacao', array('solicitacaoid' => $solicitacao));
        $this->database->trans_complete();
    }

    /**
     *  $cliente_aprovador = key_clientes_aprovador
     *  $aprovador = $key_funcionarios_aprovador
     */
    private function desaprovarSolicitacao($solicitacao, $motivo, $cliente_aprovador, $aprovador){
        $this->database->where(array('solicitacaoid' => $solicitacao));
        return $this->database->update('pedidos_solicitacao', 
            array('naoaprovado_motivo' => $motivo, 'naoaprovado' => TRUE, 'key_funcionarios_aprovador' => $aprovador, 'key_clientes_aprovador' => $cliente_aprovador, 'dh_aprovacao' => date('Y-m-d H:i:s')));
    }

    public function aprovar($n_solicitacao, $aprovar, $motivo = NULL){
        // echo('CHEGOU5');
        $produto = array();
        $entrega = array();
        $callback = FALSE;
        $this->load->model('produto/produto_model', 'produto');
        $this->load->model('funcionario/funcionario_model', 'funcionario');
        $solicitacao = $this->solicitacoesPendentes(array('ps.solicitacaoid' => (int) $n_solicitacao), 1);
        $produtos = $this->produto->itensSolicitacao(array('psi.fk_solicitacaoid' => (int) $n_solicitacao));
        $departamento = $this->funcionario->listarMatricula($this->session->key_funcionarios);
        
        if(filter_var($aprovar, FILTER_VALIDATE_BOOLEAN)){
            $reserva = $this->getPedido();
            /**
            * Efetivação de pedidos
            */
            foreach($solicitacao[0] AS $pedido):
                $requisicao[] = array(
                    'numero' => (string) $reserva[0]->numero,
                    'key_clientes' => $pedido->key_clientes,
                    'data_emissao' => date('Y-m-d'),
                    'id_depto' => $pedido->depto,
                    'id_centro_custo' => $pedido->cc,
                    'key_funcionarios' => $pedido->matricula,
                    'key_clientes_solicitante' => (string) $pedido->key_clientes_solicitante,
                    'key_funcionarios_solicitante' => (string) $pedido->key_funcionarios_solicitante,
                    'key_clientes_aprovador' => (string) $departamento[0]->cliente,
                    'key_funcionarios_aprovador' => (string) $this->session->key_funcionarios,
                    'obs' => $pedido->obs,
                    'dh_aprovacao' => date('Y-m-d H:i:s'),
                    'data_fechado' => NULL,
                    'aprovar' => TRUE,
                    'status' => 'Aberto',
                    'entrega_local' => $pedido->entrega,
                    'entrega_turno' => (int) $pedido->turno
                );
            endforeach;
        
            foreach($produtos AS $key => $item) :
                $produto[] = array(
                        'key_pedidos' => $reserva[0]->numero,
                        'key_clientes' => $pedido->key_clientes,
                        'key_produtos' => $item->codigo,
                        'key_partnumber' => $item->key_partnumber,
                        'quantidade' => $item->quantidade,
                        'valor' => $item->preco,
                        'numero_item' => $item->numero_item
                );
            endforeach;
            
            if($this->pedido($requisicao, $produto)){
                $callback = TRUE;
                $this->excluirSolicitacao((int)$n_solicitacao);
            }

            return array(
                'callback' => $callback,
                'reserva' => (string) $reserva[0]->numero,
                'solicitacao' => $n_solicitacao
            );
        }else{
            
            return array(
                'callback' => $this->desaprovarSolicitacao($n_solicitacao, $motivo, $departamento[0]->cliente, $this->session->key_funcionarios),
                'solicitacao' => str_pad($n_solicitacao, 10, '0', STR_PAD_LEFT)
            );
        }
    }

    //Total pedidos
    public function total($param){
        
        // echo "TOTAL PEDIDOS";
        $this->database->select('CAST(pe.numero AS INTEGER) as numero');
        $this->database->from('pedidos pe');
        $this->database->join('funcionarios f', 'f.matricula = pe.key_funcionarios');
        $this->database->join('funcionarios fa', 'fa.matricula = pe.key_funcionarios_aprovador');
        $this->database->join('funcionarios fs', 'fs.matricula = pe.key_funcionarios_solicitante');
        $this->database->join('pedidos_local pl', 'pl.key_pedidos = pe.numero');
        $this->database->where($param);
        $this->database->order_by('numero', 'DESC');
        $query = $this->database->get();
        return $query->num_rows();
    }

    //Total solicitação
    public function totalSolicitacao($param){
        
        // echo "TOTAL SOLICITAÇÃO";
        $this->database->select('ps.solicitacaoid AS numero');
        $this->database->from('pedidos_solicitacao ps');
        $this->database->join('funcionarios f', 'f.matricula = ps.key_funcionarios');
        $this->database->join('funcionarios fs', 'fs.matricula = ps.key_funcionarios_solicitante');
        $this->database->join('funcionarios fa', 'fa.matricula = ps.key_funcionarios_aprovador', 'LEFT');
        $this->database->join('pedidos_solicitacao_itens psl', 'fk_solicitacaoid = ps.solicitacaoid'); //troquei para pedidos_solicitacao_itens era pedidos_solicitacao_local
        $this->database->join('setor s', 's.id_centro_custo = ps.id_centro_custo');
        $this->database->where($param);
        $this->database->order_by('numero', 'DESC');
        $query = $this->database->get();
        return $query->num_rows();
    }




    //qntd req Feitas pro grafico
    public function contarRequisicoes($matricula, $mes, $ano){ 
        $this->database->select('numero, data_emissao, key_funcionarios_solicitante, key_funcionarios');
        $this->database->from('pedidos');
        $this->database->where('key_funcionarios_solicitante', $matricula);
        $this->database->where('extract (month from data_emissao) =', $mes);
        $this->database->where('extract (year from data_emissao) =', $ano);
        $this->database->or_where('key_funcionarios', $matricula);
        $this->database->where('extract (month from data_emissao) =', $mes);
        $this->database->where('extract (year from data_emissao) =', $ano);
        
        $query = $this->database->get();

        // print_r($query->result());
        // print_r($query->num_rows());

        // return $query->num_rows();
        return $query->result();
    }
    

}