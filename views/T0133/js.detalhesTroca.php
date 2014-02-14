<?php
$obj = new models_T0133();

$codAutorizacao =  $_POST["codigoAutorizacao"];
$cpf            =   $_POST["cpf"];

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
foreach ($dadosVendedor as $cpsV => $valV) {
$html   .=  "       <div class='grid_3'>";
$html   .=  "           <label>Vendedor: ". $valV["Vendedor"]."</label>";
$html   .=  "       </div>";
$html   .=  "       <div class='grid_3'>";
$html   .=  "           <label>Data da Troca: ". $valV["Data"]."</label>";
$html   .=  "       </div>";
$html   .=  "       <div class='clear10'></div>";}
$html  .=   "<table class='tablesorter tDados'>";
$html  .=   "   <thead>";
$html  .=   "       <tr>";
$html  .=   "           <th>PDV</th>";
$html  .=   "           <th>Cupom</th>";
$html  .=   "           <th>Cód. Produto</th>";
$html  .=   "           <th>Valor</th>";
$html  .=   "        </tr>";
$html  .=   "   </thead>";
$html  .=   "  <tbody>";

foreach ($dadosTroca as $cps => $val) {
$html   .=  "<tr>";    
$html   .=  "   <td>".$val["PDV"]."</td>";    
$html   .=  "   <td>".$val["Cupom"]."</td>";    
$html   .=  "   <td>".$val["CodigoProduto"]."</td>";    
$html   .=  "   <td>".$val["Valor"]."</td>";    
$html   .=  "</tr>";    

}

$html   .=  "</tbody>";    
$html   .=  "</table>";    
$html   .=  "</div>";    


echo $html;

?>


