<?php 

$obj    =   new models_T0026();

$codigoDespesa      =   $_REQUEST['codigoDespesa'];
$codigoSequencia    =   $_REQUEST['codigoSequencia'];


$dadosSeqDespesa    =   $obj->retornaDetDespesa($codigoDespesa, $codigoSequencia);


?>