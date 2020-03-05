<?php

class Relatorio_model extends CI_Model {
    public function __construct(){
        $this->db = $this->load->database($this->session->pasta, TRUE);
    }

    public function gerarConsumo($num_inicial, $num_final, $data_inicial, $data_final, $matricula, $nome, $turno, $setor, $status_apr, $status_req){
  
            $dtInici = ''; // Data de Emissão Inicial
            $dtFinal = ''; // Data de Emissão Final
            // $codSetor = ''; //Codigo Setor
            // $nmSetor = ''; // Nome do Setor
            // $nmUsuar = ''; // Nome do Usuário
            $cdFunci = ''; // Matricula do Funcionário

            $num_inicial_ = '';
            $num_final_ = '';
            $turno_ = '';
            $status_apr_ = '';
            $status_req_ = '';
            // $cdSubSetor = ''; //codigo subsetor
            // $nmSubSetor = ''; //nome do subsetor
            // $nmUsuario = ''; //nome do usuario
        
            // if (isset($_POST['dtInici'])) {
            //     $dtInici = utf8_decode($_POST['dtInici']);
            // }

            if($data_inicial !== ''){
                $dtInici = $data_inicial;
            }

            if($num_inicial !== ''){
                $num_inicial_ = $num_inicial;
            }
            if($num_final !== ''){
                $num_final_ = $num_final;
            }
            if($status_apr !== ''){
                $status_apr_ = $status_apr;
            }
            
            
            
            // if($turno !== ''){
            //     $turno_ = $turno;
            // }

            // if($num_inicial !== ''){
            //     $status_apr_ = $num_inicial;
            // }
            // if($num_final !== ''){
            //     $status_req_ = $num_final;
            // }
    
            if($data_final !== ''){
                $dtFinal = $data_final;
            }

            // if($nome !== ''){
            //     $nmUsuar = $nome;
            // }
            if($matricula){
                // echo "AAAAAAAA";
                // print_r($matricula);
                $cdFunci = $matricula;
            }
        
        
            //$cmdWhere = " where rm.key_clientes = '10.394.422/0001-42' ";
        
            // $cmdWhere = " WHERE true AND f.nome <> 'FITASSUL' AND v.key_clientes in (select cnpj from clientes where mostra_site=true)";
        
        
            //******************************* PERIODO *******************************//
            // Data inicial diferente de vazio e final igual a vazio
            if ($dtInici != '' && $dtFinal == '') {
                // $cmdWhere .="  AND v.data_emissao >='" . $dtInici . "'";                
                $this->db->where('v.data_emissao >= ', $dtInici);
            }
        
            // Data Inicial igual a vazio e final diferente de vazio
            if ($dtInici == '' && $dtFinal != '') {
                // $cmdWhere .= "  AND v.data_emissao ='" . $dtFinal . "'";                
                $this->db->where('v.data_emissao ', $dtFinal);
            }
        
            // Data Inicial e Final diferentes de vazio
            if ($dtInici != '' && $dtFinal != '') {
                // $cmdWhere .= "  AND v.data_emissao BETWEEN '" . $dtInici . "' AND '" . $dtFinal . "'";                
                // $this->db->where("v.data_emissao BETWEEN,  '.$dtInici.' AND ".$dtFinal.");                
                $this->db->where('v.data_emissao >=', $dtInici);
                $this->db->where('v.data_emissao <=', $dtFinal);              
            }
            ///////////////////////////////////////////////////////////////////////////


             //******************************* PERIODO NUM PEDIDO*******************************// MMMM ARRUMAR ESSES CAST DO PERIODO pq o rm é var e o num é int
            // PERIODO inicial diferente de vazio e final igual a vazio
            if ($num_inicial_ != '' && $num_final_ == '') {
                // $cmdWhere .="  AND v.rm >='" . $num_inicial_ . "'";
                $this->db->where('CAST(v.rm AS int) >= ', $num_inicial_);
            }
        
            // PERIODO Inicial igual a vazio e final diferente de vazio
            if ($num_inicial_ == '' && $num_final_ != '') {
                // $cmdWhere .= "  AND v.rm ='" . $num_final_ . "'";
                $this->db->where('CAST(v.rm AS int) <= ', $num_final_);
            }
        
            // PERIODO Inicial e Final diferentes de vazio
            if ($num_inicial_ != '' && $num_final_ != '') {
                // $cmdWhere .= "  AND v.rm BETWEEN '" . $num_inicial_ . "' AND '" . $num_final_ . "'";
                $this->db->where('CAST(v.rm AS int) BETWEEN ' .$num_inicial_. ' AND ' .$num_final_. '');
            }
            ////////////////////////////////////////////////////////////////////////////////

            //********************************* STATUS APR  *******************************//
        
        
            if ($status_apr_ != '' && $status_apr_ != 'Todos' ) {
                if ($status_apr_ === 'Aprovado')
                $x = 'NF';
                
                if ($status_apr_ === 'Aguardando')
                $x = 'AB';

                // print_r($status_apr_);
                // $cmdWhere .= " AND sb.id_centro_custo ='" . $codSetor . "'";
                $this->db->where('v.status ', $x);
            }


            //********************************* SETOR *******************************//
                
            if ($setor != '') {
                // $cmdWhere .= " AND sb.id_centro_custo ='" . $codSetor . "'";
                $this->db->where('v.id_centro_custo ', $setor);
            }
            
            ///////////////////////////////////////////////////////////////////////////
            //****************************** FUNCIONARIO ****************************//
        
            if ($cdFunci) {
                // print_r($cdFunci);
                // echo ("BBBBBBBBBBBBBBBBB");
                // $cmdWhere .= " AND f.matricula = '" . $cdFunci . "'";
                $this->db->where('f.matricula ', $cdFunci);
            }
        
            ///////////////////////////////////////////////////////////////////////////
            //****************************** SOLICITANTE ****************************//
        
            // if ($nmUsuario != '') {
            //     $cmdWhere .= " AND (u.key_funcionarios = '" . $nmUsuario . "')";
            // }
        
        
            ///////////////////////////////////////////////////////////////////////////
        
            $data = date('Y-m-d');
            // $this->database->select('v.rm as requisicao, TO_CHAR(cast(v.data_emissao as date), 'dd/mm/YYYY') as Data_Entrega, TO_CHAR(cast(nf.emissao as date), 'dd/mm/YYYY') AS Data_Faturamento,
            $matricula_user = $this->session->key_funcionarios;

           
            $this->db->distinct();
            $this->db->select('v.rm as requisicao, (cast(v.data_emissao as date)) as Data_Entrega, 
            (cast(nf.emissao as date)) AS Data_Faturamento,
             v.id_centro_custo as CC, f.nome as funcionario, v.key_funcionarios as matricula,
             po.descricao as Produto, vi.key_partnumber as Partnumber, po.op_ca as CA, vi.quantidade,
             (vi.valor) as Vl_Unit,
             pe.data_emissao as Data_Emissao, fu.nome as Solicitante, fu.matricula as smatricula, pl.localentrega as Local_Entrega');
                $em = "'EM'";

            $this->db->from('vendas v');

            $this->db->join('vendas_item vi', 'v.rm = vi.key_vendas AND v.item = vi.key_vendas_item');
            $this->db->join('funcionarios f', 'v.key_funcionarios = f.matricula');
            $this->db->join('produtos po', 'vi.key_produtos = po.codigo');
            $this->db->join('setor s', 's.id_centro_custo = v.id_centro_custo');
            $this->db->join('pedidos pe', '(pe.numero, pe.key_clientes) = (v.rm, v.key_clientes)');
            $this->db->join('pedidos_local pl', 'pe.numero = pl.key_pedidos');
            // $this->db->join('usuario u', 'pe.key_usuario = u.codigo');
            // $this->db->join('funcionarios fu', 'fu.matricula = u.key_funcionarios AND pe.id_depto = s.id_depto');
            $this->db->join('funcionarios fu', 'fu.matricula = '."'$matricula_user'".' AND pe.id_depto = s.id_depto'); //mudei aqui tambvem
            $this->db->join('nota_fiscal nf', 'v.key_nota_fiscal = nf.codigo and nf.status = '.$em);
            // $this->db->where('pe.key_funcionarios_solicitante', $this->session->key_funcionarios); //coloquei pra vincular com o usuario solicitante //tirei essa linha
            $this->db->order_by('2', '1');
            
            $this->db->limit(1000);
            
            $this->db->trans_complete(); 
            $result = $this->db->get()->result();
            
        // print_r($result);





        
            // Abrirdatabase();
            
            // $cmd = "SELECT DISTINCT v.rm as requisicao, TO_CHAR(cast(v.data_emissao as date), 'dd/mm/YYYY') as Data_Entrega, TO_CHAR(cast(nf.emissao as date), 'dd/mm/YYYY') AS Data_Faturamento, "
            //         . " v.id_centro_custo as CC, f.nome as funcionario, v.key_funcionarios as matricula, "
            //         . " po.descricao as Produto, vi.key_partnumber as Partnumber, po.op_ca as CA, vi.quantidade, "
            //         . " cast(vi.valor as numeric (16,2)) as Vl_Unit, 'R$ ' || cast((quantidade*valor) as numeric (16,2)) as Vl_Tot, "
            //         . " pe.data_emissao as Data_Emissao, fu.nome as Solicitante, fu.matricula as smatricula, pl.localentrega as Local_Entrega "
            //         . " FROM vendas v "
            //         . " INNER JOIN vendas_item vi on v.rm = vi.key_vendas AND v.item = vi.key_vendas_item "
            //         . " LEFT JOIN funcionarios f on v.key_funcionarios = f.matricula "
            //         . " LEFT JOIN produtos po on vi.key_produtos = po.codigo"
            //         . " INNER JOIN setor s on s.id_centro_custo = v.id_centro_custo "            
            //         . " LEFT JOIN pedidos pe on (pe.numero, pe.key_clientes) = (v.rm, v.key_clientes) "
            //         . " LEFT JOIN  pedidos_local pl on pe.numero = pl.key_pedidos "
            //         . " LEFT JOIN usuario u on pe.key_usuario = u.codigo "
            //         . " LEFT JOIN funcionarios fu on fu.matricula = u.key_funcionarios AND pe.id_depto = s.id_depto "
            //         . " LEFT JOIN nota_fiscal nf on v.key_nota_fiscal = nf.codigo and nf.status = 'EM' "
            //         . "{$cmdWhere}"
            //         . " ORDER BY 2,1 ";
                    
            // $result = pg_query($cmd);
            
        
            // $json = Array();
        
            // $totLinhas = pg_num_rows($result);
        
            // while ($coluna = pg_fetch_array($result)) {
            //     $json[] = array(
            //         'requisicao' => utf8_encode($coluna['requisicao']),
            //         'matricula' => utf8_encode($coluna['matricula']),
            //         'data_entrega' => utf8_encode($coluna['data_entrega']),
            //         'faturamento' =>  utf8_encode($coluna['data_faturamento']),            
            //         'cc' => utf8_encode($coluna['cc']),
            //         'descricao' => utf8_encode($coluna['produto']),
            //         'partnumber' => utf8_encode($coluna['partnumber']),
            //         'quantidade' => utf8_encode($coluna['quantidade']),
            //         'ca' => utf8_encode($coluna['ca']),
            //         'valor' => utf8_encode($coluna['vl_tot'])
            //         );
            // }
        
            // // Fechardatabase();
            // echo json_encode(array('aaData' => $json));

            return $result;
        }
        



    
}