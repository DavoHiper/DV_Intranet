<?php
if (!empty($_POST))
{
    $objWkf = new models_T0026();
    
 $tabela = "T016_T060";
        $user   = $_SESSION['user'];
      
            $Etapas = $objWkf->retornaProximaEtapa($_POST["Grupo"]);
            $CodigoDespesa = $_POST["Despesa"];
            $Ordem = 1;

            foreach($Etapas as $campos=>$valores)
            {
                $dados = array (  "T060_codigo"      => $valores['EtapaCodigo']
                                , "T016_codigo"      => $CodigoDespesa
                                , "T016_T060_ordem"  => $Ordem
                                , "T016_T060_status" => 0
                                , "T004_login"       => $user
                                );
                $objWkf->inserir($tabela, $dados);
                $objWkf->inserirFluxo($CodigoDespesa, $valores['ProxCodigoEtapa'], $Ordem+1);
            }
        
}
?>

<div style="margin: 10px;">
<form action="" method="post">
    <label>Codigo Despesa</label>
    <input type="text" name="Despesa" />
    <label>Grupo</label>
    <input type="text" name="Grupo" />
    <br/>
    <input type="submit" value="Enviar" />
</form>
</div>