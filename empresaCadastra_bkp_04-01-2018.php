<?php 
if (isset($_SESSION['acessar_modulos'])){
    if (($_SESSION['acessar_modulos']["L00000120170808160000"]) == "S"){?>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title"><strong>Cadastro de Empresas</strong></h3>
        </div>
        <div class="panel-body">
            <?php
            $mostrar_form = "S";
            
            //Pega as informações voltando da tela de Empresa Módulos
            if (isset($_REQUEST["empresaModulo"])){
                $btn_nome = "btn_atualizar";
                $btn_texto = "Atualizar";
                
                $sql = "SELECT * FROM tbl_empresa WHERE chave = ".$_REQUEST["empresaModulo"];
                $qry = mysqli_query($con,$sql);
                $res = mysqli_fetch_array($qry);
                
                $tipo_pessoa = $res["tipo_cliente "];
                $cnpj = $res["cnpj"];
                $insc_estadual = $res["insc_estadual"];
                $insc_municipal = $res["insc_municipal"];
                $nm_fantasia = $res["nome_fantasia"];
                $razao_social_nome = $res["nome_razaosocial"];
                $cpf = $res["cpf"];
                $cep = $res["cep"];
                $tipo = $res["tipo"];
                $logradouro = $res["logradouro"];
                $numero = $res["numero"];
                $complemento = $res["complemento"];
                $bairro = $res["bairro"];
                $cidade = $res["cidade"];
                $uf = $res["uf"];
                $telefone = $res["telefone"];
                $email_principal = $res["email_principal"];
                $site = $res["site"];
                $plano = $res["plano_servico"];
                $dia_corte = $res["dia_corte"];
                $status_empresa = $res["ativo"];
                $cd_convenio_correios = $res["cd_convenio"];
                $login = $res["login_master"];
                $senha = $res["senha_master"];
                $logomarca = $res["logomarca"];
                $nm_contato1 = $res["nome1"];
                $email_contato1 = $res["email1"];
                $telefone_contato1 = $res["telefone1"];
                $celular_contato1 = $res["celular1"];
                $nm_contato2 = $res["nome2"];
                $email_contato2 = $res["email2"];
                $telefone_contato2 = $res["telefone2"];
                $celular_contato2 = $res["celular2"];
            }
            else{
                //Caso os campos do formulário de cadastro de empresa sejam setados, os mesmos são carregados nas variáveis.
                //Caso contrário, os campos ficam em branco.
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
                if (isset($_REQUEST['plano'])) $plano = $_REQUEST['plano']; else $plano = "";
                if (isset($_REQUEST['dia_corte'])) $dia_corte = $_REQUEST['dia_corte']; else $dia_corte = "";
                if (isset($_REQUEST['status_ativo'])) $status_empresa = "S"; else $status_empresa = "N";
                if (isset($_REQUEST['cd_convenio_correios'])) $cd_convenio_correios = $_REQUEST['cd_convenio_correios']; else $cd_convenio_correios = "";
                
                $login = "";
                $senha = "";
                
                if (isset($_FILES['logomarca']['name']))    $logomarca = $_FILES['logomarca']['name'];  else    $logomarca = "";
                if (isset($_REQUEST['nm_contato1'])) $nm_contato1 = $_REQUEST['nm_contato1']; else $nm_contato1 = "";
                if (isset($_REQUEST['email_contato1'])) $email_contato1 = $_REQUEST['email_contato1']; else $email_contato1 = "";
                if (isset($_REQUEST['telefone_contato1'])) $telefone_contato1 = $_REQUEST['telefone_contato1']; else $telefone_contato1 = "";
                if (isset($_REQUEST['celular_contato1'])) $celular_contato1 = $_REQUEST['celular_contato1']; else $celular_contato1 = "";
                if (isset($_REQUEST['nm_contato2'])) $nm_contato2 = $_REQUEST['nm_contato2']; else $nm_contato2 = "";
                if (isset($_REQUEST['email_contato2'])) $email_contato2 = $_REQUEST['email_contato2']; else $email_contato2 = "";
                if (isset($_REQUEST['telefone_contato2'])) $telefone_contato2 = $_REQUEST['telefone_contato2']; else $telefone_contato2 = "";
                if (isset($_REQUEST['celular_contato2'])) $celular_contato2 = $_REQUEST['celular_contato2']; else $celular_contato2 = "";
            }
            
            //Tratamento para quando clicar no botão Avançar.
            if (isset($_REQUEST["btn_avancar"])){
                
                //Tratamento para salvar a logomarca no diretório
                $nome = $_FILES['logomarca']['name'];
                $tmp = $_FILES['logomarca']['tmp_name'];
                $pasta = "./logos_empresas";
                $caminho_img = $pasta."/".$nome;
                move_uploaded_file($tmp, $caminho_img);
                
                //Tratamento para pegar o login/senha
                if ($cnpj != "") $login = $cnpj; 
                else $login = $cpf;
                
                $sql = "SELECT * FROM tbl_empresa WHERE (cnpj = '".$login."') OR (nome_razaosocial = '".$razao_social_nome."')";
                $qry = mysqli_query($con,$sql);
                $num_reg = mysqli_num_rows($qry);
                
                if ($num_reg == 0){
                    $_SESSION['dados_empresa'] = array_merge($_REQUEST,$_FILES);
                    //print_r($_SESSION['dados_empresa']);
                    
                    msg('1','Redirecionando para a tela de definição dos módulos de acesso ao sistema.','1','2','index.php?pg=empresaModulos','');
                    $mostrar_form = "N";
                    
                    /*if ($qry){
                        msg('1','Empresa '.$cadastro_suces,'1','2','index.php?pg=empresaModulos&chave='.$chave,'');
                        $mostrar_form = "N";
                    }else{
                        msg('4',$cadastro_erro.'empresa.','','5','index.php?pg=empresaCadastra','');
                        $mostrar_form = "S";
                    }*/
                }
                else    msg('4','CNPJ e/ou Razão Social já cadastrado no sistema.','','5','index.php?pg=empresaCadastra','');
            }
            
            //Tratamento para quando clicar no botão Avançar.
            //FALTA FINALIZAR ISSO AQUI
            /*if (isset($_REQUEST["btn_atualizar"])){
                
            }*/
            
            //Tratamento para mostrar ou não os campos do formulário de cadastro de empresa.
            if ($mostrar_form == "S"){
                form_inicio('formulario', 'POST', 'index.php?pg=empresaCadastra','multipart/form-data');
                form_radio('Tipo Pessoa', 'tipo_pessoa', 'PJ:PF', 'Pessoa Jurídica:Pessoa Física', $tipo_pessoa, '12');
                form_input_text('CNPJ','cnpj',$cnpj,'18','4','','','1');
                form_input_text('Inscrição Estadual','insc_estadual',$insc_estadual,'20','4','','','');
                form_input_text('Inscrição Municipal','insc_municipal',$insc_municipal,'20','4','','','');?>
                <div style="clear: both"></div>
                <?php
                form_input_text('Nome Fantasia','nm_fantasia',$nm_fantasia,'100','6','','','');
                form_input_text('Razão Social','razao_social_nome',$razao_social_nome,'100','6','','','');
                form_input_text_leitura('CPF','cpf',$cpf,'14','2','','1');
                form_input_text('CEP','cep',$cep,'10','2','','','1');
                form_input_text_leitura('Tipo','tipo',$tipo,'10','2','','');
                form_input_text_leitura('Logradouro','logradouro',$logradouro,'100','4','','');
                form_input_text_number('Número','numero',$numero,'6','2','','1');?>
                <div style="clear: both"></div>
                <?php
                form_input_text('Complemento','complemento',$complemento,'20','3','','','');
                form_input_text_leitura('Bairro','bairro',$bairro,'100','3','','');
                form_input_text_leitura('Cidade','cidade',$cidade,'100','3','','');
                form_input_text_leitura('UF','uf',$uf,'2','1','','');
                form_input_text('Telefone','telefone',$telefone,'15','2','','telefone','1');?>
                <div style="clear: both"></div>
                <?php
                form_input_text('E-mail Principal','email_principal',$email_principal,'100','4','','','1');
                form_input_text('Site','site',$site,'50','4','','','');
                form_select("Plano", "plano", "", "", "plano01,Plano01:plano02,Plano02:plano03,Plano03", "2",'1');
                form_input_text('Dia de Corte','dia_corte',$dia_corte,'2','2','','','1');?>
                <div style="clear: both"></div>
                <?php
                form_checkbox('Status da Empresa','status','ativo','Ativo','S','2');
                form_input_text_number('Convênio Correios','cd_convenio_correios',$cd_convenio_correios,'20','3','','1');?>
                <div style="clear: both"></div>
                <?php
                form_input_file_imagem('Logomarca','logomarca','6',$logomarca,'');?>
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
                            form_input_text('Nome','nm_contato1','','100','4','','','');
                            form_input_text('e-mail','email_contato1','','100','4','','','');?>
                            <div style="clear: both"></div>
                            <?php
                            form_input_text('Telefone','telefone_contato1','','15','4','','telefone','');
                            form_input_text('Celular','celular_contato1','','15','4','','telefone','');?>
                    </div>
                    <!-- Código referente a aba Contato 02 -->
                    <div class="tab-pane" id="contato2">
                        <br>
                        <?php
                            form_input_text('Nome','nm_contato2','','100','4','','','');
                            form_input_text('e-mail','email_contato2','','100','4','','','');?>
                            <div style="clear: both"></div>
                            <?php
                            form_input_text('Telefone','telefone_contato2','','15','4','','telefone','');
                            form_input_text('Celular','celular_contato2','','15','4','','telefone','');?>
                    </div>
                    <div style="clear: both"></div>
                </div>

                <div style="clear: both"></div>
                <br>
                <label style='color:red; font-weight: normal;'>* Campos de Preenchimento Obrigatório</label>
                <br>
                <div align="right">
                    <?php
                    //form_btn_submit('Voltar');
                    form_btn_reset('Limpar');
                    form_btn('submit','btn_avancar','Avançar'); 
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