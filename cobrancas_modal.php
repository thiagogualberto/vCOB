<?php
include 'conexaoBD.php';
include_once 'funcao_formulario.php';
//include_once 'funcao_mensagem.php';
//include 'funcao_data.php';

$id_cobranca = filter_input(INPUT_POST, 'id_cobranca', FILTER_SANITIZE_STRING);

$btn_nome = "btn_liquidar";
$btn_texto = "Liquidar Cobrança";

$mostrar_form = "S";
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Dados da Cobrança</h4>
</div>

<?php
    form_inicio('formulario', 'POST', 'index.php?pg=cobrancas_modal','');?>
    <div class="modal-body">
        <?php
        if (isset($_REQUEST["btn_liquidar"])){
            msg('1','Cobrança atualizada com sucesso.','1','2','index.php?pg=cobrancas&chave='.$chave,'');
            $mostrar_form = "N";
        }
        if ($mostrar_form == "S"){
        $sql = "SELECT tc.chave, tce.nome_razaosocial, DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y'), 
                DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y'), format(tc.vl_emissao,2,'de_DE'),
                format(tc.vl_pago,2,'de_DE')
                FROM tbl_cobranca AS tc 
                INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                where (tc.chave = '".$id_cobranca."')";
        $qry = mysqli_query($con,$sql);
        $res = mysqli_fetch_array($qry);  
        $md_cliente = $res["nome_razaosocial"];
        $md_dt_emissao = $res["DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y')"];
        $md_vl_emissao = "RS ".$res["format(tc.vl_emissao,2,'de_DE')"];
        $md_dt_vencimento = $res["DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y')"];
        $md_dt_pagamento = "15/09/2017";
        $md_vl_pago = "R$111.11";

        form_input_text_leitura("Nome","nome",$md_cliente,"","8","");
        form_input_text_leitura("Data da Emissão","dt_emissao_cobrança",$md_dt_emissao,"","4","");
        form_input_text_leitura("Valor Emitido","vl_emissao",$md_vl_emissao,"","4","");
        form_input_text_leitura("Data de Vencimento","dt_vencimento_cobranca",$md_dt_vencimento,"","4","");?>
        <div style="clear: both"></div>
        <?php
        form_input_data("Data de Pagamento", "dt_pgto_cobranca", $md_dt_pagamento, "4", "1");
        form_input_text("Valor Pago","vl_pago_cobranca",$md_vl_pago,"20","4","","","1");
        ?>         
        <br>
        <div style="clear: both"></div>
    </div>
    <div class="modal-footer">
        <?php
        form_btn_fechar_modal('Fechar');
        form_btn('submit',$btn_nome,$btn_texto);
        ?>
    </div>
    <?php
    form_fim();
}?>
