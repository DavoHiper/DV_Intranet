<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em:                
// * Descrição: 
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/

class models_T0134 extends models
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
//       
       return $insere;
    }      
       
    public function altera($tabela,$campos,$delim)
    {              
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
      // echo $altera;
       return $altera;
    }  
    
    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));
        
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!');
       
       return $exclui;
    } 
    
    public function retornaDados($nome, $depto, $funcao, $loja){
        $sql    =   "      SELECT T04.T004_login       UsuarioLogin
                                , T04.T004_nome        UsuarioNome
                                , T04.T006_codigo      LojaCodigo
                                , T06.T006_nome        LojaNome
                                , T04.T121_codigo      FuncaoCodigo
                                , T121.T121_nome       FuncaoNome
                                , T04.T004_matricula   UsuarioMatricula
                                , T04.T004_email       UsuarioEmail
                                , T0677.T077_codigo    DeptoCodigo 
                                , T77.T077_nome        DeptoNome
                             FROM T004_usuario T04
                             JOIN T006_loja T06 ON T04.T006_codigo = T06.T006_codigo
                        LEFT JOIN T121_funcoes_colaboradores T121 ON T04.T121_codigo = T121.T121_codigo
                        LEFT JOIN T004_T006_T077 T0677 ON T04.T004_login = T0677.T004_login
                        LEFT JOIN T077_departamento T77 ON T0677.T077_codigo = T77.T077_codigo
                            WHERE 1  = 1";
        
                            if(!empty($nome))
                                $sql  .=   " AND T04.T004_nome  LIKE  '%$nome%'";
                            if(!empty($depto))
                                $sql  .=   " AND T77.T077_codigo  =    $depto";
                            if(!empty($funcao))
                                $sql  .=   " AND T121.T121_codigo =    $funcao";
                            if(!empty($loja))
                                $sql  .=   " AND T04.T006_codigo  =    $loja";
        
        return $this->query($sql);
    }
    
    public function retornaDadosFone($user){
        
        $sql    =   "  SELECT T10.T010_area    DDD
                            , T10.T010_numero  Numero
                            , T10.T010_ramal   Ramal
                            , T10.T011_codigo  TpFone
                            , T11.T011_nome    NomeTpFone
                         FROM T010_fone T10
                         JOIN T011_fone_tipo T11 ON T10.T011_codigo = T11.T011_codigo
                        WHERE T10.T004_login = '$user'";
        
//        echo $sql;
        
        return $this->query($sql);
    }
        
}
 ?>
