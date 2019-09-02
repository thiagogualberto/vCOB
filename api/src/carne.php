<?php
use ExpressPHP\Express as app;
$router = app::Router();

// GET /api/carne/:cliente
$router->get('/:cliente', function ($req, $res, $next) {

	$cliente = $req->params->cliente;
	
	// Faz a consulta e pega os dados em um array simples
	$result = $req->db->query("SELECT chave FROM v_cobranca WHERE tipo_baixa <> 'A' AND id_cliente = '$cliente'");
	$result = $result->fetch_all(MYSQLI_ASSOC);
	$result = array_column($result, 'chave');

	// Une as chaves para string com vírgula
	$chaves = join(',', $result);

	// Redireciona para a página de boleto
	$res->location('/../cobrancasBoletos.php?chave_cobranca='.$chaves);
	$res->end();
});