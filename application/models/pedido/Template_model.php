<?php

class Template_model extends CI_Model {

    private $database;

    public function __construct(){
        
        // echo (" UUUUUUUUUUUUUUUUUUUUU ");
        // echo "__construct";
        $this->database = $this->load->database($this->session->pasta, TRUE);
    }

    /**
     * GET/Action
     */
    public function buscar($param){//PODER SER DAQUI A PEGA O POST FUNCIONARIOS
        $id = $param['tm.key_usuario'];
        // echo "---> PARAM ";
        //         echo "<pre>";
        //         print_r($param);
        // $param = "100";

        $this->database->select('tm.numero, f.nome AS funcionario, tm.id_centro_custo AS setor, tm.descricao AS descricao, tm.obs, tm.data_cadastro');
        $this->database->from('templates tm');
        // $this->database->join('usuario u ', 'u.codigo = tm.key_usuario', 'left');
        $this->database->join('funcionarios f ', 'f.id ='."'$id'");
        $this->database->join('setor s', '(s.id_centro_custo = f.key_setor AND s.id_depto = f.key_clientes)', 'left');

        $this->database->where($param);
        $this->database->order_by('tm.numero', 'desc');

    //    echo "---> FECTCH ";
    //             echo "<pre>";
    //             print_r($this->database->get()->result());

        return $this->database->get()->result();

    //     SELECT tm.numero,f.nome AS funcionario,s.nome AS setor, 
    //    tm.descricao AS descricao,tm.obs,tm.data_cadastro
    //     FROM templates tm
    //             join usuario u on u.codigo=tm.key_usuario
	// 	JOIN funcionarios f ON f.matricula = u.key_funcionarios
	// 	JOIN setor s ON (s.id_centro_custo = f.key_setor AND s.id_depto = f.key_clientes)
	// 	     WHERE f.matricula = '110'
    //                        ORDER BY tm.numero DESC




        
  
        // $this->database->select('tm.codigo, f.nome AS funcionario, s.nome AS setor, s.id_centro_custo AS cc, tm.codigo, tm.nome AS descricao, tm.obs, tm.data_cadastro');
        // $this->database->from('templates tm');
        // $this->database->join('funcionarios f ', 'f.matricula = tm.key_funcionarios');
        // $this->database->join('setor s', '(s.id_centro_custo = f.key_setor AND s.id_depto = f.key_clientes)');

        // $this->database->where($param);
        // $this->database->order_by('tm.codigo', 'desc');
        // return $this->database->get()->result();
    }

    /**
     *  Recupera um valor da sequencia de template
     */
    public function getNumeroTemplate(){
        
        // echo (" GGGGGGGGGGGGGGGGGGGGGGGGG ");
        $this->database->select("nextval('numtemplate') as codigo");
        return $this->database->get()->result();
    }

    /**
     * Recupera um código sequencial da tabela templates_funcionarios
     */
    public function getTemplateFuncionarios(){
        
        // echo (" NNNNNNNNNNNNNNNNNNNNNNNNNNNNN ");
        // echo "getTemplateFuncionarios";
        $this->database->select("nextval('templates_funcionarios_codigo_seq') as codigo");
        return $this->database->get()->result();
    }







    public function criar($template, $template_funcionarios, $template_funcionarios_itens){
        // echo "---> Template ";
        // echo "<pre>";
        // print_r($template);
        // echo "---> Template FUNC ";
        // echo "<pre>";
        // print_r($template_funcionarios);
        // echo "---> Template ITEMS";
        // echo "<pre>";
        // print_r($template_funcionarios_itens);
     
        try{
            $this->database->trans_start();
                $this->database->insert('templates', $template);
                $this->database->insert_batch('templates_funcionarios', $template_funcionarios);
                $this->database->insert_batch('template_funcionarios_itens', $template_funcionarios_itens); //arrumei aqui o 's'
            $this->database->trans_complete();
            
            $trans = $this->database->trans_status();
            //    echo "---> TRRANS ";
            //     echo "<pre>";
            //     print_r($trans);

            return array(
                'status' => $trans,
                'template' => ($trans) ? $template['numero'] : NULL
                );
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return FALSE;
        }
        // echo "-- FINAL --";
    }
    















//pela logica o problema ta aqui
    
    /**
     * Lista todos os funcionarios da template para seleção do local de entrega
     */
    public function listarFuncionariosTemplate($template){ //vem d template.php - um numero ex 69   //////2019 tf.key_clientes por f.key_clientes

        // echo (" LLLLLLLLLLLLLLLLLLLLLLLL ");
        // echo ("LISTAR FUNC TEMPLATE");
        // echo ($template);
        // echo ("TEMPLATE MODEL2");
        $this->database->select('tf.codigo, f.key_clientes, f.nome, tf.key_funcionarios, tf.key_funcionarios AS setor'); //f.nome - criei a coluna nome em templates_funcionarios e tirei aqui da consulta denovo. 
        $this->database->from('templates_funcionarios tf');
        $this->database->join('funcionarios f', 'f.matricula = tf.key_funcionarios AND f.key_clientes = f.key_clientes'); //AND tf.nome = f.nome
        $this->database->join('setor s', 's.id_centro_custo = f.key_setor AND s.id_depto = f.key_clientes');
        $this->database->where('tf.key_templates', "$template" ); //add as aspas pra pegar certo o valor numerico //'"'.$template.'"'
        $this->database->order_by('f.nome', 'ASC');
//DESCOBRI Q O PROBLEMA COMEÇA AQUI NO NUMERO 69
        // $teste = $this->database->get()->result();

        // echo ("RESULT NO FINAL DO MODEL*************** ");
        // print_r ($teste);  
        
        // echo ("~~~~~");
        // print_r ($template);        
        // echo "<pre>QUERY ->";
        // print_r ($this->database->get()->result());

        
        
        return $this->database->get()->result();
        // return $teste;
    }


