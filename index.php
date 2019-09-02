<?php
ob_start();
include 'conexaoBD.php';
include 'funcao_formulario.php';
include 'funcao_mensagem.php';
include 'funcao_data.php';
include 'funcao_mensagem_padrao.php';
include 'funcao_auditoria.php';
include 'helpers.php';


//print_r($_SESSION["acessar_modulos"]);

if (!isset($_SESSION['acessar_modulos'])){
    echo "não setou ACESSAR_MODULOS";
    header("Location: login.php");
    exit();
}else{?>   
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <style type="text/css">
            .upload_form_cont {
                background: -moz-linear-gradient(#ffffff, #f2f2f2);
                background: -ms-linear-gradient(#ffffff, #f2f2f2);
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ffffff), color-stop(100%, #f2f2f2));
                background: -webkit-linear-gradient(#ffffff, #f2f2f2);
                background: -o-linear-gradient(#ffffff, #f2f2f2);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#f2f2f2');
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#f2f2f2')";
                background: linear-gradient(#ffffff, #f2f2f2);

                color:#000;
                overflow:hidden;
            }
            #upload_form {
                float:left;
                padding:20px;
                width:700px;
            }
            #preview {
                background-color:#fff;
                display:block;
                float:right;
                width:200px;
            }
            #upload_form > div {
                margin-bottom:10px;
            }
            #speed,#remaining {
                float:left;
                width:100px;
            }
            #b_transfered {
                float:right;
                text-align:right;
            }
            .clear_both {
                clear:both;
            }
            input {
                border-radius:10px;
                -moz-border-radius:10px;
                -ms-border-radius:10px;
                -o-border-radius:10px;
                -webkit-border-radius:10px;

                border:1px solid #ccc;
                font-size:14pt;
                padding:5px 10px;
            }
            input[type=button] {
                background: -moz-linear-gradient(#ffffff, #dfdfdf);
                background: -ms-linear-gradient(#ffffff, #dfdfdf);
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ffffff), color-stop(100%, #dfdfdf));
                background: -webkit-linear-gradient(#ffffff, #dfdfdf);
                background: -o-linear-gradient(#ffffff, #dfdfdf);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#dfdfdf');
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#dfdfdf')";
                background: linear-gradient(#ffffff, #dfdfdf);
            }
            #image_file {
                width:400px;
            }
            #progress_info {
                font-size:10pt;
            }
            #fileinfo,#error,#error2,#abort,#warnsize {
                color:#aaa;
                display:none;
                font-size:10pt;
                font-style:italic;
                margin-top:10px;
            }
            #progress {
                border:1px solid #ccc;
                display:none;
                float:left;
                height:14px;

                border-radius:10px;
                -moz-border-radius:10px;
                -ms-border-radius:10px;
                -o-border-radius:10px;
                -webkit-border-radius:10px;

                background: -moz-linear-gradient(#66cc00, #4b9500);
                background: -ms-linear-gradient(#66cc00, #4b9500);
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #66cc00), color-stop(100%, #4b9500));
                background: -webkit-linear-gradient(#66cc00, #4b9500);
                background: -o-linear-gradient(#66cc00, #4b9500);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#66cc00', endColorstr='#4b9500');
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#66cc00', endColorstr='#4b9500')";
                background: linear-gradient(#66cc00, #4b9500);
            }
            #progress_percent {
                float:right;
            }
            #upload_response {
                margin-top: 10px;
                padding: 20px;
                overflow: hidden;
                display: none;
                border: 1px solid #ccc;

                border-radius:10px;
                -moz-border-radius:10px;
                -ms-border-radius:10px;
                -o-border-radius:10px;
                -webkit-border-radius:10px;

                box-shadow: 0 0 5px #ccc;
                background: -moz-linear-gradient(#bbb, #eee);
                background: -ms-linear-gradient(#bbb, #eee);
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #bbb), color-stop(100%, #eee));
                background: -webkit-linear-gradient(#bbb, #eee);
                background: -o-linear-gradient(#bbb, #eee);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#bbb', endColorstr='#eee');
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#bbb', endColorstr='#eee')";
                background: linear-gradient(#bbb, #eee);
            }
            
            .tt-menu {
                background-color: #FFFFFF;
                border: 1px solid rgba(0, 0, 0, 0.2);
                border-radius: 8px;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
                margin-top: 12px;
                padding: 8px 0;
                width: 383px;
            }
            .tt-suggestion {
                font-size: 15px;  /* Set suggestion dropdown font size */
                padding: 3px 20px;
            }
            .tt-suggestion:hover {
                cursor: pointer;
                background-color: #0097CF;
                color: #FFFFFF;
            }
            .tt-suggestion p {
                margin: 0;
            }
            .modal-backdrop {
                display:none;
            }
        </style>

        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Vertex Group Technology</title>
        <!-- Bootstrap -->
        <!-- <link href="bootstrap/css/bootstrap.css" rel="stylesheet"> -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="bootstrap/css/sb-admin-2.css" rel="stylesheet">
        <link href="bootstrap/css/jquery-ui.css" rel="stylesheet">
<!--        <link href="bootstrap/css/jquery-ui.min.css" rel="stylesheet">-->
        <link href="bootstrap/css/tecnybrasil.css" rel="stylesheet">
        
<!--    <link href="bootstrap/datepicker/css/datepicker.css" rel="stylesheet">-->
<!--    <link href="bootstrap/css/bootstrap-modal.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-modal-bs3patch.css" rel="stylesheet">-->
<!--    <link href="bootstrap/css/dataTables.bootstrap.min.css" rel="stylesheet">-->
        <link rel="shortcut icon" href="img/icone_nav.png" >

        <!-- <script type="text/javascript" src="bootstrap/js/jquery.js"></script> -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.1.1.min.js"></script>
        <!-- <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script> -->
        <!-- <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script> -->
        <script type="text/javascript" src="bootstrap/js/jquery.maskMoney.js"></script>
        <script type="text/javascript" src="bootstrap/js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
        <!-- <script type="text/javascript" src="bootstrap/js/jquery-ui.js"></script> -->
        <script type="text/javascript" src="bootstrap/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap-collapse.js"></script>
        <script type="text/javascript" src="bootstrap/js/biblioteca_tb.js"></script>
        <script type="text/javascript" src="bootstrap/js/tecnybrasil.js"></script>
        
<!--        <script type="text/javascript" src="bootstrap/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/jquery.dataTables.min.js"></script>-->
  
<!--        <script type="text/javascript" src="bootstrap/js/jquery-1.4.2.js"></script>-->
                
    </head>
    <body style="background-color: white;}">
        <div id="wrapper" style="background-color:#f8f8f8;"> 
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php
                    //print_r($_SESSION['acessar_modulos']);
                    if ( ($_SESSION['acessar_modulos']["L00000120170808160002"]) != "N"){
                        echo "<a class='navbar-brand' href='index.php?pg=usuarios'><img src='img/marca.png'/></a>";
                    }else{
                        echo "<a class='navbar-brand' href='index.php'><img src='img/marca.png'/></a>";
                    }?>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li style="color:#337ab7;">
                        <?php
                        //echo "chave_usuario: ".$_SESSION["chave_usuario"]."<br>";
                        //echo "chave_empresa: ".$_SESSION["chave_empresa"]."<br>";
                        
                        if (isset($_SESSION["chave_usuario"])){
                            $sql = "SELECT nm_usuario, sobrenome FROM tbl_usuario 
                                    WHERE chave = '".$_SESSION["chave_usuario"]."'";
                            $qry = mysqli_query($con,$sql);
                            $res = mysqli_fetch_array($qry);
                            echo $res["nm_usuario"]." ".$res["sobrenome"];
                        }
                        else{
                            $sql = "SELECT nome_fantasia FROM tbl_empresa 
                                    WHERE chave = '".$_SESSION["chave_empresa"]."'";
                            $qry = mysqli_query($con,$sql);
                            $res = mysqli_fetch_array($qry);
                            echo $res["nome_fantasia"];
                        }?>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="sair.php"><i class="fa fa-sign-out fa-fw"></i> Sair</a></li>
                        </ul>
                    </li>
                </ul>
                
                <div class="navbar-default sidebar" role="navigation" >
                    <div class="sidebar-nav navbar-collapse" >
                        <ul class="nav" id="side-menu" >
                            <li>
                                <a href="index.php"><i class="fa fa-home  fa-fw"></i> Início</a>
                            </li>
                            <?php                           
                            if (can_access(['L00000120170808160000', 'L00000120170808160001', 'L00000120170808160002', 'L00000120170808160003', 'L00000120170808160004'], '^N')){?>
                                <li>
                                    <a href="#"><i class="fa fa-group fa-fw"></i> Cadastros<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                    <?php
                                    if (can_access(['L00000120170808160000'], '^N')) {
                                        echo "<li><a href='index.php?pg=empresa'>Empresas</a></li>";
                                    }
                                    if (can_access(['L00000120170808160001'], '^N')) {
                                        echo "<li><a href='index.php?pg=clienteEmpresa'>Clientes</a></li>";
                                    }
                                    if (can_access(['L00000120170808160002'], '^N')) {
                                        echo "<li><a href='index.php?pg=usuarios'>Usuários</a></li>";
                                    }
                                    /*if (($_SESSION['acessar_modulos']["L00000120170808160003"]) != "N"){
                                        echo "<li><a href='index.php?pg=planosCadastra'>Planos</a></li>";
                                    }
                                    if (($_SESSION['acessar_modulos']["L00000120170808160004"]) != "N"){
                                        echo "<li><a href='index.php?pg=modulos'>Módulos</a></li>";
                                    }*/?>
                                    </ul>
                                </li>
                            <?php
                            }
                            if (can_access(['L00000120170808160005'], '^N')) {?>
                                <li>
                                    <a href="#"><i class="fa fa-money fa-fw"></i> Cobranças<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="index.php?pg=cobrancas">Cobranças</a></li>
                                        <?php
                                        if (can_access(['L00000120170808160005'], '^L')) {
                                            echo "<li><a href='index.php?pg=cobrancasImportarRetorno'>Importar Retorno</a></li>";
                                            echo "<li><a href='index.php?pg=cobrancasGerarRemessa'>Gerar Remessa</a></li>";
                                        }?>
                                    </ul>
                                </li>
                            <?php
                            }
                            if (can_access(['L00000120170808160005'], '^N') && can_access(['L00000120170808160005'], '^L')){?>
                                <li>
                                    <a href="#"><i class="fa fa-book fa-fw"></i> Relatórios<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="index.php?pg=relatorios">Relatórios</a></li>
                                    </ul>
                                </li>
                            <?php
                            }?>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="page-wrapper" style="background-image: url('img/background.png');">
                <?php
                if (isset($_GET['pg']))
                    include $_GET['pg'] . ".php";
                else{
                    include "default.php";
                }?>
                <br>
                <br>
            </div>
        </div>
        
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/metisMenu.min.js"></script>
        <script src="bootstrap/js/sb-admin-2.js"></script>
<!--        <script src="bootstrap/datepicker/js/bootstrap-datepicker.js"></script>-->
    </body>
</html>
<?php
}?>