<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Recebe extends CI_Controller {
	public function index()
	{

    $cod = $_POST['cod'];

    // print_r($cod);

    // $nome = $_POST['nome'];
    // O nome original do venda no computador do usuário
    $arqName = $_FILES['venda']['name'];

    // O tipo mime do venda. Um exemplo pode ser "image/gif"
    $arqType = $_FILES['venda']['type'];

    // O tamanho, em bytes, do venda
    $arqSize = $_FILES['venda']['size'];

    // O nome temporário do venda, como foi guardado no servidor
    $arqTemp = $_FILES['venda']['tmp_name'];

    // O código de erro associado a este upload de venda
    $arqError = $_FILES['venda']['error'];

    $extensao = explode('.', $arqName);

    // Define o novo nome do arquivo usando um UNIX TIMESTAMP
    $nome = $cod . '.' . end($extensao);

    if ($arqError == 0) {
      $pasta = __DIR__ . '\uploads/';
      $upload = move_uploaded_file($arqTemp, $pasta . $nome);

      $this->load->model('recebimento/recebimento_model', 'recebimento');
      $setarRecebido = $this->recebimento->setarRecebido($cod); 
     
      if($setarRecebido == 1){
        echo "<script language='javascript'>";
        echo "alert('Recebimento concluído com sucesso!');";
        echo "javascript:window.location='painel_recebimento';</script>";
        echo "</script>";

      }
      else{
        echo "<script language='javascript'>";
        echo "alert('ERRO ao concluír recebimento! Tente novamente!');";
        echo "javascript:window.location='painel_recebimento';</script>";
        echo "</script>";
      }
    }
    
        // var recebimento = new Recebimento();   
        // var resultado = recebimento.recebe(value.cod);
    
    // print_r($arqName);
    // echo("----");  
    // print_r($arqType);
    // echo("----");
    // print_r($arqSize);
    // echo("----");
    // print_r($arqTemp);
    // echo("----");
    // print_r($arqError);
    // echo("----");
    // print_r($arqName);





  }
}

  ?>