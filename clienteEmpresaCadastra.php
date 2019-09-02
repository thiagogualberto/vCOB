<?php 
if (isset($_SESSION['acessar_modulos'])){
    if ( (($_SESSION['acessar_modulos']["L00000120170808160001"]) == "S") ||
         (($_SESSION['acessar_modulos']["L00000120170808160001"]) == "G") ){?>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading" >
                <h3 class="panel-title"><strong>Cadastro de Cliente das Empresas</strong></h3>
            </div>
            <div class="panel-body">
                <?php
                if ( (isset($_REQUEST["editar"])) || (isset($_REQUEST["visualizar"])) ){
                    $caminho_voltar = "index.php?pg=clienteEmpresa&filtrar=".$_REQUEST["filtrar"]."&pesquisar_cliente_empresa=".$_REQUEST["pesquisar_cliente_empresa"]."";
                    if (isset($_REQUEST["editar"])){
                        $btn_nome = "btn_atualizar";
                        $btn_texto = "Atualizar";

                        $sql = "select * from tbl_cliente_empresa where chave = '".$_REQUEST["editar"]."'";
                        $qry = mysqli_query($con,$sql);
                        $res = mysqli_fetch_array($qry);
                    }
                    else{
                        $sql = "select * from tbl_cliente_empresa where chave = '".$_REQUEST["visualizar"]."'";
                        $qry = mysqli_query($con,$sql);
                        $res = mysqli_fetch_array($qry);
                    }
                    
                    $_SESSION['chave_cliente_empresa'] = $res['chave'];

                    $tipo_pessoa = $res['tipo_cliente'];
                    $cnpj = $res['cnpj'];
                    $insc_estadual = $res['insc_estadual'];
                    $insc_municipal = $res['insc_municipal'];
                    $nm_fantasia = $res['nome_fantasia'];
                    $razao_social_nome = $res['nome_razaosocial']; 
                    $cpf = $res['cpf'];
                    $cep = $res['cep'];
                    $tipo = $res['tipo'];
                    $logradouro = $res['logradouro'];
                    $numero = $res['numero'];
                    $complemento = $res['complemento'];
                    $bairro = $res['bairro'];
                    $cidade = $res['cidade'];
                    $uf = $res['uf'];
                    $telefone = $res['telefone'];
                    $email_principal = $res['email_principal'];
                    $site = $res['site'];
                    $status_cliente = "S";
                    $nm_contato1 = $res['nome1'];
                    $email_contato1 = $res['email1'];
                    $telefone_contato1 = $res['telefone1'];
                    $celular_contato1 = $res['celular1'];
                    $nm_contato2 = $res['nome2'];
                    $email_contato2 = $res['email2'];
                    $telefone_contato2 = $res['telefone2'];
                    $celular_contato2 = $res['celular2'];

                    $mostrar_form = "S";
                }
                else if (isset($_REQUEST["excluir"])){
                    $sql = "DELETE FROM tbl_cliente_empresa WHERE chave = '".$_REQUEST["excluir"]."'";

                    $qry = user_delete($sql);
                    if ($qry){
                        msg('1','Cliente'.$exclusao_suces,'1','3','index.php?pg=clienteEmpresa','');
                        $mostrar_form = "N";
                    }else{
                        msg('4','Cliente'.$exclusao_erro,'','5','index.php?pg=clienteEmpresaCadastra','');
                        $mostrar_form = "S";
                    }

                    $mostrar_form = "N";
                }
                else{
                    $caminho_voltar = "index.php?pg=clienteEmpresa";
                    $btn_nome = "btn_cadastrar";
                    $btn_texto = "Cadastrar";

                    if (isset($_REQUEST['tipo_pessoa'])) $tipo_pessoa = $_REQUEST['tipo_pessoa']; else $tipo_pessoa = "";
                    if (isset($_REQUEST['cnpj'])) $cnpj = $_REQUEST['cnpj']; else $cnpj = "";
                    if (isset($_REQUEST['insc_estadual'])) $insc_estadual = $_REQUEST['insc_estadual']; else $insc_estadual = "";
                    if (isset($_REQUEST['insc_municipal'])) $insc_municipal = $_REQUEST['insc_municipal']; else $insc_municipal = "";
                    if (isset($_REQUEST['nm_fantasia'])) $nm_fantasia = $_REQUEST['nm_fantasia']; else $nm_fantasia = "";
                    if (isset($_REQUEST['razao_social_nome'])) $razao_social_nome = $_REQUEST['razao_social_nome']; else $razao_social_nome = "";
                    if (isset($_REQUEST['cpf'])) $cpf = $_REQUEST['cpf']; else $cpf = "";
                    if (isset($_REQUEST['cep'])) $cep = $_REQUEST['cep']; else $cep = "";
                    if (isset($_REQUEST['tipo'])) $tipo = $_REQUEST['tipo']; else $tipo = "";
                    if (isset($_REQUEST['logradouro'])) $logradouro = $_REQUEST['logradouro']; else $logradouro = "";
                    if (isset($_REQUEST['numero'])) $numero = $_REQUEST['numero']; else $numero = "";
                    if (isset($_REQUEST['complemento'])) $complemento = $_REQUEST['complemento']; else $complemento = "";
                    if (isset($_REQUEST['bairro'])) $bairro = $_REQUEST['bairro']; else $bairro = "";
                    if (isset($_REQUEST['cidade'])) $cidade = $_REQUEST['cidade']; else $cidade = "";
                    if (isset($_REQUEST['uf'])) $uf = $_REQUEST['uf']; else $uf = "";
                    if (isset($_REQUEST['telefone'])) $telefone = $_REQUEST['telefone']; else $telefone = "";
                    if (isset($_REQUEST['email_principal'])) $email_principal = $_REQUEST['email_principal']; else $email_principal = "";
                    if (isset($_REQUEST['site'])) $site = $_REQUEST['site']; else $site = "";
                    if (isset($_REQUEST['status_ativo'])) $status_cliente = "S"; else $status_cliente = "";
                    if (isset($_REQUEST['nm_contato1'])) $nm_contato1 = $_REQUEST['nm_contato1']; else $nm_contato1 = "";
                    if (isset($_REQUEST['email_contato1'])) $email_contato1 = $_REQUEST['email_contato1']; else $email_contato1 = "";
                    if (isset($_REQUEST['telefone_contato1'])) $telefone_contato1 = $_REQUEST['telefone_contato1']; else $telefone_contato1 = "";
                    if (isset($_REQUEST['celular_contato1'])) $celular_contato1 = $_REQUEST['celular_contato1']; else $celular_contato1 = "";
                    if (isset($_REQUEST['nm_contato2'])) $nm_contato2 = $_REQUEST['nm_contato2']; else $nm_contato2 = "";
                    if (isset($_REQUEST['email_contato2'])) $email_contato2 = $_REQUEST['email_contato2']; else $email_contato2 = "";
                    if (isset($_REQUEST['telefone_contato2'])) $telefone_contato2 = $_REQUEST['telefone_contato2']; else $telefone_contato2 = "";
                    if (isset($_REQUEST['celular_contato2'])) $celular_contato2 = $_REQUEST['celular_contato2']; else $celular_contato2 = "";

                    $mostrar_form = "S";
                }

                if (isset($_REQUEST["btn_cadastrar"])){

                    //Gera o código da empresa
                    $codigo = gera_codigo("tbl_cliente_empresa","cd_cliente_empresa");

                    //Gera a chave de registro do banco da empresa
                    $chave = gera_chave($codigo);

                    $sql = "insert into tbl_cliente_empresa(chave,cd_cliente_empresa,chave_empresa,tipo_cliente,cnpj,insc_estadual,insc_municipal,"
                            . "nome_fantasia,nome_razaosocial,cpf,cep,tipo,logradouro,numero,complemento,bairro,cidade,uf,telefone,email_principal,"
                            . "site,ativo,nome1,telefone1,celular1,email1,nome2,telefone2,celular2,email2) VALUES"
                            . "('".$chave."','".$codigo."','".$_SESSION['chave_empresa']."','".$tipo_pessoa."','".$cnpj."','".$insc_estadual."',"
                            . "'".$insc_municipal."','".$nm_fantasia."','".$razao_social_nome."','".$cpf."','".$cep."','".$tipo."',"
                            . "'".$logradouro."','".$numero."','".$complemento."','".$bairro."','".$cidade."','".$uf."','".$telefone."',"
                            . "'".$email_principal."','".$site."','".$status_cliente."','".$nm_contato1."',"
                            . "'".$telefone_contato1."','".$celular_contato1."','".$email_contato1."','".$nm_contato2."','".$telefone_contato2."',"
                            . "'".$celular_contato2."','".$email_contato2."')";
                    $qry = mysqli_query($con,$sql);
                    if ($qry){
                        msg('1','Cliente'.$cadastro_suces,'1','3','index.php','');
                        $mostrar_form = "N";
                    }else{
                        msg('4',$cadastro_erro.'cliente.','','5','index.php?pg=clienteEmpresaCadastra','');
                        $mostrar_form = "S";
                    }
                }
                else if (isset($_REQUEST["btn_atualizar"])){
                    $sql = "UPDATE tbl_cliente_empresa SET
                            tipo_cliente = '".$tipo_pessoa."', cnpj = '".$cnpj."',
                            insc_estadual = '".$insc_estadual."', insc_municipal = '".$insc_municipal."',
                            nome_fantasia = '".$nm_fantasia."', nome_razaosocial = '".$razao_social_nome."',
                            cpf = '".$cpf."', cep = '".$cep."',
                            tipo = '".$tipo."', logradouro = '".$logradouro."',
                            numero = '".$numero."', complemento = '".$complemento."',
                            bairro = '".$bairro."', cidade = '".$cidade."',
                            uf = '".$uf."', telefone = '".$telefone."',
                            email_principal = '".$email_principal."', site = '".$site."', ativo = '".$status_cliente."',
                            nome1 = '".$nm_contato1."', telefone1 = '".$telefone_contato1."',
                            celular1 = '".$celular_contato1."', email1 = '".$email_contato1."',
                            nome2 = '".$nm_contato2."', telefone2 = '".$telefone_contato2."',
                            celular2 = '".$celular_contato2."', email2 = '".$email_contato2."'

                            WHERE chave = '".$_SESSION['chave_cliente_empresa']."'";

                    $qry = user_update($sql);
                    if ($qry){
                        msg('1',$atualizacao_suces,'1','3',"index.php?pg=clienteEmpresa&filtrar=".$_REQUEST['filtrar']."&pesquisar_cliente_empresa=".$_REQUEST['pesquisar_cliente_empresa'],'');
                        //$caminho_voltar = "index.php?pg=clienteEmpresa&filtrar=".$_REQUEST["filtrar"]."&pesquisar_cliente_empresa=".$_REQUEST["pesquisar_cliente_empresa"]."";
                    
                        $mostrar_form = "N";
                    }else{
                        msg('4',$atualizacao_erro,'','5','index.php?pg=clienteEmpresaCadastra','');
                        $mostrar_form = "S";
                    }
                    $caminho_voltar = "index.php?pg=clienteEmpresa";
                    $btn_nome = "btn_atualizar";
                    $btn_texto = "Atualizar";
                }

                if ($mostrar_form == "S"){
                    if (!isset($_REQUEST["visualizar"])){
                        form_inicio('formulario', 'post', 'index.php?pg=clienteEmpresaCadastra','');
                        form_radio('Tipo Pessoa', 'tipo_pessoa', 'PJ:PF', 'Pessoa Jurídica:Pessoa Física', $tipo_pessoa, '12');
                        if ($tipo_pessoa == "PF"){
                            form_input_text_leitura('CNPJ','cnpj',$cnpj,'18','4','','');
                            form_input_text_leitura('Inscrição Estadual','insc_estadual',$insc_estadual,'20','4','','');
                            form_input_text_leitura('Inscrição Municipal','insc_municipal',$insc_municipal,'20','4','','');?>
                            <div style="clear: both"></div>
                            <?php
                            form_input_text_leitura('Nome Fantasia','nm_fantasia',$nm_fantasia,'100','6','','');
                            form_input_text('Razão Social','razao_social_nome',$razao_social_nome,'100','6','','','');?>
                            <div style="clear: both"></div>
                            <?php
                            form_input_text('CPF','cpf',$cpf,'14','2','','','1');
                        }
                        else{
                            form_input_text('CNPJ','cnpj',$cnpj,'18','4','','','1');
                            form_input_text('Inscrição Estadual','insc_estadual',$insc_estadual,'20','4','','','');
                            form_input_text('Inscrição Municipal','insc_municipal',$insc_municipal,'20','4','','','');?>
                            <div style="clear: both"></div>
                            <?php
                            form_input_text('Nome Fantasia','nm_fantasia',$nm_fantasia,'100','6','','','');
                            form_input_text('Razão Social','razao_social_nome',$razao_social_nome,'100','6','','','');?>
                            <div style="clear: both"></div>
                            <?php
                            form_input_text_leitura('CPF','cpf',$cpf,'14','2','','1');
                        }
                        form_input_text('CEP','cep',$cep,'10','2','','','1');
                        form_input_text_leitura('Tipo','tipo',$tipo,'20','2','','');
                        form_input_text_leitura('Logradouro','logradouro',$logradouro,'50','4','','');
                        form_input_text_number('Número','numero',$numero,'6','2','','1');?>
                        <div style="clear: both"></div>
                        <?php
                        form_input_text('Complemento','complemento',$complemento,'10','3','','','');
                        form_input_text_leitura('Bairro','bairro',$bairro,'100','3','','');
                        form_input_text_leitura('Cidade','cidade',$cidade,'100','3','','');
                        form_input_text_leitura('UF','uf',$uf,'2','1','','');
                        form_input_text('Telefone','telefone',$telefone,'15','2','','telefone','1');
                        form_input_text('E-mail Principal','email_principal',$email_principal,'100','3','','','1');
                        form_input_text('Site','site',$site,'50','5','','','');
                        form_checkbox('Status do Cliente','status','ativo','Ativo','S','2');?>
                        <br>
                        <br>
                        <div style="clear:both"></div>

                        <!-- Cria as abas de navegação -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#contato1" data-toggle="tab">Contato 01</a></li>
                            <li><a href="#contato2" data-toggle="tab">Contato 02</a></li>
                        </ul>

                        <!-- Cria o conteúdo de cada aba de navegação -->
                        <div class="tab-content">
                            <!-- Código referente a aba Contato 01 -->
                            <div class="tab-pane active" id="contato1">
                                <br>
                                <?php
                                    form_input_text('Nome','nm_contato1',$nm_contato1,'100','4','','','');
                                    form_input_text('e-mail','email_contato1',$email_contato1,'100','4','','','');?>
                                    <div style="clear: both"></div>
                                    <?php
                                    form_input_text('Telefone','telefone_contato1',$telefone_contato1,'14','4','','telefone','');
                                    form_input_text('Celular','celular_contato1',$celular_contato1,'15','4','','telefone','');?>
                            </div>
                            <!-- Código referente a aba Contato 02 -->
                            <div class="tab-pane" id="contato2">
                                <br>
                                <?php
                                    form_input_text('Nome','nm_contato2',$nm_contato2,'100','4','','','');
                                    form_input_text('e-mail','email_contato2',$email_contato2,'100','4','','','');?>
                                    <div style="clear: both"></div>
                                    <?php
                                    form_input_text('Telefone','telefone_contato2',$telefone_contato2,'14','4','','telefone','');
                                    form_input_text('Celular','celular_contato2',$celular_contato2,'15','4','','telefone','');?>
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div style="clear: both"></div>
                        <br>
                        <label style='color:red; font-weight: normal;'>* Campos de Preenchimento Obrigatório</label>
                        <br>
                        <div align="right">
                            <?php
                            form_btn_voltar('Voltar',$caminho_voltar);
                            form_btn_reset('Limpar');
                            form_btn('submit',$btn_nome,$btn_texto);
                            ?>
                        </div>
                        <?php
                        if ( isset($_REQUEST["filtrar"]) ) $filtrar = $_REQUEST["filtrar"]; else $filtrar = "";
                        if ( isset($_REQUEST["pesquisar_cliente_empresa"]) ) $pesquisar_cliente_empresa = $_REQUEST["pesquisar_cliente_empresa"]; else $pesquisar_cliente_empresa = "";
                        form_input_hidden('filtrar', $filtrar);
                        form_input_hidden('pesquisar_cliente_empresa', $pesquisar_cliente_empresa);
                        form_fim();
                    }
                    else{
                        form_inicio('formulario', 'post', 'index.php?pg=clienteEmpresaCadastra','');
                        form_radio('Tipo Pessoa', 'tipo_pessoa', 'PJ:PF', 'Pessoa Jurídica:Pessoa Física', $tipo_pessoa, '12');
                        
                        form_input_text_leitura('CNPJ','cnpj',$cnpj,'18','4','','');
                        form_input_text_leitura('Inscrição Estadual','insc_estadual',$insc_estadual,'20','4','','');
                        form_input_text_leitura('Inscrição Municipal','insc_municipal',$insc_municipal,'20','4','','');?>
                        <div style="clear: both"></div>
                        <?php
                        form_input_text_leitura('Nome Fantasia','nm_fantasia',$nm_fantasia,'100','6','','');
                        form_input_text_leitura('Razão Social','razao_social_nome',$razao_social_nome,'100','6','','','');?>
                        <div style="clear: both"></div>
                        <?php
                        form_input_text_leitura('CPF','cpf',$cpf,'14','2','','','1');
                        form_input_text_leitura('CEP','cep',$cep,'10','2','','','1');
                        form_input_text_leitura('Tipo','tipo',$tipo,'20','2','','');
                        form_input_text_leitura('Logradouro','logradouro',$logradouro,'50','4','','');
                        form_input_text_leitura('Número','numero',$numero,'6','2','','','1');?>
                        <div style="clear: both"></div>
                        <?php
                        form_input_text_leitura('Complemento','complemento',$complemento,'10','3','','','');
                        form_input_text_leitura('Bairro','bairro',$bairro,'100','3','','');
                        form_input_text_leitura('Cidade','cidade',$cidade,'100','3','','');
                        form_input_text_leitura('UF','uf',$uf,'2','1','','');
                        form_input_text_leitura('Telefone','telefone',$telefone,'14','2','','telefone','1');
                        form_input_text_leitura('E-mail Principal','email_principal',$email_principal,'100','3','','','1');
                        form_input_text_leitura('Site','site',$site,'50','5','','','');
                        form_checkbox('Status do Cliente','status','ativo','Ativo','S','2');?>
                        <br>
                        <br>
                        <div style="clear:both"></div>

                        <!-- Cria as abas de navegação -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#contato1" data-toggle="tab">Contato 01</a></li>
                            <li><a href="#contato2" data-toggle="tab">Contato 02</a></li>
                        </ul>

                        <!-- Cria o conteúdo de cada aba de navegação -->
                        <div class="tab-content">
                            <!-- Código referente a aba Contato 01 -->
                            <div class="tab-pane active" id="contato1">
                                <br>
                                <?php
                                    form_input_text_leitura('Nome','nm_contato1',$nm_contato1,'100','4','');
                                    form_input_text_leitura('e-mail','email_contato1',$email_contato1,'100','4','');?>
                                    <div style="clear: both"></div>
                                    <?php
                                    form_input_text_leitura('Telefone','telefone_contato1',$telefone_contato1,'14','4','');
                                    form_input_text_leitura('Celular','celular_contato1',$celular_contato1,'15','4','');?>
                            </div>
                            <!-- Código referente a aba Contato 02 -->
                            <div class="tab-pane" id="contato2">
                                <br>
                                <?php
                                    form_input_text_leitura('Nome','nm_contato2',$nm_contato2,'100','4','');
                                    form_input_text_leitura('e-mail','email_contato2',$email_contato2,'100','4','');?>
                                    <div style="clear: both"></div>
                                    <?php
                                    form_input_text_leitura('Telefone','telefone_contato2',$telefone_contato2,'14','4','');
                                    form_input_text_leitura('Celular','celular_contato2',$celular_contato2,'15','4','');?>
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div style="clear: both"></div>
                        <br>
                        <label style='color:red; font-weight: normal;'>* Campos de Preenchimento Obrigatório</label>
                        <br>
                        <div align="right">
                            <?php
                            form_btn_voltar('Voltar',$caminho_voltar);
                            ?>
                        </div>
                        <?php
                        form_fim();
                    }
                }
                ?>
            </div>
        </div>
    <?php
    }
}else{?>
    <br>
    <?php 
    msg('4','Acesso não autorizado. Redirecionamento para a tela de login.','1','5','login.php','');
}?>