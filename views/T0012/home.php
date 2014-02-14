<?php
//Chama classes

$obj    =   new models_T0012();

$lojas  =   $obj->retornaHtmlComboLojas($loja, $user);

$user  = $_SESSION['user'];

?>
<!-- Busca CNPJ ou CODIGO RMS  -->
<script src="template/js/interno/T0012/busca.js"></script>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0012/home" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>

<div class="conteudo_16">
    <form action="?router=T0012/js.pdf" method="post" target="blank">
        
        <div class="grid_15">
            <span class="form-titulo">
                <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
            </span>                        
        </div> 
        
        <div class="clear"></div>

        <div class="grid_2">
            <label class="label">Data</label>
            <input type="text" name="data"                    id="data"       class="" size="7" />
        </div>

        <div class="grid_3">
            <label class="label">CNPJ*</label>
            <input type="text" name="T026_rms_cgc_cpf"        id="cnpj_for"   class="" size="16" />
        </div>

        <div class="grid_2">
            <label class="label">Cod RMS*</label>
            <input type="text" name="T026_rms_codigo"         id="rms_codigo" class="" size="5" />
        </div>

        <div class="grid_6">
            <label class="label">Razão Social*</label>
            <input type="text" name="T026_rms_razao_social"   id="raz_social" class="" size="74"/>
        </div>

        <div class="grid_2">
            <label class="label">Valor das Baixas</label>
            <input type="text" name="total"                   id="total"      class="" />
        </div>

        <div class="clear10"></div>

        <div class="grid_15">
            <span class="form-titulo">
                <p>Pesquisa das Baixas</p>
            </span>                        
        </div>

        <div class="clear10"></div>  
        
        <div class="linha">

            <div class="grid_1">
                <label class="label">Título</label>
                <input type="text" name="titulo[]"    class="titulo2"   size="3"  maxlength="10"/>
            </div>

            <div class="grid_1">
                <label class="label">Série</label>
                <input type="text" name="serie[]"     class="serie"     size="1"  maxlength="4"/>
            </div>

            <div class="grid_1">
                <label class="label">Desd.</label>
                <input type="text" name="desd[]"      class="desd"      size="1"  maxlength="2"/>
            </div>

            <div class="grid_4">
                <label class="label">Loja</label>
                <select name="T006_codigo[]" class="loja" width="30">
                    <option value="">Selecione...</option>
                    <?php $listaLoja = $obj->listaLojas();
                            foreach ($listaLoja as $cpsLoja => $vlrLoja) { ?>
                    <option value="<?php echo substr($vlrLoja["LCODI"], 0, -1)?>"><?php echo $vlrLoja["LCODI"]."-".$vlrLoja["LNOME"]?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="grid_1">
                <label class="label">Agenda</label>
                <input type="text" name="agenda[]"    class="agenda"    size="4"  maxlength="3" readonly/>
            </div>

            <div class="grid_7">
                <label class="label">Descrição</label>
                <input type="text" name="desc[]"      class="desc"      size="35" maxlength="60" readonly/>
            </div>
    
            <div class="clear"></div>
            
            <div class="push_7 grid_2">
                <label class="label">Dt. Agenda</label>
                <input type="text" name="dt_agenda[]" class="dt_agenda" size="8"  maxlength="10" style="text-align: right;" readonly/>
            </div>

            <div class="push_7 grid_2">
                <label class="label">Dt. Venc.</label>
                <input type="text" name="dt_vencto[]" class="dt_vencto" size="8"  maxlength="10" style="text-align: right;" readonly/>
            </div>

            <div class="push_7 grid_2">
                <label class="label">Bruto</label>
                <input type="text" name="bruto[]"     class="bruto"     size="8"  maxlength="10" style="text-align: right;" readonly/>
            </div>

            <div class="push_7 grid_2">
                <label class="label">Liquído</label>
                <input type="text" name="liquido[]"   class="liquido"   size="8"  maxlength="10" style="text-align: right;" readonly/>
            </div>

            <div class="grid_1" style="display">
                <input type="hidden"  value="1" name="numerador" class="numerador"/>
            </div>
        </div>
                <div class="clear10"></div>
                
          
            <div class="form-inpu-tab"></div>
        
 
        
        <div class="clear10"></div>

        <div class="grid_16">
            <label class="label">Considerações Gerais ou relevantes, justificativas, instruções para Depto. Financeiro, etc.</label>        
            <textarea name="consi" id="consi" class="textarea-table" cols="107" rows="5" ></textarea>
        </div>                

        <div class="grid_3">
            <input type="submit" class="botao-padrao" value="Gerar Impressão">

        </div>
    
    </form>
</div>