    // select tf.codigo, tf.key_clientes, tf.key_funcionarios, tf.nome AS setor
    // from templates_funcionarios tf
    // join funcionarios f ON f.matricula = tf.key_funcionarios AND f.key_clientes = tf.key_clientes
    // join setor s ON s.id_centro_custo = f.key_setor AND s.id_depto = f.key_clientes
    // where tf.key_templates = '69' 
    // order by f.nome ASC
    
    





    










    /**
     * Detalhes da template
     */
     private function funcionariosTemplate($template){ //daqui q vem do js //aqui q tem q ter echo pra funcionar
        
        // echo (" KKKKKKKKKKKKKKKKKKK ");
         
         $this->database->select('tf.codigo, f.matricula, f.nome, f.key_clientes AS cliente, f.key_setor AS setor');
         $this->database->from('templates_funcionarios tf');
         $this->database->join('funcionarios f', 'f.matricula = tf.key_funcionarios');
         $this->database->where('tf.key_templates', $template);

        //  echo ("XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
        //  print_r ($this->database->get()->result());
         
        //  echo ("XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
        //  print_r($template);
        // echo "<pre>A";
        // print_r($this->database->get()->result());
        // die();
         
         return $this->database->get()->result();
     }



    /**
     * Método base para listagem de produtos e funcionários
     */
    public function listarFuncionariosProdutos($template){//PODER SER DAQUI A PEGA O POST FUNCIONARIOS
        
        // echo (" JJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJ ");
        // // echo "listarFuncionariosProdutos";
        // // echo '<pre>';
        // print_r($template);
        $funcionarios = $this->funcionariosTemplate($template);
        $query = array();
        // echo '<pre> JOJOJOJOJOJOJOOJ';
        // print_r($funcionarios);
        // echo (" YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY ");
        $this->database->select('tf.codigo AS funcionario, p.codigo, p.descricao, p.unidade, p.op_ca AS ca, tfi.key_partnumber, tfi.quantidade');
        $this->database->from('templates_funcionarios tf');
        $this->database->join('template_funcionarios_itens tfi', 'tfi.key_templates_funcionarios = tf.codigo');   // tirei o S
        $this->database->join('produtos p', 'p.codigo = tfi.key_produtos');
        $this->database->where('tf.key_templates', $template);
        $query = $this->database->get()->result();
        // echo (" ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ ");
        
        // print_r ($teste);
        
        // echo (" WWWWWWWWWWWWYYYYYYYYYYYYYYYYYYYYWWWWWWWWWWWW ");
        // $teste = array(
        //     'funcionarios' => $final,
        //     'produtos' => $final
        // );
        
        // echo (" WWWWWWWWWWWWYYYYYYYYYYYYYYYYYYYYWWWWWWWWWWWW ");
        // print_r ($teste);
        
        // echo (" WWWWWWWWWWWWYYYYYYYYYYYYYYYYYYYYWWWWWWWWWWWW ");
        // echo "<pre>B";
        // print_r($this->database->get()->result());
        // die();
        $retorno = array(
            'funcionarios' => $query,
            'produtos' => $query
        );
        // echo "RETORNO DA FUNC";
        // echo '<pre>';
        // print_r ($retorno);
        return $retorno;
    }













    /**
     * @var $template é um Int
     */
    public function deletar($template){
        // echo "deletar";
        $codigos = array();
        $this->database->trans_start();
            $resultado = $this->database
                            ->select('codigo')
                            ->from('templates_funcionarios')
                            ->where('key_templates', $template)
                            ->get()->result();
            /**
             * Itera os codigos da tabela template_funcionarios
             */
            if( ! empty($resultado)){
                foreach($resultado AS $codigo):
                    array_push($codigos, $codigo->codigo);
                endforeach;
            }

            $this->database->where_in('key_templates_funcionarios', $codigos);
            $this->database->delete('template_funcionarios_itens'); //tirei o S
            
            $this->database->where('key_templates', $template);
            $this->database->delete('templates_funcionarios');

            $this->database->where('numero', $template);
            $this->database->delete('templates');

        $this->database->trans_complete();

        return $this->database->trans_status();
    }










    /**
     * @var $template int 
     * @var $funcionario array
     */
    public function atualizar($template, $funcionario){
        // echo "atualizar";

    }

}