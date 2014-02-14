<?php

//Instancia Classe
$conn               =   "";
$obj          =   new models_T0012($conn);

?>

  <select style="margin-left:1px; width: 220px;" name="T006_codigo[]" class="loja" >
                    <option value="">Selecione...</option>
                    <?php $listaLoja = $obj->listaLojas();
                            foreach ($listaLoja as $cpsLoja => $vlrLoja) { ?>
                        <option value="<?php echo substr($vlrLoja["LCODI"], 0, -1)?>"><?php echo $vlrLoja["LCODI"]."-".$vlrLoja["LNOME"]?></option>
                    <?php } ?>
                </select>