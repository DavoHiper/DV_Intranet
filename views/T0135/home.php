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

if((($_POST["ano"])&&($_POST["mes"]) != "")||($_POST["T122_data_inicial"])!= ""){
    
    $mes = $_POST["mes"];
    $ano = $_POST["ano"];
    $dataInicial    =   $_POST["T122_data_inicial"];
    $dataFinal      =   $_POST["T122_data_final"];
    $faixa          =   $_POST["T123_faixa"];
    
$dados      = $obj->retornaRanking($mes, $ano, $dataInicial, $dataFinal, $faixa) ;
}
?>
<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <?php 
        $adm = 0;
        
        foreach ($obj->selecionaAdministradores($_SESSION["user"]) as $cpsAdm => $vlrAdm) {
            
            $adm++;
            
        }   if($adm > 0) {?>
        <li><a href="?router=T0135/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
        <li><a href="?router=T0135/importa"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Importar    </a></li>
        <li><a href="?router=T0135/novoUsuarioEMS"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo Usuário    </a></li>
        <?php }?>
    </ul>
</div>

<div class="div-primaria div-filtro">
    <form action="" method="post" class="validaFormulario">
        
        <div class="conteudo_16">
            
            <div class="grid_3">
                <label class="label">Mês</label>
                <select name="mes" id="mes">
                    <option value="">Selecione...</option>
                    <option value="01">Janeiro</option>
                    <option value="02">Fevereiro</option>
                    <option value="03">Março</option>
                    <option value="04">Abril</option>
                    <option value="05">Maio</option>
                    <option value="06">Junho</option>
                    <option value="07">Julho</option>
                    <option value="08">Agosto</option>
                    <option value="09">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
            </div>
            
            <div class="grid_3">
                <label class="label">Ano</label>
                <input style="width:45px;" type="text" name="ano"  value=""/>                
            </div>
            
            <div class="grid_3">
                <label class="label">Período Semanal</label>
                <input style="width:65px;" type="text" name="T122_data_inicial"  value="" class="data"/>                
                <input style="width:65px;" type="text" name="T122_data_final"    value="" class="data"/>                
            </div>
            
             <div class="grid_3">
                <label class="label">Faixa</label>
                <select name="T123_faixa" id="faixa">
                    <option value="">Selecione a Faixa...</option>
                    <option value="1">12 a 25 dias</option>
                    <option value="2">26 a 44 dias</option>
                    <option value="3">Receptivo</option>
                    <option value="4">Híbrido</option>
                </select>
            </div>
            
            <div class="grid_2">
                <input type="submit" value="Filtrar" class="botao-padrao" />                          
            </div>
            
            <div class="clear10"></div>
            
            <table class="tablesorter tDados">
                <thead>
                    <tr class="ui-widget-header ">
                        <th>Rank </th>
                        <th>Nome </th>
                        <th>Valor </th>
                    </tr> 
                </thead>
                <tbody class="campos">
                    <?php $rank = 0; foreach($dados    as  $campos =>  $valores){ $rank++;
                    if ($contador % 2 == 1) {
                            $coratual = "#cccccc";
                        } else {
                            $coratual = "#FFFFFF";
                        }
                    ?>
                    <tr >
                        <td style="background-color: <?php echo $coratual;?>;"><?php echo $rank."º"; ?></td>
                        <td style="background-color: <?php echo $coratual;?>;"><?php echo $valores["Nome"];  ?></td>
                        <td style="background-color: <?php echo $coratual;?>;"><?php echo str_replace(".", ",", $valores["Valor"]);  ?></td>
                    </tr>
                    <?php  
                    $contador++;
                        } ?>
                </tbody>
            </table>            
            
            
        </div>
        
    </form>        
</div>

