<?php
use ExpressPHP\Express as app;
use PropTypes\{Types, Schema};

$router = app::Router();

$create_schema = new Schema([
	'id_cliente' => Types::required_number,
	'dt_vencimento' => Types::required_date,
	'dt_pagamento' => Types::date,
	'vl_pago' => Types::number,
	'vl_emissao' => Types::required_number,
	'parcelas' => Types::required_number,
	'num_referencia' => Types::required_string,
	'mensagem' => Types::string,
	'juros' => [
		'%' => Types::required_number,
		'dias' => Types::required_number
	],
	'multa' => [
		'%' => Types::required_number,
		'dias' => Types::required_number
	],
	'instrucoes' => [
		'tipo' => Types::required_number,
		'%' => Types::number,
		'valor' => Types::number,
		'data_final' => Types::date,
	]
]);

$update_schema = new Schema([
	'dt_vencimento' => Types::date,
	'dt_pagamento' => Types::date,
	'vl_pago' => Types::number,
	'vl_emissao' => Types::number,
	'num_referencia' => Types::string,
	'mensagem' => Types::string,
	'juros' => [
		'%' => Types::required_number,
		'dias' => Types::required_number
	],
	'multa' => [
		'%' => Types::required_number,
		'dias' => Types::required_number
	],
	'instrucoes' => [
		'tipo' => Types::required_number,
		'%' => Types::number,
		'valor' => Types::number,
		'data_final' => Types::date,
	]
]);

// GET /api/cobranca
$router->get('/', function ($req, $res, $next) {

	$result = $req->db->select_all('v_cobranca', '*', ['chave_empresa' => $req->user->chave_empresa, 'cliente' => $req->query('nome')]);
	VCob\unset_fields($result, 'chave|tipo_baixa');

	$res->json($result);
});

// GET /api/cobranca/:id
$router->get('/:id', function ($req, $res, $next) {

	$result = $req->db->select('v_cobranca', '*', ['id' => $req->params->id]);
	VCob\unset_fields($result, 'chave|chave_empresa|tipo_baixa');

	$res->json($result);
});

// PUT /api/cobranca/:id
$router->put('/:id', function ($req, $res, $next) use ($update_schema) {

	// Desliga campos protegidos
	VCob\unset_fields($req->body, 'chave|chave_empresa|cd_cobranca|chave_cliente|dt_emissao|linha|tipo_baixa|tipo_impressao');

	$cobranca = $req->body;
	$result = $update_schema->validate($cobranca);
	
	// Se os dados forem inválidos, encerra
	if (!$result->isValid()) {
		$res->json($result->getErrorInfo());
		$res->end();
	}

	$result = $req->db->update('tbl_cobranca', $req->body, ['cd_cobranca' => $req->params->id]);

	if ($result) {
		$res->json(Message::success('Cobrança atualizada com sucesso!'));
	} else {
		$res->json(Message::error('Erro ao atualizar cobrança!'));
	}
});

// POST /api/cobranca
$router->post('/', function ($req, $res, $next) use ($create_schema) {

	$cobranca = $req->body;
	$result = $create_schema->validate($cobranca);
	
	// Se os dados forem inválidos, encerra
	if (!$result->isValid()) {
		$res->json($result->getErrorInfo());
		$res->end();
	}

	// Pega a chave do cliente
	$cliente = $req->db->select('tbl_cliente_empresa', 'chave', ['cd_cliente_empresa' => $req->body->id_cliente]);

	if ($cliente) {

		// Desliga campos protegidos
		VCob\unset_fields($cobranca, 'chave|chave_empresa|cd_cobranca|id_cliente|dt_emissao|linha|tipo_baixa|tipo_impressao');
		
		// Gera o código da cobrança
		$cobranca->cd_cobranca = VCob\gera_codigo('tbl_cobranca','cd_cobranca');
		$cobranca->chave_cliente = $cliente['chave'];
		$cobranca->chave_empresa = $req->user->chave_empresa;
		$cobranca->dt_emissao = date('Y-m-d');
		$parcelas = array_pop_assoc($cobranca, 'parcelas');

		try {
			$cobranca = create_cobranca($cobranca);
		} catch (Exception $e) {
			$res->json(Message::error('Campos incorretos!', $e->getMessage()));
			$res->end();
		}

		// Cria as parcelas
		for ($i=0; $i < $parcelas; $i++) {

			//Cria a cobrança
			$cobranca->chave = VCob\gera_chave($cobranca->cd_cobranca);
			$cobranca->num_referencia = sprintf('%s-%02d', $req->body->num_referencia, $i+1);
			
			$result = $req->db->insert('tbl_cobranca', $cobranca);
			
			if (!$result) {
				$res->json(Message::error('Erro ao adicionar parcela '.($i+1), $req->db->error));
				$res->end();
			}
			
			$cobranca->cd_cobranca++;
			$cobranca->dt_vencimento = VCob\plus_month($cobranca->dt_vencimento, 1);
		}
		
		// Mensagem de sucesso ou erro
		if ($result) {
			$res->json(Message::success('Cobrança adicionada com sucesso!'));
		} else {
			$res->json(Message::error('Erro ao adicionar cobrança!', $result->error));
		}

	} else {
		$res->json(Message::success('Cliente não encontrado!'));
	}
});

