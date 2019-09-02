<?php
if (isset($_SESSION['acessar_modulos'])){
    if ( (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "S") ||
         (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "G") ){
    $id_cobranca = mysqli_real_escape_string($con, $_POST['id_cobranca']);

    $dt_emissao_cobranca = mysqli_real_escape_string($con, $_POST['dt_emissao_cobranca']);
    $dt_emissao_cobranca = data_converte($dt_emissao_cobranca,"/");

    $dt_pgto_cobranca = mysqli_real_escape_string($con, $_POST['dt_pgto_cobranca']);
    $dt_pgto_cobranca = data_converte($dt_pgto_cobranca,"/");

    $diferenca_data = data_maior($dt_emissao_cobranca, $dt_pgto_cobranca);

    $vl_pago_cobranca = mysqli_real_escape_string($con, $_POST['vl_pago_cobranca']);
    $vl_pago_cobranca = trim(str_replace("R$","",str_replace(",",".",str_replace(".","",$vl_pago_cobranca))));

    $vl_emissao_cobranca = $_POST['vl_emissao_cobranca'];
    $vl_emissao_cobranca = trim(str_replace("R$","",str_replace(",",".",str_replace(".","",$vl_emissao_cobranca))));?>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title"><strong>Cobranças</strong></h3>
        </div>
        <div class="panel-body">
            <br>
            <?php
            $sql = "UPDATE tbl_cobranca SET 
                    dt_pagamento = '$dt_pgto_cobranca',
                    vl_pago = '$vl_pago_cobranca',
                    tipo_baixa = 'M'
                WHERE chave = '$id_cobranca'";
            $qry = user_update($sql);
            if ($qry){
                msg('1','Cobrança liquidada com sucesso.','1','3','index.php?pg=cobrancas&filtrar='.$_REQUEST["filtrar"].'&pesquisar_cobrancas_cliente='.$_REQUEST["pesquisar_cobrancas_cliente"],''); 
            }?>
        </div>
    </div>
    <?php
    }
}else{?>
    <br>
    <?php 
    msg('4','Acesso não autorizado. Redirecionamento para a tela de login.','1','5','login.php','');
}?>