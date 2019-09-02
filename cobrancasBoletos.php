<?php
// ob_start();
require_once 'conexaoBD.php';
require_once 'funcao_formulario.php';
require_once 'funcao_data.php';
require_once 'funcao_auditoria.php';

require_once 'vendor/autoload.php';
include 'boletos/funcoes_cef.php';

if (isset($_REQUEST['chave_cobranca']) && !empty($_REQUEST['chave_cobranca']))
{
    $chaves = str_replace(",", "','", $_REQUEST['chave_cobranca']);
}
else if (isset($_SESSION['chave_cobranca']) && !empty($_SESSION['chave_cobranca']))
{
    $chaves = $_SESSION['chave_cobranca'];
    unset($_SESSION['chave_cobranca']);
}
else die;
    
$sql = "SELECT te.nome_razaosocial AS empresa, tce.nome_fantasia AS nome_fantasia, tce.cd_cliente_empresa, tce.cnpj, tce.cpf, 
        tce.nome_razaosocial AS cliente_empresa, tc.chave,
        tce.tipo, tce.logradouro, tce.numero, tce.bairro, tce.cidade, tce.uf, tce.cep,
        tce.telefone, tc.cd_cobranca, tc.num_referencia, DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y'), 
        format(tc.vl_emissao,2,'de_DE'), vl_emissao, DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y'), tc.dt_vencimento,
        DATE_FORMAT(tc.dt_pagamento,'%d/%m/%Y'), tc.dt_pagamento, DATEDIFF(tc.dt_pagamento,tc.dt_vencimento),
        format(tc.vl_pago,2,'de_DE'),
        tipo_baixa, mensagem, chave_cobranca_instrucoes, format(tc.desconto_dinheiro,2,'de_DE'),desconto_dinheiro, 
        desconto_porcentagem, DATE_FORMAT(data_desconto,'%d/%m/%Y'),
        cobrar1, porcentagem_juros_cobrar1, diasjuros_cobrar1, 
        cobrar2, porcentagem_multa_cobrar2, diasmulta_cobrar2,
        linha
        FROM tbl_cobranca AS tc 
        INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
        INNER JOIN tbl_empresa AS te on tce.chave_empresa = te.chave
        where (tc.chave IN ('$chaves')) AND ( (tipo_baixa = '') OR (tipo_baixa is NULL) )";
//echo $sql;

$qry = mysqli_query($con,$sql);
$QTD_PARCELAS = mysqli_num_rows($qry);

//Vetor de boletos
$boletos = [];

