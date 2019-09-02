<?php
// namespace VCob;

class Message {

	/**
	 * Mensagem de sucesso do VCob
	 * 
	 * @param string $message Mensagem
	 * @param mixed $data Dados extra
	 */
	public static function success($message, $data = null) {
		return self::generic($message, true, $data);
	}

	/**
	 * Mensagem de erro do VCob
	 * 
	 * @param string $message Mensagem
	 * @param mixed $data Dados extra
	 */
	public static function error($message, $data = null) {
		return self::generic($message, false, $data);
	}

	/**
	 * Mensagem genérica do VCob (erro ou sucesso)
	 * 
	 * @param string $message Mensagem
	 * @param bool $success Status da mensagem
	 * @param mixed $data Dados extra
	 */
	public static function generic($message, $success, $data = null)
	{
		$array['message'] = $message;
		$array['success'] = $success;

		if ($data) {
			$array['data'] = $data;
		}

		return $array;
	}
}