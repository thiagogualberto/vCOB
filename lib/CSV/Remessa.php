<?php
namespace VCob\CSV;

class Remessa extends CSV {

	private $max_parcelas;

	public function __construct($max_parcelas = 12)
	{
		// Chama o construtor da superclasse
		parent::__construct();

		// Seta os valores
		$this->max_parcelas = $max_parcelas;
		fputcsv($this->file, $this->getCampos(), ';');
	}

	public function addCliente(Cliente $cliente) {
		$this->addLine($cliente);
	}

	/**
	 * Retorna os campos do arquivo csv
	 */
	public function getCampos() : array {

		$campos = [
			'idcliente',
			'nome',
			'cpfcliente',
			'endereco',
			'qtdparcelas'
		];

		for ($i=1; $i <= $this->max_parcelas; $i++)
		{ 
			$campos = array_merge($campos, [
				'datavencimento'.$i,
				'codigodebarras'.$i,
				'linhadigitavel'.$i,
				'dataemissao'.$i,
				'idParcela'.$i,
				'historico'.$i,
				'valor'.$i
			]);
		}

		return $campos;
	}
}