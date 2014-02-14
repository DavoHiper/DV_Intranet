<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 14/01/2014  por Roberta Schimidt
// * Descrição: Programa de Controle de Pré Aprovado
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//


$obj        =   new models_T0140();

 $conn             =   "mssql";
    $verificaConexao    =   "";
    $db                 =   "DBO_CRE";
    $objMSSQL = new models_T0140($conn,$verificaConexao,$db);

// Instancia Classe T0140 para conexao Emporium
$connEMP            =  "emporium"                                   ;               
$verificaConexao    =  1                                            ; //se 1 ignora conexao, caso haja erro na conexao com BD do Emporium
$objEMP             =  new models_T0140($connEMP,$verificaConexao)  ;
    
    
    

$dataini = $_POST["dataini"];
$dataini = substr($dataini,6,4)."-".substr($dataini,3,2)."-".substr($dataini,0,2);

$datafim = $_POST["datafim"];
$datafim = substr($datafim,6,4)."-".substr($datafim,3,2)."-".substr($datafim,0,2);



$user           =   $_SESSION['user'];


?>
<div class="conteudo_16">
            <div class="div-primaria div-filtro">
              <form action="" method="post" class="validaFormulario">
                <div class="grid_3">
                      <label class="label">Data Inicial / Data</label>
                      <input  type="text" style="width: 100px;" name="dataini" class="data"  value=""/>    
                   </div>
                <div class="grid_3">
                      <label class="label">Data Final</label>
                      <input  type="text" style="width: 100px;" name="datafim" class="data"  value=""/>    
                   </div>
                  <div class="grid_2">
                      <input type="submit" value="Gerar" class="botao-padrao" />                          
                  </div>
                  <?php If($dataini != "--"){?>
                   <div class="grid_2">
                       </br></br>
                       <a href="?router=T0140/js.exportarExcelCartao&dataini=<?php echo $dataini;?>&datafim=<?php echo $datafim?>">Gerar Excel</a>                          
                  </div>
                  <?php }?>
                  </form>
            </div>
    <div class="clear10"></div>
    
    <table class="tablesorter tDados">
                <thead>
                    <tr class="ui-widget-header ">
                        <th>Loja       </th>
                        <th>Nome         </th>
                        <th>CPF         </th>
                        <th>Data Compra       </th>
                        <th>Data Emissão  </th>
                        <th>Tempo em Minutos  </th>
                    </tr> 
                </thead>
                <tbody class="campos">
                    
                    
                    
                    <?php 
                    
                    if($dataini != "--"){
                    
                    if ($datafim == "--"){
    
                            $datafim = $dataini;
                        }
//                    $retornaPreApr = $objEMP->vendasPA($dataini, $datafim)  ;  
//                    
//                    $i=0;
//               foreach($retornaPreApr as $keyPA => $valPA ){        
                    
                    $retornaCartao = $objMSSQL->retornaDadosCartao($dataini, $datafim);
                             $i=0; 
                         while ($valores = mssql_fetch_array($retornaCartao))
                            { 
                              
                    if ($contador % 2 == 1) {
                            $coratual = "#cccccc";
                        } else {
                            $coratual = "#FFFFFF";
                        }
                             
                             
                               echo "<tr>"
                                        . "<td style='background-color:$coratual;'>".$valores["LOCAL"]."</td>"
                                        . "<td style='background-color:$coratual;'>".$valores["NOME"]."</td>"
                                        . "<td style='background-color:$coratual;'>".$valores["CPF"]."</td>"
                                        . "<td style='background-color:$coratual;'>".$valores["DATA"]."</td>"
                                        . "<td style='background-color:$coratual;'>".$valores["DATA_EMISSAO"]."</td>"
                                        . "<td style='background-color:$coratual;'>".$valores["TEMPO"]."</td>"
                                    . "</tr>";
                               
                                  $qtd =  $i++;
                            }
                            
                        
                            
             //  }
                           
                            
                            echo "<tr>"
                            ."<td colspan = '5'>Cartoes Emitidos</td>"
                            ."<td>".($qtd+1)."</td></tr>";
                            
                    }
                    ?>
                    
                    
   
                </tbody>
    
    </table>
        
</div>

