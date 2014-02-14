<?php
$obj = new models_T0133();

$codAutorizacao =   $_POST["codigoAutorizacao"];
$cpf            =   $_POST["cpf"];


$html    =  "<div class='conteudo_16' style='width:auto;'>";
$html   .=  "   <form action='?router=T0133/js.inserirDados' method='post' id='dialogForm'>";
$html   .=  "       <div class='clear10'></div>";
$html   .=  "       <div class='grid_4'>";
$html   .=  "           <label>Código de Autorização: $codAutorizacao</label>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_3'>";
$html   .=  "           <label>CPF: $cpf</label>";
$html   .=  "       </div>";
$html   .=  "       <div class='clear10'></div>";
$html   .=  "       <div class='clear10'></div>";
$html   .=  "       <div class='grid_2'>";
$html   .=  "           <label>Código do Vendedor</label>";
$html   .=  "           <input type='text' class='vendedor' name='T125_vendedor_troca'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_2'>";
$html   .=  "           <label>Data da Troca</label>";
$html   .=  "           <input type='text' class='data' name='T125_dt_troca'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='clear10'></div>";
$html   .=  "       <div class='clear10'></div>";
$html   .=  "      <div class='linhaDados'>";
$html   .=  "       <div class='grid_2'>";
$html   .=  "           <label>PDV</label>";
$html   .=  "           <input type='text' class='pdv' name='T127_pdv[]'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_2'>";
$html   .=  "           <label>Cupom</label>";
$html   .=  "           <input type='text' class='cupom' name='T127_cupom[]'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_2'>";
$html   .=  "           <label>Código Produto</label>";
$html   .=  "           <input type='text' class='codProduto' name='T127_cod_produto[]'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_2'>";
$html   .=  "           <label>Valor</label>";
$html   .=  "           <input type='text' class='valor' name='T127_valor[]'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_1'>";
$html   .=  "           <input type='hidden' class='numerador' name='numerador[]'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_1'>";
$html   .=  "           <label><br></label>";
$html   .=  "           <ul class='lista-de-acoes'><li><a href='#' Title='Adicionar Produto' class='botaoMaisProduto'><span class='ui-icon ui-icon-circle-plus'></span></a></li></ul>    ";
$html   .=  "       </div>";
$html   .=  "<div class='form-inpu-tab'></div>";
$html   .=  "</div>";
$html   .=  "       <div class='clear10'></div>";
$html   .=  "       <div class='clear10'></div>";
$html   .=  "       <div class='grid_1'>";
$html   .=  "           <input type='hidden' class='codAutorizacao' name='codAutorizacao' value='$codAutorizacao'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_1'>";
$html   .=  "           <input type='hidden' class='cpf' name='cpf'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_2'>";
$html   .=  "           <input id='btnFiltrar' class='ui-button ui-widget ui-state-default ui-corner-all' type='submit' value='Efetuar Troca' role='button'> ";
$html   .=  "       </div>";
$html   .=  "   </form>";
$html   .=  "</div>";



echo $html;


        


?>