// DELETE /api/cobranca/:chave
$router->delete('/:id', function ($req, $res, $next) {

	$result = $req->db->delete('tbl_cobranca', ['cd_cobranca' => $req->params->id]);
	
	if ($result) {
		$res->json(Message::success('Cobrança excluída com sucesso!'));
	} else {
		$res->json(Message::success('Erro ao excluir cobrança!'));
	}
});

function create_cobranca(object $cobranca) {

	$cobranca->cobrar1 = 'N';
	$cobranca->cobrar2 = 'N';

	// Caso tenha juros
	if (isset($cobranca->juros))
	{
		$juros = array_pop_assoc($cobranca, 'juros');

		$cobranca->cobrar1 = 'S';
		$cobranca->porcentagem_juros_cobrar1 = $juros->{'%'};
		$cobranca->diasjuros_cobrar1 = $juros->dias;
	}

	// Caso tenha multa
	if (isset($cobranca->multa))
	{
		$multa = array_pop_assoc($cobranca, 'multa');

		$cobranca->cobrar2 = 'S';
		$cobranca->porcentagem_multa_cobrar2 = $multa->{'%'};
		$cobranca->diasmulta_cobrar2 = $multa->dias;
	}

	// Caso tenha instruções
	if (isset($cobranca->instrucoes))
	{
		$msg_error = 'Algum campo das instruções não foi informado';
		$instrucoes = array_pop_assoc($cobranca, 'instrucoes');
		$tipo = $instrucoes->tipo;
		$inst = [
			'L00000120170905201900', 'L00000120170905201901',
			'L00000120170905201902', 'L00000120170905201903',
			'L00000120170905201904'
		];

		// Define a chave do tipo de instrução
		$cobranca->chave_cobranca_instrucoes = $inst[$tipo];

		// Definição dos campos de cada tipo
		// Tudo explicado os tipos na documentação da cobrança
		if ($tipo == 1)
		{
			if (!isset($instrucoes->valor) || !isset($instrucoes->data_final)) {
				throw new Exception($msg_error);
			}

			$cobranca->desconto_dinheiro = $instrucoes->valor;
			$cobranca->data_desconto = $instrucoes->data_final;
		}
		else if ($tipo == 2)
		{
			if (!isset($instrucoes->{'%'}) || !isset($instrucoes->data_final)) {
				throw new Exception($msg_error);
			}

			$cobranca->desconto_porcentagem = $instrucoes->{'%'};
			$cobranca->data_desconto = $instrucoes->data_final;
		}
		else if ($tipo == 3 or $tipo == 4)
		{
			if (!isset($instrucoes->valor)) {
				throw new Exception($msg_error);
			}

			$cobranca->desconto_dinheiro = $instrucoes->valor;
		}
	}
	
	return $cobranca;
}

function array_pop_assoc(&$array, string $key) {

	if (is_array($array)) {
		$value = $array[$key];
		unset($array[$key]);
	} else {
		$value = $array->$key;
		unset($array->$key);
	}

	return $value;
}