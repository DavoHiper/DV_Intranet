<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 29/08/2013 por Roberta Schimidt
// * Descrição: Conferencia de valores netpoints
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//

$obj = new models_T0138();

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    $theData = fgets($handle);
    $i = 0;
    
    
    while(!feof($handle)){
        
        $dados_csv[] = fgets($handle);
        $array_csv  =   explode(";", $dados_csv[$i]);
            $insert_csv = array();
            $insert_csv['CPF_CLIENTE'] = $array_csv[0];
            $insert_csv['DATA_PAGAMENTO'] =  $array_csv[1];
            $insert_csv['VALOR'] =  $array_csv[2];
          
           $valor =  str_replace(",", ".", $insert_csv['VALOR']);
            
            $tabela = "T126_valores_netpoints";
            
            $campos = array( "T125_cpf_cliente"     => $insert_csv['CPF_CLIENTE']
                            ,"T125_data_vencimento" =>  $obj->formataData($insert_csv['DATA_PAGAMENTO'])
                            ,"T125_valor"           => $valor
                            ,"T125_mes_envio"       => $_POST['T125_mes_envio'] 
                            ,"T125_ano_envio"       => $_POST['T125_ano_envio'] 
                            ,"T125_local"           => $_POST['T125_local']); 
            
           
            
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
    </ul>
</div>

<div class="conteudo_16">
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
    
    <div class="grid_1">  
    <label> Mês: </label>
    <input name="T125_mes_envio" type="text" id="mes"/>
    </div>
    
    <div class="grid_2">
    <label> Ano: </label>
    <input name="T125_ano_envio" type="text" id="ano"/>
    </div>
    
     <div class="grid_3">
         <br>
                <select name="T125_local" id="local">
                    <option value="">Selecione a Empresa...</option>
                    <option value="1">Supermercado</option>
                    <option value="2">Posto</option>
                    <option value="3">Farma</option>
                </select>
            </div>
    
    <div class="grid_4">
        <label>Escolha o Arquivo:</label>
        <input name="csv" type="file" id="csv" /> 
    </div>
    
    <div class="grid_2 push_1">
        <br>
        <input type="submit" name="Submit" value="Importar" /> 
    </div>
    
    <div class="clear10"></div>
    
  
  
  
</form> 
</div>
