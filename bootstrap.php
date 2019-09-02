<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "src/Cliente.php";
require_once "src/Produto.php";
require_once "src/Venda.php";
require_once "src/Pedido.php";
require_once "src/Usuario.php";
require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);

// database configuration parameters
$conn = array(
	'driver' => 'pdo_mysql',
	'user' => 'root',
	'password' => '',
	'dbname' => 'glam'
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);



?>