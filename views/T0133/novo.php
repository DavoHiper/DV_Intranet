<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 05/08/2013 por Roberta Schimidt
// * Descrição: Programa de Controle de Sinistro GE
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//


$obj    =   new models_T0133();

$user           =   $_SESSION['user'];

$data           =   date('d/m/Y H:i:s');

//cadastro do sinistro no BD 

if(!empty($_POST["T125_cpf"])){

$tabelaSinistro = "T125_sinistro_ge";

$cpf = $_POST["T125_cpf"];
$cpf = str_replace(".", "", $cpf);
$cpf = str_replace("-", "", $cpf);


$campos = array("T125_cpf"              =>  $cpf 
               ,"T125_certificado"      =>  $_POST["T125_certificado"]
               ,"T125_cod_autorizacao"  =>  $_POST["T125_cod_autorizacao"]
               ,"T125_produto"          =>  $_POST["T125_produto"]
               ,"T125_nome"             =>  $_POST["T125_nome"]
               ,"T125_valor"            =>  $_POST["T125_valor"]
               ,"T004_login"            =>  $user
               ,"T125_status"           =>  0);        
        
$insere = $obj->inserir($tabelaSinistro, $campos);

$codSinistro = $obj->lastInsertId();

$tabela = "T125_T060";  
$etapa = $obj->retornaEtapaGrupo(268);

  foreach($etapa as $cps=>$valores)
    {
        $array = array ( "T060_codigo"          =>  $valores['EtapaCodigo']
                       , "T125_codigo"          =>  $codSinistro
                       , "T125_T060_ordem"      =>  1
                       , "T125_T060_status"     =>  0
                       , "T004_login"           =>  $user);
        
        $insere2 = $obj->inserir($tabela, $array);
        $insere3 = $obj->inserirFluxoSiGe($codSinistro, $valores['ProxEtapaCodigo'],2);
    }
    
}


?>

<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
  
    <div class="push_9 conteudo_16">
          <ul class="lista-horizontal">
            <li><a href="?router=T0133/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
        </ul>
        <div class="push_7 grid_5">
            <label class="label">Sinistro de GE - Nova </label>
        </div>
    </div>
</div>


<div class="conteudo_16">
    <form action="" method="post" class="validaFormulario">
    <div class="grid_5">
        <label class="label">CPF</label>
        <input class='cpf' style="width: 100px;" type="text" name="T125_cpf"  value=""/>                
    </div>
    <div class="grid_3 push_2">
        <label class="label">Certificado</label>
        <input  type="text" style="width: 100px;" name="T125_certificado"   value=""/>                
    </div>
        <div class="grid_3 push_2">
        <label class="label">Código de Autorização</label>
        <input  type="text" style="width: 100px;" name="T125_cod_autorizacao"   value=""/>                
    </div>
        <div class="clear"></div>    
    
    <div class="grid_5">
        <label class="label">Nome</label>
        <input  type="text" name="T125_nome"   value=""/>                
    </div>
        
   <div class="grid_5 push_2" >
        <label class="label">Produto</label>
        <input  type="text" name="T125_produto"   value=""/>                
    </div>
   <div class="grid_2 push_2" >
        <label class="label">Valor</label>
        <input  type="text" name="T125_valor"   value="" class="valor"/>                
    </div>
    <div class="clear"></div>    
    <div class="grid_2">
                <input type="submit" value="Enviar" class="botao-padrao" />                          
            </div>
    </form>
                 
</div>