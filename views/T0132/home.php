<?php
 $conn             =   "mssql";
    $verificaConexao    =   "";
    $db                 =   "DBO_CRE";
$objMSSQL = new models_T0132($conn, $verificaConexao, $db);

$matricula  =   $_POST["matricula"];


if(!empty($_POST)) {
$objMSSQL ->desbloqueiaMatricula($matricula); }


?>
<div id="conteudo">
    <div style="margin: 10px;">
        <form action="" method="post">
            <label>Matrícula</label>
            <input type="text" name="matricula" />
            <br/>
            <input type="submit" value="Desbloquear" />
        </form>
    </div>
</div>
