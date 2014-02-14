<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 08/05/2013 por Rodrigo Alfieri
// * Descrição: Cadastro de categoria por fornecedor
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0136 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
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
    
    
}
 ?>
