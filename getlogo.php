<?php
include 'conexaoBD.php';

$sql = "SELECT logomarca AS content_type FROM tbl_empresa WHERE chave = '{$_GET['chave']}'";
$res = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($res);

if (!isset($data['content_type']))
    header("HTTP/1.0 404 Not Found");
else {
    header('Content-Type: ' . $data['content_type']);
    die(file_get_contents('logos_empresas/'.$_GET['chave']));
}