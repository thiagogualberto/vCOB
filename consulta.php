<?php 
// Dados da conexão com o banco de dados
define('SERVER', 'localhost');
define('DBNAME', 'db_blog');
define('USER', 'root');
define('PASSWORD', '');
 echo "TESTANDO";
// Recebe os parâmetros enviados via GET
$acao = (isset($_GET['acao'])) ? $_GET['acao'] : '';
$parametro = (isset($_GET['parametro'])) ? $_GET['parametro'] : '';
 
// Configura uma conexão com o banco de dados
$opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
$conexao = new PDO("mysql:host=".SERVER."; dbname=".DBNAME, USER, PASSWORD, $opcoes);
 
// Verifica se foi solicitado uma consulta para o autocomplete
if($acao == 'autocomplete'):
	$where = (!empty($parametro)) ? 'WHERE titulo LIKE ?' : '';
	$sql = "SELECT codigo_barra, titulo, categoria FROM livro " . $where;
 
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, '%'.$parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);
 
	$json = json_encode($dados);
	echo $json;
endif;
 
// Verifica se foi solicitado uma consulta para preencher os campos do formulário
if($acao == 'consulta'):
	$sql = "SELECT codigo_barra, titulo, categoria, unidade, valor_compra, valor_venda, status, DATE_FORMAT(data_cadastro, '%d/%m/%Y') AS data_cadastro FROM livro ";
	$sql .= "WHERE titulo LIKE ? LIMIT 1";
 
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);
 
	$json = json_encode($dados);
	echo $json;
endif;