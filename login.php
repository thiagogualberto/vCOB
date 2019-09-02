<?php
include 'conexaoBD.php';
include 'funcao_formulario.php'; 
include 'funcao_mensagem.php';
include 'funcao_data.php';
include 'funcao_mensagem_padrao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
<!--        <style type="text/css">
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
        </style>-->
        
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Vertex Group Technology</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="bootstrap/css/sb-admin-2.css" rel="stylesheet">
        <link href="bootstrap/datepicker/css/datepicker.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-modal.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-modal-bs3patch.css" rel="stylesheet">
        <link href="bootstrap/css/tecnybrasil.css" rel="stylesheet">
        <link href="bootstrap/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="img/icone_nav.png" >

<!--        <script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/jquery.maskMoney.js"></script>
        <script type="text/javascript" src="bootstrap/js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="bootstrap/js/jqueryvalidate.js"></script>
        <script type="text/javascript" src="bootstrap/js/biblioteca_tb.js"></script>
        <script type="text/javascript" src="bootstrap/js/tecnybrasil.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap-modal.js"></script>
        <script type="text/javascript" src="bootstrap/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap-collapse.js"></script>
        
        <script type="text/javascript" src="bootstrap/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/jquery.dataTables.min.js"></script>-->
<!--        <script type="text/javascript" src="bootstrap/js/jquery-1.4.2.js"></script>-->
        
