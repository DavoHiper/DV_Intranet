<?php 

$obj    =   new models_T0016();

$dados  =   $obj->retornaApsForaControladoria();
?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0016/home" class="active">Listar</a></li>
                <li><a href="?router=T0016/novo">Novo</a></li>
                <?php
                if (($user == 'lbsilva') || ($user == 'jnova') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'aribeiro') || ($user == 'gssilva'))
                 echo "<li><a href='?router=T0016/monitora'>Visualizar Antigas</a></li>";

                if (($user == 'rrocha') || ($user == 'fcolivei') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'ralfieri') || ($user == 'rcsilva') || ($user == 'lolive') || ($user == 'ctlima') || ($user == 'mlsilva') || ($user == 'rcsouza'))
                 echo "<li><a href='?router=T0016/painel'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo">Fluxo AP</a></li>
                <li><a href="?router=T0016/foraControladoria">Aps fora Controladoria</a></li>
            </ul>
        </span>
    </div>
</div>
<div class="conteudo_16">
           
    <div class="clear10"></div>
    
    <table id="tPrincipal" class="tablesorter">
        <thead>
            <tr>
                <th width="5%">Ap Nº</th>
                <th width="5%">Quem fez a Ap</th>
            </tr>
        </thead>
        <tbody>
        <?php $i=0;   foreach($dados as $campos=>$valores){ ?>            
            <tr class="dados">
                <td><?php echo $valores['CodigoAp'];?></td>
                <td><?php echo $valores['Login'];?></td>
            </tr>
              <?php } if ($i==0){?>
            <tr>
                <td colspan="2" align="center">Não existe nenhuma Ap com a data de hoje emitida por um uusário fora da controladoria</td>
            </tr>
              <?php }?>
        </tbody>
        
    </table>    
    
    <div class="clear10"></div>
        
</div>
