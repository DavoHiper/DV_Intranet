<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 21/11/2013 por Roberta Schimidt
// * Descrição: Programa de Controle de Sinistro GE
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//


$obj        =   new models_T0133();

$user           =   $_SESSION['user'];


?>

<div class="">
    <form action="?router=T0133/js.exportarExcel" method="post" class="validaFormulario">
        <div class="conteudo_16">
            
          <div class="grid_3">
                <label class="label">Data Inicial</label>
                <input  type="text" style="width: 100px;" name="dataInicial" class="data"  value=""/>    
             </div>
            
          <div class="grid_3 pull_1">
                <label class="label">Data Final</label>
                <input  type="text" style="width: 100px;" name="dataFinal" class="data"   value=""/>    
             </div>
   
        
             <div class="grid_2">
                <input type="submit" value="Filtrar" class="botao-padrao" />                          
            </div>
           </div>
    </form>
</div>
