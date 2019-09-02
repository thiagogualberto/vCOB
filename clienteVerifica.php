<?php
    include 'conexaoBD.php';
    if (isset($_REQUEST["cnpj"]))   $sql = "select * from tbl_cliente_empresa where cnpj = '".$_REQUEST["cnpj"]."'";
    else if (isset($_REQUEST["cpf"]))   $sql = "select * from tbl_cliente_empresa where cpf = '".$_REQUEST["cpf"]."'";
    $qry = mysqli_query($con,$sql);
    $res = mysqli_fetch_assoc($qry);
    
    echo json_encode($res);
?>
