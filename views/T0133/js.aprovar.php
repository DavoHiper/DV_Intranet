<?php
$obj = new models_T0133();

$RemoteADDR  =  $_SERVER['REMOTE_ADDR']     ;
$RequestTime =  $_SERVER['REQUEST_TIME']    ;
$RequestUri  =  $_SERVER['REQUEST_URI']     ;
$data        =  date('d/m/Y H:i:s')         ;
$user        =  $_SESSION['user']           ;    
$cod         =  $_POST["codigoAutorizacao"] ;
$acao        =  $_POST["acao"]              ;

$sinistro = $obj->retornaTrocaSinistro($cod);

foreach ($sinistro as $cps => $val) {
    
    $idSinistro = $val["ID"];
    
}


If ($acao == 1){


$tabela = "T125_T060";

$delim  =   "T125_codigo    =   $idSinistro AND T060_codigo = 211"   ;
$campos = array(
                        "T125_T060_status"          =>  1
                   ,    "T125_T060_dt_aprovacao"    =>  $data
                   ,    "T004_login"                =>  $user
                   ,    "T125_T060_REMOTE_ADDR"     =>  $RemoteADDR
                   ,    "T125_T060_REQUEST_TIME"    =>  $RequestTime
                   ,    "T125_T060_REQUEST_URL"     =>  $RequestUri
                   );

$altera = $obj->altera($tabela, $campos, $delim);


} else {
    
    
    $tabela = "T125_T060";

$delim  =   "T125_codigo    =   $idSinistro AND T060_codigo = 210"   ;
$campos = array(
                        "T125_T060_status"          =>  2
                   ,    "T125_T060_dt_aprovacao"    =>  $data
                   ,    "T004_login"                =>  $user
                   ,    "T125_T060_REMOTE_ADDR"     =>  $RemoteADDR
                   ,    "T125_T060_REQUEST_TIME"    =>  $RequestTime
                   ,    "T125_T060_REQUEST_URL"     =>  $RequestUri
                   );

$altera = $obj->altera($tabela, $campos, $delim);
    
    
    
}
 


?>
