<?php
namespace VCob;

class Auditoria extends Banco {

	private $chave_usuario;
	private $user;

	public function __invoke($req, $res, $next)
	{
		parent::__invoke($req, $res, $next);
		$this->user = &$req->user;
	}

	/**
	 * Atualiza uma informação no banco de dados
	 * Salva backup de auditoria no banco 
	 */
	function before_update($query)
	{
		// Pega a chave do usuário e o nome da tabela
		$chave_usuario = $this->user->chave;
		$table = preg_replace('/UPDATE (\w+).*/si', '$1', $query);

		// Obtem o backup
		$backup_query = preg_replace('/UPDATE.*WHERE/si', "SELECT * FROM $table WHERE", $query);
		$result = $this->query($backup_query)->fetch_all(MYSQLI_ASSOC);
		$backup = json_encode($result);

		// Salva o backup
		$this->query("INSERT INTO tbl_auditoria (acao, tabela, chave_usuario, backup) VALUES ('U', '$table', '$chave_usuario', '$backup')");
	}

	/**
	 * Deleta uma informação no banco de dados
	 * Salva backup de auditoria no banco
	 */
	function before_delete($query)
	{
		// Pega a chave do usuário e o nome da tabela
		$chave_usuario = $this->user->chave;
		$table = preg_replace('/DELETE FROM (\w+).*/si', '$1', $query);

		// Obtem o backup
		$backup_query = preg_replace('/DELETE FROM/si', "SELECT * FROM", $query);
		$result = $this->query($backup_query)->fetch_all(MYSQLI_ASSOC);
		$backup = json_encode($backup);
		
		// Salva o backup
		$this->query("INSERT INTO tbl_auditoria (acao, tabela, chave_usuario, backup) VALUES ('D', '$table', '$chave_usuario', '$backup')");
	}
}