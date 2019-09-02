<?php
if (can_access(['L00000120170808160000'], 'S')) {?>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title"><strong>Cadastro de Empresas</strong></h3>
        </div>
        <div class="panel-body">
            <?php
            $mostrar_form = "S";
            
            //Pega as informações voltando da tela de Empresa Módulos
            if (isset($_REQUEST["empresaModulo"]))
            {
                $btn_nome = "btn_atualizar";
                $btn_texto = "Atualizar";
                
                $sql = "SELECT * FROM tbl_empresa WHERE chave = ".$_REQUEST["empresaModulo"];
                $qry = mysqli_query($con,$sql);
                $res = mysqli_fetch_array($qry);
                
                //$tipo_pessoa = $res["tipo_cliente "];
                $cnpj = $res["cnpj"];
                $insc_estadual = $res["insc_estadual"];
                $insc_municipal = $res["insc_municipal"];
                $nome_fantasia = $res["nome_fantasia"];
                $nome_razaosocial = $res["nome_razaosocial"];
                //$cpf = $res["cpf"];
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
                $plano_servico = $res["plano_servico"];
                $dia_corte = $res["dia_corte"];
                $status_empresa = $res["ativo"];
                $cd_convenio = $res["cd_convenio"];
                $login = $res["login_master"];
                $senha = $res["senha_master"];
                $logomarca = $res["logomarca"];
                $nm_contato1 = $res["nome1"];
                $email_contato1 = $res["email1"];
                $telefone1 = $res["telefone1"];
                $celular_contato1 = $res["celular1"];
                $nm_contato2 = $res["nome2"];
                $email_contato2 = $res["email2"];
                $telefone2 = $res["telefone2"];
                $celular_contato2 = $res["celular2"];
            }
            else if (isset($_GET['editar']) || isset($_GET['visualizar']))
            {
                // Chave da empresa a editar/visualizar
                $chave = isset($_GET['editar']) ? $_GET['editar'] : $_GET['visualizar'];

                // Consulta da empresa a ser editada
                $sql = "SELECT * FROM tbl_empresa WHERE chave = '$chave'";

                $qry = mysqli_query($con,$sql);
                $res = mysqli_fetch_assoc($qry);

                // Extrai o array para as variáveis
                extract($res);
            }
            else if (isset($_GET['excluir'])){
                $sql = "DELETE FROM tbl_empresa WHERE chave = '{$_GET['excluir']}'";

                $qry = user_delete($sql);
                if ($qry){
                    msg('1','Empresa'.$exclusao_suces,'1','3','index.php?pg=empresa','');
                    $mostrar_form = "N";
                }else{
                    msg('4','Empresa'.$exclusao_erro,'','5','index.php?pg=empresaCadastra','');
                    $mostrar_form = "S";
                }

                $mostrar_form = "N";
            }
            else
            {
                //Caso os campos do formulário de cadastro de empresa sejam setados, os mesmos são carregados nas variáveis.
                //Caso contrário, os campos ficam em branco.
                //if (isset($_REQUEST['tipo_pessoa'])) $tipo_pessoa = $_REQUEST['tipo_pessoa']; else $tipo_pessoa = "";
                $cnpj = validate($_REQUEST['cnpj']);
                $insc_estadual = validate($_REQUEST['insc_estadual']);
                $insc_municipal = validate($_REQUEST['insc_municipal']);
                $nome_fantasia = validate($_REQUEST['nome_fantasia']);
                $nome_razaosocial = validate($_REQUEST['razao_social_nome']);
                //$cpf = validate($_REQUEST['cpf']);
                $cep = validate($_REQUEST['cep']);
                $tipo = validate($_REQUEST['tipo']);
                $logradouro = validate($_REQUEST['logradouro']);
                $numero = validate($_REQUEST['numero']);
                $complemento = validate($_REQUEST['complemento']);
                $bairro = validate($_REQUEST['bairro']);
                $cidade = validate($_REQUEST['cidade']);
                $uf = validate($_REQUEST['uf']);
                $telefone = validate($_REQUEST['telefone']);
                $email_principal = validate($_REQUEST['email_principal']);
                $site = validate($_REQUEST['site']);
                $plano_servico = validate($_REQUEST['plano_servico']);
                $dia_corte = validate($_REQUEST['dia_corte']);
                $status_empresa = isset($_REQUEST['ativo']) ? 'S' : 'N';
                $cd_convenio = validate($_REQUEST['cd_convenio_correios']);
                
                $login = "";
                $senha = "";
                
                $logomarca = validate($_FILES['logomarca']['name']);
                $nm_contato1 = validate($_REQUEST['nm_contato1']);
                $email_contato1 = validate($_REQUEST['email_contato1']);
                $telefone1 = validate($_REQUEST['telefone1']);
                $celular_contato1 = validate($_REQUEST['celular_contato1']);
                $nm_contato2 = validate($_REQUEST['nm_contato2']);
                $email_contato2 = validate($_REQUEST['email_contato2']);
                $telefone2 = validate($_REQUEST['telefone2']);
                $celular_contato2 = validate($_REQUEST['celular_contato2']);
            }
            
            //Tratamento para quando clicar no botão Avançar.
            if (isset($_REQUEST["btn_avancar"])){
                //Tratamento para salvar a logomarca no diretório
                $nome = $_FILES['logomarca']['name'];
                $tmp = $_FILES['logomarca']['tmp_name'];
                $type = $_FILES['logomarca']['type'];
                $caminho_img = 'logos_empresas/'.$nome;

                if (!is_dir('logos_empresas')) {
                    mkdir('logos_empresas');
                }

                move_uploaded_file($tmp, $caminho_img);

                // Caso estiver editando uma empresa
                if (isset($_GET['editar'])) {
                    
                    $empresa = $_POST;
                    // $empresa['ativo'] = $empresa['status_ativo'] == 'ativo' ? 'S' : 'N';
                    $empresa['logomarca'] = file_exists($caminho_img) ? $type : null;

                    if (file_exists($caminho_img)) {
                        // Seta o mimetype da logomarca
                        $empresa['logomarca'] = $type;
                        // Renomear para a chave do usuário
                        rename($caminho_img, 'logos_empresas/'.$_GET['editar']);
                    } else {
                        $empresa['logomarca'] = null;
                    }

                    // Remove as variáveis desnecessárias
                    unset($empresa['btn_avancar']);
                    // unset($empresa['status_ativo']);

                    // Cria a query de update
                    $columns = implode(', ', array_map(
                        function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
                        $empresa,
                        array_keys($empresa)
                    ));
                    
                    // Consulta da empresa a ser editada
                    $sql = "UPDATE tbl_empresa SET $columns  WHERE chave = '{$_GET['editar']}'";
                    $qry = user_update($sql);
                    
                    msg('1','Dados editados com sucesso!<br>Redirecionando para a tabela de empresas.','1','2','index.php?pg=empresa','');
                    $mostrar_form = "N";

                } else {
                    $sql = "SELECT * FROM tbl_empresa WHERE (cnpj = '".$cnpj."') OR (nome_razaosocial = '".$nome_razaosocial."')";
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
            }
            
            //Tratamento para quando clicar no botão Avançar.
            //FALTA FINALIZAR ISSO AQUI
            /*if (isset($_REQUEST["btn_atualizar"])){
                
            }*/
            
            //Tratamento para mostrar ou não os campos do formulário de cadastro de empresa.
            if ($mostrar_form == "S"){
                form_inicio('formulario', 'POST', '','multipart/form-data');
                form_input_text('CNPJ','cnpj',$cnpj,'18','4','','','1');
                form_input_text('Inscrição Estadual','insc_estadual',$insc_estadual,'20','4','','','');
                form_input_text('Inscrição Municipal','insc_municipal',$insc_municipal,'20','4','','','');?>
                <div style="clear: both"></div>
                <?php
                form_input_text('Nome Fantasia','nome_fantasia',$nome_fantasia,'100','6','','','');
                form_input_text('Razão Social','nome_razaosocial',$nome_razaosocial,'100','6','','','');
                form_input_text('CEP','cep',$cep,'10','3','','','1');
                form_input_text_leitura('Tipo','tipo',$tipo,'10','2','','');
                form_input_text_leitura('Logradouro','logradouro',$logradouro,'100','5','','');
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
                form_select("Plano", "plano_servico", "", "", "plano01,Plano01:plano02,Plano02:plano03,Plano03", "2",'1');
                form_input_text('Dia de Corte','dia_corte',$dia_corte,'2','2','','','1');?>
                <div style="clear: both"></div>
                <?php
                // form_checkbox('Status da Empresa','status','ativo','Ativo','S','2');
                form_input_text_number('Convênio Correios','cd_convenio',$cd_convenio,'20','3','','1');?>
                <div style="clear: both"></div>
                <?php
                form_input_file_imagem('Logomarca','logomarca','6',"getlogo.php?chave=$chave",'');?>
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
                            form_input_text('Nome','nome1','','100','4','','','');
                            form_input_text('e-mail','email1','','100','4','','','');?>
                            <div style="clear: both"></div>
                            <?php
                            form_input_text('Telefone','telefone1','','15','4','','telefone','');
                            form_input_text('Celular','celular1','','15','4','','telefone','');?>
                    </div>
                    <!-- Código referente a aba Contato 02 -->
                    <div class="tab-pane" id="contato2">
                        <br>
                        <?php
                            form_input_text('Nome','nome2','','100','4','','','');
                            form_input_text('e-mail','email2','','100','4','','','');?>
                            <div style="clear: both"></div>
                            <?php
                            form_input_text('Telefone','telefone2','','15','4','','telefone','');
                            form_input_text('Celular','celular2','','15','4','','telefone','');?>
                    </div>
                    <div style="clear: both"></div>
                </div>

                <div style="clear: both"></div>
                <br>
                <?php if (!isset($_GET['visualizar'])) : ?>
                    <label style='color:red; font-weight: normal;'>* Campos de Preenchimento Obrigatório</label>
                <?php endif; ?>
                <br>
                <div align="right">
                    <?php
                    if (isset($_GET['visualizar'])) { ?>
                        <script>
                            $('input, select').prop('disabled', true);
                        </script>
                        <a class="btn btn-primary" href="index.php?pg=empresa">Voltar</a>
                    <?php
                    } else {
                        //form_btn_submit('Voltar');
                        form_btn_reset('Limpar');
                        form_btn('submit','btn_avancar','Avançar');
                    }
                    ?>
                </div>
            <?php
            form_fim();
            }?>
        </div>
    </div>
    <?php
} else { ?>
    <br>
    <?php 
    msg('4','Acesso não autorizado. Redirecionamento para a tela de login.','1','5','login.php','');
}?>