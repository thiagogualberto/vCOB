<?php
$router = ExpressPHP\Express::Router();

// GET /api/cliente
$router->get('/', function ($req, $res, $next) {

	$result = $req->db->select_all('v_cliente', '*', "chave_empresa = '{$req->user->chave_empresa}' AND (razao_social LIKE '%{$req->query('nome')}%' OR nome_fantasia LIKE '%{$req->query('nome')}%')");

	foreach ($result as &$value) {
		unset($value['chave_empresa']);
	}

	$res->json($result);
});

// GET /api/cliente/:id
$router->get('/:id', function ($req, $res, $next) {

	$result = $req->db->select('v_cliente', '*', ['id' => $req->params->id]);
	unset($result['chave_empresa']);

	$res->json($result);
});

// PUT /api/cliente/:id
$router->put('/:id', function ($req, $res, $next) {

	VCob\unset_fields($req->body, 'chave|chave_empresa|cd_cliente_empresa');

	// Atualiza o cliente
	$result = $req->db->update('tbl_cliente_empresa', $req->body, ['cd_cliente_empresa' => $req->params->id]);

	// Mensagens de sucesso ou erro
	if ($result) {
		$res->json(Message::success('Cliente atualizado com sucesso!'));
	} else {
		$res->json(Message::error('Erro ao atualizar cliente!'));
	}
});

// POST /api/cliente
$router->post('/', function ($req, $res, $next) {

	$cliente = $req->body;
	VCob\unset_fields($cliente, 'chave|chave_empresa|cd_cliente_empresa|razao_social');

	$codigo = VCob\gera_codigo('tbl_cliente_empresa','cd_cliente_empresa');
	$chave =  VCob\gera_chave($codigo);

	$cliente->chave = $chave;
	$cliente->cd_cliente_empresa = $codigo;
	$cliente->chave_empresa = $req->user->chave_empresa;
	$cliente->nome_razaosocial = $cliente->razao_social;

	// Executa o insert
	$resutl = $req->db->insert('tbl_cliente_empresa', $req->body);

	// Mensagens de sucesso ou falha
	if ($result) {
		$res->json(Message::success('Cliente adicionado com sucesso!'));
	} else {
		$res->json(Message::error('Erro ao adicionar cliente!'));
	}
});
