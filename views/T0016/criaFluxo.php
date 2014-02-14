<?php
if (!empty($_POST))
{
    $objWkf = new models_T0016();
    
    $tabela = "T008_T060";
    $Etapa  = $objWkf->retornaEtapaGrupo($_POST['Grupo']);
    $codAp  = $_POST['Ap'];
    foreach($Etapa as $campos=>$valores)
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

<div style="margin: 10px;">
<form action="" method="post">
    <label>Codigo Ap</label>
    <input type="text" name="Ap" />
    <label>Grupo</label>
    <input type="text" name="Grupo" />
    <br/>
    <input type="submit" value="Enviar" />
</form>
</div>