<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em:  26/06/2013               
// * Descrição: Ranking Individual Cobrança
// * Entrada:   
// * Origens:   
// Roberta Schimidt
//           
//**************************************************************************
//*/

$obj        =   new models_T0135();

$dados = $obj->somaValores();


if($_POST["T122_data_inicial"] != ""){
    
    $a = 0;
    foreach ($obj->retornaDatasRanking($_POST["T122_data_inicial"]) as $key => $value) {
        $a++;
    }
    
    if($a == 0){
    
    $obj->truncateTmp();
    
    
    foreach ($dados as $cps => $vlr) {
        
        $campos = array(  "T123_matricula"       =>  $vlr["Matricula"]
                        ,"T122_valor"           =>   $vlr["Valor"]
                        ,"T122_data_inicial"    =>  $_POST["T122_data_inicial"]
                        ,"T122_data_final"      =>  $_POST["T122_data_final"]);
        
        $tabela =    "T122_ranking_individual";
        
     $inserir =   $obj->inserir($tabela, $campos);
        
    }
    
    if($inserir){?>
       <div class="conteudo_16">
    <label class="label">Ranking gerado com sucesso !</label>
</div>
  <?php  }
     } else {
         ?>
             
<div class="conteudo_16">
    <label class="label">Ranking já gerado para esse período!</label>
</div>
             
       <?php
         
     }
}

?>

<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a class="botao-padrao"  href="?router=T0135/home"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar </a></li>
    </ul>
</div>


<div class="conteudo_16">
    <form action="" method="post" class="validaFormulario">
    <div class="grid_3">
        <label class="label">Data Inicial</label>
        <input class='data' style="width: 75px;" type="text" name="T122_data_inicial"  value=""/>                
    </div>
    <div class="grid_3">
        <label class="label">Data Final</label>
        <input  type="text" style="width: 75px;" name="T122_data_final"  class="data" value=""/>                
    </div>
    <div class="grid_2">
                <input type="submit" value="Rank" class="botao-padrao" />                          
            </div>
    </form>
                 
</div>
