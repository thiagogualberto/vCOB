<?php
namespace VCob;

class Banco extends \mysqli
	implements \ExpressPHP\Router\RouterCallable {

	private const host = 'localhost';
	private const user = 'svertex_vcob';
	private const pass = '*vc0b';
	private const db = 'svertex_vcob';

	// Nome da variável no request
	private $name;

	public function __construct($name = 'db')
	{
		parent::__construct(self::host, self::user, self::pass, self::db);
		$this->name = $name;

		if ($this->connect_errno) {
			echo "Failed to connect to MySQL: " . $this->connect_error;
		}	

		$this->set_charset('utf8');
	}

	public function __invoke($req, $res, $next) {
		$req->{$this->name} = $this;
		$next();
	}

	public function query($query, $resultmode = null) {
		return parent::query($query, $resultmode);
	}

	public function select($table, $cols = '*', $where = '') {

		$where = $this->process_where($where);

		if (is_array($cols))
		{
			foreach ($array as $column => $value) {
				$cols .= "`$column`,";
			}
		}

		$sql = "SELECT $cols FROM $table WHERE $where";

		return $this->query($sql)->fetch_assoc();
	}

	public function select_all($table, $cols = '*', $where = 1) {

		$where = $this->process_where($where);

		if ($cols != '*')
		{
			foreach ($array as $column => $value) {
				$cols .= "`$column`,";
			}
		}

		$sql = "SELECT $cols FROM $table WHERE $where";
		$sql = paginate_query($sql);

		return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
	}

	/**
	 * Insere uma linha no banco de dados
	 */
	function insert($table, $array)
	{
		$values = '';
		$cols = '';

		foreach ($array as $column => $value) {
			$values .= $this->quote($value) . ',';
			$cols .= "`$column`,";
		}

		$values = rtrim($values, ',');
		$cols = rtrim($cols, ',');

		$sql = "INSERT INTO $table ($cols) VALUES ($values)";

		return $this->query($sql);
	}

	/**
	 * Faz update no banco de dados com o array passado
	 */
	public function update($table, $values = [], $where = '')
	{
		$set = '';
		$where = $this->process_where($where);

		foreach ($values as $column => $value) {
			$set .= "$column = {$this->quote($value)},";
		}

		$set = rtrim($set, ',');
		$sql = "UPDATE $table SET $set WHERE $where";

		// Antes de fazer update, faz isso
		$this->before_update($sql);

		return $this->query($sql);
	}

	/**
	 * Deleta o registro da tabela
	 * (WHERE obrigatório)
	 */
	public function delete ($table, $where)
	{
		$where = $this->process_where($where);
		$sql = "DELETE FROM $table WHERE $where";

		// Antes de deletar, faz isso
		$this->before_delete($sql);

		return $this->query($sql);
	}

	public function quote($value) {
		return '\''.$this->escape_string($value).'\'';
	}

	/**
	 * Processa o array, montando uma cláusula WHERE
	 */
	private function process_where ($array)
	{
		$where = $array;

		if (is_array($array)) {

			$where = '';

			foreach ($array as $key => $value) {
				$where .= "$key = {$this->quote($value)} AND ";
			}

			$where = rtrim($where, ' AND ');
		}

		return $where;
	}

	// HOOKS
	public function before_update($sql) {}
	public function before_delete($sql)	{}
	public function before_select($sql)	{}
	public function before_insert($sql)	{}
}

function paginate_query($query) {

	$page = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

	if ($page > 0) {
		$max_pagina = isset($_GET['max_pagina']) ? $_GET['max_pagina'] : 20;
		$offset = ($page - 1) * $max_pagina;
	} else {
		throw new \Exception('A página deve ser maior ou igual a 1');
	}

	return "$query LIMIT $offset,$max_pagina";
}