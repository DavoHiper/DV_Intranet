<?php
$obj = new models_T0133();

$codAutorizacao = $_POST["codigoAutorizacao"];
$cpf = $_POST["cpf"];

$dadosTroca = $obj->selecionaDetalhesTroca($codAutorizacao);
$dadosVendedor = $obj->retornaTroca($codAutorizacao);


$html   = "<div class='conteudo_8'>";
$html   .=  "       <div class='clear10'></div>";
$html   .=  "       <div class='grid_4'>";
$html   .=  "           <label>Código de Autorização: $codAutorizacao</label>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_3'>";
$html   .=  "           <label>CPF: $cpf</label>";
$html   .=  "       </div>";
$html   .=  "       <div class='clear10'></div>";
$html   .=  "       <div class='clear10'></div>";

foreach ($dadosVendedor as $cpsV => $valV) {
    
$html   .=  "       <div class='grid_2'>";
$html   .=  "           <label>Código do Vendedor</label>";
$html   .=  "           <input type='text' class='vendedor' name='T125_vendedor_troca' value='".$valV["Vendedor"]."'/>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_2'>";
$html   .=  "           <label>Data da Troca</label>";
$html   .=  "           <input type='text' class='data' name='T125_dt_troca' value='".$valV["Data"]."'/>";
$html   .=  "       </div>";
    
}

$html   .=  "       <div class='clear10'></div>";
$html   .=  "       <div class='clear10'></div>";

$html  .=   "<table class='tablesorterEdit tDados'>";
$html  .=   "   <thead>";
$html  .=   "       <tr>";
$html  .=   "           <th>PDV</th>";
$html  .=   "           <th>Cupom</th>";
$html  .=   "           <th>Cód. Produto</th>";
$html  .=   "           <th>Valor</th>";
$html  .=   "           <th></th>";
$html  .=   "           <th></th>";
$html  .=   "        </tr>";
$html  .=   "   </thead>";
$html  .=   "  <tbody>";

$i = 0;
foreach ($dadosTroca as $cps => $val) {
$html   .=  "<tr class='linhaDadosEdit'>";    
$html   .=  "   <td><input type='text' class='pdv' name='T127_pdv[]' value='".$val["PDV"]."'/> <input type='hidden' class='ID' name='T127_codigo[]' value='".$val["ID"]."'/></td>";    
$html   .=  "   <td><input type='text' class='cupom' name='T127_cupom[]' value='".$val["Cupom"]."'/></td>";    
$html   .=  "   <td><input type='text' class='codProduto' name='T127_cod_produto[]' value='".$val["CodigoProduto"]."'/></td>";    
$html   .=  "   <td><input type='text' class='valor' name='T127_valor[]' value='".$val["Valor"]."'/><input type='hidden' class='numerador' name='numerador[]' value='".$i++."'/></td>";    
$html   .=  "   <td><ul class='lista-de-acoes'><li><a href='#' Title='Adicionar Produto' class='botaoMaisProdutoEdit'><span class='ui-icon ui-icon-circle-plus'></span></a></li></ul></td>"; 
$html   .=  "   <td><ul class='lista-de-acoes'><li><a href='#' Title='Excluir Produto' class='botaoRemoverProd'><span class='ui-icon ui-icon-circle-minus'></span></a></li></ul></td>"; 
$html   .=  "</tr>";    

   }

$html   .=  "</tbody>";    
$html   .=  "</table>";    
$html .= "";

echo $html;
?>
