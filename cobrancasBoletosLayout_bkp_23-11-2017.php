<?php
ob_start();
include('boletos/funcoes_cef.php');
include("mpdf60/mpdf.php");

$idProduto = 8;
$idSegmento = 6;
$idValorReal_referencia = 8;

//Pega o CNPJ ou CPF do cliente
if ($cpf != "")
    $documento = str_replace('.', '', $cpf);
else
    $documento = str_replace('.', '', $cnpj);
$documento = substr($documento, 0,8);

$endereco = $tipo." ".$logradouro.", ".$numero.", ".$bairro.", ".$cidade."-".$uf." - ".$cep;

$cd_cobranca = formata_numero($cd_cobranca,13,0);
$dt_vencimento_BD = str_replace('-', '', $dt_vencimento_BD);
$dt_vencimento_BD = str_replace('/', '', $dt_vencimento_BD);
$valor = str_replace('.', '', $vl_emissao);
$valor = formata_numero($valor,11,0);
$linha_parte1 = $idProduto.$idSegmento.$idValorReal_referencia;
$linha_parte2 = $valor.$documento.$dt_vencimento_BD.$cd_cobranca;
$linha_aux = $linha_parte1.$linha_parte2;
$mod_11 = modulo_11($linha_aux);
$linha_digitavel = $linha_parte1.$mod_11.$linha_parte2;

if ( ($linha == "") || ($linha == NULL) ){
    $sql = "UPDATE tbl_cobranca
            SET linha = '".$linha_digitavel."' WHERE chave = '".$_REQUEST['chave_cobranca']."'";
    $qry = user_update($sql);
}

$mpdf=new mPDF('pt','A4','12','',15,15,15,15,'','','L');
$html = '
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="content-type" content="text/html;charset=utf-8" />
            <title>Cobrança</title>
        </head>
        <body>
            <div style="width:100%; margin-left: 0px;">
                <table width="100%" border="1" cellspacing="0" cellspading="0" style="font-size: 12px;">
                    <tr>
                        <td><strong>NOME/RAZÃO SOCIAL: </strong>'.strtoupper($cliente_empresa).'</td>
                        <td><strong>CÓDIGO COBRANÇA: </strong>'.$cd_cobranca.'</td>
                        <!--<td><strong>CÓDIGO CLIENTE: </strong>'.$cd_cliente_empresa.'</td>-->
                    </tr>
                    <tr>';
                        if ($cpf != ""){
                            $html .= '<td><strong>CPF: </strong>'.$cpf.'</td>';
                        }else{
                            $html .= '<td><strong>CNPJ: </strong>'.$cnpj.'</td>';
                        }
                        $html .= '<td><strong>TELEFONE: </strong>'.$telefone.'</td>
                    </tr>
                    <tr><td colspan="2"><strong>ENDEREÇO: </strong>'.$endereco.'</td></tr>
                </table>
            </div>
            <div style="width:100%;">
                <div style="width: 100%; float: left;  margin: 10px 0 0px 0px; font-size: 10px;">
                    <div style="width: 20%; height: 120px; border: solid 1px #000; border-right: dashed 1px #000; float: left;">
                        <div style="height: 38px; border: solid 1px #000; border-right: dashed 1px #000; font-size: 8px;">
                            <strong>Nº DOCUMENTO</strong> <br>
                            '.$cd_cobranca.'/'.$num_referencia.'
                        </div>
                        <div style="height: 38px; border: solid 1px #000; border-right: dashed 1px #000; font-size: 8px;">
                            <strong>VENCIMENTO</strong> <br>
                            '.$dt_vencimento.'
                        </div>
                        <div style="height: 38px; border: solid 1px #000; border-right: dashed 1px #000; font-size: 8px;">
                            <strong>NÚMERO DE REFERÊNCIA</strong> <br>
                            '.$num_referencia.'
                        </div>
                        <div style="height: 38px; border: solid 1px #000; border-right: dashed 1px #000; font-size: 8px;">
                            <strong>SACADO</strong> <br>'.strtoupper($cliente_empresa).'
                        </div>
                        <div style="height: 39px; border: solid 1px #000; border-right: dashed 1px #000; font-size: 8px; border-bottom: none;">
                            <strong>VALOR PAGAR</strong> <br>R$'.strtoupper($vl_emissao).'
                        </div>
                    </div>

                    <div style="width: 79.5%; height: 193px; border: solid 1px #000; margin: 0px 0 10px 0px; border-left: none; float: left;">
                        <div style="width: 100%; height: 15px; ">&nbsp;'.strtoupper($empresa).'</div>
                        <div style="width: 100%; height: 15px; border: solid 1px #000; border-right: none; border-left: none; ">
                            &nbsp;CLIENTE: '.strtoupper($cliente_empresa).'
                        </div>
                        <div>
                            <div style="width: 39.6%; height: 15px; border-bottom: solid 1px #000; border-right: solid 1px #000; float: left;">
                                &nbsp;NÚMERO DE REFERÊNCIA: <strong>'.$num_referencia.' </strong>
                            </div>
                            <div style="width: 30%; height: 15px; border-bottom: solid 1px #000; border-right: solid 1px #000; float: left;">
                                &nbsp;VENCIMENTO: <strong>'.strtoupper($dt_vencimento).'</strong>
                            </div>
                            <div style="width: 30%; height: 15px; border-bottom: solid 1px #000; float: left;">
                                &nbsp;VALOR PAGAR: <strong>R$ '.strtoupper($vl_emissao).'</strong>
                            </div>
                        </div>
                        <div id="codigo_barras"> 
                            <div id="fbar" style="width: 100%; margin: 5px 5px; float: left;">';
                            //$linha = $parc['linha'];
                            $linha = $linha_digitavel;
                            $ld1 = substr($linha,0,11).modulo_11(substr($linha,0,11));
                            $ld2 = substr($linha,11,11).modulo_11(substr($linha,11,11));
                            $ld3 = substr($linha,22,11).modulo_11(substr($linha,22,11));
                            $ld4 = substr($linha,33,11).modulo_11(substr($linha,33,11));
                            $html .= substr($ld1,0,11)." ".substr($ld1,11,1);
                            $html .= "&nbsp;&nbsp;&nbsp;";
                            $html .= substr($ld2,0,11)." ".substr($ld2,11,1);
                            $html .= "&nbsp;&nbsp;&nbsp;";
                            $html .= substr($ld3,0,11)." ".substr($ld3,11,1);
                            $html .= "&nbsp;&nbsp;&nbsp;";
                            $html .= substr($ld4,0,11)." ".substr($ld4,11,1);
                            $html .= "<br>";
                            //$html .= $linha."<br>";
                            $html .= fbarcode($linha);
                            $html .= '</div>
                        </div>
                        <div id="codigo_barras">
                            <div style="width: 100%; font-size: 7px; float: left; padding: 5px 5px 5px 5px;">';
                                if ($instrucoes != "")  $html .= '- '.$instrucoes.'<br>';
                                if ($cobrar1 != "N")  $html .= '- '.$msg_cobrar1.'<br>';
                                if ($cobrar2 != "N")  $html .= '- '.$msg_cobrar2.'<br>';
                                $html .= '<p>'.$mensagem.'</p>';
                                $html .= '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>';

$mpdf->WriteHTML($html);
ob_clean();
$mpdf->Output();
exit();
?>