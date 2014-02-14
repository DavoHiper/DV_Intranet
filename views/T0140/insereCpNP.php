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


//$arrPos = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46);

//$arrHora = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);

//$arrLoja = array(6);



 $vendas = $objEMP ->retornaVendas('2014-02-11', '2014-02-11', 6);
 
 foreach ($vendas as $cpVenda => $vendaVl) {
     
     $answer = $objEMP->retornaAnswer($vendaVl["Loja"], $vendaVl["PDV"], $vendaVl["cupom"], $vendaVl["Data"]);
     
     foreach ($answer as $cpAns => $valAns) {
         
         $cpf = $valAns["cpf"];
     
     }
     
     
     if ($cpf == ''){
         $cpf = 0;
     }
     
         $tabela = 'davo_VendanNP';
         

         $campos = array("T128_data" => $vendaVl["Data"]
                        ,"T128_pdv" => $vendaVl["PDV"]
                        ,"T128_cupom" => $vendaVl["cupom"]
                        ,"T128_cpf" => $cpf
                        ,"T128_loja" => $vendaVl["Loja"]
                        ,"T128_operador" => $vendaVl["Op"]
                        ,"T128_hora" => $vendaVl["Hora"]);
         
         
         
         
       $objEMP->inserir($tabela, $campos);
         
     
     $cpf = 0 ;
}

  