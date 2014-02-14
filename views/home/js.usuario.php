<?php
//Entradas
$usuario            =   $_REQUEST['login'];
$senha              =   $_REQUEST['senha']  ;
$evento             =   $_REQUEST['evento'] ;

//System Date (data hoje) 
$dia                =   date("d");
$mes                =   date("m");
$ano                =   date("Y");

//Parametro (FAZER VERIFICAÇÃO DA TABELA DE PARAMETRO)
$parametro  =   120;        //parametro de 120 dias

//Data Juliana System Date
$dtJdHoje           =   gregoriantojd($mes, $dia, $ano);

//Instancia Classe
$obj                =   new models_home();

//Classe para Autenticação
$autentica          =   new models();
 
if ($evento==1) 
{    
    
    //Faz atutenticação ou logout
    if ($autentica->autentica())   
    {
	    //Verifica última atualização dos dados de usuário
	    $dadosUsuario       =   $obj->retornaUsuario($usuario);
	   
	    foreach ($dadosUsuario  as $campos=>$valores)
	    {
	        
	        if(!is_null($valores['CodigoDepto']))
	            $depto  =   $obj->preencheZero('E', 3, $valores['CodigoDepto']).' - '.$valores['NomeDepto'];
	        
	        $dados['Nome']              =   $valores['UsuarioNome'];
	        $dados['Matricula']         =   $valores['UsuarioMatricula'];
	        $dados['Funcao']            =   $valores['UsuarioFuncao'];
	        $dados['DtUltAlteracao']    =   $valores['UsuarioDataUltAlteracao'];
	        $dados['Loja']              =   $valores['UsuarioLoja'];
	        $dados['Email']             =   $valores['UsuarioLogin'].'@davo.com.br';
	        $dados['CPF']               =   $valores['UsuarioCPF'];
	        $dados['Depto']             =   $depto;
	    }
	    
	    if (!empty($UsuarioDataUltAlteracao)) 
	    {
	        $UsuarioDataUltAlteracao    =   explode(' ',$UsuarioDataUltAlteracao)   ;
	        $dataUsuario                =   explode('-',$UsuarioDataUltAlteracao[0]);
	        $ano                        =   $dataUsuario[0]                         ;
	        $mes                        =   $dataUsuario[1]                         ;
	        $dia                        =   $dataUsuario[2]                         ;
	        $dtJdUsuario                =   gregoriantojd($mes, $dia, $ano)         ;
	        $data                       =   $dtJdHoje - $dtJdUsuario;
	    }
	    else
	        $data                   =   $parametro;
	    
	    //Verifica se usuario existe
	    if ($data>=$parametro) 
	    {        
	        echo json_encode($dados);
	    }
	    else
	        echo '0'; //retorno js para usuario com dados atualizados
    }else
		echo '0';
}
else if($evento==2)
{
    $Lojas = $obj->retornaLojas();
    $i  =   0;
    foreach($Lojas as $campos=>$valores)
    {
        $dados[$i]  = $valores  ;
        $i++;
    }

echo json_encode($dados);
      
}else if($evento==3)
{
    $nome           =   $_REQUEST['nome']           ;
    $matricula      =   $_REQUEST['matricula']      ;
    $funcao         =   $_REQUEST['funcao']         ;
    $departamento   =   $_REQUEST['departamento']   ;
    $loja           =   $_REQUEST['loja']           ;
    $cpf            =   $_REQUEST['cpf']            ;
    $login          =   $_SESSION['user']           ;
    $email          =   $_REQUEST['email']          ;
    
    $arrTpFon       =   $_REQUEST['tpfone'];
    $arrNumero      =   $_REQUEST['numero'];
    $arrDDD         =   $_REQUEST['ddd'];
    $arrRamal       =   $_REQUEST['ramal'];
    
    $tabela         =   "T006_T077";
    
    if($obj->checaDepto())
    {
        $campos         =   array(  'T006_codigo'    =>  $loja
                                  , 'T077_codigo'    =>  $departamento
                                 );

        $delim  =   "T004_login =   '$login'";

        $obj->alterar($tabela, $campos, $delim);
    }   
    else
    {
        $campos         =   array(  'T006_codigo'   =>  $loja
                                  , 'T077_codigo'   =>  $departamento
                                  , 'T004_login'    =>  $login
                                 );

        $obj->inserir($tabela, $campos);                        
    }
    
    $tabela         =   'T010_fone';
    
    $count  =   count($arrTpFon);
    
    for($i=1;$i<=$count;$i++)
    {
        if(empty($arrRamal[$i]))
            $arrRamal[$i]   =   'null';

        $campos         =   array(  'T010_area'     =>  $obj->retiraMascara($arrDDD[$i])
                                  , 'T010_numero'   =>  $obj->retiraMascara($arrNumero[$i])
                                  , 'T011_pais'     =>  55
                                  , 'T010_ramal'    =>  $obj->retiraMascara($arrRamal[$i])
                                  , 'T011_codigo'   =>  $obj->retiraMascara($arrTpFon[$i])
                                  , 'T004_login'    =>  $login
                                 );        
        
        if(!$obj->verificaNumeros($login, $arrTpFon[$i], $arrNumero[$i], $arrRamal[$i]))
        {
 

            $obj->inserir($tabela, $campos);
        }else
        {
            $delim  =   "       T004_login  =   '$login' 
                            AND T010_numero = $arrNumero[$i] 
                              OR T010_ramal = $arrRamal[$i] ";
            
            $obj->alterar($tabela, $campos, $delim);
        }
                        
    }
           
    $tabela         =   'T004_usuario'              ;
    $data           =   date('d/m/Y H:i:s')         ;
    
    $dadosUsuario   =   array('T004_nome'               => $nome
                             ,'T004_matricula'          => $matricula
                             ,'T121_codigo'             => $funcao
                             ,'T004_cpf'                => $cpf
//                             ,'T077_departamento'       => $departamento
                             ,'T006_codigo'             => $loja
                             ,'T004_email'              => $email
                             ,'T004_data_ult_alteracao' => $data);
    
    $delim  =   " T004_login  =   '$login'";
    
    $obj->altera($tabela, $dadosUsuario, $delim);
    
}else if($evento==4){
    
    if(empty($usuario))
        $usuario    =   $_SESSION['user'];
    
    
    //Busca Telefones Contato Colaborador
    $dadosTelefone  =   $obj->retornaTelefones($usuario);
    
    $i= 0; 
    foreach ($dadosTelefone  as $campos=>$valores)
    {
        
        if($i==0)
        {
            $html    =   "<script>
                            $(function() {
                
                                $('#linhaCabec').css('display','block');

                            });
                          </script>";

//            $html   .=   "    <div class='grid_2'>";
//            $html   .=   "        <label class='label'>Tipo</label>";
//            $html   .=   "    </div>";         
//
//            $html   .=   "    <div class='grid_1'>";
//            $html   .=   "        <label class='label'>DDD</label>";
//            $html   .=   "    </div>";         
//
//            $html   .=   "    <div class='grid_2'>";
//            $html   .=   "        <label class='label'>Número</label>";
//            $html   .=   "    </div>";         
//
//            $html   .=   "    <div class='grid_1'>";
//            $html   .=   "        <label class='label'>Ramal</label>";
//            $html   .=   "    </div>";         
//
//            $html   .=   "</div>";
//
//            $html   .=   "<div class='clear'></div>";             
        }
        
        $html   .=  "<div class='linha'>";

        $html   .=  "    <div class='grid_2' style='display:none;' >";
        $html   .=  "        <input type='hidden' value='".$valores['Id']."' class='cId'/>";
        $html   .=  "    </div>";

        $html   .=  "    <div class='grid_2' >";
        $html   .=  "        <select name='tipoFone[]' class='cTpFone' disabled>";
        $html   .=  "            <option value='".$valores['CodigoTpFone']."'>".$valores['NomeTpFone']."</option>";
        $html   .=  "        </select>";
        $html   .=  "    </div>";

        $html   .=  "    <div class='grid_1'>";
        $html   .=  "        <input type='text' name='ddd[]' class='cDDD' value='".$valores['AreaFone']."' disabled/>";
        $html   .=  "    </div>";                            

        $html   .=  "    <div class='grid_2'>";
        $html   .=  "        <input type='text' name='numero[]' class='cNumero' value='".$valores['NroFone']."' disabled/>";
        $html   .=  "    </div>";                        

        $html   .=  "    <div class='grid_1'>";
        $html   .=  "        <input type='text' name='ramal[]' class='cRamal' value='".$valores['Ramal']."' disabled/>";
        $html   .=  "    </div>";                        

        $html   .=  "  <ul class='lista-de-acoes'>";
        $html   .=  "      <li><a href='#' title='Remover'  class='cRemove'><span class='ui-icon ui-icon-minus'>  </span></a></li>";
        $html   .=  "  </ul>";                        

        $html   .=  "    <div class='clear10'></div>";

        $html   .=  "</div>";         
        
        $i++;
        
    }    
    
   echo $html;
        
}
else if($evento==5){
    
    $id     =   $_REQUEST['id'];
    
    $tabela =   "T010_fone";
    $delim  =   " T010_id = $id";
    $excluir=   $obj->excluir($tabela, $delim);
    
    if($excluir)
        echo 1;
    else
        echo 0;
        
}
else if ($evento==6){
    
    $usuario    =   $_SESSION['user'];
    
    //Verifica última atualização dos dados de usuário
    $dadosUsuario       =   $obj->retornaUsuario($usuario);
   
    foreach ($dadosUsuario  as $campos=>$valores)
    {
        
        if(!is_null($valores['CodigoDepto']))
            $depto  =   $obj->preencheZero('E', 3, $valores['CodigoDepto']).' - '.$valores['NomeDepto'];
        
        $dados['Nome']              =   $valores['UsuarioNome'];
        $dados['Matricula']         =   $valores['UsuarioMatricula'];
        $dados['Funcao']            =   $valores['UsuarioFuncao'];
        $dados['DtUltAlteracao']    =   $valores['UsuarioDataUltAlteracao'];
        $dados['Loja']              =   $valores['UsuarioLoja'];
        $dados['Email']             =   $valores['UsuarioLogin'].'@davo.com.br';
        $dados['CPF']               =   $valores['UsuarioCPF'];
        $dados['Depto']             =   $depto;
    }    
    
    echo json_encode($dados);
}
else if ($evento==7){
    
    $user      =   $_SESSION['user'];
    
    $parametro  =   $obj->retornaParametro();
    $parametro  =   (int)$parametro[0];
            
    $databd     = $obj->retornaUltDataAlteracao($user);// coloque a data vinda do banco de dados
    $databd     = explode("-",$databd[0]); 
    $data       = mktime(0,0,0,$databd[1],$databd[2],$databd[0]);
    $data_atual = mktime(0,0,0,date("m"),date("d"),date("Y"));
    $dias       = ($data_atual - $data)/86400;
    
    if($dias>=$parametro)
        echo 1;
    else
        echo 0;
            
}
?>