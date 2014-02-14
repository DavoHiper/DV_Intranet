<?php

if(isset($_SESSION["user"])){

//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);
$obj       =   new models_T0119();
$user      =   $_SESSION['user'];

$arrLote    =   $_REQUEST['arrLote'];
$arrLoja    =   $_REQUEST['arrLoja'];
$arrTipo    =   $_REQUEST['arrTipo'];

// Acao = 2 Aprovar // 7 = Reprovar
$Acao      = $_REQUEST['Acao']; 

$DataHora=date("d/m/Y H:i:s");

$qtd        =   count($arrLote);

for($i=0;$i<$qtd;$i++)
{

    $arrStatus = array( "aprovacao_status_id" =>$Acao
                       ,"aprovacao_data"      =>$DataHora
                       ,"aprovacao_usuario"   =>$user
                      );

    $Tabela     = "davo_ccu_lote";

    $Delim     = "lote_numero=$arrLote[$i] AND store_key=$arrLoja[$i] AND aprovacao_status_id=1";

    $Retorno   = $objEMP->altera($Tabela, $arrStatus, $Delim) ;
    
    if($Retorno)
    {
        $DigLoja   = $obj->calculaDigitoMod11($arrLoja[$i],1,100);
        $LojaCD    = $arrLoja[$i].$DigLoja; // loja Com Digito

        $arrStatus = array("T116_aprovacao_status_id" =>$Acao
                          ,"T116_aprovacao_data"      =>$DataHora
                          ,"T004_login"               =>$user
                          );

        $Tabela    = "T116_ccu_lote";
        $Delim     = "T116_lote=$arrLote[$i] AND T006_codigo=$LojaCD AND T116_aprovacao_status_id=1";

        $RetornoInt   = $obj->altera($Tabela, $arrStatus, $Delim) ;
    
    }
    
    
    // verifica se ? uma producao e ? uma Reprovacao, somente se houve sucesso no update
    if(($Retorno)&&($arrTipo[$i]==2)) // &&($Acao==7))
    {
        // recupera lotes consumidos pelo Destino
        $RetornoOrigens = $objEMP->ConsultaLotesOrigem($arrLoja[$i], $arrLote[$i]);
        
        foreach($RetornoOrigens as $camposO=>$valoresO)
        {
         
            if($Acao==2)
            {
                // monta UPDATE da Origem para aprovado
                $arrUpdateApr = array(   "aprovacao_status_id"   => 3
                                        ,"aprovacao_data"        => $DataHora
                                        ,"aprovacao_usuario"     => $user
                                     );        
                
                $arrStatus = array("T116_aprovacao_status_id" =>3
                                  ,"T116_aprovacao_data"      =>$DataHora
                                  ,"T004_login"               =>$user
                                  );                   
            }
            else
            {
                // busca header do lote de origem, para verificar se eh uma producao expressa
                $LoteProducao = $objEMP->ConsultaLote($arrLoja[$i], $arrLote[$i]);
                foreach($LoteProducao as $camposPRD=>$valoresPRD)
                {
                   $PRDStorekey        = $valoresPRD['store_key'];
                   $PRDPosNumber       = $valoresPRD['pos_number'];
                   $PRDTicketNumber    = $valoresPRD['ticket_number'];
                   $PRDStartTime       = $valoresPRD['start_time'];
                }
                
                // busca header do lote de destin, para verificar se eh uma producao expressa
                $LoteRetirada = $objEMP->ConsultaLote($valoresO['store_key_origem'], $valoresO['lote_numero_origem']);
                foreach($LoteRetirada as $camposRET=>$valoresRET)
                {
                   $RETStorekey        = $valoresRET['store_key'];
                   $RETPosNumber       = $valoresRET['pos_number'];
                   $RETTicketNumber    = $valoresRET['ticket_number'];
                   $RETStartTime       = $valoresRET['start_time'];
                }
                
                // verifica se chave da sale, eh igual para Retirada e Producao, indicando uma producao expressa
                if ( ($PRDStorekey==$RETStorekey) && 
                     ($PRDPosNumber==$RETPosNumber) &&
                     ($PRDTicketNumber==$RETTicketNumber) &&
                     ($PRDStartTime==$RETStartTime)   
                   )
                {
                    $ProducaoExpressa=1;
                    // monta UPDATE da Origem como rejeitado
                    $arrUpdateApr = array(   "aprovacao_status_id"   => 7
                                            ,"aprovacao_data"        => $DataHora
                                            ,"aprovacao_usuario"     => $user
                                         );                                

                    $arrStatus = array("T116_aprovacao_status_id" => 7
                                      ,"T116_aprovacao_data"      => $DataHora
                                      ,"T004_login"               => $user
                                      );                         
                }
                else
                {   // é uma retirada "normal"
                    $ProducaoExpressa=0;
                    // monta UPDATE da Origem para disponivel novamente
                    $arrUpdateApr = array(   "aprovacao_status_id"   => 1
                                            ,"aprovacao_data"        => "NULL"
                                            ,"aprovacao_usuario"     => NULL
                                         );                                

                    $arrStatus = array("T116_aprovacao_status_id" => 1
                                      ,"T116_aprovacao_data"      => "NULL"
                                      ,"T004_login"               => NULL
                                      );                      
                }
               
            }
            
            $Tabela     = "davo_ccu_lote";

            $Delim     = "lote_numero=".$valoresO['lote_numero_origem']." AND store_key=".$valoresO['store_key_origem'].
                         "  AND aprovacao_status_id=6  AND integracao_status_id <> 2  ";

            $RetornoOrg   = $objEMP->altera($Tabela, $arrUpdateApr, $Delim) ;              
            
            if($RetornoOrg)
            {
                  //Atualiza na Intranet
                   $DigLoja   = $obj->calculaDigitoMod11($valoresO['store_key_origem'],1,100);
                   $LojaCD    = $valoresO['store_key_origem'].$DigLoja; // loja Com Digito

                   $Tabela    = "T116_ccu_lote";
                   $Delim     = "T116_lote=".$valoresO['lote_numero_origem']." AND T006_codigo=$LojaCD";

                   $RetornoOrg   = $obj->altera($Tabela, $arrStatus, $Delim) ;

            }            
            
            // verifica se � cancelamento, somente para producoes normais
            if(($Acao==7)&&!($ProducaoExpressa))
            {
                // "libera" lote para consumo novamente
                $arrUpdateCon = array(   "consumo_status_id"     => 0
                                        ,"consumo_data"          => "NULL"
                                        ,"consumo_agent_key"     => "NULL"
                                        ,"aprovacao_agent_key"   => "NULL"
                                       );

                $Tabela     = "davo_ccu_lote";

                $Delim     = "lote_numero=".$valoresO['lote_numero_origem']." AND store_key=".$valoresO['store_key_origem'];

                $Retorno   = $objEMP->altera($Tabela, $arrUpdateCon, $Delim) ;  
                
                // Atualizacao foi feita com sucesso, apaga o consumo
                if($Retorno)
                {
                    $Tabela     = "davo_ccu_lote_consumo";

                    $Delim     = "lote_numero_origem=".$valoresO['lote_numero_origem']." AND store_key_origem=".$valoresO['store_key_origem'];

                    $Retorno   = $objEMP->excluir($Tabela, $Delim) ;            
                }

            }
        }
    }
    
}
echo $Retorno;

}else{
    header('Location:');
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
