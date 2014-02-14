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

$conn   =   "ora";
$objORA    =   new models_T0140($conn);


// Instancia Classe T0075 para conexao Emporium
$connEMP            =  "emporium"                                   ;               
$verificaConexao    =  1                                            ; //se 1 ignora conexao, caso haja erro na conexao com BD do Emporium
$objEMP             =  new models_T0140($connEMP,$verificaConexao)  ;

$user           =   $_SESSION['user'];


$dataini = $_POST["dataini"];
$dataini = substr($dataini,6,4)."-".substr($dataini,3,2)."-".substr($dataini,0,2);

$datafim = $_POST["datafim"];
$datafim = substr($datafim,6,4)."-".substr($datafim,3,2)."-".substr($datafim,0,2);


$retOper = $objORA->retornaCpfOp($_POST["operador"]);

while($valCpf = oci_fetch_array($retOper)){
    
   $codOp = $valCpf["COD_RMS"];
}

$operador = $codOp;

?>

<div class="conteudo_16">
    <div class="div-primaria div-filtro">
        
        
    <form action="" method="post" class="validaFormulario">
        <div class="conteudo_16">
            
                   <div class="grid_3">
                      <label class="label">Data Inicial / Data</label>
                      <input  type="text" style="width: 100px;" name="dataini" class="data"  value=""/>    
                   </div>
                    <div class="grid_3">
                      <label class="label">Data Final</label>
                      <input  type="text" style="width: 100px;" name="datafim" class="data"  value=""/>    
                   </div>
                    <div class="grid_3">
                      <label class="label">CPF Operador</label>
                      <input  type="text" style="width: 100px;" name="operador"  value=""/>    
                   </div>
                  
            <div class="grid_2">
                <input type="submit" value="Gerar" class="botao-padrao" />                          
            </div>
            <?php If($dataini != "--"){?>
            <div class="grid_2">
                </br></br>
                <a href="?router=T0140/js.exportarExcel_1&dataini=<?php echo $dataini?>&datafim=<?php echo $datafim?>">Gerar Excel</a>                         
            </div>
            <?php }?>
           </div>
    </form>
        </div>
    
    <div class="clear10"></div>
    <table class="tablesorter tDados">
        <thead>
                    <tr class="ui-widget-header ">
                        <th>Data Operação   </th>
                        <th>Operador        </th>
                        <th>CPF             </th>
                        <th>Loja            </th>
                        <th>Qtd Abordados   </th>
                        <th>Qtd Convertidos </th>
                    </tr> 
                </thead>
                <tbody class="campos">
                    <?php 
                    
                     if ($datafim == "--"){
    
                            $datafim = $dataini;
                        }
                        
                    
                   $retornaAbordados = $objEMP->retornaQtdAbd($dataini, $datafim, $operador);
                            
                    foreach ($retornaAbordados as $key => $value) {
                        
                        
                        $dadosFunc = $objORA->retornaFunc($value["operador"]);

                        while ($valores = oci_fetch_array($dadosFunc))
                              { 
                                   $nome  = $valores["NOME"];
                                   $cpf   = $valores["CPF"];
                              }   
                              
                                 if ($contador % 2 == 1) {
                            $coratual = "#cccccc";
                        } else {
                            $coratual = "#FFFFFF";
                        }
  
                    ?>
                        <tr >
                            <td style="background-color: <?php echo $coratual;?>;"><?php echo $value["data"];?></td>
                            <td style="background-color: <?php echo $coratual;?>;"><?php echo $nome;?></td>
                            <td style="background-color: <?php echo $coratual;?>;"><?php echo $cpf;?></td>
                            <td style="background-color: <?php echo $coratual;?>;"><?php echo $value["loja"];?></td>
                            <td style="background-color: <?php echo $coratual;?>;"><?php echo $value["QtdAbd"];?></td>
                            <td style="background-color: <?php echo $coratual;?>;"><?php echo $value["QtdConv"];?></td>
                        </tr>
                        
                        
                        
                        <?php 
                        $contador++;
                        
                        $totalVenda += $value["QtdAbd"];
                        $totalConv  += $value["QtdConv"];
                        
                        }
                        
                                   echo "<tr>"
                            ."<td colspan = '4'>Total Vendas</td>"
                            ."<td>$totalVenda</td>"
                            ."<td>$totalConv</td></tr>";
                        
                        ?>
                </tbody>
        </table>
        
        
    
    
</div>

