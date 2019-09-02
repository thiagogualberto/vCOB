<?php
include 'conexaoBD.php';
include 'vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$cobrancas = $_SESSION['relatorio']['retorno'];
unset($_SESSION['relatorio']['retorno']);

$sql = "SELECT * FROM tbl_empresa WHERE chave = '{$_SESSION['chave_empresa']}'";

$qry = mysqli_query($con,$sql);
$res = mysqli_fetch_array($qry);

$chave_cliente = $res["chave"];
$cnpj = $res["cnpj"];
$logadouro = $res["tipo"] .' '. $res["logradouro"];
$numero = $res["numero"];
$bairro = $res["bairro"];
$cidade = $res["cidade"];
$uf = $res["uf"];
$cep = $res["cep"];
$telefone = $res["telefone"];
$nome = $res['nome_razaosocial'];
$email = $res['email_principal'];

$pg_config = [
	'margin_left' => 10,
	'margin_right' => 10,
	'margin_top' => 46,
	'margin_bottom' => 36
];

$pdf = new HtmlPDF\HtmlPDF('templates/retorno.html', $pg_config);

// Preenche os campos
$pdf->set('header_empresa', $nome);
$pdf->set('header_cnpj', $cnpj);
$pdf->set('header_email', $email);
$pdf->set('header_tel', $telefone);
$pdf->set('header_logo', 'getlogo.php?chave='.$_SESSION['chave_empresa']);

// Dados do relatório
$pdf->set('cobrancas', $cobrancas);

// Rodapé
$pdf->set('address', "$logadouro, $numero");
$pdf->set('cep', $cep);
$pdf->set('city', $cidade);
$pdf->set('state', $uf);
$pdf->set('user', $_SESSION['nome_user']);

// Mostra o relatório
$pdf->output();