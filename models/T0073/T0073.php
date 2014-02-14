<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 04/01/2012 por Alexandre Alves
 * Descrição: Classe para interação com banco do programa T0073 (Conciliacoes Redecard Crédito)  
           
***************************************************************************/

class models_T0073 extends models
{

    public function __construct($conn,$verificaConexao)
    {
        parent::__construct($conn,$verificaConexao);
    }

    public function executaProcedureBaixasRedecardCRE($Data , $Metodo , $Tipo, $operadora)
    {   
        $connORA  =   $this->consulta;
        
        if($operadora==1)
        {
            $sql = "BEGIN 

                            SPFIN_BaixasRedecardCRE_int ('$Data','$Metodo','$Tipo' ,1); 
                            SPFIN_BaixasRedecardCRE_int ('$Data','$Metodo','$Tipo' ,2); 
                            SPFIN_BaixasRedecardCRE_int ('$Data','$Metodo','$Tipo', 3);     
                    END;";
        }else if($operadora==2)
        {
            $sql = "BEGIN 

                            SPDVFIN_BaixasElavon_CRE ('$Data','$Metodo','$Tipo' ,1); 
                            SPDVFIN_BaixasElavon_CRE ('$Data','$Metodo','$Tipo' ,2); 
                            SPDVFIN_BaixasElavon_CRE ('$Data','$Metodo','$Tipo', 3);     
                    END;";            
        }
        
//        echo $sql;
        
        $stid    = oci_parse($connORA, $sql);
                        
        if(oci_execute($stid))
            $this->alerts('false', 'Alerta!', 'Executado com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Executar!');
                        
        oci_execute($stid);
        
        return($stid);
    }
    
    public function teste()
    {
        $connORA = $this->consulta;
        $sql ="begin
                  teste;
                end;";
        $stdid = oci_parse($connORA, $sql);
        
        oci_execute($stid);
        return($stdid);
    }
    
}
?>
<?php
/* -------- Controle de versões - models/T0034.php --------------
 * 1.0.0 - 17/10/2011   --> Liberada a versão
*/
?>