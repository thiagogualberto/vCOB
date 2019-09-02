<?php
use ExpressPHP\Express as app;
$router = app::Router();

// GET /api/boleto/:chave
$router->get('/:chave', function ($req, $res, $next) {
	$res->location('/../cobrancasBoletos.php?chave_cobranca='.$req->params->chave);
	$res->end();
});