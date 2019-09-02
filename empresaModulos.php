<?php 
if (isset($_SESSION['acessar_modulos'])){
    if (($_SESSION['acessar_modulos']["L00000120170808160000"]) == "S"){?>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title"><strong>Permissões de Acesso aos Módulos do Sistema</strong></h3>
        </div>
        <div class="panel-body">
            <?php
            $mostrar_form = "S";
            $caminho_voltar = "index.php?pg=empresaCadastra";
            //$caminho_voltar = "index.php?pg=empresaCadastra&empresaModulo=".$_SESSION['chave_empresa_cadastra'];
            
            //Define os módulos de acesso.
            if (isset($_REQUEST["btn_cadatrar"])){
                
                //Pega os elementos da tela de cadastro de empresa que estavam na variável de sessão.
                //$tipo_pessoa = $_SESSION['dados_empresa']['tipo_pessoa'];
                $cnpj = $_SESSION['dados_empresa']['cnpj'];
                $insc_estadual = $_SESSION['dados_empresa']['insc_estadual'];
                $insc_municipal = $_SESSION['dados_empresa']['insc_municipal'];
                $nm_fantasia = $_SESSION['dados_empresa']['nm_fantasia'];
                $razao_social_nome = $_SESSION['dados_empresa']['razao_social_nome'];
                //$cpf = $_SESSION['dados_empresa']['cpf'];
                $cep = $_SESSION['dados_empresa']['cep'];
                $tipo = $_SESSION['dados_empresa']['tipo'];
                $logradouro = $_SESSION['dados_empresa']['logradouro'];
                $numero = $_SESSION['dados_empresa']['numero'];
                $complemento = $_SESSION['dados_empresa']['complemento'];
                $bairro = $_SESSION['dados_empresa']['bairro'];
                $cidade = $_SESSION['dados_empresa']['cidade'];
                $uf = $_SESSION['dados_empresa']['uf'];
                $telefone = $_SESSION['dados_empresa']['telefone'];
                $email_principal = $_SESSION['dados_empresa']['email_principal'];
                $site = $_SESSION['dados_empresa']['site'];
                $plano = $_SESSION['dados_empresa']['plano'];
                $dia_corte = $_SESSION['dados_empresa']['dia_corte'];
                //$status_ativo = $_SESSION['dados_empresa']['status_ativo'];
                if ($_SESSION['dados_empresa']['status_ativo']) $status_empresa = "S"; else $status_empresa = "N";
                $cd_convenio_correios = $_SESSION['dados_empresa']['cd_convenio_correios'];
                $logomarca = $_SESSION['dados_empresa']['logomarca'];
                $nm_contato1 = $_SESSION['dados_empresa']['nm_contato1'];
                $email_contato1 = $_SESSION['dados_empresa']['email_contato1'];
                $telefone_contato1 = $_SESSION['dados_empresa']['telefone_contato1'];
                $celular_contato1 = $_SESSION['dados_empresa']['celular_contato1'];
                $nm_contato2 = $_SESSION['dados_empresa']['nm_contato2'];
                $email_contato2 = $_SESSION['dados_empresa']['email_contato2'];
                $telefone_contato2 = $_SESSION['dados_empresa']['telefone_contato2'];
                $celular_contato2 = $_SESSION['dados_empresa']['celular_contato2'];

                //Tratamento para pegar o login/senha
                //if ($cnpj != "") $login = $cnpj; 
                //else $login = $cpf;

                $login = limpaCPF_CNPJ($cnpj);
                $senha = gerar_senha('10', true, true, true, true);

                //Gera o código da empresa
                $codigo = gera_codigo("tbl_empresa","cd_empresa");

                //Gera a chave de registro do banco da empresa
                $chave = gera_chave($codigo);
                
                //Tratamento da logomarca
                $nome = $logomarca['name'];
                $tipo_logo = $logomarca['type'];
                $tmp = $logomarca['tmp_name'];
                $tamanhoImg = $logomarca['size'];
                
                /*echo 'nome: '.$nome."<br>";
                echo 'type: '.$tipo."<br>";
                echo 'tamanhoImg: '.$tamanhoImg."<br>";
                echo 'tmp: '.$tmp."<br>";*/
                
                $logomarca_type = NULL;
                
                if (!empty($nome))
                {
                    $caminho_img = 'logos_empresas/'.$nome;
                    rename($caminho_img, 'logos_empresas/'.$chave);

                    $logomarca_type = $tipo_logo;
                }

                //Coloca em uma variável de sessão a chave gerada para o cadastro da nova empresa.
                //$_SESSION['chave_empresa_cadastra'] = $chave;

                //SQL para inserir os dados da empresa no banco.
                $sql = "insert into tbl_empresa(chave,cd_empresa,cnpj,insc_estadual,insc_municipal,"
                        . "nome_fantasia,nome_razaosocial,cep,tipo,logradouro,numero,complemento,bairro,cidade,"
                        . "uf,telefone,email_principal,site,plano_servico,dia_corte,ativo,cd_convenio,login_master,"
                        . "senha_master,logomarca,nome1,telefone1,celular1,email1,nome2,telefone2,celular2,email2,"
                        . "tipo_acesso) "
                        . "VALUES('".$chave."','".$codigo."','".$cnpj."','".$insc_estadual."','".$insc_municipal."','".$nm_fantasia."',"
                        . "'".$razao_social_nome."','".$cep."','".$tipo."','".$logradouro."','".$numero."','".$complemento."',"
                        . "'".$bairro."','".$cidade."','".$uf."','".$telefone."','".$email_principal."','".$site."','".$plano."',"
                        . "'".$dia_corte."','".$status_empresa."','".$cd_convenio_correios."','".$login."','".$senha."',"
                        . "'".$logomarca_type."','".$nm_contato1."','".$email_contato1."','".$telefone_contato1."',"
                        . "'".$celular_contato1."','".$nm_contato2."','".$email_contato2."','".$telefone_contato2."',"
                        . "'".$celular_contato2."','E')";

                $qry = mysqli_query($con,$sql);

                //Pega as chaves dos módulos de forma direta. Este tratamento precisa ser melhorado.
                $modulos = array();
                $sql = "select chave from tbl_modulos";
                $qry = mysqli_query($con,$sql);
                while ($res = mysqli_fetch_array($qry)){
                    array_push($modulos, $res["chave"]);
                }
                
                $sql = "insert into tbl_empresa_modulos(chave_empresa, chave_modulo, permissao)VALUES";
                $i=1;
                $cont = count($modulos);
                foreach($modulos as $chave_modulo){
                    if ( isset($_REQUEST["modulo_".$i]) )  $op_permissao = $_REQUEST["modulo_".$i];
                    else    $op_permissao = "N";
                    
                    if ($i == $cont)
                        $sql = $sql."('".$chave."','".$chave_modulo."','".$op_permissao."')";
                    else
                        $sql = $sql."('".$chave."','".$chave_modulo."','".$op_permissao."'),";
                    $i++;
                }
                $qry = mysqli_query($con,$sql);
                if ($qry){
                    msg('1','Empresa'.$cadastro_suces.'<br>Módulos definidos com sucesso.','1','2','index.php?','');
                    $mostrar_form = "N";
                }
            }
            
            //Tratamento para mostrar ou não os campos do formulário de definição das permissões de acessso aos módulos do sistema
            //associados a uma empresa
            if ($mostrar_form == "S"){
                form_inicio('formulario', 'POST', 'index.php?pg=empresaModulos','');?>
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
                                //Tratamento para criar a listagem de módulos com a possibilidade de selecionar a permissão.
                                $sql = "select chave, nm_modulo from tbl_modulos";
                                $qry = mysqli_query($con,$sql);
                                $i = 1;
                                while($res = mysqli_fetch_array($qry)){//Lista cada um dos módulos do sistema
                                    if ( isset($_REQUEST["modulo_".$i]) )$permisao_mod = $_REQUEST["modulo_".$i]; else $permisao_mod="";
                                    if ( ($res["chave"] != 'L00000120170808160000') && 
                                         ($res["chave"] != 'L00000120170808160003') &&
                                         ($res["chave"] != 'L00000120170808160004') ){?>
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <?php echo $res["nm_modulo"];?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php form_checkbox_semtitulo("modulo_".$i,"N","","","",'onclick="muda_opcao(this)"');?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    $i++;
                                }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div style="clear: both"></div>
                <div align="right">
                    <?php
                    //form_btn_voltar('Voltar',$caminho_voltar);
                    form_btn_reset('Limpar');
                    form_btn('submit','btn_cadatrar','Cadastrar'); 
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