<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto extends CI_Controller {

    # fc_produtos_permitidos(cliente, setor);
    public function permitidos(){
        
        //Implementar validação
        $produtos_permitidos = array();
        $cliente = (string) $this->input->post_get('cliente');
        $setor = (string) $this->input->post_get('setor');
        $ghe = (string) $this->input->post_get('ghe');
        $produto = (string) $this->input->post_get('produto');
        $pagina = (int) $this->input->post_get('pagina');


        
        // echo "---> CLIENTE ";
        //     echo "<pre>";
        //     print_r($cliente);
        
        // echo "---> SETOR ";
        //     echo "<pre>";
        //     print_r($setor);
        
        // echo "---> GHE ";
        //     echo "<pre>";
        //     print_r($ghe);
        
        // echo "---> PRODUTO ";
        //     echo "<pre>";
        //     print_r($produto);
        
        // echo "---> PAGINA ";
        //     echo "<pre>";
        //     print_r($pagina);

        $this->load->model('produto/produto_model', 'produto');
        // $produto = null;
        // echo "---> MAOI 2";
       // $produtos = $this->produto->permitidos(trim($cliente), trim(strtoupper($setor)), trim(strtoupper($produto)), $pagina);


        $produtos = $this->produto->permitidos(trim($cliente),  trim(strtoupper($setor)), trim($ghe), trim(strtoupper($produto)), $pagina);


        // echo "---> MAOI 3";
        foreach($produtos[0] AS $key => $item) :
            $produtos_permitidos[] = array(
                'codigo' => (string) $item->codigo,
                'partnumber' => (string) utf8_encode($item->partnumber),
                'unidade' => (string) utf8_encode($item->unidade),
                'descricao' => (string) utf8_encode($item->descricao),
                'ca' => (string) $item->ca,
                'preco' => (string) $item->preco
            );
        endforeach;

        $retorno = array(
   //         'total' => $this->produto->total(trim($cliente), trim(strtoupper($setor)), trim(strtoupper($produto))),
            'total' => $this->produto->total(trim($cliente), trim(strtoupper($setor)), trim(strtoupper($ghe)), trim(strtoupper($produto))),
            'produtos' => $produtos_permitidos,
            'retornado' => $produtos[1]
        );

        // echo "---> RETORNO ";
        //     echo "<pre>";
        //     print_r($retorno);

        $this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($retorno));
    }













    public function requisicaoItens(){
        $itens_requisicao = array();
        $this->load->model('produto/produto_model', 'produto');
        $itens = $this->produto->itensRequisicao(array('pi.key_pedidos' => (string) $this->input->post('requisicao')));

        foreach($itens AS $item):
            $itens_requisicao[] = array(
                'codigo' => $item->codigo,
                'descricao' => utf8_encode($item->descricao),
                'ca' => $item->ca,
                'partnumber' => utf8_encode($item->key_partnumber),
                'unidade' => utf8_encode($item->unidade),
                'qty' => $item->quantidade
            );
        endforeach;

        $this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($itens_requisicao));

    }

     public function solicitacaoItens(){
        $itens_requisicao = array();
        $this->load->model('produto/produto_model', 'produto');
        $itens = $this->produto->itensSolicitacao(array('psi.fk_solicitacaoid' => (string) $this->input->post('requisicao')));

        if($this->session->userdata('mostrar_valores')){
            foreach($itens AS $item):
                $itens_requisicao[] = array(
                    'codigo' => $item->codigo,
                    'descricao' => utf8_encode($item->descricao),
                    'ca' => $item->ca,
                    'partnumber' => utf8_encode($item->key_partnumber),
                    'unidade' => utf8_encode($item->unidade),
                    'qty' => $item->quantidade,
                    'valor_total_item' => $item->valor_total_item,
                    'valor_exibicao_item' => number_format($item->valor_total_item, 2, ',', '.')
                );
            endforeach;
            $total = array_sum(array_column($itens_requisicao, 'valor_total_item'));

            $this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode(array(
                'itens' => $itens_requisicao,
                'total' => number_format($total, 2, ',', '.'),
                'parametros' => TRUE
            )));
        }else{
             foreach($itens AS $item):
                $itens_requisicao[] = array(
                    'codigo' => $item->codigo,
                    'descricao' => utf8_encode($item->descricao),
                    'ca' => $item->ca,
                    'partnumber' => utf8_encode($item->key_partnumber),
                    'unidade' => utf8_encode($item->unidade),
                    'qty' => $item->quantidade
                );
            endforeach;

            $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode(array(
                    'itens' => $itens_requisicao,
                    'parametros' => FALSE
                )));
        }

    }


}