while ($res = mysqli_fetch_array($qry)){
    $chave_cobranca = $res["chave"];
    $empresa = $res["empresa"];
    $cd_cliente_empresa = $res["cd_cliente_empresa"];
    $cnpj = $res["cnpj"];
    $cpf = $res["cpf"];
    $cliente_empresa = empty($cnpj) ? $res["cliente_empresa"] : $res["nome_fantasia"];
    $tipo = $res["tipo"];
    $logradouro = $res["logradouro"];
    $numero = $res["numero"];
    $bairro = $res["bairro"];
    $cidade = $res["cidade"];
    $uf = $res["uf"];
    $cep = $res["cep"];
    $telefone = $res["telefone"];
    $cd_cobranca = $res["cd_cobranca"];
    $num_referencia = $res["num_referencia"];
    $dt_emissao = $res["DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y')"];
    $vl_emissao = $res["format(tc.vl_emissao,2,'de_DE')"];
    $dt_vencimento = $res["DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y')"];
    $dt_vencimento_BD = $res["dt_vencimento"];
    $dt_pagamento = $res["DATE_FORMAT(tc.dt_pagamento,'%d/%m/%Y')"];
    $vl_pago = $res["format(tc.vl_pago,2,'de_DE')"];
    $mensagem = $res["mensagem"];
    $chave_cobranca_instrucoes = $res["chave_cobranca_instrucoes"];
    $desconto_dinheiro = $res["format(tc.desconto_dinheiro,2,'de_DE')"];
    $desconto_porcentagem = trim(str_replace(".",",","0.33"));
    $data_desconto = $res["DATE_FORMAT(data_desconto,'%d/%m/%Y')"];
    $dias_juros = $res["DATEDIFF(tc.dt_pagamento,tc.dt_vencimento)"];
    
    if ($chave_cobranca_instrucoes == "L00000120170905201901")
        $instrucoes = "<br>Desconto de R$ ".$desconto_dinheiro." até ".$data_desconto.".";
    else if ($chave_cobranca_instrucoes == "L00000120170905201902")
        $instrucoes = "<br>Desconto de ".$desconto_porcentagem."% até ".$data_desconto.".";
    else if ($chave_cobranca_instrucoes == "L00000120170905201903")
        $instrucoes = "<br>Desconto de R$ ".$desconto_dinheiro." por dia corrido de antecipação.";
    else if ($chave_cobranca_instrucoes == "L00000120170905201904")
        $instrucoes = "<br>Desconto de R$ ".$desconto_dinheiro." por dia útil de antecipação.";
    else $instrucoes = "";
    
    $cobrar1 = $res["cobrar1"];
    if ($cobrar1 == 'S'){
        $porcentagem_juros_cobrar1 = $res["porcentagem_juros_cobrar1"];
        $diasjuros_cobrar1 = $res["diasjuros_cobrar1"];
        $valor_juros_dia = $res["vl_emissao"] * ($porcentagem_juros_cobrar1/100);
        $valor_juros_dia = "R$ ".number_format($valor_juros_dia, 2, ',', '.');
        $msg_cobrar1 = "<br>Cobrar $valor_juros_dia de juros ao dia após $diasjuros_cobrar1 dias de atraso.";
    } 
    else  $msg_cobrar1 = "";
    
    
    $cobrar2 = $res["cobrar2"];
    if ($cobrar2  == 'S'){
        $porcentagem_multa_cobrar2 = $res["porcentagem_multa_cobrar2"];
        $diasmulta_cobrar2 = $res["diasmulta_cobrar2"];
        $valor_multa = $res["vl_emissao"] * ($porcentagem_multa_cobrar2/100);
        $valor_multa = "R$ ".number_format($valor_multa, 2, ',', '.');
        $data_multa = data_dia_adiciona($dt_vencimento_BD, $diasmulta_cobrar2);
        $data_multa = data_converte($data_multa, "-");
        $msg_cobrar2 = "<br>Cobrar multa de $valor_multa após ".$data_multa.".";
    } 
    else  $msg_cobrar2 = "";
    
    $linha = $res["linha"];
    
    //Começa a pegar informaçõe para gerar o código de barras
    $idProduto = 8;
    $idSegmento = 6;
    $idValorReal_referencia = 8;

    //Pega o CNPJ ou CPF do cliente
    if ($cpf != "")
        $documento = str_replace('.', '', $cpf);
    else
        $documento = str_replace('.', '', $cnpj);
    $documento = substr($documento, 0,8);

    $endereco = $tipo." ".$logradouro.", ".$numero.", ".$bairro.", ".$cidade."-".$uf;

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

    $msg = $mensagem."<br>".$instrucoes.$msg_cobrar1.$msg_cobrar2;
    $num_doc = $cd_cobranca.'/'.$num_referencia;
    $sacado = $cliente_empresa;

    if ( ($linha == "") || ($linha == NULL) ){
        $sql2 = "UPDATE tbl_cobranca SET 
                    linha = '".$linha_digitavel."',
                    tipo_impressao = 'L'
                WHERE chave = '".$chave_cobranca."'";
        $qry2 = user_update($sql2);
    }
    // echo 
    
    //monta o boleto
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
            'linha_digitavel' => preg_replace('/(\\d{10})(\\d)/', '$1 $2 ', $linha_digitavel),
            'codigo' => $codigo,
            'valor' => $vl_emissao,
            'vencimento' => $dt_vencimento,
            'data' => $dt_emissao,
            'sacado' => $sacado,
            'empresa' => $empresa,
            'mensagem' => $msg,
            'endereco' => $endereco
    ];
}

// Configuração da página PDF
$pg_config = ['margin_top' => 5, 'margin_right' => 5, 'margin_bottom' => 0];

// Gera o PDF com o array de boletos informados
$boleto = new HtmlPDF\HtmlPDF('boletos/template.html', $pg_config);
$boleto->set('boletos', $boletos);
$boleto->output();
