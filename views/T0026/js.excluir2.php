<?php 

$obj    =   new models_T0026();

$codigoDespesa      =   $_REQUEST['codigoDespesa'];
$totalDespesa       =   $_REQUEST['totalDespesa'];
$totalDespesaDiv    =   $_REQUEST['totalDespesaDiv'];
$totalGeral         =   $_REQUEST['totalGeral'];


$tabela =   "T017_despesa_detalhe";

$delim  =   "T016_codigo    =   $codigoDespesa";
$obj->excluir($tabela, $delim);

$tabela =   "T015_T016";
$obj->excluir($tabela, $delim);



$tabela =   "T016_despesa";

$delim  =   "T016_codigo    =   $codigoDespesa ";

$campos =   array(  "T016_vl_total_km"          =>$totalDespesa  
                  , "T016_vl_total_diversos"    =>$totalDespesaDiv
                  , "T016_vl_total_geral"       =>$totalGeral);


$obj->altera($tabela, $campos, $delim, $alerta);


?>