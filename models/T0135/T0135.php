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

class models_T0135 extends models
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
    
    public function somaValores(){
        
        $sql = "SELECT   tmp_matricula  Matricula
                        ,sum(tmp_valor) Valor
                    FROM tmp_ranking_individual tp
               WHERE tmp_matricula <> 0
              GROUP BY tmp_matricula
              ORDER BY sum(tmp_valor) DESC;";
        
        return $this->query($sql);
    }
    
    public function retornaRanking($mes, $ano, $dataInicial, $dataFinal, $faixa) {
        
       $dataInicial = $this->formataData($dataInicial);
       $dataFinal   = $this->formataData($dataFinal);
        
        $sql = "SELECT  T123.T123_nome           Nome,
                        T122.T123_matricula      Matricula,
                        sum(T122.T122_valor)     Valor
                FROM    T122_ranking_individual T122
                JOIN
                        T123_usuarios_ems T123
                  ON    T122.T123_matricula = T123.T123_matricula
               JOIN     T123_T124   T123124
                   ON   T123124.T123_matricula = T123.T123_matricula
                WHERE 1 = 1";
        
        if($mes != ""){
        $sql    .= " AND MONTH(T122_data_inicial) = $mes";}
        if($ano != ""){
        $sql    .= " AND YEAR(T122_data_inicial) = $ano";}
        if($dataInicial != "null"){
        $sql    .= " AND T122_data_inicial =   '".$dataInicial."'";}
        if($dataFinal != "null"){
        $sql    .=  " AND T122_data_final   =   '".$dataFinal."'";}
        if($faixa != ""){
            $sql .= " AND T124_codigo = ".$faixa;
        }
        
        $sql .=   "  GROUP BY T122.T123_matricula
             ORDER BY  sum(T122.T122_valor) DESC";
        
        
       return $this->query($sql);
        
    }
    
    function truncateTmp() {
        
        $sql = "truncate table tmp_ranking_individual";
        
        return $this->query($sql);
        
    }
    
    function retornaDatasRanking($dataInicial) {
               $dataInicial = $this->formataData($dataInicial);
       $dataFinal   = $this->formataData($dataFinal);
       
       $sql = "SELECT * FROM T122_ranking_individual
                WHERE   T122_data_inicial = '".$dataInicial."'";
  
       return $this->query($sql);
       
    }
    
    function retornaUsuario($usuario){
        
        $sql = "SELECT T123_nome        Nome
                      ,T123_matricula   Matricula
                  FROM  T123_usuarios_ems
                  WHERE 1=1";
        if($usuario != ""){
        $sql .= " AND T123_matricula = ".$usuario;
        }
        
        
        
        return $this->query($sql);
    }
    
    function retornaFaixas($matricula){
        
        $sql =  "SELECT  T124_descricao Descricao
                        ,T124.T124_codigo Codigo
                    FROM T124_setores_confianca T124
                         JOIN T123_T124 T123T124 
                           ON T123T124.T124_codigo = T124.T124_codigo
                   WHERE T123T124.T123_matricula = $matricula";
        
        return $this->query($sql);
        
    }
    
    function selecionaAdministradores($user){
        
        $sql = "SELECT *
                    FROM T004_T009
                   WHERE T004_login = '$user' AND T009_codigo = 64";
        
        return $this->query($sql);
        
    }
    
    
    
        
}
 ?>
