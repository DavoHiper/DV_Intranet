<?php
//captura nome do arquivo
$arquivo     = $_GET['file'];
//captura categoria do arquivo
$categoria   = $_GET['categoria'];
//captura nome da extensão
$extensao    = $_GET['extensao'];

//formata o path do caminho atual do arquivo
$path       = CAMINHO_ARQUIVOS."CAT".$categoria."/".$arquivo;

$path_apache = 'http://'.$_SERVER[HTTP_HOST]."/intranet_41".CAMINHO_ARQUIVOS."tmp"."/".$arquivo.".".$extensao;

//formata o path do caminho temporário para fazer o download
$path_tmp = CAMINHO_ARQUIVOS."tmp"."/".$arquivo;
//formata o path para renomear o arquivo movido ao temporário   
$path_tmp_rename = CAMINHO_ARQUIVOS."tmp"."/".$arquivo.".".$extensao;

//Inicia a manipulação do arquivo
if (copy($path, $path_tmp))
   { //Copia o arquivo original para o diretório temporário
    echo "<br>ARQUIVO COPIADO!<br>";
    if (rename($path_tmp, $path_tmp_rename))
       { //Renomeia o arquivo temporário
        echo "ARQUIVO RENOMEADO";
        echo "<br/>";
        //abre o arquivo
        header("Location: $path_apache");
       }
    else
       {
        echo "ARQUIVO NÃO RENOMEADO";
        echo "<br/>";           
       }
   }
else
   {
    echo "NÃO COPIOU"; 
   }
?>
