<?php
namespace VCob\CSV;

class CSV {

	protected $file;

	public function __construct() {
		$this->path = '/tmp/'.time();
		$this->file = fopen($this->path, 'w+');
	}

	public function addLine(Line $line) {
		fputcsv($this->file, $line->getFields(), ';');
	}

	/**
	 * Envia o arquivo como download para o usuário
	 */
	public function download($arquivo = 'file.csv')
	{
		// Seta os cabeçalhos para download
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename=' . $arquivo);
		header('Pragma: no-cache');

		// Exibe o arquivo
		readfile($this->path);

		// Fecha e apaga o arquivo
		fclose($this->file);
		unlink($this->path);
	}
}