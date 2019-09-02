<?php
$router = ExpressPHP\Express::Router();

// GET /api/usuario
$router->get('/', function ($req, $res, $next) {
	$sql = "SELECT chave, nm_usuario AS nome, sobrenome, email, ativo FROM tbl_usuario WHERE chave_empresa='{$req->user->chave_empresa}'";
	$result = $req->db->query($sql);
	$res->json($result->fetch_all(MYSQLI_ASSOC));
});

// GET /api/usuario/:chave
$router->get('/:chave', function ($req, $res, $next) {
	$sql = "SELECT chave, nm_usuario AS nome, sobrenome, email, ativo FROM tbl_usuario WHERE chave='{$req->params->chave}'";
	$result = $req->db->query($sql);
	$res->json($result->fetch_assoc());
});

// PUT /api/usuario/:chave
$router->put('/:chave', function ($req, $res, $next) {

	$user = $req->body;

	// Desliga campos protegidos
	VCob\unset_fields($req->body, 'chave|chave_empresa|cd_usuario');

	if (isset($req->body->senha)) {
		$user->senha = password_hash($req->body->senha, PASSWORD_BCRYPT);
	}

	$req->db->update('tbl_usuario', $req->body, "chave='{$req->params->chave}'");
	$res->json(Message::success('Usuário atualizado com sucesso!'));
});

// POST /api/usuario
$router->post('/', function ($req, $res, $next) {

	$user = $req->body;

	// Desliga campos protegidos
	VCob\unset_fields($user, 'chave|chave_empresa|cd_usuario|senha');

	$codigo = VCob\gera_codigo('tbl_usuario','cd_usuario');
	$chave =  VCob\gera_chave($codigo);

	$user->chave = $chave;
	$user->cd_usuario = $codigo;
	$user->chave_empresa = $req->user->chave_empresa;
	$user->senha = password_hash($req->body->senha, PASSWORD_BCRYPT);

	$req->db->insert('tbl_usuario', $user);
	$res->json(Message::success('Usuário adicionado com sucesso!', $user));
});

// DELETE /api/usuario/:chave
$router->delete('/:chave', function ($req, $res, $next) {
	$req->db->delete('tbl_usuario', "chave = '{$req->params->chave}'");
	$req->db->delete('tbl_usuario_modulos', "chave = '{$req->params->chave}'");
});