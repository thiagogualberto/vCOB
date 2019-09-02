<?php
// Inicia a sessão
session_start();

// Mostrar erros do PHP
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

// Script para realizar a conexão com o banco de dados
$host = "localhost";
$user = "svertex_vcob";
$new_pass = "*vc0b";
$con = mysqli_connect($host,$user,$new_pass,'','3306','') or die ("Falha na conexão.");

mysqli_select_db($con,"svertex_vcob") or ("Banco de Dados não encontrado.");
mysqli_set_charset($con, 'utf8');
