<?php



$obj = new models_T0133();

$dataInicial = $_POST["dataInicial"];
$dataInicial = substr($dataInicial,6,4)."-".substr($dataInicial,3,2)."-".substr($dataInicial,0,2);
$dataFinal   = $_POST["dataFinal"];
$dataFinal = substr($dataFinal,6,4)."-".substr($dataFinal,3,2)."-".substr($dataFinal,0,2);

header("Content-type: application/vnd.ms-excel");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=relatorio".$dataInicial.".xls");
header("Pragma: no-cache");



echo "<style>.FmtTexto {mso-number-format:\@}"
. ".MOEDARS {
mso-number-format:'_\(\[$R$ -416\]* \#\,\#\#0\.00_\)\;_\(\[$R$ -416\]* \\\(\#\,\#\#0\.00\\\)\;_\(\[$R$ -416\]* \0022-\0022??_\)\;_\(\@_\)';
}"
. ".DATA2 {
mso-number-format:'Short Date';
}"
.".numInt {mso-number-format:'0'; }"        
        . "</style>";
 

$retornaSinistros = $obj->retornaDadosRelatorio($dataInicial, $dataFinal);

echo  "<table border=1>"
. "<tr bgcolor='#BEBEBE'>"
        . "<td>Data</td>"
        . "<td>Loja</td>"
        . "<td>CPF</td>"
        . "<td>Cliente</td>"
        . "<td>Certificado</td>"
        . "<td>Código Troca</td>"
        . "<td>Produto</td>"
        . "<td>Valor</td>"
        . "<td>Vendedor</td>"
        . "<td>Troca Realizada em</td>"
        . "<td></td>"
        
    . "</tr>";



foreach ($retornaSinistros as $key => $value) {
    
    echo "<tr>"
    . "<td class='DATA2'>".$value["Data"]."</td>"
    . "<td>".$value["Loja"]."</td>"
    . "<td class='FmtTexto'>".$value["CPF"]."</td>"
    . "<td>".$value["Nome"]."</td>"
    . "<td class='numInt'>".$value["Certificado"]."</td>"
    . "<td class='FmtTexto'>".$value["CodAutorizacao"]."</td>"
    . "<td>".$value["Produto"]."</td>"
    . "<td class='MOEDARS'>".str_replace(".", ",",$value["Valor"])."</td>"
    . "<td>".$value["Vendedor"]."</td>"
    . "<td class='DATA2'>".$value["Data"]."</td>"
    . "<td><table border = 1>"
            . "<tr>"
            . "<td>PDV</td>"
            . "<td>Cupom</td>"
            . "<td>Cod. Item</td>"
            . "</tr>";
            foreach($obj->retornaProdTroca($value["CodAutorizacao"]) as $cpProd => $valProd){
         echo "<tr>"
                . "<td>".$valProd["T127_pdv"]."</td>"
                . "<td>".$valProd["T127_cupom"]."</td>"
                . "<td>".$valProd["T127_cod_produto"]."</td>"
              ."</tr>";
            }
            echo "</table></td>"
    
            . "</tr>";
            
            
           $sumValorTroca += $value["Valor"];
           $desconto = $sumValorTroca * 0.2;
           $totalReceber = ($sumValorTroca - $desconto);
           
           
}


 echo "<tr>"
     . "<td colspan='7' align='right'>Total Troca</td>"
     . "<td class='MOEDARS'>".$sumValorTroca."</td>"
   . "</tr>"
   . "<tr>"
     . "<td colspan='7' align='right'>Desconto</td>"
     . "<td class='MOEDARS'>".$desconto."</td>"
   . "</tr>"
   . "<tr bgcolor='#8FBC8F'>"
     . "<td colspan='7' align='right'>Total a Receber</td>"
     . "<td class='MOEDARS'>".$totalReceber."</td>"
   . "</tr>"
."</table>";

        
        
        


