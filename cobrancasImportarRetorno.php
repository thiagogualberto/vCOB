<?php
if (isset($_SESSION['acessar_modulos'])){
    if ( (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "S") ||
         (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "G") ){?>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading" >
                <h3 class="panel-title"><strong>Importar Retorno Correios</strong></h3>
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

                        $pasta = "./arquivos_retorno"; //Nome da pasta onde vao ficar armazenados os arquivos;
                        /*print_r($pasta);echo "<br>";
                        print_r($nome);echo "<br>";
                        print_r($type);echo "<br>";
                        print_r($size);echo "<br>";
                        print_r($tmp);echo "<br>";*/

                        if($type == 'application/octet-stream'){
                            if($tmp){
                                if(move_uploaded_file($tmp, $pasta."/".$nome)){
                                    $lendo = @fopen($pasta."/".$nome,"r");

                                    if (!$lendo){
                                        echo "Erro ao abrir a URL.";
                                        exit;
                                    }
                                    $i = 0;
                                    $gerar_log = false;
                                    $cabecalho_log = "HOUVERAM ERROS NA BAIXA DOS BOLETOS ".date('d/m/Y');
                                    $linha_log = '';
                                    while (!feof($lendo)){
                                        $i++;
                                        $linha = fgets($lendo,9999);
                                        $t_u_segmento = substr($linha,0,1);//Segmento A (cabeçalho) ou G (registros)
                                        if($t_u_segmento == 'A'){
                                            $nsa = substr($linha,73,8);//Pega os 8 últimos dígitos da 1ª linha do arquivo.
                                            
                                            //verifica se arquivo já foi importado
                                            $sql = "select id, nsa, date_format(data_retorno, '%d/%m/%Y %H:%i:%s') as data_retorno from tbl_retorno_correios where nsa = '$nsa'";
                                            $qry = mysqli_query($con,$sql);
                                            if(mysqli_num_rows($qry) > 0){
                                                $res = mysqli_fetch_object($qry);
                                                msg('4','Houveram erros na importação.<br>Arquivo já baixado anteriormente na data: '.$res->data_retorno,'0','','','');
                                                //echo "<h1>HOUVERAM ERROS NA IMPORTAÇÃO</h1><br> ARQUIVO JÁ BAIXADO ANTERIORMENTE NA DATA: {$res->data_retorno}<br><br><br><br>";
                                                die();
                                            }
                                            else{
                                                $sql = "INSERT INTO tbl_retorno_correios (data_retorno, nsa) VALUES ('".date('Y-m-d H:i:s')."','$nsa')";
                                                $qry = mysqli_query($con,$sql);
                                            }
                                        }
                                        if($t_u_segmento == 'G'){
                                            $dt_pagamento = substr($linha, 21,8);//echo "<br>dt_pagamento: ".$dt_pagamento."<br>";
                                            $dt_credito = substr($linha, 29,8);//echo "dt_credito: ".$dt_credito."<br>";
                                            $codigo_barras = substr($linha, 37,44);//echo "codigo_barras: ".$codigo_barras."<br>";
                                            $cd_cobranca = substr($codigo_barras, -12,12);//echo "cd_cobranca: ".$cd_cobranca."<br>";
                                            $valor_pago = substr($linha, 81,12);//echo "valor_pago: ".$valor_pago."<br>";
                                            $valor_pago = substr($valor_pago, 0,10).'.'.substr($valor_pago, -2,2);//echo "valor_pago: ".$valor_pago."<br>";

                                            //$data_agora = date('Y-m-d');echo "data_agora: ".$data_agora."<br>";
                                            //$hora_agora = date('H:i:s');echo "hora_agora: ".$hora_agora."<br>";

                                            $ano = substr($dt_pagamento, 0, 4);
                                            $mes = substr($dt_pagamento, 4, 2);
                                            $dia = substr($dt_pagamento, 6, 2);
                                            $dt_pagamento = $ano.'-'.$mes.'-'.$dia;//echo "dt_pagamento: ".$dt_pagamento."<br>";

                                            $ano = substr($dt_credito, 0, 4);
                                            $mes = substr($dt_credito, 4, 2);
                                            $dia = substr($dt_credito, 6, 2);
                                            $dt_credito = $ano.'-'.$mes.'-'.$dia;//echo "dt_credito: ".$dt_credito."<br>";

                                            //verifica se parcela já foi paga anteriormente
                                            $sql = "select * from tbl_cobranca WHERE cd_cobranca = '$cd_cobranca' AND ( (tipo_baixa = 'A') OR (tipo_baixa = 'M') )";
                                            $qry = mysqli_query($con,$sql);
                                            if(mysqli_num_rows($qry) > 0){
                                                $gerar_log = true;
                                                //pega dados do cliente
                                                $sql = "SELECT tce.nome_razaosocial, tc.dt_pagamento
                                                            FROM tbl_cobranca AS tc 
                                                            INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                                                            where tc.cd_cobranca = '".$cd_cobranca."'";
                                                $qry = mysqli_query($con,$sql);
                                                $cli = mysqli_fetch_object($qry);
                                                $linha_log .= "PARCELA PAGA EM DUPLICIDADE | Cliente: {$cli->nome_razaosocial}, Código da Cobrança: {$cd_cobranca}, data PRIMEIRO PAGAMENTO: ".data_converte($cli->dt_pagamento,'-').", data pagamento DUPLICADO: ".data_converte($dt_pagamento,'-').", data credito DUPLICADO: ".data_converte($dt_credito,'-')."\n\r";
                                            }
                                            else{// se o pagamento não foi feito antes pega dados do cliente para montar tabela de pagantes.
                                                $sql = "SELECT tce.nome_fantasia, tc.vl_emissao, tc.dt_vencimento
                                                            FROM tbl_cobranca AS tc 
                                                            INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                                                            where tc.cd_cobranca = '".$cd_cobranca."'";
                                                $qry = mysqli_query($con,$sql);
                                                $cli = mysqli_fetch_object($qry);
                                                //monta linhas da tabela de pagantes
                                                $vl_emissao = "R$ ".number_format($cli->vl_emissao, 2, ',', '.');
                                                $vl_pago = "R$ ".number_format($valor_pago, 2, ',', '.');
                                                $table[] = [
                                                    'cliente' => $cli->nome_fantasia,
                                                    'codigo' => $cd_cobranca,
                                                    'vl_emissao' => $vl_emissao,
                                                    'vencimento' => data_converte($cli->dt_vencimento,'-'),
                                                    'pagamento' => data_converte($dt_pagamento,'-'),
                                                    'vl_pagamento' => $vl_pago
                                                ];

                                                $sql = "UPDATE tbl_cobranca SET 
                                                                dt_pagamento='$dt_pagamento',
                                                                vl_pago='$valor_pago', 
                                                                tipo_baixa = 'A' 
                                                           WHERE cd_cobranca='$cd_cobranca'";
                                                user_update($sql) or print(mysqli_error($con));
                                            }
                                        }
                                    }
                                    fclose($lendo);
                                    //se houver erros gera arquivo de log para usuário
                                    if($gerar_log){
                                        $nomeArquivo = "LOG_ERRO_IMPORTACAO_PAGAMENTOS_".date('YmdHis');
                                        $caminhoCompletoArquivo = __DIR__."/boletos/log/".$nomeArquivo.".txt";
                                        $arq = fopen($caminhoCompletoArquivo, "w");
                                        fwrite($arq, $cabecalho_log.PHP_EOL);
                                        $linha_log = utf8_decode($linha_log);
                                        fwrite($arq, $linha_log.PHP_EOL);
                                        fclose($arq);
                                        
                                        //echo "<h1>HOUVERAM ERROS NA IMPORTAÇÃO</h1><br> <a href='boletos/log/$nomeArquivo.txt' target='_blank'> CLIQUE AQUI </a> para baixar o arquivo de log de erros.<br><br><br>";
                                        msg('4',"Houveram erros na importação.<br><a href='boletos/log/$nomeArquivo.txt' target='_blank'> CLIQUE AQUI </a> para baixar o arquivo de log de erros.",'0','','','');
                                        if($table == ''){
                                            echo "<br><br><br>";
                                        }
                                    }

                                    //imprime tabela com os pagantes
                                    if (isset($table)) {
                                        $_SESSION['relatorio']['retorno'] = $table;
                                        echo '<iframe src="pdfRelatorioRetorno.php" width="100%" onload="this.height = $(window).height() * 0.76" frameborder="0"></iframe>';
                                    }
                                }
                            }
                                // echo "
                                // <div align='center'>
                                //     <a class='btn btn-primary btn-lg' href='index.php?pg=cobrancas' role='button'><i class='fa fa-search fa-fw'></i>&nbsp;Pesquisar Cobranças</a>
                                // </div>
                                // <br><br><br>";
                        }else{
                            echo "<h1>HOUVERAM ERROS NA IMPORTAÇÃO</h1><br>
                                    <strong>
                                        Nenhum arquivo de retorno selecionado!<br/>
                                        <a title='IMPORTAR ARQUIVO RETORNO CORREIOS' href='index.php?pg=cobrancasImportarRetorno'>CLIQUE AQUI PARA FAZER A IMPORTAÇÃO!</a>
                                    </strong>";
                        }

                    } // FIM DA ACAO RETORNO ?>
                    <?php 
                    if ($mostrar_form == "S"){
                        form_inicio('formulario', 'post', 'index.php?pg=cobrancasImportarRetorno&acao=retorno','multipart/form-data');
                        form_input_file('Selecionar Arquivo de Retorno do banco:', '6', '1');?>
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
