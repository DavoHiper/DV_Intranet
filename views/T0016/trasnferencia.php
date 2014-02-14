<?php

//Instancia Classe
$objP0016         =   new models_T0016();

//Captura Login para inserção
$user           =   $_SESSION['user'];
$data           =   date('d/m/Y H:i:s');
$tipo           =   $_GET['tipo'];
//Verifica se CNPJ não é nulo

$ListaAP       =   $objP0016->TemporariaInclusaoFluxoAP();
foreach($ListaAP as $campos=>$valores)
{
    echo "AP n°:".$valores['CodigoAP']."<br/>";


    $tabela = "T008_T060";
    $Etapa = $objP0016->retornaEtapaGrupo($valores['CodigoGP']);
    foreach($Etapa as $campos2=>$valores2)
    {
        $array = array ( "T060_codigo"          =>  3
                       , "T008_codigo"          =>  $codAp
                       , "T008_T060_ordem"      =>  1
                       , "T008_T060_status"     =>  0
                       , "T004_login"           =>  $user);
        
        $objWkf->inserir($tabela, $array);
        
        $array = array ( "T060_codigo"          =>  2
                       , "T008_codigo"          =>  $codAp
                       , "T008_T060_ordem"      =>  2
                       , "T008_T060_status"     =>  0
                       , "T004_login"           =>  $user);
        
        $objWkf->inserir($tabela, $array);
        
        $objWkf->inserirFluxoAp($codAp, $valores['EtapaCodigo'],3);
    }
}

?>