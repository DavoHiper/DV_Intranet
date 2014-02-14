<?php
$obj = new models_T0135();

$codigoUsuario  =  $_POST["cod"];
$codigoFaixa    =  $_POST["codFaixa"];


if ($codigoFaixa == ""){

$tabela = "T123_T124";

$delim = " T123_matricula   =   ".$codigoUsuario;


$excluir1 = $obj->excluir($tabela, $delim);


    
    $tabela2 = "T123_usuarios_ems";
    
    $delim2 = " T123_matricula   =   ".$codigoUsuario;
    
    
    $obj->excluir($tabela2, $delim2);
    
 }else {
    
    $tabela = "T123_T124";

    $delim = " T123_matricula   =   ".$codigoUsuario." AND T124_codigo = ".$codigoFaixa;


$excluir1 = $obj->excluir($tabela, $delim);
    
}
    








?>
