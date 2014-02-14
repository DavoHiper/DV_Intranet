<?php  
$obj = new models_T0135();

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    $theData = fgets($handle);
    $i = 0;
    
    $obj->truncateTmp();
    
    while(!feof($handle)){
        
        $dados_csv[] = fgets($handle);
        $array_csv  =   explode(";", $dados_csv[$i]);
            $insert_csv = array();
            $insert_csv['COD_FUNCIONARIO'] = $array_csv[5];
            $insert_csv['VLR_NOMINAL'] =  $array_csv[8];
            
            
            $tabela = "tmp_ranking_individual";
            
            $campos = array( "tmp_matricula"    => $insert_csv['COD_FUNCIONARIO']
                            ,"tmp_valor"        => $insert_csv['VLR_NOMINAL']); 
            
            
            $inserir = $obj->inserir($tabela, $campos);
            $i++;
    } 
    
    if($inserir){
        ?>
<div class="conteudo_16">
    <label class="label">Dados Importados com Sucesso !</label>
</div>      
      <?php
    }
}
?> 

<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a class="botao-padrao"  href="?router=T0135/home"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar </a></li>
        <li><a href="?router=T0135/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Rank    </a></li>
    </ul>
</div>

<div class="conteudo_16">
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Escolha o arquivo CSV: <br /> 
  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Importar" /> 
</form> 
</div>


