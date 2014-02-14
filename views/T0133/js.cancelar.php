<?php
$obj = new models_T0133();


$user        =  $_SESSION['user']           ;    
$cod         =  $_POST["codigoAutorizacao"] ;


$tabela = "T125_sinistro_ge";

$delim  =   "T125_cod_autorizacao    ='".$cod."'";
$campos = array(
                        "T125_status"          =>  4
                  
                   );

$altera = $obj->altera($tabela, $campos, $delim);



 


?>
