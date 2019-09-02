<?php
include 'vendor/autoload.php';
include 'conexaoBD.php';
include 'helpers.php';

use vCob\Boleto;
use vCob\CSV\{Remessa, Cliente};

if (can_access(['L00000120170808160001'], '^N'))
{
	// Pega as chaves das cobranças e monta a query
	$chaves = join($_POST['cobrancas'], "','");

	$sql = "SELECT tc.chave, tc.dt_vencimento, tc.linha, tc.dt_emissao, tc.vl_emissao, tc.chave_cliente, tc.mensagem, tc.cd_cobranca, tce.nome_razaosocial, IF (tce.cpf is null or tce.cpf = '', tce.cnpj, tce.cpf) AS documento
			FROM tbl_cobranca AS tc
			INNER JOIN tbl_cliente_empresa AS tce ON tc.chave_cliente = tce.chave
			WHERE tc.chave IN ('$chaves')";

	$result = mysqli_query($con, $sql);

	// Criar remessa
	$csv = new Remessa();
	$clientes = [];

	while ($res = mysqli_fetch_assoc($result))
	{
		// Se o cliente ainda não tiver uma linha no csv
		if (!isset($clientes[$res['chave_cliente']]))
		{
			$cliente = new Cliente ($res['chave_cliente'], $res['nome_razaosocial'], $res['documento'], '');
			$clientes[$res['chave_cliente']] = $cliente;
		}
		else
		{
			$cliente = $clientes[$res['chave_cliente']];
		}

		// Gera o boleto
		$boleto = new Boleto ($res['cd_cobranca'], $res['vl_emissao'], $res['documento'], $res['dt_vencimento'], $res['linha']);

		// Adiciona a parcela ao cliente atual
		$cliente->addParcela (
			$res['chave'],
			$res['dt_emissao'],
			$res['dt_vencimento'],
			$res['vl_emissao'],
			$boleto->getLinha(),
			$boleto->getLinhaDigitavel(),
			$res['mensagem']
		);

		// Atualiza a cobrança
		update_cobranca($res['chave'], $boleto->getLinha());
	}

	// Adiciona os clientes ao csv
	foreach($clientes as $cliente) {
		$csv->addCliente($cliente);
	}

	// Envia o arquivo para download
	$csv->download('arquivo.csv');
}
else
{
	http_response_code(401);
}

/**
 * Atualiza as informações da cobrança no banco de dados
 */
function update_cobranca($chave, $linha) {
	global $con;
	user_update("UPDATE tbl_cobranca SET linha='$linha', tipo_impressao='L' WHERE chave='$chave'");
}