<!--        <script src='https://www.google.com/recaptcha/api.js'></script>-->
        
    </head>
    <body style="background-color:#f8f8f8;">
        <div id="wrapper" style="background-color:#f8f8f8;"> 
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"> <img src="img/marca.png" /></a>
                </div>
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="text-align: center;"><strong>Login</strong></h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                if (isset($_REQUEST["email"])) $email = $_REQUEST["email"]; else $email = "";
                                if (isset($_REQUEST["senha"])) $senha = $_REQUEST["senha"]; else $senha = "";
                                
                                if (isset($_REQUEST["logar"])){
                                    if (!empty($_REQUEST) && 
                                        (empty($_REQUEST['email']) || empty($_REQUEST['senha']))) {
                                        msg('4','Digite a sua senha.','','','','');
                                    }
                                    else{
                                        $email = $_REQUEST['email'];
                                        $senha = $_REQUEST['senha'];
                                        $_SESSION['login_usuario'] = $email;
                                        $_SESSION['senha_usuario'] = $senha;

                                        $existe = strpos($email,'@');
                                        //Verifica se o login está sendo realizado por um usuário.
                                        if ( ($existe) && ( strcmp($email,"admin@admin.com")!=0) ){
                                            $sql = "SELECT chave, cd_usuario, chave_empresa, CONCAT(nm_usuario, ' ', sobrenome) as nome_user, senha, chave_modulo, permissao
                                                FROM tbl_usuario AS tu
                                                INNER JOIN tbl_usuario_modulos AS tum on tu.chave = tum.chave_usuario
                                                WHERE email = '".$email."'";
                                            $qry = mysqli_query($con,$sql);
                                            $res = mysqli_fetch_assoc($qry);
                                            $hash_senha = $res["senha"];
                                            if (password_verify($senha, $hash_senha) == 1){
                                                //Seta a variável de sessao para gerenciar os módulos que podem ser acessados.
                                                $_SESSION['acessar_modulos'] = array();
                                                
                                                $_SESSION['chave_usuario'] = $res["chave"];
                                                //$_SESSION['cd_usuario'] = $res["cd_usuario"];
                                                $_SESSION['chave_empresa'] = $res["chave_empresa"];

                                                $_SESSION['nome_user'] = $res['nome_user'];

                                                $_SESSION['acessar_modulos'][$res["chave_modulo"]] = $res["permissao"];
                                                while ($res = mysqli_fetch_array($qry)){
                                                    $_SESSION['acessar_modulos'][$res["chave_modulo"]] = $res["permissao"];
                                                }

                                                $_REQUEST["logar"]="";
                                                msg('1','Login realizado com sucesso.','1','1','index.php','');
                                            }
                                            else{
                                                //Tratamento para quando digitar um login/senha de um usuário errado
                                                $sql = "select chave,cd_usuario,chave_empresa,chave_modulo,permissao from tbl_usuario
                                                    inner join tbl_usuario_modulos on tbl_usuario.chave = tbl_usuario_modulos.chave_usuario
                                                    where email = '".$email."'";
                                                $qry = mysqli_query($con,$sql);
                                                $num_reg = mysqli_num_rows($qry);
                                                if ($num_reg > 0)
                                                    msg('4','Senha do usuário inexistente.','','','','');
                                                else msg('4','E-mail do usuário inexistente.','','','','');
                                            }
                                        }
                                        else{   //Verifica se o login está sendo realizado por uma empresa.
                                            $sql = "SELECT chave, cd_empresa, tipo_acesso, chave_modulo, permissao
                                                FROM tbl_empresa AS te
                                                INNER JOIN tbl_empresa_modulos AS tem ON te.chave = tem.chave_empresa
                                                WHERE login_master = '".$email."' and senha_master = '".$senha."'";
                                            $qry = mysqli_query($con,$sql);
                                            
                                            $num_reg = mysqli_num_rows($qry);
                                            if($num_reg > 0){
                                                //Seta a variável de sessao para gerenciar os módulos que podem ser acessados.
                                                $_SESSION['acessar_modulos'] = array();
                                                
                                                $res = mysqli_fetch_array($qry);
                                                $_SESSION['chave_empresa'] = $res["chave"];
                                                $tipo_acesso = $res["tipo_acesso"];
                                                $_SESSION['acessar_modulos'][$res["chave_modulo"]] = $res["permissao"];
                                                while ($res = mysqli_fetch_array($qry)){
                                                    //  TRATAMENTO PARA DIRECIONAR SOMENTE AO MÓDULO USUÁRIO
                                                    if ( ($tipo_acesso == "E") && ($res["chave_modulo"] != "L00000120170808160002") ){
                                                        $_SESSION['acessar_modulos'][$res["chave_modulo"]] = 'N';
                                                    }
                                                    else    $_SESSION['acessar_modulos'][$res["chave_modulo"]] = $res["permissao"];
                                                }

                                                $_REQUEST["logar"]="";
                                                if ($tipo_acesso == "A"){//Acesso realizado pelo administrador. Todos os módulos são setados
                                                    msg('1','Login realizado com sucesso.','1','1','index.php','');
                                                }
                                                else if ($tipo_acesso == "E"){//Acesso realizado por empresa que foi cadastrada no sistema.
                                                    //print_r($_SESSION['acessar_modulos']);
                                                    msg('1','Login realizado com sucesso.','1','1','index.php?pg=usuarios','');
                                                }
                                            }
                                            else{
                                                $sql = "SELECT te.chave, te.cd_empresa AS cod_empresa, tipo_acesso, 
                                                tem.chave_modulo AS chave_mod_emp, tem.permissao AS permissao_empresa
                                                FROM tbl_empresa AS te
                                                INNER JOIN tbl_empresa_modulos AS tem ON te.chave = tem.chave_empresa
                                                WHERE login_master = '".$email."'";
                                                $qry = mysqli_query($con,$sql);
                                                $num_reg = mysqli_num_rows($qry);
                                                
                                                //Tratamento para verificar se a chave ou senha existem no sistema
                                                if($num_reg > 0)    msg('4','Senha da chave incorreta.','','','','');
                                                else    msg('4','Chave inexistente.','','','','');
                                            }
                                        }
                                    }
                                }
                                form_inicio('login','post','login.php','');
                                form_input_text('E-mail/Chave','email',$email,'','','','','1');
                                form_input_text_senha('Senha','senha',$senha,'','','','1');
                                ?>
                                <div style="clear:both"></div>
<!--                                <div class="g-recaptcha" data-sitekey="6Ld6CTsUAAAAANcqelSxgnHPCfza9DAvA0oG0v0R"></div>
                                <br>-->
                                <?php
                                //form_input_captch('Digite o código','captch','12','');
                                form_botao('submit','logar','Login');
                                form_fim();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/metisMenu.min.js"></script>
        <script src="bootstrap/js/sb-admin-2.js"></script>
        <script src="bootstrap/datepicker/js/bootstrap-datepicker.js"></script>
    </body>
</html>