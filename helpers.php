<?php
function can_access(array $modulos, $permission = 'S')
{
	if (isset($_SESSION['acessar_modulos']))
	{
		foreach($modulos as $modulo)
		{
			// Verifica se a permissão do módulo bate com a permissão solicitada
			if (preg_match("/[$permission]/", $_SESSION['acessar_modulos'][$modulo])) {
				return true;
			}
		}
	}

	return false;
}

function validate(&$var, $default = '') {
    return isset($var) ? $var : $default;
}

function format_date($date)
{
	if (!empty($date) && $date != '0000-00-00') {
		return date('d/m/Y', strtotime($date));
	} else {
		return '-';
	}
}

function format_money($value)
{
	if (!empty($value) && $value != '0.00') {
		return 'R$ '.number_format($value, 2, ',', '.');
	} else {
		return '-';
	}
}

function date_br2usa($date) {
	$date = DateTime::createFromFormat('d/m/Y', $date);
	return $date->format('Y-m-d');
}