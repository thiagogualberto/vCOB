<?php
if (isset($_SESSION['acessar_modulos'])){
    if ( (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "S") ||
         (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "G") ){?>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading" >
                <h3 class="panel-title"><strong>Mensagem</strong></h3>
            </div>
            <div class="panel-body">
                <?php
                $mostrar_form = "S";

                $nm_mensagem = "";
                $mensagem = "";

                if (isset($_REQUEST["btn_cadastrar"])){
                    if (isset($_REQUEST['nm_mensagem'])) $nm_mensagem = $_REQUEST['nm_mensagem']; else $nm_mensagem = "";
                    if (isset($_REQUEST['mensagem'])) $mensagem = $_REQUEST['mensagem']; else $mensagem = "";

                    $sql = "SELECT * from tbl_cobranca_mensagem WHERE nm_mensagem = '".$nm_mensagem."'";
                    $qry = mysqli_query($con,$sql);
                    if (mysqli_num_rows($qry) == 0){ //Verifica se o nome vinculado a mensagem ja foi criado.
                        //Gera o código do usuário
                        $codigo = gera_codigo("tbl_cobranca_mensagem","cd_cobranca_mensagem");

                        //Gera a chave de registro do banco do usuário
                        $chave = gera_chave($codigo);

                        $sql = "insert into tbl_cobranca_mensagem(chave,cd_cobranca_mensagem,chave_empresa,nm_mensagem,mensagem) 
                                VALUES('".$chave."','".$codigo."','".$_SESSION["chave_empresa"]."','".$nm_mensagem."','".$mensagem."')";
                        $qry = mysqli_query($con,$sql);
                        $mostrar_form = "N";
                        msg('1','Mensagem cadastrada com sucesso.','1','1','index.php?pg=cobrancas','');
                    }
                    else    msg('4','Nome da mensagem já existe. Defina outro nome.','','','','');
                }

                if ($mostrar_form == "S"){
                    form_inicio('formulario', 'POST', 'index.php?pg=cobrancasMensagem','');
                    form_input_text('Nome da Mensagem','nm_mensagem',$nm_mensagem,'50','3','','','1');
                    form_input_textarea('Mensagem','mensagem',$mensagem,'10','3','1');
                    ?>
                    <br>
                    <br>
                    <div style="clear:both"></div>
                    <label style='color:red; font-weight: normal;'>* Campos de Preenchimento Obrigatório</label>
                    <br>
                    <div align="right">
                        <?php
                        form_btn_submit('Voltar');
                        form_btn_reset('Limpar');
                        form_btn('submit','btn_cadastrar','Cadastrar');
                        ?>
                    </div>
                    <?php
                    form_fim();
                }?>
            </div>
        </div>
        <?php
    }
}else{?>
    <br>
    <?php 
    msg('4','Acesso não autorizado. Redirecionamento para a tela de login.','1','5','login.php','');
}?>