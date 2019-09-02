<?php
namespace VCob\CSV;

class Cliente extends Line {

	private $qtdparcelas = 0;
	private $parcelas = [];

	public function __construct($idcliente, $nome, $cpfcliente, $endereco) {
		$this->addFields($idcliente, $nome, $cpfcliente, $endereco, 0);
	}

	public function addParcela($id, $emissao, $vcto, $valor, $barcode, $linha, $descricao)
	{
		// Posição que guarda a quantida de de parcelas
		$x = ++$this->qtdparcelas;
		$this->setField(4, $x);

		$this->parcelas['datavencimento'.$x] = $vcto;
		$this->parcelas['codigodebarras'.$x] = $barcode;
		$this->parcelas['linhadigitavel'.$x] = $linha;
		$this->parcelas['dataemissao'.$x] = $emissao;
		$this->parcelas['idParcela'.$x] = $id;
		$this->parcelas['historico'.$x] = $descricao;
		$this->parcelas['valor'.$x] = $valor;
	}

	public function getParcelas() {
		return $this->parcelas;
	}

	public function getFields() {
		return array_merge(parent::getFields(), $this->parcelas);
	}
}