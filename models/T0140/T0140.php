<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 13/01/2014 por Roberta Schimidt
// * Descrição: Controle Vendas Pré Aprovadas
//
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0140 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    
    
        public function retornaDadosEmp($dataini, $datafim) {
        
            $sql = "call spRetornaPAOp('$dataini', '$datafim')";        
        return $this->query($sql);
    }
    

    public function retornaFunc($codRMS) {
        
        $connORA  =   $this->consulta;
        
        $sql = "SELECT nvl(10*T.TIP_CODIGO+T.TIP_DIGITO,0)          COD_RMS
                     , nvl(T.TIP_RAZAO_SOCIAL,'NAO CADASTRADO RMS') NOME
                     , T.Tip_Cgc_Cpf                                CPF
                  FROM RMS.AA2CTIPO T  
             where nvl(10*T.TIP_CODIGO+T.TIP_DIGITO,0)  = $codRMS";
        
    //   echo $sql;
        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
    }
    
    
    
     public function retornaCpfOp($cpf) {
        
        $connORA  =   $this->consulta;
        
        $sql = "SELECT nvl(10*T.TIP_CODIGO+T.TIP_DIGITO,0)          COD_RMS
                     , nvl(T.TIP_RAZAO_SOCIAL,'NAO CADASTRADO RMS') NOME
                     , T.Tip_Cgc_Cpf                                CPF
                  FROM RMS.AA2CTIPO T  
             where  T.Tip_Cgc_Cpf  = '$cpf'";
        
       //echo $sql;
        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
        
    }
    
    
    public function vendasPA($dataini, $datafim) {
        
        $sql = "SELECT  sm.store_key     Loja,
                        sm.pos_number    Pdv,
                        ems.NumeroCartao Cartao
                   FROM sale_media sm
                    JOIN ft094_ems ems
                    ON sm.store_key =  ems.CodigoDaLoja
                    AND sm.pos_number = ems.NumeroDoPDV
                    AND ems.NumerodoComprovante = sm.ticket_number
                 WHERE sm.media_id = 18
                 AND start_time >= '$dataini'
                 AND start_time < date_add('$datafim', interval 1 day)"
                . "ORDER BY start_time DESC";
        
        return $this->query($sql);
        
    }
    
    public function retornaDadosCartao($dataini, $datafim, $Loja, $Pdv, $cartao) {
        
        $connMSSQL = $this->consulta;
        
        $sql = "SELECT	A.COD_LOCAL_CTR         LOCAL,
                        CPF_CLIENTE		CPF, 
                        NOM_CLIENTE		NOME,	
                        CONVERT(VARCHAR(10),A.DAT_INC_CTR, 103)+ ' '+CONVERT(VARCHAR(10),A.DAT_INC_CTR, 108)           DATA,  
                        CONVERT(VARCHAR(10),B.DAT_ENVIO_GRAFICA, 103)+ ' '+CONVERT(VARCHAR(10),B.DAT_ENVIO_GRAFICA, 108)   DATA_EMISSAO,
                        DATEDIFF(mi, A.DAT_INC_CTR, B.DAT_ENVIO_GRAFICA)	TEMPO 
                    FROM dbo.CONTRATOS_COP_0014T A
                            JOIN dbo.CLIENTE_CARTAO_CEV_0148T B 
                                    ON	A.COD_LOCAL_CLIENTE = B.COD_LOCAL_CLIENTE
                                    AND B.COD_CLIENTE = A.COD_CLIENTE
                            JOIN dbo.CLIENTE_CORP_0116T C
                                    ON	B.COD_CLIENTE = C.COD_CLIENTE
                                    AND B.COD_LOCAL_CLIENTE = C.COD_LOCAL_CLIENTE
                    WHERE A.DAT_INC_CTR >= CONVERT(VARCHAR(10), '$dataini', 101)
                             AND A.DAT_INC_CTR < CONVERT(VARCHAR(10), DATEADD(DAY, 1, '$datafim'), 101)
                             AND (CONVERT(VARCHAR(10),  A.DAT_INC_CTR, 101) <=  CONVERT(VARCHAR(10),B.DAT_ENVIO_GRAFICA, 101) OR B.DAT_ENVIO_GRAFICA is NULL)  	
                             AND A.TIP_APR_CTR = 0
                             AND A.DAT_INC  < B.DAT_ENVIO_GRAFICA
                             AND NUM_TITULAR_OU_DEPEND = 0
                             AND SUBSTRING(B.NUM_CARTAO_CEV,7, 3) = '996'
                             AND SUBSTRING(B.NUM_CARTAO_CEV,6, 1) = '1'	
                             AND DATEDIFF(mi, A.DAT_INC_CTR, B.DAT_ENVIO_GRAFICA) > 0 
                             AND NUM_PDV > 0
                            ORDER BY CONVERT(VARCHAR(10),A.DAT_INC_CTR, 103),  CONVERT(VARCHAR(10),A.DAT_INC_CTR, 108) DESC";
        
       
        $stid = mssql_query($sql, $connMSSQL);
                 return $stid;

    }
    
    
   public function retornaVendas($dataini, $datafim, $loja) {
    
  
   $sql =     "SELECT s.store_key           Loja,
                           s.ticket_number  cupom,
                           date_format(s.start_time, '%d/%m/%Y')     Data,
                           s.pos_number     PDV,
                           a.id             Op,
                           date_format(s.start_time, '%H:%i:%s') Hora
                    FROM
                       sale s
                             JOIN agent a
                                ON s.cashier_key = a.agent_key
                         WHERE  s.start_time >= '$dataini'
                             and s.start_time < date_add('$datafim', interval 1 day)
   and s.store_key = $loja"; 
   
   
    echo $sql."<br><br>";
   return $this->query($sql);
       
   }
  
   
    
    
   public function retornaAnswer($loja, $pos, $cupom, $data) {
       
 $sql =  " select ad.data_value cpf FROM answer_data ad
            where ad.store_key = $loja
                and ad.pos_number = $pos
                and ad.ticket_number = $cupom
                and date_format(ad.start_time, '%d/%m/%Y')  = '$data' "
         . " and ad.data_id = 324";
         
 
 echo $sql."<br><br>";
 return $this->query($sql);
     
   }

   public function retornaQtdAbd($dataini, $datafim, $operador) {
       
       if($operador == ''){
       $sql =  "call sp_AbordadosPreAprov('$dataini', '$datafim')";} else {
       $sql =  "call sp_AbordadosPreAprovOp('$dataini', '$datafim', '$operador')";}
       
     
       
       return $this->query($sql);
       
   }
   
   
    public function inserir($tabela,$campos)
    {
        
        $insere = $this->exec($this->insere($tabela, $campos));
        
//       if($insere)
//            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
    }      
    
    public function retornaCodOp(){
        
        $sql = "select distinct T128_operador operador from davo_VendanNP";
        
        return $this->query($sql);
        
    }
    


}


 ?>
