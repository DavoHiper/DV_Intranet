<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 02/08/2013 por Roberta Schimidt
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


$TArq         =  $obj->selecionaTipoArquivo();



if((!empty($_POST))&&($_POST["status"] <> 0)){

$dadosSinistroGe = $obj->retornaSinistroGe($_POST["status"], $user, $_POST["T125_cod_autorizacao"], $_POST["T125_cpf"]);

}
?>

<div class="dialogDadosTroca" style="display: none;">
    
 </div>

<div class="dialogDetalhesTroca" style="display: none;">
    
 </div>

<div class="dialogEditarDadosTroca" style="display: none;">
    
 </div>

<div id="dialog-upload" title="Upload" style="display:none">
	<p    class="validateTips">Selecione um tipo e um arquivo para carregar no sistema!</p>
        <span class="form-input">
	<form action="?router=T0133/js.upload" method="post" id="form-upload"  enctype="multipart/form-data">
	<fieldset>
                <label class="label">Tipo de Arquivo*</label>
                <select                 name="T056_codigo"  id="tp_codigo" class="form-input-select">
                <?php foreach($TArq as $campos=>$valores){?>
                    <option value="<?php echo $valores['COD']?>"><?php echo ($valores['NOM'])?></option>
                <?php }?>
                </select>
                <label class="label">Escolha o Arquivo*</label>
                <input type="file"      name="P0133_arquivo"      id="arquivo" class="form-input-text"   />
                <input type="hidden"    name="T055_nome"            value=""                             />
                <input type="hidden"    name="T055_desc"            value=""                             />
                <input type="hidden"    name="T055_dt_upload"       value=""                             />
                <input type="hidden"    name="T004_login"           value="<?php echo $user?>"           />
                <input type="hidden"    name="T057_codigo"          value=""                             />
                <input type="hidden"    name="T059_codigo"          value=""                             />
                <!-- Tipo Processo (Approval/Aprovação-->
                <input type="hidden"    name="T061_codigo"          value="1"                            />
    </fieldset>
	</form>
        </span>
</div>




<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
       <?php
      $ger = 0;
       foreach($obj->retornaGerenciaSinistro($user) as $cpGerSin => $valGerSin){ $ger++;}
       
       if($ger > 0){?>
        <li><a href="?router=T0133/gerarRelatorio"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-document"  ></span>Relatório </a></li>
        <?php 
       }
        $emissor = 0;
        foreach ($obj->selecionaEmissor($user) as $cpsEmissor => $valEmissor) {
            $emissor++;
        } if($emissor > 0){?>
        <li><a href="?router=T0133/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-circle-plus"    ></span>Novo    </a></li>
        <?php }?>
    </ul>
</div>

<div class="">
    <form action="" method="post" class="validaFormulario">
        <div class="conteudo_16">
            
            <div class="grid_3">
                <label class="label">Status</label>
                <select name="status" id="ges">
                            <option value="0">Selecione...                      </option>
                            <option value="1">Aguardando Troca                  </option>
                            <option value="2">Troca Efetuada                    </option>
                            <option value="3">Pagos                             </option>
                            <option value="4">Todos                             </option>                    
                </select>
            </div>
            
          <div class="grid_3">
                <label class="label">Cod. de Autorização</label>
                <input  type="text" style="width: 100px;" name="T125_cod_autorizacao"   value=""/>    
             </div>
            
          <div class="grid_3 pull_1">
                <label class="label">CPF</label>
                <input  type="text" style="width: 100px;" name="T125_cpf"   value=""/>    
             </div>
            
            <div class="grid_2">
                <input type="submit" value="Filtrar" class="botao-padrao" />                          
            </div>
  
            
        </div>
        
    </form>
</div>

<div class="clear10"></div>

<div class="conteudo_16">

<table class="tablesorter tDados">
        <thead>
            <tr>
                <th>Cod. de Autorização</th>
                <th>CPF</th>
                <th>Nome</th>
                <th>Produto</th>
                <th>Valor</th>
                <th>Anexos</th>
                <th width="7%">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            foreach($dadosSinistroGe as $campos=>$valores) {     
            
             ?>
            <tr class="linha">
                <td class="codigoAutorizacao"><?php echo $valores["CodAutorizacao"];?></td>
                <td class="cpf"><?php echo $valores["CPF"];?></td>
                <td><?php echo $valores["Nome"];?></td>
                <td><?php echo $valores["Produto"];?></td>
                <td><?php echo str_replace('.', ',', $valores["Valor"]);?></td>
                <td>
                    <table class='list-iten-arquivos'>
                        <?php $Arq  =   $obj->selecionaArquivos($valores["CodAutorizacao"]);
                        foreach($Arq as $cpsArq => $vlrArq){
                            
                             if( $cont%2 == 0)
                                        $cor = "line_color";
                                 else
                                        $cor = "";
                                 $cont++;

                                 $lnkArq = $obj->preencheZero("E", 4, $vlrArq['CAT'])."/".$arquivo=$obj->preencheZero("E", 4, $vlrArq['ARQ']).".".$vlrArq['EXT'];
                                 //$lnkBotao = $lnkArq;

                                 $html  = "<tr class='".$cor."'>";
                                 $html .= "<td width='95%' ><a target='_blank' href=".$AD.CAMINHO_ARQUIVOS."CAT".$lnkArq.$AD.">".$vlrArq['NOM']."</a></td>";
                                 $html .= "<td width='5%'  ><a href=".$AD."javascript:excluir('T0133','T0133/home&cod=".$valores['CodAutorizacao']."&path=".$lnkArq."','T125_T055','T055_codigo','".$vlrArq['ARQ']."')".$AD." title='Excluir' class='excluir'></a></td>";
                                 $html .= "</a>";
                                 $html .= "</td>";
                                 $html .= "</tr>";
                                 
                                 $html .= "<!-- Caixa Dialogo Excluir -->";
                                 $html .= "<div id='dialog-confirm' title='Mensagem!' style='display:none'>";
                                 $html .= "<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>Tem certeza que deseja excluir este item?</p>";
                                 $html .= "</div>";

                                 echo $html;
                        }
                        
            
                        
                        ?>
                    </table>
                </td>
                <td>
                    <ul class="lista-de-acoes">
                        <?php if($_POST["status"] == 1){
                        $trocador = 0;
                        foreach ($obj->selecionaTrocador($user) as $cpsTrc => $valTrc) {
                            $trocador++;
                        }
                        if($trocador > 0){?>
                        <li><a href="#" Title="Efetuar Troca" class="efetuarTroca"><span class='ui-icon ui-icon-check'>   </span></a></li>
                        <li><a href="#" Title="Relatar Produtos" class="botaoDadosTroca"><span class='ui-icon ui-icon-refresh'>   </span></a></li>
                        <li><a href="#" Title="Cancelar Sinistro" class="botaoCancelar"><span class='ui-icon ui-icon-cancel'>   </span></a></li>
                        <li><a href="#" Title="Editar Detalhes" class="botaoEditarDadosTroca"><span class='ui-icon ui-icon-pencil'>   </span></a></li>
                        <?php }?>
                        <li><a href="#" Title="Anexar" class="botaoAnexar"><span class='ui-icon ui-icon-pin-s'>   </span></a></li>
                        <li><a href="#" Title="Detalhes" class="botaoDetalhesTroca"><span class='ui-icon ui-icon-search'>   </span></a></li>
                        <?php }else if($_POST["status"] == 2){ ?>
                        <li><a href="#" Title="Detalhes" class="botaoDetalhesTroca"><span class='ui-icon ui-icon-search'>   </span></a></li>    
                        <?php if($ger > 0) {?>
                        <li><a href="#" Title="Confirmar Pagamento" class="confirmaPag"><span class='ui-icon ui-icon-check'>   </span></a></li>
                        <?php } } else {?>
                        <li><a href="#" Title="Detalhes" class="botaoDetalhesTroca"><span class='ui-icon ui-icon-search'>   </span></a></li>
                        <?php }?>
                    </ul>
                </td>
            </tr>      
            
                    
                    
           <?php
            }  
            ?>
        </tbody>
</table>
    
</div>
