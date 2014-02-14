<?php

$obj =  new models_T0133();

$id = $_POST["id"];

$tabela = "T127_dados_produto_ge";

$delim = "T127_codigo = ".$id;


$obj->excluir($tabela, $delim); 


?>
