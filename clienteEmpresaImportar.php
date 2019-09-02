<?php
if (isset($_SESSION['acessar_modulos'])){
    if ( (($_SESSION['acessar_modulos']["L00000120170808160001"]) == "S") ||
         (($_SESSION['acessar_modulos']["L00000120170808160001"]) == "G") ){?>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading" >
                <h3 class="panel-title"><strong>Importar Clientes</strong></h3>
            </div>
            <div class="panel-body">
                <?php
                    $mostrar_form = "S";
                    if (isset($_REQUEST["acao"])){
                        $mostrar_form = "N";
                        $nome = $_FILES['arquivo']['name'];
                        $type = $_FILES['arquivo']['type'];
                        $size = $_FILES['arquivo']['size'];
                        $tmp = $_FILES['arquivo']['tmp_name'];

                        $pasta = "./arquivos_clientes_importacao"; //Nome da pasta onde vao ficar armazenados os arquivos;
                        //print_r($pasta);echo "<br>";
                        /*print_r($nome);echo "<br>";
                        print_r($type);echo "<br>";
                        print_r($size);echo "<br>";
                        print_r($tmp);echo "<br>";*/

                        if($type == 'application/vnd.ms-excel'){
                            if($tmp){
                                if(move_uploaded_file($tmp, $pasta."/".$nome)){
                                    $lendo = @fopen($pasta."/".$nome,"r");

                                    if (!$lendo){
                                        echo "Erro ao abrir a URL.";
                                        exit;
                                    }
                                    
                                    $gerar_log = false;
                                    $cabecalho_log = "HOUVERAM ERROS NA IMPORTAÇÃO DOS CLIENTES - ".date('d/m/Y');
                                    $cabecalho_log = utf8_decode($cabecalho_log);
                                    $linha_log = "";
                                    
                                    //sql criada para fazer a inserção dos cliente do arquivo csv
                                    $sql_csv = "insert into tbl_cliente_empresa(chave, cd_cliente_empresa, chave_empresa, tipo_cliente, cnpj, nome_fantasia, nome_razaosocial, cpf, cep, tipo, logradouro, numero, bairro, cidade, uf, telefone, email_principal, ativo) VALUES ";
                                    
                                    //Elimina a linha do cabeçalho do arquivo csv.
                                    $data = fgetcsv($lendo, 2000, ";");
                                    
                                    //Gera o código da empresa
                                    $codigo = gera_codigo("tbl_cliente_empresa","cd_cliente_empresa");

                                    //Gera a chave de registro do banco da empresa
                                    $chave = gera_chave($codigo);
                                    while (($data = fgetcsv($lendo, 2000, ";")) !== FALSE) {
                                        //print_r($data);echo "<br><br>";
                                        //echo "Chave: ".$chave." | Codigo: ".$codigo."<br>";
                                        
                                        //Pega os dados da linha do arquivo csv
                                        $tipo_cliente = $data[0];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $cnpj = $data[1];
                                        if ($cnpj != ""){
                                            $nome_fantasia = $data[2];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                            $razao_social = $data[3];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        }
                                        else{
                                            $nome_fantasia = "";//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                            $razao_social = $data[2];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        }
                                        
                                        $cpf = $data[4];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $cep = $data[5];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $tipo = $data[6];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $logradouro = $data[7];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $numero = $data[8];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $bairro = $data[9];;//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $cidade = $data[10];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $uf = $data[11];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $telefone = $data[12];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        $email_principal = $data[13];//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                        
                                        //verifica se o cliente ja está na base de dados.
                                        if ($cnpj != "")
                                            $sql = "select * from tbl_cliente_empresa WHERE chave_empresa = '".$_SESSION['chave_empresa']."' AND (cnpj = '".$cnpj."')";
                                        else if ($cpf != "")
                                            $sql = "select * from tbl_cliente_empresa WHERE chave_empresa = '".$_SESSION['chave_empresa']."' AND (cpf = '".$cpf."')";
                                        
                                        //echo "sql: ".$sql."<br>";
                                        $qry = mysqli_query($con,$sql);
                                        if(mysqli_num_rows($qry) > 0){
                                            $gerar_log = true;
                                            
                                            //Monta as informações para inserir no arquivo de log.
                                            $linha_log .= "CLIENTE EM DUPLICIDADE | Pessoa: {$tipo_cliente}, ";
                                            if ($tipo_cliente == "PJ"){
                                                $linha_log .= "CNPJ: {$cnpj}, NOME FANTASIA:{$nome_fantasia}, RAZÃO SOCIAL: {$razao_social}";
                                            }
                                            else    $linha_log .= "CPF: {$cpf}, NOME:{$nome_fantasia}";
                                            $linha_log .= "\n\r";
                                        }
                                        else{
                                            $sql_csv .= "('".$chave."', '".$codigo."', '".$_SESSION['chave_empresa']."',
                                                          '".$tipo_cliente."', '".$cnpj."', '".$nome_fantasia."', '".$razao_social."',
                                                          '".$cpf."', '".$cep."', '".$tipo."', '".$logradouro."', '".$numero."',
                                                          '".$bairro."', '".$cidade."', '".$uf."', '".$telefone."', '".$email_principal."','S'),"; 
                                            $codigo++;
                                        }
                                        //Gera a chave de registro do banco da empresa
                                        $chave = gera_chave($codigo);
                                    }
                                    fclose($lendo);
                                    $sql_csv = substr($sql_csv,0,-1);
                                    $qry_csv = mysqli_query($con,$sql_csv);
                                    
                                    //se houver erros gera arquivo de log para usuário
                                    if($gerar_log){
                                        $nomeArquivo = "LOG_ERRO_IMPORTACAO_CLIENTES_".date('YmdHis');
                                        $caminhoCompletoArquivo = __DIR__."/clientes/log/".$nomeArquivo.".txt";
                                        $arq = fopen($caminhoCompletoArquivo, "w");
                                        fwrite($arq, $cabecalho_log.PHP_EOL);
                                        fwrite($arq, utf8_decode($linha_log).PHP_EOL);
                                        fclose($arq);
                                        
                                        msg('4',"Houveram erros na importação.<br><a href='clientes/log/$nomeArquivo.txt' target='_blank'> CLIQUE AQUI</a> para baixar o arquivo de log de erros.",'0','','','');
                                    }
                                    else    msg('1','Clientes importados com sucesso.','1','3','index.php?pg=clienteEmpresa','');
                                }
                            }
                        }else{
                            msg('4',"Houveram erros na importação.<br><strong>Arquivo selecionado não está no formato CSV.<br/><a title='IMPORTAR ARQUIVO DOS CLIENTES' href='index.php?pg=clienteEmpresaimportar'>CLIQUE AQUI PARA FAZER A IMPORTAÇÃO do CSV.</a></strong>",'0','','','');
                        }

                    } // FIM DA ACAO RETORNO ?>
                    <?php 
                    if ($mostrar_form == "S"){
                        form_inicio('formulario', 'post', 'index.php?pg=clienteEmpresaImportar&acao=retorno','multipart/form-data');
                        form_input_file('Selecionar Arquivo de Importação de Clientes:', '6', '1');?>
                        <div style="clear: both"></div>
                        <div style = "padding-left: 16px;">
                            <?php form_btn('submit','btn_enviar','Enviar');?>
                        </div>
                        <br>
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
