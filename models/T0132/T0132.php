<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 17/05/2013 por Roberta Schimidt
// * Descrição: 
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0132 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    
    public function desbloqueiaMatricula($matricula) {
     
        $connMSSQL = $this->consulta;
        
        $sql    =   "DELETE
                        FROM
                            LOG_SISTEMA_0128T
                        WHERE
                            COD_FUNC    =    $matricula";
        
        //echo $sql;
        
        $stid = mssql_query($sql, $connMSSQL);
        
          if($stid)
            $this->alerts('false', 'Alerta!', 'Desbloqueado com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Desbloquear!');  
        
        return $stid;
        
    }
    
}
?>
