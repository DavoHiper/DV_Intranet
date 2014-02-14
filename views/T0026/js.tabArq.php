<?php 
$obj        =   new models_T0026();
$codigoDespesa = $_REQUEST["codigoDespesa"];

?>


<table class='list-iten-arquivos'>   
                        <tbody>
                        <?php $ArquivosDespesa  =   $obj->retornaArquivos($codigoDespesa);?>
                        <?php foreach($ArquivosDespesa  as  $cpsArquivo =>  $vlsArquivo){
                            
                                        $Categoria      =   $vlsArquivo['CategoriaCodigo']                          ;
                                        $ArquivoCodigo  =   $vlsArquivo['ArquivoCodigo']                            ;
                                        $Extensao       =   $vlsArquivo['ExtensaoNome']                             ;
                                        $LinkArquivo    =   $obj->linkArquivo($Categoria, $ArquivoCodigo, $Extensao);
                                        
                                        if( $cont%2 == 0)
                                               $cor = "line_color";
                                        else
                                               $cor = "";                            

                            ?>
                        <tr class='linhaArq_<?php echo $codigoDespesa;?>'>
                            <td width="95%"><a target="_blank" href="<?php echo $LinkArquivo?>">Despesa</a></td>  
                            <td width="5%" ><a class="excluir" title="Excluir" href="javascript:excluir('T0026','<?php echo $valores['DespesaCodigo'];?>','<?php echo $LinkArquivo;?>','T016_T055','T055_codigo','<?php echo $ArquivoCodigo;?>')"></a></td>                            
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>