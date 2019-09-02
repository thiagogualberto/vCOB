<?php
namespace VCob;

class Boleto {

	private $idProduto = 8;
    private $idSegmento = 6;
	private $idValorReal_referencia = 8;
	
	public function __construct($cd_cobranca, $valor, $documento, $vencimento, $linha = '')
	{
		$this->cd_cobranca = $this->formata_numero($cd_cobranca,13,0);
		$this->vencimento = preg_replace('/-|\//', '', $vencimento);
		$this->valor = $this->formata_numero(str_replace('.', '', $valor), 11, 0);
		$this->linha = $linha;

		$this->documento = str_replace('.', '', $documento);
        $this->documento = substr($this->documento, 0,8);
	}

	/**
	 * String da Linha digitável
	 */
	public function getLinha()
	{
		if (!empty($this->linha)) {
			return $this->linha;
		}

		$linha_parte1 = $this->idProduto.$this->idSegmento.$this->idValorReal_referencia;
		$linha_parte2 = $this->valor.$this->documento.$this->vencimento.$this->cd_cobranca;
        $linha_aux = $linha_parte1.$linha_parte2;
		$mod_11 = $this->modulo_11($linha_aux);

        return $linha_parte1.$mod_11.$linha_parte2;
	}

	/**
	 * Linha digitável formatada
	 */
	public function getLinhaDigitavel()
	{
		return preg_replace('/(\\d{10})(\\d)/', '$1 $2 ', $this->getLinha());
	}

	/**
	 * Função vinda do arquivo funcoes_cef.php
	 */
	private function formata_numero($numero,$loop,$insert,$tipo = "geral") {
		if ($tipo == "geral") {
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "valor") {
			/*
			retira as virgulas
			formata o numero
			preenche com zeros
			*/
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "convenio") {
			while(strlen($numero)<$loop){
				$numero = $numero . $insert;
			}
		}
		return $numero;
	}

	/**
	 * Outra função vinda do arquivo funcoes_cef.php
	 */
	private function modulo_11($num, $base=9, $r=0)  {
		$soma = 0;
		$fator = 2;
		$tamanhoSemDv = strlen($num) - 1; //teste1
		//$tamanhoSemDv = strlen($num); // teste2
		/* Separacao dos numeros */
		for ($i = $tamanhoSemDv; $i >= 0; $i--) {        
			$parcialDV = substr($num,$i,1) * $fator;
			// Soma dos digitos
			$soma += $parcialDV;
			/*if($tamanhoSemDv > 11){
			  $br = $i % 10 == 0 ? '<br>' : '';
			  echo substr($num,$i,1).' * '.$fator.' = '.$parcialDV;
			  echo ' ------ soma:'.$soma.'<br>';
			}*/
			$fator++;
			if ($fator == ($base + 1)) 
			{
				// restaura fator de multiplicacao para 2
				$fator = 2;
			}
		}
		//$soma *= 10;
		$resto = $soma % 11;
		/*if($tamanhoSemDv > 11){
		  echo 'Soma ---- '.$soma." ::::::::  ";
		  echo 'Resto --- '.$resto.'<br>';
		}*/
		if ($resto == 10 || $resto == 1 || $resto == 0) {
			if ($resto == 10){
			  $dv = 1;
			}else{
			  $dv = 0;
			}
		}else{
			$dv = 11 - $resto;
		}
		return $dv;
	}
}