<?php
$obj = new models_T0133();

foreach ($_POST["T127_pdv"] as $i => $valor) {
    
    $campos =   array("T127_cod_autorizacao" => $_POST["codAutorizacao"]
                     ,"T127_pdv" => $valor
                     ,"T127_cupom"  =>  $_POST["T127_cupom"][$i]
                     ,"T127_cod_produto" => $_POST["T127_cod_produto"][$i]
                     ,"T127_valor"  => $_POST["T127_valor"][$i]);
    
    $tabela = "T127_dados_produto_ge";
    
  $inserir =   $obj->inserir($tabela, $campos);
    
  //  echo $_POST["codAutorizacao"]."-".$valor."-".$_POST["T127_cod_produto"][$i]."-".$_POST["T127_cupom"][$i]."-".$_POST["T127_valor"][$i]."<br>";
    
}

if($inserir){
    
    
   $tabela02   = "T125_sinistro_ge";
    
    $delim02    = "T125_cod_autorizacao = '".$_POST["codAutorizacao"]."'";
    
    $campos02 = array("T125_vendedor_troca" => $_POST["T125_vendedor_troca"],
                        "T125_dt_troca" => $_POST["T125_dt_troca"]);
    
    $altera02 = $obj->altera($tabela02, $campos02, $delim02);
    
}

  header('location:?router=T0133/home');



?>
