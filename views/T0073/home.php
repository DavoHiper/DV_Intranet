<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 04/01/2012 por Alexandre Alves
 * Descrição: Programa para Conciliacao automatica dos Cartoes Redecard, utiliza a procedure spfin_baixasredecardcre_int do DAVOPRD
 *            e gera arquivo no /dbx/PRD/FIN
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/


//Instancia Classe
$conn           =   "ora";
$obj            =   new models_T0073($conn);

$operadora    =   $_POST['operadora'];
$Data         =   $_POST['Data'];

$arrayData  = explode("/", $Data);

$ano    =   $arrayData[2]-1900;
$mes    =   $arrayData[1];
$dia    =   $arrayData[0];

$DataRMS    =   $ano.$mes.$dia;
$Metodo     =   1 ; // sempre envia metódo de atualizacao
$Tipo       =   $_POST['tipo'] ;

if (!empty($_POST))
$executaProcedure   =   $obj->executaProcedureBaixasRedecardCRE($DataRMS , $Metodo , $Tipo, $operadora);

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
                    <th width="200px"><label>Data</label></th>
                    <th><label>Tipo</label></th>
                </tr>
                <tr>
                    <td><input type="text" id="dt_inicial" class="FilVencimentoInicial"  name="Data" /></td>
                    <td>
                        <select name="tipo">
                            <option value=" ">Todos</option>
                            <option value="P">P - Parcelados</option>
                            <option value="R">R - Rotativos</option>
                        </select>
                    </td>
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