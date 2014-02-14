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
class models_T0133 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    
    
       public function retornaEtapaGrupo($cod)
   {
       $sql = "SELECT T1.T060_codigo              EtapaCodigo
                    , T1.T060_proxima_etapa       ProxEtapaCodigo
                 FROM T060_workflow               T1
                WHERE T1.T059_codigo              = $cod";
             
      
       return $this->query($sql);
   }
   
   
       public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        
        if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');  
        
        return $insere;
    }
    
        public function inserirFluxoSiGe($codSinistro, $codEtapa, $ordem)
    {   $tabela = "T125_T060";
        $user   = $_SESSION['user'];
        if(!is_null($codEtapa))
        {
            $Etapas = $this->retornaProximaEtapa($codEtapa);

            foreach($Etapas as $campos=>$valores)
            {
                $array = array ( "T060_codigo"=>$valores['EtapaCodigo']
                               , "T125_codigo"=>$codSinistro
                               , "T125_T060_ordem"=>$ordem
                               , "T125_T060_status"=>1
                               , "T004_login"=>$user);
                $this->inserir($tabela, $array);
                $this->inserirFluxoSiGe($codSinistro, $valores['ProxCodigoEtapa'], $ordem+1);
            }
        }
        return true;
    }
    
    
       public function retornaProximaEtapa($codEtapa)
   {
       return $this->query("SELECT T1.T060_codigo              EtapaCodigo
                                 , T1.T060_proxima_etapa       ProxCodigoEtapa
                              FROM T060_workflow               T1
                             WHERE T1.T060_codigo              = $codEtapa");
   }
   
   
   public function retornaSinistroGe($codGrupo, $user, $codAutorizacao, $cpf, $dataInicial, $dataFinal) {
       
     
       
       $sql = "SELECT   T125.T125_cpf CPF,
                        T125.T125_certificado Certificado,
                        T125.T125_nome Nome,
                        T125.T125_produto Produto,
                        T125.T125_valor     Valor,
                        T125.T125_cod_autorizacao CodAutorizacao,
                        T125.T125_dt_troca  Data,
                        T125.T125_vendedor_troca Vendedor
                   FROM T125_sinistro_ge T125
                        JOIN T125_T060 T125T60
                           ON T125.T125_codigo = T125T60.T125_codigo
                        JOIN T060_workflow T60
                           ON T125T60.T060_codigo = T60.T060_codigo
                  WHERE     1=1";
       
       if($codGrupo == 1){
            $sql .= "  AND T125T60.T060_codigo = 211 AND T125T60.T125_T060_status = 0 
       AND (EXISTS
              (SELECT *
                 FROM T004_T059 T0459
                WHERE     T0459.T004_login = '$user'
                      AND T0459.T059_codigo = 269) OR (T125.T004_login = '$user'))
                      AND T125.T125_status <> 4";}
       if($codGrupo == 2){
           $sql .= " AND T125T60.T060_codigo = 211 AND T125T60.T125_T060_status = 1  AND T125.T125_status <> 4";
           $sql .= " AND NOT EXISTS (SELECT * FROM T125_T060 X WHERE X.T125_codigo = T125T60.T125_codigo 
                     AND X.T060_codigo = 210 AND X.T125_T060_status = 2  )   ";
       }
       
       if ($codGrupo == 3){
           $sql .= " AND T125T60.T060_codigo = 210 AND T125T60.T125_T060_status = 2 AND T125.T125_status <> 4";
       }
       
       if( $codAutorizacao != ""){
           $sql .=  " AND T125.T125_cod_autorizacao = '".$codAutorizacao."'";
       }
       
       if( $cpf != ""){
           $sql .=  " AND T125.T125_cpf = '".$cpf."'";
       }
       
         if (($dataInicial != "")&&($dataFinal != ""))
            {
                $sql .= "AND T125.T125_dt_troca between '$dataInicial' and '$dataFinal'";
            }
           if($codGrupo == 4){
            $sql .= " GROUP BY  T125.T125_cod_autorizacao ";}
            
          
       
        //   echo $sql;
        
       
      return $this->query($sql);
   
   }
   
   public function retornaTrocaSinistro($codAutorizacao) {
       
       $sql = "SELECT T125.T125_codigo ID
                    FROM T125_sinistro_ge T125
                   WHERE T125.T125_cod_autorizacao = '$codAutorizacao'";
       
       return $this->query($sql);
       
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
   
    
    
    public function selecionaDetalhesTroca($codAutorizacao) {
        
        $sql = "SELECT T127.T127_codigo ID,
                        T127.T127_cod_autorizacao CodAutorizacao,
                        T127.T127_pdv PDV,
                        T127.T127_cupom Cupom,
                        T127.T127_cod_produto CodigoProduto,
                        T127.T127_valor Valor
                   FROM T127_dados_produto_ge T127
                  WHERE T127_cod_autorizacao = '$codAutorizacao'";
        
        return $this->query($sql);
        
    }
    

    
    public function retornaTroca($sinistro) {
        
        $sql = "SELECT T125_vendedor_troca Vendedor,
                       DATE_FORMAT(T125_dt_troca, '%d/%m/%Y')    Data
                    FROM T125_sinistro_ge
                        WHERE T125_cod_autorizacao = '$sinistro'   ";
        
        return $this->query($sql);
        
    }




    public function selecionaTipoArquivo()
    {
       return $this->query("SELECT DISTINCT TF1.T056_codigo	COD
                                 , TF1.T056_nome		NOM 
                              FROM T056_categoria_arquivo TF1
                              ORDER BY TF1.T056_nome") ;
       
       
    }
    
    public function selecionaArquivos($sinistro)
    {
        $sql = "SELECT T5.T056_nome           NOM
                                  , T5.T056_codigo         CAT
                                  , T3.T055_codigo         ARQ
                                  , T5.T056_desc           DES
                                  , T4.T057_nome           EXT
                               FROM T125_T055              T1
                                  , T125_sinistro_ge       T2
                                  , T055_arquivos          T3
                                  , T057_extensao          T4
                                  , T056_categoria_arquivo T5
                              WHERE T1.T125_codigo =   T2.T125_cod_autorizacao
                                AND T1.T055_codigo =   T3.T055_codigo
                                AND T3.T056_codigo =   T5.T056_codigo
                                AND T3.T057_codigo =   T4.T057_codigo
                                AND T1.T125_codigo =   $sinistro";
        
       // echo $sql;
        return $this->query($sql);
        
        
        
   }
   
   
       public function selecionaExtensao($extensao)
    {
       return $this->query("SELECT T1.T057_codigo   COD
                                  , T1.T057_nome    NOM
                                  , T1.T057_desc    DES
                               FROM T057_extensao   T1
                              WHERE T1.T057_nome = '$extensao'");
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
    
    public function selecionaEmissor($user){
        
        $sql = "SELECT T004_login LOGIN
                     FROM T004_T059
                    WHERE T061_codigo = 6 AND T059_codigo = 268 AND T004_login = '$user'";
        
        return $this->query($sql);
    }
    
    
       public function selecionaTrocador($user){
        
        $sql = "SELECT T004_login LOGIN
                     FROM T004_T059
                    WHERE T061_codigo = 6 AND T059_codigo = 269 AND T004_login = '$user'";
        
        return $this->query($sql);
    }
    
    public function retornaDadosRelatorio($dataInicial, $dataFinal){
        
        $sql = "SELECT T125.T125_cpf CPF,
                        T125.T125_certificado Certificado,
                        T125.T125_nome Nome,
                        T125.T125_produto Produto,
                        T125.T125_valor Valor,
                        T125.T125_cod_autorizacao CodAutorizacao,
                        T125.T125_dt_troca Data,
                        T125.T125_vendedor_troca Vendedor
                   FROM T125_sinistro_ge T125
                        JOIN T125_T060 T125T60
                           ON T125.T125_codigo = T125T60.T125_codigo
                        JOIN T060_workflow T60
                           ON T125T60.T060_codigo = T60.T060_codigo
                  WHERE     1 = 1
                        AND T125T60.T060_codigo = 211
                        AND T125T60.T125_T060_status = 1
                        AND T125.T125_status <> 4
                        AND NOT EXISTS
                                   (SELECT *
                                      FROM T125_T060 X
                                     WHERE     X.T125_codigo = T125T60.T125_codigo
                                           AND X.T060_codigo = 210
                                           AND X.T125_T060_status = 2)
                        AND T125.T125_dt_troca >= '$dataInicial'
                        AND T125.T125_dt_troca <= '$dataFinal'" ;
        
        return $this->query($sql);
        
    }
    
    
    public function retornaProdTroca ($codAutorizacao){
        
        
        $sql = "SELECT *
                    FROM T127_dados_produto_ge
                   WHERE T127_cod_autorizacao = '$codAutorizacao'";
        
        
        return $this->query($sql);

    }
    
    public function retornaGerenciaSinistro($usuario){
        
        $sql = "SELECT * FROM T004_T009"
                . " WHERE T004_login = '$usuario'"
                . " AND T009_codigo = 67 ";
        
        
        
        return $this->query($sql);
        
        
        
    }
    
    
    function retornaUltimoCod(){
        
        $sql = "SELECT max(T125_codigo) FROM T125_sinistro_ge";
        
        return $this->query($sql);
        
    }
   
    
}
?>
