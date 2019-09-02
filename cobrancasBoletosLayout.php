<?php
//ob_start();
require 'vendor/autoload.php';
include('boletos/funcoes_cef.php');

$teste = new HtmlPDF\HtmlPDF('boletos/template.html', ['margin_top' => 5, 'margin_right' => 5]);

$boletos = [];
for ($i=0; $i<$QTD_PARCELAS; $i++) {
    atualiza_dados();
    $linha = $linha_digitavel;
    $ld1 = substr($linha,0,11).modulo_11(substr($linha,0,11));
    $ld2 = substr($linha,11,11).modulo_11(substr($linha,11,11));
    $ld3 = substr($linha,22,11).modulo_11(substr($linha,22,11));
    $ld4 = substr($linha,33,11).modulo_11(substr($linha,33,11));
    $codigo = fbarcode($linha);
    
    $boletos[] = [
            'num_doc' => $num_doc,
            'num_referencia' => $num_referencia,
            'logo' => 'boletos/img/logo.png',
            'linha_digitavel' => $linha_digitavel,
            'codigo' => $codigo,
            'valor' => $vl_emissao,
            'vencimento' => $dt_vencimento,
            'data' => $dt_emissao,
            'sacado' => $sacado,
            'empresa' => $empresa,
            'mensagem' => $msg
    ];
}

$teste->set('boletos', $boletos);
$teste->output();
?>