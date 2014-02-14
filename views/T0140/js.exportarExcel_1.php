<?php



$obj = new models_T0140();

$conn   =   "ora";
$objORA    =   new models_T0140($conn);


// Instancia Classe T0075 para conexao Emporium
$connEMP            =  "emporium"                                   ;               
$verificaConexao    =  1                                            ; //se 1 ignora conexao, caso haja erro na conexao com BD do Emporium
$objEMP             =  new models_T0140($connEMP,$verificaConexao)  ;

$dataini = $_REQUEST["dataini"];
//$data = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
$datafim = $_REQUEST["datafim"];
//$data = '2014-01-09'; 

header("Content-type: application/vnd.ms-excel");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=relatorio".$data.".xls");
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

 if ($datafim == "--"){
    
                            $datafim = $dataini;
                        }


 $retornaAbordados = $objEMP->retornaQtdAbd($dataini, $datafim);

echo  "<table border=1>"
. "<tr bgcolor='#BEBEBE'>"
        . "<td>Data Operacao</td>"
        . "<td>Operador</td>"
        . "<td>CPF</td>"
        . "<td>Loja</td>"
        . "<td>Abordados</td>"
        . "<td>Convertidos</td>"
    . "</tr>";


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
  
  
    
    echo "<tr>"
    . "<td>".$value["data"]."</td>"
    . "<td>".$nome."</td>"
    . "<td class='FmtTexto'>".$cpf."</td>"
    . "<td>".$value["loja"]."</td>"
    . "<td class='numInt'>".$value["QtdAbd"]."</td>"
    . "<td class='numInt'>".$value["QtdConv"]."</td>"
      . "</tr>";

              $totalVenda += $value["QtdAbd"];
                        $totalConv  += $value["QtdConv"];
}

    echo "<tr>"
                            ."<td colspan = '4'>Total Vendas</td>"
                            ."<td>$totalVenda</td>"
                            . "<td>$totalConv</td></tr>";


echo "</table>";



        
        
        


