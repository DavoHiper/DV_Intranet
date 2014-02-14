<?php
//Chama classes
 
//Classe para Banners
$obj = new models_home(); 

$banners    =   $obj->selecionaBanners();

$textos     =   $obj->selecionaNoticia();

$user = $_SESSION['user'];

         
?>
<div id="dialog-carregando" title="Aviso!" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Teste</p>
</div>
<div id="ferramenta">
    <div id="ferr-conteudo">  
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=home/home" class="active">Home</a></li>
                <li><a href="?router=home/utilidades">Utilidades</a></li>
                <li><a href="?router=home/treinamentos">Treinamentos</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
    <div class="conteudo-visivel">
    <p style="margin-left: 11px; margin-bottom: 3px; font-size: 13px;">Entre no sistema com seus dados (Usuário e Senha), e clique na imagem para visualizar as notícias.</p>
    <div id="cont-borda">
        <div id="cont-bord-imagem">
            <?php foreach($banners as $campos=>$valores){?>
            <span class="cont-bord-imagem-img">
                <!--<a href="\\oraas012\Intranet\ITAQUA">  <img src="<?php echo $valores['CAMINHO'];?>" /> </a>-->
                <a href="#">  <img src="<?php echo $valores['CAMINHO'];?>" /> </a>
            </span>
            <?php }?>
        </div>
        <br/>
    </div>
    <div id="cont-noticia">
        <div id="accordionResizer" style="margin-left: 10px; height:420px; width: 250px;">
            <div id="cont-widg-conteudo">
                <h3><a href="#">Cotação</a></h3>
                <div style="background:white;padding:3px; border:1px solid #999999;">
                    <iframe width="250" scrolling="no" height="450" frameborder="0" style="display: block; height: 423px;" src="http://www-open-opensocial.googleusercontent.com/gadgets/ifr?url=http%3A%2F%2Fwww.tidybits.com%2Figquotesbr%2Fspecification.xml&amp;container=open&amp;view=home&amp;lang=all&amp;country=ALL&amp;debug=0&amp;nocache=0&amp;sanitize=0&amp;v=c43a004f67806d00&amp;source=http%3A%2F%2Fwww.zooming.com.br%2Ffazer-site%2Fig-quotes-gadget-do-google-para-inserir-cotacoes-indices-e-cambio-em-seu-site%2F&amp;parent=http%3A%2F%2Fwww.zooming.com.br%2Ffazer-site%2Fig-quotes-gadget-do-google-para-inserir-cotacoes-indices-e-cambio-em-seu-site%2F&amp;libs=core%3Acore.io%3Arpc#up_stocks=PETR4.SA%7CVALE5.SA%7CBVMF3.SA&amp;up_indexes=%5EBVSP%7C%5EDJI%7C%5EIXIC&amp;st=%25st%25&amp;rpctoken=1732173307" name="1732173307" id="1732173307"></iframe>
                </div>               
                  
                <h3><a href="#">Tempo</a></h3>
                <div>
                    <iframe src='http://selos.climatempo.com.br/selos/MostraSelo.php?CODCIDADE=558&SKIN=padrao' scrolling='no' frameborder='0' width="150" height='170' marginheight='0' marginwidth='0' align="center"></iframe>
                </div>
            </div>
        </div> 
<!--        <span class="titulo">
            <?php //foreach($textos as $campos=>$valores){?>
            <p><?php //echo $valores['TITULO'];?></p>
        </span>
        <span class="chamada">
            <p><?php //echo ($valores['CHAMADA']);?></p>
        </span>
        <span class="texto">
            <p><?php //($valores['TEXTO']);?></p>
        </span>-->
        <?php //}?>
        <?php
        //if ($_SESSION['user'] != "")
        //{
        ?>
<!--        <span class="veja_mais">
            <a href="?router=home/noticias"><img src="template/css/-template-imagens/botao-veja_mais.gif" alt="Veja Mais" /></a>
        </span>-->
        <?php
        //}
        //else
        //{
        ?>
<!--        <div class="ui-state-highlight ui-corner-all destaque" style="margin-top: 20px; padding: 0 .7em;"> 
                <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                <strong>Faça Login para ver todas as notícias.</p>
        </div>        -->
        <?php
        //}
        ?>
    </div>
    </div>     
</div>