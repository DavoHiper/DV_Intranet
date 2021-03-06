<?php
// Session usuário [Seleciona Usuário]
$user           = $_SESSION['user'];
// Variavel para deixar como default em Owner nos filtros de arquivos e upload de arquivo
$owner          = $_SESSION['displayName']." - ".$_SESSION['user'];

//Cria objeto de conexão com as models
$obj       = new models_T0029();
//Variavel retorna todos os tipos de arquivos para listar o filtro de tipo de arquivo
$TipArq       = $obj->retornaTipoArquivos();
//Variavel retorna todos os tipos de arquivos para listar no cadastro de upload de arquivo
$FiltroTipArq = $obj->retornaTipoArquivos();
//Variavel retorna todos os perfis para filtro
$filtroPerfil = $obj->retornaPerfisFiltro();
//Variavel retorna todos as lojas para filtro
$filtroLoja   = $obj->retornaLojas(); 

//Retorna grid com ou sem filtro
$FilDesc           = $_POST['T055_desc']                                         ;
$FilDepartamento   = $_POST['departamento']                                 ;
$FilTipoArquivo    = $_POST['tipo_arq']                                     ;
$FilProprietario   = $obj->formataLoginAutoComplete($_POST['proprietario']) ;
$FilPerfil         = $_POST['perfil']                                       ;
$FilDtInicial      = $_POST['dt_inicial']                                   ;
$FilDtFinal        = $_POST['dt_final']                                     ;
$FilNomeArquivo    = $_POST['nome_arquivo']                                 ;

//Monta os filtros à serem utilizados
$Filtro = ' ' ;

if(!empty($FilDesc)){
  $Filtro .=  ' AND( ( T55.T055_desc      LIKE '."'%".$FilDesc."%'".' ) ';
  $Filtro .=  ' OR ( T55.T055_nome        LIKE '."'%".$FilDesc."%'".' ) ';
  $Filtro .=  ' OR ( T55.T055_tags        LIKE '."'%".$FilDesc."%'".' )) ';}
if(!empty($FilDepartamento))
  $Filtro .=  ' AND ( SED.DepartamentoCodigo = '.$FilDepartamento.' ) ';
if(!empty($FilProprietario))
  $Filtro .=  ' AND ( T55.T004_owner = '."'".$FilProprietario."'".' ) ';
if(!empty($FilNomeArquivo))
  $Filtro .=  ' AND ( T55.T055_nome LIKE '."'%".$FilNomeArquivo."%'".' ) ';
if(!empty($FilTipoArquivo))
  $Filtro .=  ' AND ( T55.T056_codigo = '.$FilTipoArquivo.' ) ';
if(!empty($FilDtInicial))
  $Filtro .=  ' AND ( T55.T055_dt_upload  >= str_to_date('."'".$FilDtInicial."'".', "%d/%m/%Y" ) )';
if(!empty($FilDtFinal))
  $Filtro .=  ' AND ( T55.T055_dt_upload  <= str_to_date('."'".$FilDtFinal."'".', "%d/%m/%Y" ) )';

 $Arquivos = $obj->retornaArquivos($user,$Filtro);

 // Retorna o valor de proprietario no campo filtro

  if ($FilProprietario == $user)
      $FiltroProprietarioCampo = $owner;
  else
      $FiltroProprietarioCampo = $FiltroProprietario;

?>
<script type="text/javascript" src="template/js/interno/T0029/T0029.js"></script>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0029/home" class="active" >Listar</a></li>
                <li><a href="?router=T0029/novo"                >Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<script src="template/js/interno/T0029/upload.js"></script>
