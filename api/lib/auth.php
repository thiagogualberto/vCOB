<?php
class BasicAuth extends ExpressPHP\Auth\BasicAuth {

	/**
	 * Checa se o usuário e senha recebidos é válido
	 * @return boolean
	 */
	public function authenticate($user, $pass)
	{
		$sql = "SELECT * FROM tbl_usuario WHERE email = '$user'";
		$user = VCob\query($sql);

		// Verifica se o usuário é válido
		if (count($user) && password_verify($pass, $user['senha'])) {

			$sql = "SELECT * FROM tbl_usuario_modulos WHERE chave_usuario = '{$user['chave']}'";
			$modulos = VCob\query_all($sql);
	
			// Adiciona os módulos ao usuário
			foreach ($modulos as $modulo) {
				$user['modulos'][$modulo['chave_modulo']] = $modulo['permissao'];
			}
	
			// Adiciona o usuário à sessão
			$this->set_user($user);

			return true;
		}

		return false;
	}

	/**
	 * Adiciona o usuário à sessão
	 */
	public function set_user($user) {
		$_SESSION['user'] = $user;
		$this->user = (object) $user;
	}

	/**
	 * Pega o usuário da sessão e retorna ele
	 * Retorna null se não houver usuário
	 */
	public function get_user() {
		return isset($_SESSION['user']) ? (object) $_SESSION['user'] : null;
	}
}

function can_access($modulos, $permission = 'S')
{
	return function ($req, $res, $next) use ($modulos, $permission)
	{
		if ($req->user != null || (isset($req->auth) && $req->auth->is_authenticated())) {
			foreach($modulos as $modulo)
			{
				// Verifica se a permissão do módulo bate com a permissão solicitada
				if (preg_match("/[$permission]/", $req->user->modulos[$modulo])) {
					$next();
					return;
				}
			}
			$res->json(Message::error('Usuário sem permissão'));
		} else {
			$res->json(Message::error('Usuário ou senha incorretos'));
		}

		$res->status(401);
		$res->end();
	};
}
