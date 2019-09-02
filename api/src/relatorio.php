<?php
$router = ExpressPHP\Express::Router();

/**
 * Mostrar relatório
 */
$router->get('/', function ($req, $res, $next) {
	$sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj,tce.cpf,dt_emissao, vl_emissao, dt_vencimento, dt_pagamento, vl_pago, vl_emissao,tipo_baixa
	FROM tbl_cobranca AS tc
	INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
	WHERE tc.chave_empresa = '{$req->user->chave_empresa}'
		AND dt_vencimento >='{$req->query('inicio')}'
		AND dt_vencimento <='{$req->query('fim')}'
		AND tce.ativo = 'S'";
	$res->json(VCob\query_all($sql));
});
