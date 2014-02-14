<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 26/08/2013 por Roberta Schimidt
// * Descrição: Conferencia de valores netpoints
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0138 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        
        $insere = $this->exec($this->insere($tabela, $campos));
        
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
    }      
        
    public function altera($tabela,$campos,$delim)
    {
       $conn = "";
       
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
       return $altera;
    }

    public function excluir($tabela, $delim)
    {
        $exclui =  $this->exec($this->exclui($tabela, $delim));
        
        if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!');         
        
        return $exclui;
    }
    
    public function selecionaValores($mes, $ano, $local) {
        
        $sql = "SELECT SUM(T126_valor) VALOR,
                        T126_mes_envio MES,
                        T126_ano_envio ANO,
                        T126_local LOCAL,
                       date_format(T126_data_vencimento, '%d/%m/%Y') VENCIMENTO
                   FROM T126_valores_netpoints T126
                  WHERE T126_mes_envio = $mes AND T126_ano_envio = $ano AND T126_local = $local
                 GROUP BY T126_data_vencimento";
        
       // echo $sql;
        
        return $this->query($sql);
              
                            
        
    }
    
    
}
 ?>
