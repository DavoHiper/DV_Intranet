<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em:  02/07/2013               
// * Descrição: Ranking Individual Cobrança
// * Entrada:   
// * Origens:   
// Roberta Schimidt
//           
//**************************************************************************
//*/

$obj        =   new models_T0135();


if(!empty($_POST["T123_nome"])){
    
    $tabela = "T123_usuarios_ems";
    
    $campos = array("T123_matricula"    =>  $_POST["T123_matricula"]
                   ,"T123_nome"         =>  $_POST["T123_nome"]);
    
    $insere1 = $obj->inserir($tabela, $campos);
    
    $tabela2 = "T123_T124";

    $campos2 = array("T123_matricula"   =>  $_POST["T123_matricula"]
                    ,"T124_codigo"      =>  $_POST["T124_codigo"]);

    $insere2   =    $obj->inserir($tabela2, $campos2);

        
    
    
    
}

         ?>

<div id="dialog-mensagem-usuarioEms">
</div>

<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a class="botao-padrao"  href="?router=T0135/home"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar </a></li>
    </ul>
</div>

<div class="conteudo_16">
    <form action="" method="post" class="validaFormulario">
    <div class="grid_6">
        <label class="label">Nome</label>
        <input  style="width: 250px;" type="text" name="T123_nome"  value=""/>                
    </div>
    <div class="grid_3">
        <label class="label">Código EMS</label>
        <input  type="text" style="width: 75px;" name="T123_matricula"   value=""/>                
    </div>
    <div class="grid_3">
                <label class="label">Faixa</label>
                <select name="T124_codigo" id="faixa">
                    <option value="">Selecione a Faixa...</option>
                    <option value="1">12 a 25 dias</option>
                    <option value="2">26 a 44 dias</option>
                    <option value="3">Receptivo</option>
                    <option value="4">Híbrido</option>
                </select>
            </div>
    <div class="grid_2">
                <input type="submit" value="Gravar" class="botao-padrao" />                          
            </div>
    </form>
    
       <div class="clear10"></div>
            
            <table class="tablesorter tDados" >
                <thead>
                    <tr class="ui-widget-header ">
                        <th>Nome </th>
                        <th width="10%">Código EMS </th>
                        <th width="20%">Ações </th>
                    </tr> 
                </thead>
                <tbody class="campos">
                    <?php foreach($obj->retornaUsuario() as  $campos =>  $valores){
                    if ($contador % 2 == 1) {
                            $coratual = "#cccccc";
                        } else {
                            $coratual = "#FFFFFF";
                        }
                    ?>
                    <tr class="dados">
                        <td style="background-color: <?php echo $coratual; ?>;"><?php echo $valores["Nome"]; ?></td>
                            <td style="background-color: <?php echo $coratual; ?>;" class="codigo"><?php echo $valores["Matricula"]; ?></td>
                            <td style="background-color: <?php echo $coratual; ?>;"><span class="lista_acoes">
                                    <ul>
                                        <li class="ui-state-default ui-corner-all" title="Excluir" >
                                            <a class="ui-icon ui-icon-closethick exclui"  ></a>
                                        </li>
                                        <li class="ui-state-default ui-corner-all" title="Editar">
                                            <a class="ui-icon ui-icon-pencil" href="?router=T0135/editarUsuario&T123_matricula=<?php echo $valores["Matricula"];?>"></a>
                                        </li>
                                    </ul>
                                </span></td>
                    </tr>
                    <?php  
                    $contador++;
                        } ?>
                </tbody>
            </table>  
                 
</div>
