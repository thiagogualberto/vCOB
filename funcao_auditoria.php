<?php
/**
 * Atualiza uma informação no banco de dados
 * Salva backup de auditoria no banco 
 */
function user_update($query)
{
	global $con;

	// Pega a chave do usuário e o nome da tabela
	$chave_usuario = isset($_SESSION['chave_usuario']) ? $_SESSION['chave_usuario'] : $_SESSION['chave_empresa'];
	$table = preg_replace('/UPDATE (\w+).*/si', '$1', $query);

	// Obtem o backup
	$backup_query = preg_replace('/UPDATE.*WHERE/si', "SELECT * FROM $table WHERE", $query);
	$result = mysqli_query($con, $backup_query);
	$backup = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$backup = json_encode($backup);
	
	// Salva o backup
	$backup_query = "INSERT INTO tbl_auditoria (acao, tabela, chave_usuario, backup) VALUES ('U', '$table', '$chave_usuario', '$backup')";
	mysqli_query($con, $backup_query);

	// Executa a query
	return mysqli_query($con, $query);
}

/**
 * Deleta uma informação no banco de dados
 * Salva backup de auditoria no banco
 */
function user_delete($query)
{
	global $con;

	// Pega a chave do usuário e o nome da tabela
	$chave_usuario = isset($_SESSION['chave_usuario']) ? $_SESSION['chave_usuario'] : $_SESSION['chave_empresa'];
	$table = preg_replace('/DELETE FROM (\w+).*/si', '$1', $query);

	// Obtem o backup
	$backup_query = preg_replace('/DELETE FROM/si', "SELECT * FROM", $query);
	$result = mysqli_query($con, $backup_query);
	$backup = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$backup = json_encode($backup);
	
	// Salva o backup
	$backup_query = "INSERT INTO tbl_auditoria (acao, tabela, chave_usuario, backup) VALUES ('D', '$table', '$chave_usuario', '$backup')";
	mysqli_query($con, $backup_query);

	// Executa a query
	return mysqli_query($con, $query);
}