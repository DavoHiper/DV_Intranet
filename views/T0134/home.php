<?php
// teste ORAAS141
//Instancia Classe
$obj        =   new models_T0134();

$user       =   $_SESSION['user'];

if(!empty($_POST))
{
    $nome       =   $_POST['nome'];
    $depto      =   $_POST['T077_codigo'];
    $funcao     =   $_POST['T121_codigo'];
    $loja       =   $_POST['T006_codigo'];
        
    $dados      =   $obj->retornaDados($nome, $depto, $funcao, $loja);
}else
    $dados      =   $obj->retornaDados();

?>
<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#" class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros oculta -->
<div class="conteudo_16  div-filtro">
    
    <form action="" method="post" class="div-filtro-visivel validaFormulario">
        <!--<input type="hidden" name="router" value="T0119/home" />-->
        
        <div class="grid_3">
            <label class="label">Filtro Dinâmico</label>
            <input width="155px" type="text" id="filtroDinamico" value="" name="search">
        </div>
                        
        <div class="grid_4">
            <label class="label">Nome</label>
            <input type="text" name="nome"  value="<?php if(!empty($nome)) echo $nome;?>"/>               
        </div>        
        
        <div class="grid_4">
            <?php echo $obj->retornaHtmlDeptosColaboradores($depto); ?>              
        </div>
        
        <div class="grid_4">
            <?php echo $obj->retornaHtmlFuncoesColaboradores($funcao); ?>            
        </div>
        
        <div class="clear"></div>
        
        <div class="grid_4">       
            <?php echo $obj->retornaHtmlComboTodasLojas($loja); ?>
        </div>                                       

        <div class="grid_1">
            <input type="submit" class="botao-padrao" value="Filtrar">
        </div>
        
        <div class="clear10"></div>
                
    </form>
    
</div>

<div class="conteudo_16">    
                
    <table id="tPrincipal" class="tablesorter">
        <thead>
            <tr>
                <th>Nome Colaborador</th>
                <th>Departamento</th>
                <th>Função</th>
                <th>Contatos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dados    as $campos  =>  $valores){?>
            <tr class="dados">                               
                <td><?php echo $valores['UsuarioNome']?></td>
                <td><?php echo $valores['DeptoNome']?></td>
                <td><?php echo $valores['FuncaoNome']?></td>
                <td>
                    <table>
                        <?php 
                        
                        $dadosFone  =   $obj->retornaDadosFone($valores['UsuarioLogin']);
                        foreach($dadosFone    as  $cpFone =>  $vlFone){ ?>
                        <tr>
                            <td><b><?php echo $vlFone['NomeTpFone'];?>:</b></td>                            
                            <td><?php echo "(".$vlFone['DDD'].") ".$vlFone['Numero'];?></td>
                            
                            <?php if(!is_null($vlFone['Ramal'])){?>
                                <td><b>Ramal:</b></td>     
                                <td><?php echo $vlFone['Ramal'];?></td>
                            <?php }?>
                        </tr>
                        <?php }?>
                    </table>
                </td>
            </tr>
            <?php }?>
        </tbody>
        
    </table>
    
    <div class="clear10"></div>
    
    <div class="grid_3">
        <input type="button" class="botao-padrao" value="Visualizar Selecionados" id="visualizarSelecionados"/>
    </div>
    
</div>   