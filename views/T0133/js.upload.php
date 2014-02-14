<?php
print_r($_POST);
print_r($_FILES);
if (isset($_FILES["P0133_arquivo"])){

//DECLARAÇÕES E PARAMETROS

    //Instancia Classe models_T0133
    $objUpload  =   new models_T0133();
 
//Utilizados
    $sinistro   =   $_POST['T125_cod_autorizacao'];
    $arquivo    =   $_FILES["P0133_arquivo"];
    $tmp        =   $arquivo["tmp_name"];
    $nome       =   $arquivo["name"];
    $diretorio  =   CAMINHO_ARQUIVOS."CAT";
        //Extrai a extensão arquivo
        $extensao['extensao'] = explode('.' , $arquivo["name"]);
    $extensao = $extensao['extensao'][1];

    $data       =   date("d/m/Y");
    $categoria  =   $objUpload->preencheZero("E", 4, $_POST['T056_codigo']);

    //Selecinar extensao
    $tabela     =   "T057_extensao";
    $procura    =   $objUpload->selecionaExtensao($extensao);
    $i          =   0;
    foreach ($procura   as $campos=>$valores)
    {
        $codExt     =   $valores['COD'];
        $i++;
    }

    $_POST['T057_codigo']   =   $codExt;

    if($i==1)
    {
        //copia arquivo para diretóio files
        $copiar     =   move_uploaded_file($tmp, $diretorio .$categoria. "/" . $nome);
        if(!$copiar)
        {
            echo "nao copiou o arquivo!!";
            echo "arquivo nome: $arquivo";
            exit (0);
        }
        else
        {
            //Limpa variaveis array
            unset($_POST['T059_codigo']);
            unset($_POST['T125_cod_autorizacao']);
            //Atribui nome INTERNO (ex.: 0001.pdf)
            $_POST['T055_dt_upload']    =   $data;
            //inseri T055_arquivo
            $tabela      =  "T055_arquivos";
            $_POST['T055_nome']         =   "[Automatico] - P0133/Arquivo Sinistro GE";
            $_POST['T055_desc']         =   "[Automatico] - P0133/Arquivo Sinistro GE";
            
            
            $insUpload   =  $objUpload->inserir($tabela, $_POST);
            $codArq      =  $objUpload->lastInsertId();
            //Renomeia arquivo
            $nomeInt    =   $objUpload->preencheZero("E", 4, $codArq).".".strtolower($extensao);

            if (rename($diretorio.$categoria."/".$nome,$diretorio.$categoria."/".$nomeInt))
            {
                //Inseri T125_T055
                $tabela      =  "T125_T055";
                $dados       = array('T125_codigo' => $sinistro
                                   , 'T055_codigo' => $codArq);

                $insUpload   =  $objUpload->inserir($tabela, $dados);
                //echo $insUpload;
                //Lê página inicial
                header("location:?router=T0133/home");
            }
            else
            {
                echo "Erro";
            }
        }
    }
}

?>