<div id="dialog-upload" title="Upload" style="display:none">
	<p    class="validateTips">Selecione um tipo e um arquivo para carregar no sistema!</p>
        <span class="form-input">
	<form action="?router=T0029/js.upload" method="post" id="form-upload"  enctype="multipart/form-data">
	<fieldset>
            
                <label class="label">Escolha o Arquivo*</label>
                <input type="file"      name="P0029_arquivo"      id="arquivo" class="form-input-text"   />
        </fieldset>
	</form>
        </span>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Filtros de Arquivos</a></li>
        <?php
        //Retorna se o usuário tem permissão de update
        $permissao = $obj->retornaUsuarioUP($user);
        foreach($permissao as $campos=>$valores)
        {
            $usu_permissao = $valores['Permissao'];
        }
        ?>
    </ul>
    <div id="tabs-1">
        <form action="" method="post">
        <div id="formulario">
            <span  class="form-input">
                <table class="form-inpu-tab">
                    <thead>
                        <tr>
                            <th width="155px"><label>Descrição</label></th>
                            <th width="155px"><label>Departamento</label></th>
                            <th width="155px"><label>Tipo de Arquivo</label></th>
                        </tr>
                        <tr>
                            <td>
                              <input type='text' name='T055_desc' id='T055_desc' size='50'/>  
                            </td>
                            <td>
                                <select name="departamento">
                                    <option value="">Selecione...</option>
                                    <?php
                                    function verificaDeptos($CodigoPai, $FilDepartamento)
                                    {
                                        global $nivel; $nivel ++;
                                        $obj    =   new models_T0029();
                                        $DptosPai  =   $obj->retornaDepartamentosPai($CodigoPai);                                        
                                        foreach($DptosPai   as  $campos =>  $valores)
                                        {       
                                            if (!empty($valores['DptoPai']))
                                                $Cascata .= str_repeat("&nbsp",($nivel*4)-4)   ;
                                            else
                                                $Cascata  = "" ;  // Raiz pai = NULL
                                            
                                            if ($FilDepartamento == $valores['DptoCodigo'])
                                                $selected   =   "selected"  ;
                                            else
                                                $selected   =   ""          ;
                                                                                        
                                            echo "<option value='".$valores['DptoCodigo']."'".$selected.">".$Cascata.$obj->preencheZero("E", 3, $valores['DptoCodigo'])."-".$valores['DptoNome']."</option>";
                                            $Cascata  = ""                  ;
 
                                            verificaDeptos($valores['DptoCodigo'], $FilDepartamento);
                                        }
                                        $nivel --;
                                    }
                                    $CodigoPai      =   NULL    ;
                                    $Retorno    =   verificaDeptos($CodigoPai, $FilDepartamento);
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select name="tipo_arq">
                                    <option value="">Selecione...</option>
                                    <?php
                                    foreach($FiltroTipArq as $campos=>$valores){
                                    ?>
                                    <option value="<?php echo $valores['Codigo']; ?>" <?php  if ( $FilTipoArquivo == $valores['Codigo']) echo "selected"; ?>><?php echo $obj->preencheZero("E", 2, $valores['Codigo'])." - ".$valores['Nome'] ; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            
                        </tr>
                        <tr>
                            <th width="155px"><label>Dinâmico    </label></th>                            
                            <th width="155px"><label>Proprietário</label></th>                              
                            <th><label>Nome do Arquivo           </label></th>                          
                            <th width="155px"><label>Data Inicial</label></th>
                            <th width="155px"><label>Data Final  </label></th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="search" value="" id="id_search" />
                                <br/><span class="loading">Carregando...</span>
                            </td>   
                            <td>
                                <input type="text" id="proprietario" name="proprietario" value="<?php if (!empty($FiltroProprietarioCampo)) echo $FiltroProprietarioCampo; //else echo $owner; ?>" class="buscaUsuario" />
                            </td>                            
                            <td><input type="text" id="nome_arquivo" name="nome_arquivo" value="<?php echo $FilNomeArquivo; ?>" size="20" /></td>
                            <td><input type="text" id="dt_inicial"   name="dt_inicial"   value="<?php echo $FilDtInicial;   ?>" size="7"  /></td>
                            <td><input type="text" id="dt_final"     name="dt_final"     value="<?php echo $FilDtFinal;     ?>" size="7"  /></td>
                        </tr>
                    </thead>
                </table>
                <div class="form-inpu-botoes">
                    <input type="hidden" name="T004_login" value="<?php echo $user; ?>" />
                    <input type="submit" value="Filtrar" />
                </div>
            </span>
        </div>
        </form>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
                    <tr class="ui-widget-header ">
                        <th>Nome                          </th>
                        <th width="8%">Data do<br/> Upload</th>
                        <th width="18%">Proprietario      </th>
                        <th width="9%">Ações              </th>
                    </tr>
		</thead>
		<tbody>
                    <?php
                    if (!empty($_POST))
                    {
                        foreach($Arquivos as $campos=>$valores)
                        {
                         $Permissao = $obj->retornaPermissaoPermissoes($valores['Usuario'], $valores['Codigo'],'P');
                         $Download  = $obj->retornaPermissaoPermissoes($user, $valores['Codigo'],'V');
                         $Alterar   = $obj->retornaPermissaoPermissoes($user, $valores['Codigo'],'A');                       
                         $Excluir   = $obj->retornaPermissaoPermissoes($user, $valores['Codigo'],'E');

                         //verifica se o usuário possui a visualização do arquivo, ou se ele é dono do arquivo
                         if(($Download != 0) || $Permissao != 0 || $valores["Publico"] == 1)
                         {
                        ?>
                        <tr class="dados">
                            <td><?php echo "<b>".$valores['Codigo']." - ".$valores['Nome'].".".$valores['NomeExtensao']."</b><br/><br/>".$valores['Descricao']; ?></td>
                            <td><?php echo $valores['DataUp']?></td>
                            <td><?php echo $valores['NomeUsuario']." <br/>(".$valores['Usuario'].")";?></td>
                            <td class="acoes">
                                <span class="lista_acoes">
                                <ul>
                                    <?php
                                    $arquivo    = $obj->preencheZero("E", 8,$valores['Codigo']);
                                    $categoria  = $obj->preencheZero("E", 4, $valores['CodCategoria']);
                                    $extensao   = $valores['NomeExtensao'];
                                    $link    = CAMINHO_ARQUIVOS."CAT".$categoria."/".$arquivo;
                                    //se permissão for diferente de 0, quer dizer que o usuário logado é
                                    //o dono do arquivo, logo, ele pode usar todos os botões
                                    if($Permissao != 0)
                                    {
                                         ?><li class="ui-state-default ui-corner-all" title="Download" ><a href="?router=T0029/js.file&file=<?php echo $arquivo; ?>&categoria=<?php echo $categoria; ?>&extensao=<?php echo $extensao; ?>" class="ui-icon ui-icon-arrowthick-1-s" target="_blank"></a></li><?php
                                         
                                         if ($usu_permissao == 1)
                                         {?><li class="ui-state-default ui-corner-all" title="Substituir Arquivo"><a href="javascript:upload('<?php echo $valores['Codigo']; ?>','<?php echo $valores['CodCategoria']; ?>')"  class="ui-icon ui-icon-arrowreturnthick-1-n"></a></li>
                                            <li class="ui-state-default ui-corner-all" title="Alterar Arquivo">   <a href="?router=T0029/alterar&codigo=<?php echo $valores['Codigo']; ?>"  class="ui-icon ui-icon ui-icon-pencil"></a></li><?php }?>
                                          <?php if($valores["Publico"] == 0 || $valores["Publico"] == ""){?><li class="ui-state-default ui-corner-all" title="Permissões" ><a href="?router=T0029/associar&cod=<?php echo ($valores['Codigo']);?>&nome=<?php echo $valores['Nome'].".".$valores['NomeExtensao']; ?>"  class="ui-icon ui-icon-locked">               </a></li><?php }?>
                                            <li class="ui-state-default ui-corner-all" title="Excluir"><a href="javascript:excluir('T0029','T0029/home&cod=<?php echo $valores['Codigo']."&path=".$link;?>','T055_arquivos','T055_codigo','<?php echo $valores['Codigo'];?>')" class="ui-icon ui-icon-closethick" title='Excluir'></a></li>
                                         <?php
                                    }
                                    else
                                    {?>
                                         <li class="ui-state-default ui-corner-all" title="Download" ><a href="?router=T0029/js.file&file=<?php echo $arquivo; ?>&categoria=<?php echo $categoria; ?>&extensao=<?php echo $extensao; ?>" class="ui-icon ui-icon-arrowthick-1-s" target="_blank"></a></li>
                                         <?php
                                         //verifica se ele tem permissão para alterar o arquivo
                                         if($Alterar != 0 && $usu_permissao == 1)
                                         {?> <li class="ui-state-default ui-corner-all" title="Substituir Arquivo"><a href="javascript:upload('<?php echo $valores['Codigo']; ?>','<?php echo $valores['CodCategoria']; ?>')"  class="ui-icon ui-icon-arrowreturnthick-1-n"></a></li>
                                             <li class="ui-state-default ui-corner-all" title="Alterar Arquivo">   <a href="?router=T0029/alterar&codigo=<?php echo $valores['Codigo']; ?>"  class="ui-icon ui-icon ui-icon-pencil"></a></li><?php }
                                         //verifica se ele tem permissão para excluir o arquivo
                                         if($Excluir != 0)
                                            {?><li class="ui-state-default ui-corner-all" title="Excluir"    ><a href="javascript:excluir('T0029','T0029/home&cod=<?php echo $valores['Codigo']."&path=".$link;?>','T055_arquivos','T055_codigo','<?php echo $valores['Codigo'];?>')" class="ui-icon ui-icon-closethick" title='Excluir'></a></li><?php }
                                    }?>
                                </ul>
                                </span>
                            </td>
                        </tr>
                        <?php
                         } //finaliza a verificação se pode visualizar o arquivo
                        } //finaliza o foreach
                    ?>
                <div id="dialog-confirm" title="Mensagem!" style="display:none">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>
                <?php
                    } // Finaliza a verificação se o POST está setado
                    else 
                    { // Se post esta vazio, imprimir a linha a seguir
                ?>
                <tr>
                    <td colspan="4">Utilize o filtro de arquivos para trazer um resultado mais especifico.</td>
                </tr>
                <?php
                    }
                ?>
		</tbody>
	</table>
    </span>
</div>