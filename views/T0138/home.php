<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 26/08/2013 por Roberta Schimidt
// * Descrição: Conferencia de valores netpoints
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/

//    $connMSSQL             =   "mssql";
//    $verificaConexao    =   "";
//    $db                 =   "DBO_CRE";
//    $objMSSQL = new models_T0138($connMSSQL,$verificaConexao,$db);
    
    
    $obj        =   new models_T0138();
    
    
    if(!empty($_POST["T126_mes_envio"])){
      
        $local = $_POST["T126_local"];
        $mes = $_POST["T126_mes_envio"];
        $ano = $_POST["T126_ano_envio"];
        
    $dados = $obj->selecionaValores($mes, $ano, $local);
    }
    
    

?>
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>
<div class="conteudo_16">
<div class="div-primaria div-filtro">
    
    <form action="" method="post" class="validaFormulario">

<div class="grid_1">
                <label class ="label">Mês</label>
                <input style="width:65px;" type="text" name="T126_mes_envio"  value="" />                
            </div>
        
<div class="grid_1 push_1">
                <label class ="label">Ano</label>
                <input style="width:65px;" type="text" name="T126_ano_envio"  value="" />                
            </div>
    
    <div class="grid_3 push_2">
                <label class="label">Local</label>
                <select name="T126_local" id="local">
                    <option value="">Selecione...</option>
                    <option value="1">Supermercado</option>
                    <option value="2">Posto</option>
                    <option value="3">Farma</option>
                </select>
            </div>


<div class="grid_2 push_2">
                <input type="submit" value="Filtrar" class="botao-padrao" />                          
            </div> </div>
</form>
<div class="clear10"></div>

<table class="tablesorter tDados">
                <thead>
                    <tr class="ui-widget-header ">
                        <th>Local       </th>
                        <th>Mês         </th>
                        <th>Ano         </th>
                        <th>Valor       </th>
                        <th>Vencimento  </th>
                    </tr> 
                </thead>
                <tbody class="campos">
                    <?php                  foreach($dados as $cps=>$row) {
                        
                       //calculo de pontos por compra 
                        
                        if($row["LOCAL"] == 2){
                        
                        $pontoInd =  ($row["VALOR"]/10)*4 ;} else {
                            
                            $pontoInd = ($row["VALOR"]/10*3);
                          
                        }
                        
                    
                    if ($contador % 2 == 1) {
                            $coratual = "#cccccc";
                        } else {
                            $coratual = "#FFFFFF";
                        }
                    ?>
                    <tr >
                        <td style="background-color: <?php echo $coratual;?>;"><?php echo $row["LOCAL"];?></td>
                        <td style="background-color: <?php echo $coratual;?>;"><?php echo $row["MES"];?></td>
                        <td style="background-color: <?php echo $coratual;?>;"><?php echo $row["ANO"];?></td>
                        <td style="background-color: <?php echo $coratual;?>;"><?php echo number_format($row["VALOR"],2,",",".");?></td>
                        <td style="background-color: <?php echo $coratual;?>;"><?php echo $row["VENCIMENTO"];?></td>
                    </tr>
                    <?php  
                    $contador++;
                      $somaTotal += $row["VALOR"];  
                       $pontos += $pontoInd;
                      
                        } ?>
                    
                      <tr >
                        <td colspan="3" align="right"></td>
                        <td ></td>
                        <td ></td>
                    </tr>
                    
                  <?
                  
                 
?>
                    
                     <tr >
                        <td colspan="3" align="right">Total: </td>
                        <td style="background-color: <?php echo $coratual;?>;"><?php echo number_format($somaTotal,2,",",".");?></td>
                        <td style="background-color: <?php echo $coratual;?>;">Totais de pontos: <?php echo round($pontos);?></td>
                    </tr>
                </tbody>
            </table>            
</div>