<?php
namespace VCob;

include_once '../conexaoBD.php';

function query_all($query) {
	global $con;

	$query = paginate_query($query);
	$res = mysqli_query($con, $query);

	return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function query($query) {
	global $con;
	$res = mysqli_query($con, $query);
	return mysqli_fetch_assoc($res);
}

/**
 * Insere uma linha no banco de dados
 */
function insert ($table, $array)
{
	global $con;

	$values = '';
	$cols = '';

	foreach ($array as $column => $value) {
		$values .= '\''.mysqli_escape_string($con, $value).'\',';
		$cols .= "`$column`,";
	}

	$values = rtrim($values, ',');
	$cols = rtrim($cols, ',');

	$sql = "INSERT INTO $table ($cols) VALUES ($values)";

	$result = mysqli_query($con, $sql);
	echo mysqli_error($con);
}

/**
 * Faz select no banco de dados com o array passado
 */
function update ($table, $values = [], $where = '')
{
	global $con;

	$set = '';
	// $where = process_where($where);

	foreach ($values as $column => $value) {
		$set .= "$column = ".mysqli_quote($value).',';
	}

	$set = rtrim($set, ',');
	$sql = "UPDATE $table SET $set WHERE $where";

	mysqli_query($con, $sql);
	echo mysqli_error($con);
}

/**
 * Deleta o registro da tabela
 * (WHERE obrigatório)
 */
function delete ($table, $where)
{
	global $con;

	// $where = process_where($where);
	$sql = "DELETE FROM $table WHERE $where";

	return mysqli_query($con, $sql);
}





//função para gerar o código de registro
function gera_codigo($tabela,$campo,$dir=null){
	global $con;
	$sql = "select count(*) as qtd from $tabela";
	$qry = mysqli_query($con,$sql);
	$res = mysqli_fetch_array($qry);
	if ($res["qtd"] == 0){	
		return 1;
	}
	else{
		$sql = "select $campo as cod from $tabela order by $campo desc limit 1";
		$qry = mysqli_query($con,$sql);
		$res = mysqli_fetch_array($qry);
		$codigo = $res["cod"]+1;
		return $codigo;
	}
}

//função para gerar a chave de um registro de banco
function gera_chave($codigo) {
	$tam_cod = strlen($codigo);
	if ($tam_cod == 1)  $codigo = '00000'.$codigo;
	else if ($tam_cod == 2)  $codigo = '0000'.$codigo;
	else if ($tam_cod == 3)  $codigo = '000'.$codigo;
	else if ($tam_cod == 4)  $codigo = '00'.$codigo;
	else if ($tam_cod == 5)  $codigo = '0'.$codigo;

	$chave = 'L'.$codigo.date('YmdHis');
	return $chave;
}

function mysqli_quote($string) {
	global $con;
	return '\''.mysqli_escape_string($con, $string).'\'';
}

function unset_fields(&$object, $fields)
{
	if (is_string($fields)) {
		$fields = explode('|', $fields);
	}

	if (is_array($object))
	{
		if (is_array($object[0]))
		{
			foreach($object as &$obj) {
				foreach ($fields as $field) {
					unset($obj[$field]);
				}
			}
		}
		else
		{
			foreach ($fields as $field) {
				unset($object[$field]);
			}
		}
	}
	else
	{
		foreach ($fields as $field) {
			unset($object->$field);
		}
	}
}

function rename_fields(&$object, $fields) {

	if (is_array($object)) {
		$object = (object) $object;
	}

	foreach ($fields as $old => $new) {
		$object->$new = $object->$old;
		unset($object->$old);
	}
}

function plus_month($data_mysql, $mes) {

	$thisyear = substr($data_mysql, 0, 4);
	$thismonth = substr($data_mysql, 5, 2);
	$thisday = substr($data_mysql, 8, 2);

	$mesresto = 12 - $thismonth;
	$mesresto = 12 - $thismonth;
	$nextdate = mktime(0, 0, 0, $thismonth + $mes, $thisday, $thisyear);

	return strftime("%Y-%m-%d", $nextdate);
}