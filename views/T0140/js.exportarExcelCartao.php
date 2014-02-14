<?php



    $obj = new models_T0140();


    $conn             =   "mssql";
    $verificaConexao    =   "";
    $db                 =   "DBO_CRE";
    $objMSSQL = new models_T0140($conn,$verificaConexao,$db);
    
    
    // Instancia Classe T0140 para conexao Emporium
$connEMP            =  "emporium"                                   ;               
$verificaConexao    =  1                                            ; //se 1 ignora conexao, caso haja erro na conexao com BD do Emporium
$objEMP             =  new models_T0140($connEMP,$verificaConexao)  ;
    



$dataini = $_REQUEST["dataini"];
$datafim = $_REQUEST["datafim"];
//$data = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);

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
mso-number-format:'m\/d\/yy\ h\:mm\ AM\/PM';
}"
.".numInt {mso-number-format:'0'; }"        
        . "</style>";
 
                      if ($datafim == "--"){
    
                            $datafim = $dataini;
                        }
                        
                        
                        
echo  "<table border=1>"
. "<tr bgcolor='#BEBEBE'>"
        . "<td>Loja</td>"
        . "<td>Nome</td>"
        . "<td>CPF</td>"
        . "<td>Data Compra</td>"
        . "<td>Data Emissao</td>"
        . "<td>Tempo em Minutos</td>"
    . "</tr>";                        

//$retornaPreApr = $objEMP->vendasPA($dataini, $datafim);

$i=0;

//foreach($retornaPreApr as $keyPA => $valPA ){        
                        
                        
$retornaCartao = $objMSSQL->retornaDadosCartao($dataini, $datafim);
  
  while ($valores = mssql_fetch_array($retornaCartao))
        { 
            
        
  echo "<tr>"
    . "<td>".$valores["LOCAL"]."</td>"
    . "<td>".$valores["NOME"]."</td>"
    . "<td class='FmtTexto'>".$valores["CPF"]."</td>"
    . "<td class='FmtTexto'>".$valores["DATA"]."</td>"
    . "<td class='FmtTexto'>".$valores["DATA_EMISSAO"]."</td>"
    . "<td>".$valores["TEMPO"]."</td>"
      . "</tr>";
  
  
  $qtd = $i++;
      
  }
  
  
//}

  
echo "<tr>"
  ."<td colspan = '5'>Cartoes Emitidos</td>"
  ."<td>".($qtd+1)."</td>";

echo "</table>";



        
        
        


