<?php 

//foreach( $_SESSION as $index => $data ){
//     echo $index, ' = ', $data."<br>"; 
//}


//MUDAR O BANCO PARA PERMISSAO A E TESTAR. DEPOIS PROSSEGUIR COM OS AJUSTES DO MÓDULO DE COBRANÇAS E RELATÓRIOS.


if (isset($_SESSION['acessar_modulos'])){
    if (($_SESSION['acessar_modulos']["L00000120170808160002"]) != "N"){?>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading" >
                <h3 class="panel-title"><strong>Cadastro de Usuários</strong></h3>
            </div>
            <div class="panel-body">
                <?php
                if ( (isset($_REQUEST["editar"])) || (isset($_REQUEST["visualizar"])) ){    //Tratamento para editar os dados de um usuário do sistema
                    if (isset($_REQUEST["editar"])){
                        $btn_nome = "btn_atualizar";
                        $btn_texto = "Atualizar";
                        
                        $sql = "select * from tbl_usuario where chave = '".$_REQUEST["editar"]."'";
                        $qry = mysqli_query($con,$sql);
                        $res = mysqli_fetch_array($qry);
                        //$_SESSION['chave_usuario'] = $res['chave'];
                        $chave_usuario = $_REQUEST["editar"];
                    }
                    else{
                        $sql = "select * from tbl_usuario where chave = '".$_REQUEST["visualizar"]."'";
                        $qry = mysqli_query($con,$sql);
                        $res = mysqli_fetch_array($qry);
                        $chave_usuario = $_REQUEST["visualizar"];
                    }
                    
                    $nm_usuario = $res["nm_usuario"];
                    $caminho_voltar = "index.php?pg=usuarios&pesquisar_usuario=".$nm_usuario;
                    
                    $nm_usuario = utf8_encode($res["nm_usuario"]);
                    $sobrenome = utf8_encode($res["sobrenome"]);
                    $email_usuario = $res['email'];
                    $senha_usuario = $res['senha'];
                    
                    $mostrar_form = "S";
                    
                    //echo "chave_usuario: ".$_REQUEST["chave_usuario"]."<br>";
                }
                else if (isset($_REQUEST["excluir"])){  //Tratamento para excluir usuário do sistema.

                    $qry1 = user_delete("DELETE FROM tbl_usuario WHERE chave = '{$_REQUEST["excluir"]}'");
                    $qry2 = user_delete("DELETE FROM tbl_usuario_modulos WHERE chave_usuario = '{$_REQUEST["excluir"]}'");

                    if ($qry && $qry2){
                        msg('1','Usuário'.$exclusao_suces,'1','2','index.php?pg=usuarios','');
                        $mostrar_form = "N";
                    }else{
                        msg('4',$exclusao_erro,'','','index.php?pg=usuarios','');
                        $mostrar_form = "S";
                    }
                    $mostrar_form = "N";
                }
                else{
                    $btn_nome = "btn_cadastrar";
                    $btn_texto = "Cadastrar";
                    $caminho_voltar = "index.php?pg=usuarios";

                    if (isset($_REQUEST['nm_usuario'])) $nm_usuario = $_REQUEST['nm_usuario']; else $nm_usuario = "";
                    if (isset($_REQUEST['sobrenome'])) $sobrenome = $_REQUEST['sobrenome']; else $sobrenome = "";
                    if (isset($_REQUEST['email_usuario'])) $email_usuario = $_REQUEST['email_usuario']; else $email_usuario = "";
                    if (isset($_REQUEST['senha_usuario']) && !empty($_REQUEST['senha_usuario'])) {
                        $senha_usuario = password_hash($_REQUEST['senha_usuario'], PASSWORD_BCRYPT);
                    }else $senha_usuario = "";
                    
                    if (isset($_REQUEST['chave_usuario'])) $chave_usuario = $_REQUEST['chave_usuario']; else $chave_usuario = "";
                    //echo "REQUEST[chave_usuario]: ".$_REQUEST['chave_usuario'];

                    $mostrar_form = "S";
                }

                if (isset($_REQUEST["btn_cadastrar"])){ //Tratamento para quando clica em cadastrar um novo usuário.
                    $sql = "SELECT * FROM tbl_usuario WHERE email = '".$email_usuario."'";
                    $qry = mysqli_query($con,$sql);
                    $existe_usuario = mysqli_num_rows($qry);

                    if ($existe_usuario == 0){
                        //Gera o código do usuário
                        $codigo = gera_codigo("tbl_usuario","cd_usuario");

                        //Gera a chave de registro do banco do usuário
                        $chave = gera_chave($codigo);

                        //Processo para cadastrar um novo usuário
                        $sql = "insert into tbl_usuario(chave,cd_usuario,chave_empresa,nm_usuario,sobrenome,email,senha,ativo) 
                                VALUES('".$chave."','".$codigo."','".$_SESSION['chave_empresa']."','".utf8_encode($nm_usuario)."',
                                '".utf8_encode($sobrenome)."','".$email_usuario."','".$senha_usuario."','S')";
                        echo $sql;
                        $qry = mysqli_query($con,$sql);

                        if (!$qry){
                            msg('4',$cadastro_erro.'usuário.','','','','');
                            $mostrar_form = "S";
                        }
                        else{
                            //Processo para definição de permissões de acesso de um novo usuário
                            $sql = "INSERT INTO tbl_usuario_modulos(chave_usuario,chave_modulo,permissao) VALUES ";

                            $sql2 = "SELECT chave_modulo, permissao FROM tbl_empresa_modulos 
                                INNER JOIN tbl_modulos on tbl_empresa_modulos.chave_modulo = tbl_modulos.chave
                                WHERE chave_empresa = '".$_SESSION["chave_empresa"]."'";
                            $qry2 = mysqli_query($con,$sql2);
                            $num_reg = mysqli_num_rows($qry2);
                            $i=1;
                            while($res2 = mysqli_fetch_array($qry2)){
                                if ($res2["permissao"] == "N"){
                                    $sql .= "('".$chave."','".$res2["chave_modulo"]."','N'),";
                                    //echo "1-chave_empresa: ".$chave." | chave_modulo: ".$res2["chave_modulo"]." | permissão: N<br>";
                                }
                                else{
                                    $sql .= "('".$chave."','".$res2["chave_modulo"]."','".$_REQUEST["modulo_".$i]."'),";
                                    //echo "2-chave_empresa: ".$chave." | chave_modulo: ".$res2["chave_modulo"]." | permissão: ".$_REQUEST["modulo_".$i]."<br>";
                                    $i++;
                                }
                            }
                            $sql = substr($sql,0,-1);   //Remove a vírgula do final da SQL.

                            $qry = mysqli_query($con,$sql);
                            if ($qry){
                                msg('1','Usuário'.$cadastro_suces,'1','2','index.php?pg=usuarios','');
                                $mostrar_form = "N";
                            }else{
                                msg('4',$cadastro_erro.'usuário.','','5','index.php?pg=usuariosCadastra','');
                                $mostrar_form = "S";
                            }
                        }
                    }
                    else    msg('4','Usuário cadastrado no sistema. Favor inserir outro e-mail.','','5','index.php?pg=usuariosCadastra','');
                }
                else if (isset($_REQUEST["btn_atualizar"])){

                    // Se não houver senha, a query fica vazia
                    if (empty($senha_usuario)) {
                        $senha_usuario = '';
                    } else {
                        $senha_usuario = ", senha = '$senha_usuario'";
                    }

                    $sql = "UPDATE tbl_usuario SET
                            nm_usuario = '$nm_usuario', sobrenome = '$sobrenome',
                            email = '$email_usuario' $senha_usuario
                            WHERE chave = '$chave_usuario'";
                    //echo $sql."<br>";
                    $qry = user_update($sql);
                    if ($qry){
                        //$sql2 = "SELECT chave_modulo from tbl_usuario_modulos where chave_usuario = '".$chave_usuario."'";
                        $sql2 = "SELECT chave_modulo, permissao FROM tbl_empresa_modulos 
                                INNER JOIN tbl_modulos on tbl_empresa_modulos.chave_modulo = tbl_modulos.chave
                                WHERE chave_empresa = '".$_SESSION["chave_empresa"]."'";
                        $qry2 = mysqli_query($con,$sql2);
                        $i=1;
                        while($res2 = mysqli_fetch_array($qry2)){
                            if ($res2["permissao"] != "N"){
                                $sql3 = "UPDATE tbl_usuario_modulos
                                    SET permissao = '".$_REQUEST["modulo_".$i]."'
                                    WHERE ( (chave_modulo = '".$res2["chave_modulo"]."') AND (chave_usuario='".$chave_usuario."') )";
                                $qry3 = user_update($sql3);
                                $i++;
                            }                            
                            
                        }
                        msg('1',$atualizacao_suces,'1','3','index.php?pg=usuarios','');
                        $mostrar_form = "N";
                    }else{
                        msg('4',$atualizacao_erro,'','5','index.php?pg=usuariosCadastra','');
                        $mostrar_form = "S";
                        $btn_nome = "btn_atualizar";
                        $btn_texto = "Atualizar";
                    }
                }

                if ($mostrar_form == "S"){
                    if (!isset($_REQUEST["visualizar"])){
                        form_inicio('formulario', 'POST', 'index.php?pg=usuariosCadastra','');
                        form_input_text('Nome','nm_usuario',$nm_usuario,'50','3','','','1');
                        form_input_text('Sobrenome','sobrenome',$sobrenome,'50','3','','','1');
                        form_input_text('e-mail','email_usuario',$email_usuario,'100','3','','','1');

                        if (isset($_REQUEST["editar"])) {
                        ?>

                        <script>
                            function editarSenha (elem) {
                                elem.style.display = 'none';
                                document.getElementById('senha_usuario').type = 'password'
                            }
                        </script>

                        <div class="form-group col-lg-3">
                            <label>Senha</label>
                            <span style="display:block;width:100%;height:34px;">****** <a href="#" class="btn btn-link" onclick="editarSenha(this.parentElement)">Editar</a></span>
                            <input type="hidden" class="form-control" id="senha_usuario" name="senha_usuario" maxlength="8" required="required" placeholder="Senha" aria-invalid="false" autocomplete="new-password">
                        </div>

                        <?php
                        } else {
                            form_input_text_senha('Senha','senha_usuario',$senha_usuario,'8','3','','1');
                        }

                        /*Os módulos carregados abaixo serão buscados da empresa que está cadastrando o usuário*/
                        ?>
                        
                        <div class="form-group col-lg-10">
                            <div class="table-responsive">
                                <br>
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; width: 50%">Módulos</th>
                                            <th style="text-align: center; width: 15%">Permissão</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //echo "chave_usuario: ".$chave_usuario;
                                        //if (!isset($_SESSION["chave_usuario"])){
                                        if ($chave_usuario == ""){
                                            $sql = "SELECT tm.nm_modulo, tem.chave_modulo, tem.permissao
                                                    FROM tbl_empresa_modulos AS tem
                                                    INNER JOIN tbl_modulos AS tm on tem.chave_modulo = tm.chave
                                                    WHERE tem.chave_empresa = '".$_SESSION["chave_empresa"]."' 
                                                        AND tem.permissao!='N'";
                                            //echo $sql."<br>";
                                            $qry = mysqli_query($con,$sql);
                                            $i = 1;
                                            while($res = mysqli_fetch_array($qry)){
                                                if ( isset($_REQUEST["modulo_".$i]) )$permisao_mod = $_REQUEST["modulo_".$i]; else $permisao_mod="";?>
                                                <tr>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <?php echo $res["nm_modulo"];?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                        $permisao_mod = $res["permissao"];
                                                        form_select_semtitulo_horizontal('modulo_'.$i,$permisao_mod,"","L,Leitura:G,Gravar:N,Nenhum","10");
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            $i++;
                                            }
                                        }
                                        else{
                                            $sql = "SELECT tm.nm_modulo, tum.chave_modulo, tum.permissao AS permissao_u, 
                                                    tem.permissao AS permissao_e
                                                    FROM tbl_usuario_modulos AS tum
                                                    INNER JOIN tbl_modulos AS tm on tum.chave_modulo = tm.chave
                                                    INNER JOIN tbl_empresa_modulos AS tem on tm.chave = tem.chave_modulo
                                                    WHERE tum.chave_usuario = '".$chave_usuario."' AND
                                                          tem.chave_empresa = '".$_SESSION["chave_empresa"]."'";
                                            $qry = mysqli_query($con,$sql);
                                            $i = 1;
                                            while($res = mysqli_fetch_array($qry)){
                                                if ($res["permissao_e"] == "S"){
                                                    if ( isset($_REQUEST["modulo_".$i]) )$permisao_mod = $_REQUEST["modulo_".$i]; else $permisao_mod="";?>
                                                    <tr>
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <?php echo $res["nm_modulo"];?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?php 
                                                            $permisao_mod = $res["permissao_u"];
                                                            form_select_semtitulo_horizontal('modulo_'.$i,$permisao_mod,"","L,Leitura:G,Gravar:N,Nenhum","10");
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                        }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div style="clear: both"></div>
                        <label style='color:red; font-weight: normal;'>* Campos de Preenchimento Obrigatório</label>
                        <br><br><br>
                        <div align="right">
                            <?php
                            form_btn_voltar('Voltar',$caminho_voltar);
                            form_btn_reset('Limpar');
                            form_btn('submit',$btn_nome,$btn_texto);
                            ?>
                        </div>
                        <?php
                        form_input_hidden('chave_usuario', $chave_usuario);
                    }
                    else{
                        form_inicio('formulario', 'POST', 'index.php?pg=usuariosCadastra','');
                        form_input_text_leitura('Nome','nm_usuario',$nm_usuario,'50','3','','');
                        form_input_text_leitura('Sobrenome','sobrenome',$sobrenome,'50','3','','');
                        form_input_text_leitura('e-mail','email_usuario',$email_usuario,'100','3','','');
                        form_input_text_senha('Senha','senha_usuario',$senha_usuario,'8','3','','1');

                        /*Os módulos carregados abaixo serão buscados da empresa que está cadastrando o usuário*/
                        ?>

                        <div class="form-group col-lg-10">
                            <div class="table-responsive">
                                <br>
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; width: 50%">Módulos</th>
                                            <th style="text-align: center; width: 15%">Permissão</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT tm.nm_modulo, tum.chave_modulo, tum.permissao AS permissao_u, 
                                                tem.permissao AS permissao_e
                                                FROM tbl_usuario_modulos AS tum
                                                INNER JOIN tbl_modulos AS tm on tum.chave_modulo = tm.chave
                                                INNER JOIN tbl_empresa_modulos AS tem on tm.chave = tem.chave_modulo
                                                WHERE tum.chave_usuario = '".$chave_usuario."' AND
                                                      tem.chave_empresa = '".$_SESSION["chave_empresa"]."'";
                                        //echo $sql;
                                        $qry = mysqli_query($con,$sql);
                                        $i = 1;
                                        while($res = mysqli_fetch_array($qry)){
                                            if ($res["permissao_e"] == "S"){
                                                if ( isset($_REQUEST["modulo_".$i]) )$permisao_mod = $_REQUEST["modulo_".$i]; else $permisao_mod="";?>
                                                <tr>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <?php echo $res["nm_modulo"];?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                        $permisao_mod = $res["permissao_u"];
                                                        if ($permisao_mod == "L") echo "Leitura";
                                                        else if ($permisao_mod == "G") echo "Gravar";
                                                        else echo "Nenhum";
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div style="clear: both"></div>
                        <br><br><br>
                        <div align="right">
                            <?php
                            form_btn_voltar('Voltar',$caminho_voltar);
                            ?>
                        </div>
                        <?php
                    }
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