<?php
//Set Data do Cabeçalho
$data = date; 
$obj = new models_home();
//Trata Sessão Usuário e Menus
$model = new models();
if (is_null($_SESSION['user']))
{
    $user = null;
    $menu=$model->menu("");
    $TituloPrograma =   "";
}
else
{
    //Fonte baixa para usuario
    $_SESSION['user'] = strtolower($_SESSION['user']);
    $user = $_SESSION['user'];
    $Grupo= $model->selecionaPerfil($user);
    foreach($Grupo as $campos=>$valores)
    {
        $grps .= $valores['COD'] . ",";
    }
    $grps = substr($grps,0,strlen($grps)-1);
    $menu=$model->menu("privado",$grps);
    
    $ProgramaAtual      =   $_REQUEST['router'];
    $ProgramaAtual      =   explode("/",$ProgramaAtual);
    $ProgramaAtual[0]   =   str_replace("T", "", $ProgramaAtual[0]);
    $ProgramaAtual      =   $ProgramaAtual[0];
    if (is_numeric($ProgramaAtual))
    {
        if (!empty($ProgramaAtual))
        {
            $DadosPrograma      =   $obj->title($ProgramaAtual);
            foreach($DadosPrograma as $campos=>$valores)
            {
                $TituloPrograma =   $valores['EstruturaTitulo'];
            }
        }   
    }else
        $TituloPrograma = "Home";
    
}

//Classe para Atalhos

$atalhosGlobais = $obj->atalhosGlobais();
$stringData     = $obj->string_data($data);

if (empty($_SERVER['msg'])) 
{
    $_SERVER['msg'] = "Você ainda não está logado, clique aqui para logar!";    
}
$msg         = $_SERVER['msg'];
$displayname = $_SESSION['displayName'];

//Fast Path
$fp     =   $_POST['FastPath'];

