<?php
include '../vendor/autoload.php';
include 'lib/functions.php';
include 'lib/query.php';
include 'lib/auth.php';

define('DEBUG', false);

use VCob\Auditoria;
use ExpressPHP\Express as app;

// Instância do app
$app = new app;

// Página inicial
$app->get('/', function ($req, $res) {
	$res->json([
		'version' => '1.0.0-alpha.1',
		'name' => 'VCob Sistema de Cobranças',
		'copyright' => 'Vertex Group 2018 - Todos direitos reservados'
	]);
});

/**
 * Plugins
 */
$app->use(new BasicAuth);
$app->use(new Auditoria);

/**
 * Rotas da api
 */
$app->use('/cliente', can_access(['L00000120170808160001'], '^N'), app::require('src/cliente.php'));
$app->use('/cobranca', can_access(['L00000120170808160005'], '^N'), app::require('src/cobranca.php'));
$app->use('/relatorio', can_access(['L00000120170808160006'], 'SG'), app::require('src/relatorio.php'));
$app->use('/boleto', can_access(['L00000120170808160005'], 'SG'), app::require('src/boleto.php'));
$app->use('/carne', can_access(['L00000120170808160005'], 'SG'), app::require('src/carne.php'));
// $app->use('/usuario', can_access(['L00000120170808160002'], '^N'), app::require('src/usuario.php'));

/**
 * Logout
 */
$app->get('/logout', function ($req, $res) {
	$req->auth->logout();
	$res->location('/');
	$res->end();
});

/**
 * Páginas de erro
 */
// Erro 500
$app->use(function ($req, $res, $next) {
	if ($res->status() == 500) {
		$res->json(Message::error($res->error));
		$res->end();
	}

	$next();
});

// Erro 404
$app->use(function ($req, $res, $next) {
	// if ($res->status() == 404) {
		$res->json(Message::error("A rota $req->method $req->url não foi encontrada!"));
		$res->status(404);
		$res->end();
	// }
});