<?php
//Instancia Classe
$conn           =   "ora";
$obj            =   new models_T0061($conn);

$operadora    =   $_POST['operadora'];
$Data         =   $_POST['Data'];

$arrayData  = explode("/", $Data);

$ano    =   $arrayData[2]-1900;
$mes    =   $arrayData[1];
$dia    =   $arrayData[0];

$DataRMS    =   $ano.$mes.$dia;

if (!empty($_POST))
$executaProcedure   =   $obj->executaProcedureBaixasRedecardDEB($operadora, $DataRMS);

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
            </ul>
        </span>
    </div>
</div>

<div id="tabs">
    <div id="tabs-1">
        <form action="" method="post">
        <table class="form-inpu-tab">
            <thead>
                <tr>  
                    <th width="100px"><label>Operadora</label></th>
                </tr>
                <tr>
                    <td width="100px">
                        <select name="operadora">
                            <option value="1" <?php echo $operadora==1?"selected":"";?>>Redecard</option>
                            <option value="2" <?php echo $operadora==2?"selected":"";?>>Elavon</option>
                        </select>
                    </td>
                </tr>
                <tr>  
                    <th width="100px"><label>Data</label></th>
                </tr>
                <tr>
                    <td width="100px"><input type="text" id="dt_inicial" class="FilVencimentoInicial"  name="Data" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="form-inpu-botoes">
                            <input type="submit"  value="Executar Baixas" />
                        </div>
                    </td>
                </tr>
            </thead>
        </table>
        </form>
    </div>
</div>