if(!is_null($fp))
{
    $fp = str_pad($fp, 4, "0", STR_PAD_LEFT);
    header("location:/?router=T$fp/home");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<title>Intranet D´avó</title>
<link rel="shortcut icon" href="template/img/favicon.ico" />
<link rel="icon" href="template/img/favicon.ico" />
<link rel="stylesheet" href="template/css/-estilo-include-tudo.css"/>

<?php if($_SERVER['SERVER_NAME']=='localhost'){?>
    <link rel="stylesheet" href="template/css/-layout-local.css"/>
<?php }?>
<?php if($_SERVER['SERVER_NAME']=='oraas141' || $_SERVER['SERVER_NAME']=='10.2.1.141' || $_SERVER['SERVER_NAME']=='intranet_qas') {?>
    <link rel="stylesheet" href="template/css/-layout-qas.css"/>
<?php }?>
<?php if($_SERVER['SERVER_NAME']=='oraas041' || $_SERVER['SERVER_NAME']=='intranet99.grupodavo.davo.com.br' || $_SERVER['SERVER_NAME']=='intranet' || $_SERVER['SERVER_NAME']=='intranet1') {?>
    <link rel="stylesheet" href="template/css/-layout-prd.css"/>
<?php }?>
<!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="template/css/-estilo-include-tudo-ie7.css" />
<![endif]-->

<!-- BIBLIOTÉCA JQUERY 1.6.1 ------------------------------------------------------------------------->
<script src="template/js/interno/jquery-1.6.1.min.js"></script>
<!--<script src="template/js/interno/jquery-ui-1.8.11.custom.min.js"></script>-->

<!-- MÁSCARAS EM CAMPOS INPUT ------------------------------------------------------------------------>
<script src="template/js/interno/jquery.maskedinput-1.3.js"></script>

<!-- INCLUDE FUNÇÃO DE MOEDA ------------------------------------------------------------------------->
<script src="template/js/interno/moeda.js"></script>

<!-- MÁSCARAS MONETÁRIO (REAL) PARA CAMPOS INPUT ----------------------------------------------------->
<script src="template/js/interno/jquery.price_format.1.4.js"></script>

<!-- JQUERY BIBLIOTECA MATEMÁTICA -------------------------------------------------------------------->
<script src="template/js/interno/jquery.math.1.0.js"></script>

<!-- JQUERY GRÁFICO -------------------------------------------------------------------->
<script src="template/js/interno/highcharts.js"></script>
<script src="template/js/interno/highcharts_export.js"></script>

<!-- SCRIPTS DE MENU --------------------------------------------------------------------------------->
<script src="template/js/interno/menu.js"></script>

<!-- SCRIPTS PARA BUSCA RÁPIDA ----------------------------------------------------------------------->
<script type="text/javascript" src="template/js/interno/jquery.quicksearch.js"></script>

<!-- TEMPLATE PARA CX LOGIN -------------------------------------------------------------------------->
<script src="template/js/jquery/ui/jquery-ui-1.8.11.custom.js"></script>
<script src="template/js/interno/login.js"></script>
<script src="template/js/interno/classes-ui-jquery-form.js"></script>
<script src="template/js/interno/funcoesGerais.js"></script>

<!-- VALIDAÇÃO DE FORMULÁRIO INICIO ------------------------------------------------------------------>
<script src="template/jQuery/validaForm/jquery.validationEngine.js"></script>
<script src="template/jQuery/validaForm/jquery.validationEngine-pt.js"></script>
<script>
    jQuery(document).ready(function(){
        // Liga Submit do formulário com os vampos para a engine de validação
        jQuery(".validaFormulario").validationEngine();
    });
</script>
<!-- VALIDAÇÃO DE FORMULÁRIO FIM --------------------------------------------------------------------->

<!-- GRID SYSTEM --------------------------------------------------------------------------------->
<link rel="stylesheet" href="template/css/-960/960.css" />
<!-- FIM GRID SYSTEM ----------------------------------------------------------------------------->

<!-- MENSAGENS --------------------------------------------------------------------------------------->
<script type="text/javascript" src="template/js/msgs/jquery.pnotify.js"></script>
<link href="template/css/-msgs/jquery.pnotify.default.css" rel="stylesheet" type="text/css" />
<link href="template/css/-msgs/jquery.pnotify.default.icons.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="template/js/interno/mensagens.js"></script>
<!-- FIM MENSAGENS ----------------------------------------------------------------------------------->

<!-- ORDENAÇÃO DE TABELA (TABLESORTER) ----------------------------------------------------------------------------------->
<link rel="stylesheet" href="template/js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="template/js/tablesorter/tablesorter.js"></script>

<!-- FIM ORDENAÇÃO DE TABELA (TABLESORTER) ----------------------------------------------------------------------------------->

<!-- INICIO SCRIPT LISTPICKER ---------------------------------------------------------->
<script type="text/javascript" src="template/js/interno/jquery.listpicker.js"></script>
<!-- FIM SCRIPT LISTPICKER ------------------------------------------------------------->

</head>
    
<!--   IMPORTA JS NO PROGRAMA CASO EXISTA     -->
<?php 
$arquivoJs  =   "template/js/interno/".PROGRAMA."/".PROGRAMA.".js";
if (file_exists($arquivoJs))
    echo "<script src='$arquivoJs'></script>";
?>    
    
    
<body id="tools">

<!-- PARA APAGAR DIV DO MENU APYCOM -------------------------------------------- NÃO APAGAR ---------->
<div style="visibility:hidden; display: none">
    <a href="http://apycom.com/">Apycom jQuery Menus</a>
</div>

<div id="dialog-login" style="display:none">
	
    <div class="conteudo_16">
        
        <form action="?router=home/js.usuario" method="post" class="validaFormulario">

            <div class="grid_3">
                <label class="label">Digite sua Senha e Login de Rede</label>
            </div>
            
            <div class="clear"></div>
        
            <div class="grid_3">
                <label class="label">Usuário</label>
                <input type="text" name="name" id="name" />
            </div>
            
            <div class="clear"></div>
        
            <div class="grid_3">
                <label class="label">Senha</label>
                <input type="password" name="password" id="password" value="" />
            </div>
            
            <div class="clear"></div>
        
        </form>
        
    </div>

</div>


<div id="dialog-confirm-dados" title="Confirmação de Dados!" style="display:none">
    <div class="conteudo_16">
        
        <div class="grid_4">
            <label class="label">Nome</label>
            <input type="text" name="" id="cNome"/>
        </div>        
        
        <div class="grid_2">
            <label class="label">Matrícula</label>
            <input type="text" name="" id="cMatricula"/>
        </div>
        
        <div class="clear"></div>
        
        <div class="grid_2">
            <label class="label">CPF</label>
            <input type="text" name="" id="cCPF"/>
        </div>
        
        <div class="grid_4">
            <?php echo $obj->retornaHtmlComboTodasLojas();?>
        </div>  
        
        <div class="clear"></div>        
        
        <div class="grid_3">
            <?php echo $obj->retornaHtmlFuncoesColaboradores();?>
        </div>
        
        <div class="grid_3">
            <label class="label">Departamento</label>
            <select name="" id="cDepto">
                <option value="1">Tecnologia</option>
                <option value="2">Comercial</option>
                <option value="3">Marketing</option>
                <option value="4">Prevenção de Perdas</option>
                <option value="5">Cartão Confiança</option>
                <option value="6">Patrimônio</option>
                <option value="7">Drogaria</option>
                <option value="8">Frente de Loja</option>
                <option value="9">Jurídico</option>
                <option value="10">Financeiro</option>
                <option value="11">Contabilidade</option>
                <option value="12">Contas Pagar/Receber</option>
                <option value="13">Fiscal</option>
                <option value="14">Liberação</option>
                <option value="15">Tesouraria Central</option>                
            </select>
        </div>
        
        <div class="clear"></div>
        
        <div id="linhaCabec" style="display:none;">

            <div class="grid_2">
                <label class="label">Tipo</label>
            </div>         

            <div class="grid_1">
                <label class="label">DDD</label>
            </div>         

            <div class="grid_2">
                <label class="label">Número</label>
            </div>         

            <div class="grid_1">
                <label class="label">Ramal</label>
            </div>         

        </div>
            
        <div class="clear"></div>
        
        <div id="linhaPrincipal">                   

            <div class="linha" style="display:none;">

                <div class="grid_2" >
                    <select name="tipoFone[]" class="cTpFone">
                        <option value="" selected>Selecione...</option>
                        <option value="1">Residencial</option>
                        <option value="2">Trabalho</option>
                        <option value="3">Celular</option>
                        <option value="4">Fax</option>
                        <option value="5">Pager</option>
                        <option value="6">Rádio</option>
                    </select>
                </div>

                <div class="grid_1">
                    <input type="text" name="ddd[]" class="cDDD"/>
                </div>                            
                
                <div class="grid_2">
                    <input type="text" name="numero[]" class="cNumero"/>
                </div>                        

                <div class="grid_1">
                    <input type="text" name="ramal[]" class="cRamal"/>
                </div>                        

                <div class="clear10"></div>

            </div>            
            
        </div>
                     
        <div class="grid_6">
            <ul class="lista-de-acoes">                                        
                <label class="label">(Clique aqui para adicionar telefones)</label>
                <li><a href="#" title="Adicionar"  id="cAdd"><span class='ui-icon ui-icon-plus'>  </span></a></li>                                                                    
            </ul>            
        </div>  

        <div class="grid_2">
            
        </div>  
        
        <div class="clear10"></div>
        
        <div class="grid_3">
            <label class="label">Email</label>
            <input type="text" name="" id="cEmail" disabled/>
        </div>
        
        <div class="clear"></div>        
                
    </div>
</div>  
<div id="dialog-form3" title="APROVAÇÕES PENDENTES" style="display:none">
            <label class="label">Aprovação de Pagamento (AP):</label>
            <table>
                <tr>
                    <td id="ApPendente" align="right" valign="center"  width="30" ></td>
                    <td                               valign="center"  width="200" height="25"> - AP(s) Aguardando Minha Aprovação   </td>
                </tr>
                <tr>
                    <td id="ApAbaixo" align="right" valign="center" width="30"></td>
                    <td                             valign="center" width="200" height="25"> - AP(s) Anteriores a Mim   </td>
                </tr>
                <tr>
                    <td id="ApDentroPrazo" align="right" valign="center" width="30"></td>
                    <td valign="center" width="200" height="25" > - Ap(s) Dentro do Prazo</td>
                </tr>
                <tr>
                    <td id="ApForaPrazo" align="right" valign="center" width="30"></td>
                    <td valign="center" width="200" height="25"> - Ap(s) Fora do Prazo</td>
                    <td id="vApForaPrazo">
                        <ul class="lista-de-acoes">
                            <li id="linkAp"><a href="?router=T0016/home&Msg=1" title="Abrir Tela AP(s)">
                                    <span class='ui-icon ui-icon-search'></span>
                                </a>
                            </li>
                        </ul>                        
                    </td>
                </tr>
            </table>
            <label class="label">Reembolso de Despesa (RD)  :</label>
            <table>
                <tr>
                    <td id="DespesaPendente" align="right" valign="center" width="30"></td>
                    <td                                    valign="center" width="200" height="25"> - RD(s) Aguardando Minha Aprovação   </td>
                </tr>
                <tr>
                    <td id="DespesaAbaixo"  align="right" valign="center" width="30" ></td>
                    <td                                   valign="center" width="200" height="25"> - RD(s) Anteriores a Mim   </td>
                    <td id="vDespesaAbaixo">
                        <ul class="lista-de-acoes">
                            <li><a href="?router=T0026/home" title="Abrir Tela RD(s)">
                                    <span class='ui-icon ui-icon-search'></span>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>
            
</div>
<!-- 
    // Data de Criação: 24/11/2011 
    // Desenvolvedor: Jorge Nova
    // Div para inserir modals dinâmicos
-->
<div id="dialog-modal">
   
</div>
<div id="dialog-mensagem">
   
</div>




<!-- 
    // Final do modal de dialog-mostraUsuario
-->

<div id="pagina">
	<div id="cabecalho">
    	<div id="cabec-conteudo">
            <div id="cabec-cont-informacao">
            	<div id="cabec-cont-info-data">
                	<span class="cabec-cont-info-data-p"><p><?php echo $stringData;?></p></span>
                </div>
                <div id="cabec-cont-info-atalhos">
                	<span class="cabec-info-atal-ul">
                        <ul>
                            <?php foreach ($atalhosGlobais as $campos=>$valores){?>
                            <li><a href="<?php echo $valores['URL']?>" title="<?php echo $valores['Titulo']?>" target="_blank"><img src="<?php echo $valores['Caminho']?>" alt="" /></a></li>
                            <?php }?>
                        </ul>
                    </span>
                </div>
                <div id="cabec-cont-info-fast_path">
                	<span class="cabec-cont-info-fast_path-form">
                    	<form action="" method="post">
                            <table>
                                <thead>
                                <tr>
                                    <td><input type="text" class="fp-text" value="Fast Path" id="fastpath"  name="FastPath"/></td>
                                    <td><button class="botao"></button></td>
                                </tr>
                                </thead>
                            </table>
                    	</form>
                    </span>
                </div>
                <div id="cabec-cont-info-login">
                	<span class="cabec-info-logi-ul">
                        <ul><li class="usuario">
                        <?php if (is_null($user))
                              {
                                 echo "<a href='#' id='login'>".$msg."</a>";
                              }
                              else
                              {
                                 echo ucwords($displayname)."|<a href='#' class='cabec-info-logi-ul-sair' id='meus_dados'>Meus Dados</a>|"."<a href='#' class='cabec-info-logi-ul-sair' id='logout'>Sair</a>";
                              }?>
                             </li>
                        </ul>
                        </span>
                </div>
            </div>

            <div id="cabec-cont-localizacao">
                <div id="cabec-cont-loca-conteudo">
                    <div id="cabec-cont-loca-cont-logo">
                        <a href="?router=home/home"><img src="template/css/-template-imagens/logo.png" alt="D´avó" /></a>
                    </div>
                    <div id="cabec-cont-loca-cont-titulo_breadcrumbs">
                        <span class="titulo"><h3>Intranet D´avó, Quem acessa conhece!</h3></span>
                        <span class="bread"><center><h1><?php echo $TituloPrograma?></h1></center></span>
                    </div>
                </div>
            </div>

            <div id="cabec-cont-menu">
                <div id="menu">
                <?php
                        function menu($menu)
                        {
                            foreach($menu as $chaves=>$valores)
                            {
                                if (is_array($valores))
                                {   array_push($valores,"A");?>
                                    <li><a href='javascript:void(0)' class='parent'><span><?php echo $chaves;?></span></a><ul>
                                    <?php
                                    menu($valores);
                                }
                                else
                                {   if($valores!="A")
                                    { ?>
                                        <li><a href='?router=T<?php echo $valores = str_pad($valores, 4, "0", STR_PAD_LEFT);?>/home'><span style="color: rgb(132, 112, 255);"><?php echo $chaves?></span></a></li>
                              <?php }
                                    else
                                    {?>
                                        </ul></li>
                              <?php }
                                }
                            }?>
                         <?php
                         } ?>
                <ul class="menu"><?php menu($menu);?></ul>
                </div>
            </div>
        </div>
    </div>
<?php
//Mensagem/Alertas
//Variavel para controle se existe mensagem em $_SESSION

$true       =   $_SESSION['alert']['true']                      ;

//Verifica se verdade
if ($true)
{
    //Preenche as variaveis para mensagem
    $err        =   $_SESSION['alert']['err']                   ;   //se erro (True/False)
    $titulo     =   $_SESSION['alert']['titulo']                ;   //titulo mensagem
    $mensagem   =   $_SESSION['alert']['mensagem']              ;   //mensagem
    
    //exibe mensagem
    if($true)
    echo "<script>show_stack_bottomleft($err, '$titulo', '$mensagem');</script>";
    
    //anula msg para proximo refresh
    $_SESSION['alert']['true'] = false;        
    
}
?>    
    
