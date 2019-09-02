<?php
include 'conexaoBD.php';
include 'funcao_data.php';
include 'vendor/autoload.php';
include 'helpers.php';

function not_empty($value)
{
	if (!empty($value)) {
		return $value;
	} else {
		return '-';
	}
}

if (can_access(['L00000120170808160006'], 'SG'))
{
	$tipo_cobranca = $_REQUEST["tipo_cobranca"];
	$dt_inicio_relat = $_REQUEST["dt_inicio_relat"];
	$dt_final_relat = $_REQUEST["dt_final_relat"];
	$cliente_cobranca = $_REQUEST["cliente_cobranca"];

	if ($tipo_cobranca == "td") { //Pesquisa por todas as cobranças de um cliente em um espaço de data.
		$sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj, tce.cpf, tc.dt_emissao, tc.vl_emissao, tc.dt_vencimento, tc.dt_pagamento, tc.vl_pago,vl_emissao,tipo_baixa
				FROM tbl_cobranca AS tc
				INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
				WHERE (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND 
						( (dt_vencimento >='".data_converte($dt_inicio_relat,"/")."') AND
						(dt_vencimento <='".data_converte($dt_final_relat,"/")."') ) AND (tce.ativo = 'S')";
	}
	else if ($tipo_cobranca == "ea"){ //Pesquisa pelas cobranças de um cliente em aberto ou liquidadas em um espaço de data.
		$sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj, tce.cpf, tc.dt_emissao, tc.vl_emissao, tc.dt_vencimento, tc.dt_pagamento, tc.vl_pago,vl_emissao,tipo_baixa
				FROM tbl_cobranca AS tc
				INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
				WHERE (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND 
						( (dt_vencimento >='".data_converte($dt_inicio_relat,"/")."') AND (dt_vencimento <='".data_converte($dt_final_relat,"/")."') ) AND
						( (tipo_baixa = '') OR (tipo_baixa IS NULL) ) AND (tce.ativo = 'S')";
	}
	else{
		$sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj, tce.cpf, tc.dt_emissao, tc.vl_emissao, tc.dt_vencimento, tc.dt_pagamento, tc.vl_pago,vl_emissao,tipo_baixa
				FROM tbl_cobranca AS tc
				INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
				WHERE (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND 
					( (dt_pagamento >='".data_converte($dt_inicio_relat,"/")."') AND (dt_pagamento <='".data_converte($dt_final_relat,"/")."') ) AND
					( (tipo_baixa = 'M') OR (tipo_baixa = 'A') ) AND (tce.ativo = 'S')";
	}
	if ($cliente_cobranca != "")    $sql .= " AND (tce.nome_fantasia = '".$cliente_cobranca."')";
	$sql .= " ORDER BY tce.nome_fantasia, tc.dt_emissao, tc.dt_vencimento";

	$total_pago = 0.0;
	$total_receber = 0.0;
	$qry = mysqli_query($con,$sql);

	// Caso não tenha resultados
	if (!mysqli_num_rows($qry)) {
		$arrayCobrancas[] = [
			'cliente' => '-',
			'emisao' => '-',
			'vl_emissao' => '-',
			'vencimento' => '-',
			'pagamento' => '-',
			'vl_pagamento' => '-',
			'baixa' => '-'
		];
	}

	while ($res = mysqli_fetch_array($qry)){
		if ( ($res["cnpj"] != "") && ($res["cnpj"] != NULL) )   
			$nome = $res["nome_fantasia"];
		else if ( ($res["cpf"] != "") && ($res["cpf"] != NULL) ) 
			$nome = $res["nome_razaosocial"];
		
		$arrayCobrancas[] = [
			'cliente' => $nome,
			'emisao' => format_date($res['dt_emissao']),
			'vl_emissao' => format_money($res['vl_emissao']),
			'vencimento' => format_date($res['dt_vencimento']),
			'pagamento' => format_date($res['dt_pagamento']),
			'vl_pagamento' => format_money($res['vl_pago']),
			'baixa' => not_empty($res['tipo_baixa'])
		];
		
		$total_pago += $res["vl_pago"];
		if ( ($res["tipo_baixa"] != 'M') && ($res["tipo_baixa"] != 'A') )
			$total_receber += $res["vl_emissao"];
	}

	$sql = "SELECT * FROM tbl_empresa WHERE chave = '{$_SESSION['chave_empresa']}'";

	$qry = mysqli_query($con,$sql);
	$res = mysqli_fetch_array($qry);

	$chave_cliente = $res["chave"];
	$cnpj = $res["cnpj"];
	$logadouro = $res["tipo"] .' '. $res["logradouro"];
	$numero = $res["numero"];
	$bairro = $res["bairro"];
	$cidade = $res["cidade"];
	$uf = $res["uf"];
	$cep = $res["cep"];
	$telefone = $res["telefone"];
	$nome = $res['nome_razaosocial'];
	$email = $res['email_principal'];

	$pg_config = [
		'margin_left' => 10,
		'margin_right' => 10,
		'margin_top' => 46,
		'margin_bottom' => 36
	];

	// Novo pdf
	$rel = new HtmlPDF\HtmlPDF('templates/cobranca.html', $pg_config);
	
	// Preenche os campos
	$rel->set('header_empresa', $nome);
	$rel->set('header_cnpj', $cnpj);
	$rel->set('header_email', $email);
	$rel->set('header_tel', $telefone);
	$rel->set('header_logo', 'getlogo.php?chave='.$_SESSION['chave_empresa']);

	// Data do relatório
	$rel->set('inicio', $_GET['dt_inicio_relat']);
	$rel->set('fim', $_GET['dt_final_relat']);

	// Dados Relatório
	$rel->set('cobrancas', $arrayCobrancas);
	$rel->set('total_pago', 'R$ '.number_format($total_pago,2,",","."));
	$rel->set('total_receber', 'R$ '.number_format($total_receber,2,",","."));

	// Rodapé
	$rel->set('address', "$logadouro, $numero");
	$rel->set('cep', $cep);
	$rel->set('city', $cidade);
	$rel->set('state', $uf);
	$rel->set('user', $_SESSION['nome_user']);
	
	// Exibe na tela
	$rel->output();
	$rel->print();
} else {
	http_response_code(401);
}