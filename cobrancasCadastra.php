<?php
//foreach( $_SESSION as $index => $data ){
//     echo $index, ' = ', $data."<br>"; 
//}

if (can_access(['L00000120170808160005'], 'SG')){?>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title"><strong>Cobranças</strong></h3>
        </div>
        <div class="panel-body">
            <?php
            if (isset($_REQUEST["editar"])){    //Tratamento para editar os dados de uma cobrança
                $btn_nome = "btn_atualizar";
                $btn_texto = "Atualizar";
                $caminho_voltar = "index.php?pg=cobrancas&filtrar=".$_REQUEST["filtrar"]."&pesquisar_cobrancas_cliente=".$_REQUEST["pesquisar_cobrancas_cliente"];

                $sql = "SELECT chave, chave_cliente, num_referencia, DATE_FORMAT(dt_emissao,'%d/%m/%Y'), 
                        format(vl_emissao,2,'de_DE'), DATE_FORMAT(dt_vencimento,'%d/%m/%Y'), mensagem,
                        chave_cobranca_instrucoes, format(desconto_dinheiro,2,'de_DE'), 
                        DATE_FORMAT(data_desconto,'%d/%m/%Y'), desconto_porcentagem,
                        cobrar1, porcentagem_juros_cobrar1, diasjuros_cobrar1, 
                        cobrar2, porcentagem_multa_cobrar2, diasmulta_cobrar2
                        FROM tbl_cobranca WHERE chave = '".$_REQUEST["editar"]."'";
                $qry = mysqli_query($con,$sql);
                $res = mysqli_fetch_array($qry);

                //$chave = $res["chave"];
                $cliente_cobranca = $res["chave_cliente"];
                $num_ref_cobranca = $res["num_referencia"];
                $dt_emissao_cobranca = $res["DATE_FORMAT(dt_emissao,'%d/%m/%Y')"];
                $vl_emissao_cobranca = $res["format(vl_emissao,2,'de_DE')"];
                $dt_vencimento_cobranca = $res["DATE_FORMAT(dt_vencimento,'%d/%m/%Y')"];
                $msg_cobranca = $res["mensagem"];
                $chave_instrucao = $res["chave_cobranca_instrucoes"];

                $desconto_dinheiro = "";
                $data_desconto = "";
                $desconto_porcentagem = "";
                if ($chave_instrucao == 'L00000120170905201901'){
                    $desconto_dinheiro = $res["format(desconto_dinheiro,2,'de_DE')"];
                    $data_desconto = $res["DATE_FORMAT(data_desconto,'%d/%m/%Y')"];
                }else if ($chave_instrucao == 'L00000120170905201902'){
                    $desconto_porcentagem = $res["desconto_porcentagem"];
                    $data_desconto = $res["DATE_FORMAT(data_desconto,'%d/%m/%Y')"];
                }else if ( ($chave_instrucao == 'L00000120170905201903') || ($chave_instrucao == 'L00000120170905201904') ){
                    $desconto_dinheiro = $res["format(desconto_dinheiro,2,'de_DE')"];
                }

                $cobrar1 = $res["cobrar1"];
                $leitura1 = 1;
                if ($cobrar1 == "S"){
                    $leitura1 = 0;
                    $porcent_juros_cobrar1 = $res["porcentagem_juros_cobrar1"];
                    $diasjuros_cobrar1 = $res["diasjuros_cobrar1"];
                }else{
                    $porcent_juros_cobrar1 = "";
                    $diasjuros_cobrar1 = "";
                }

                $leitura2 = 1;
                $cobrar2 = $res["cobrar2"];
                if ($cobrar2 == "S"){
                    $leitura2 = 0;
                    $porcent_multa_cobrar2 = $res["porcentagem_multa_cobrar2"];
                    $diasmulta_cobrar2 = $res["diasmulta_cobrar2"];
                }else{
                    $porcent_multa_cobrar2 = "";
                    $diasmulta_cobrar2 = "";
                }

                $mostrar_form = "S";
                $_SESSION['chave_cobranca'] = $_REQUEST["editar"];
                
                if (isset($_REQUEST['filtrar'])) $filtrar = $_REQUEST['filtrar']; else $filtrar = "";
                if (isset($_REQUEST['pesquisar_cobrancas_cliente'])) $pesquisar_cobrancas_cliente = $_REQUEST['pesquisar_cobrancas_cliente']; else $pesquisar_cobrancas_cliente = "";
                
            }
            else if (isset($_REQUEST["excluir"])){  //Tratamento para excluir uma cobrança
                //Deleta cobrança da tabela tbl_cobranca
                $sql = "DELETE FROM tbl_cobranca
                        WHERE chave = '".$_REQUEST["excluir"]."'";
                $qry = user_delete($sql);
                $mostrar_form = "N";
                if ($qry){
                    msg('1','Cobrança'.$exclusao_suces,'1','3','index.php?pg=cobrancas','');
                }else{
                    msg('4',$exclusao_erro,'1','3','index.php?pg=cobrancas','');
                }
            }
            else{
                $btn_nome = "btn_cadastrar";
                $btn_texto = "Cadastrar";
                $caminho_voltar = "index.php?pg=cobrancas";
                //$chave = "";
                if (isset($_REQUEST['cliente_cobranca'])) $cliente_cobranca = $_REQUEST['cliente_cobranca']; else $cliente_cobranca = "";
                if (isset($_REQUEST['num_ref_cobranca'])) $num_ref_cobranca = $_REQUEST['num_ref_cobranca']; else $num_ref_cobranca = "";
                if (isset($_REQUEST['dt_emissao_cobranca'])) $dt_emissao_cobranca = $_REQUEST['dt_emissao_cobranca']; else $dt_emissao_cobranca = date("d/m/Y");
                if (isset($_REQUEST['vl_emissao_cobranca'])) $vl_emissao_cobranca = $_REQUEST['vl_emissao_cobranca']; else $vl_emissao_cobranca = "";
                if (isset($_REQUEST['dt_vencimento_cobranca'])) $dt_vencimento_cobranca = $_REQUEST['dt_vencimento_cobranca']; else $dt_vencimento_cobranca = "";
                if (isset($_REQUEST['parcelas'])) $parcelas = $_REQUEST['parcelas']; else $parcelas = "";
                if (isset($_REQUEST['msg_cobranca_opcao'])) $msg_cobranca_opcao = $_REQUEST['msg_cobranca_opcao']; else $msg_cobranca_opcao = "";
                if (isset($_REQUEST['msg_cobranca'])) $msg_cobranca = $_REQUEST['msg_cobranca']; else $msg_cobranca = "";
                if (isset($_REQUEST['instrucoes'])) $chave_instrucao = $_REQUEST['instrucoes']; else $chave_instrucao = "";

                $desconto_dinheiro = "";
                $data_desconto = "";
                $desconto_porcentagem = ""; 
                if ($chave_instrucao == 'L00000120170905201901'){
                    if (isset($_REQUEST['desc_vl_fixo_dt_informada'])) $desconto_dinheiro = $_REQUEST['desc_vl_fixo_dt_informada']; else $desconto_dinheiro = "";
                    if (isset($_REQUEST['data_vl_fixo_dt_informada'])) $data_desconto = $_REQUEST['data_vl_fixo_dt_informada']; else $data_desconto = "";
                }else if ($chave_instrucao == 'L00000120170905201902'){
                    if (isset($_REQUEST['desc_perc_dt_informada'])) $desconto_porcentagem = $_REQUEST['desc_perc_dt_informada']; else $desconto_porcentagem = "";
                    if (isset($_REQUEST['dt_perc_dt_informada'])) $data_desconto = $_REQUEST['dt_perc_dt_informada']; else $data_desconto = "";
                }else if ( ($chave_instrucao == 'L00000120170905201903') || ($chave_instrucao == 'L00000120170905201904') ){
                    if (isset($_REQUEST['desc_diacorr_diautil'])) $desconto_dinheiro = $_REQUEST['desc_diacorr_diautil']; else $desconto_dinheiro = "";
                }

                //Pega os elementos do 1º checkbox da cobrança
                if (isset($_REQUEST['cobrar1'])){
                    $cobrar1 = $_REQUEST['cobrar1'];
                    $leitura1 = 0;
                }else{
                    $cobrar1 = "N";
                    $leitura1 = 1;
                }
                if (isset($_REQUEST['porcento1'])) $porcent_juros_cobrar1 = $_REQUEST['porcento1']; else $porcent_juros_cobrar1 = "";
                if (isset($_REQUEST['diasjuros'])) $diasjuros_cobrar1 = $_REQUEST['diasjuros']; else $diasjuros_cobrar1 = "";

                //Pega os elementos do 2º checkbox da cobrança
                if (isset($_REQUEST['cobrar2'])){
                    $cobrar2 = $_REQUEST['cobrar2'];
                    $leitura2 = 0;
                }else{
                    $cobrar2 = "N";
                    $leitura2 = 1;
                }
                if (isset($_REQUEST['porcento2'])) $porcent_multa_cobrar2 = $_REQUEST['porcento2']; else $porcent_multa_cobrar2 = "";
                if (isset($_REQUEST['diasmulta'])) $diasmulta_cobrar2 = $_REQUEST['diasmulta']; else $diasmulta_cobrar2 = "";

                if (isset($_REQUEST['filtrar'])) $filtrar = $_REQUEST['filtrar']; else $filtrar = "";
                if (isset($_REQUEST['pesquisar_cobrancas_cliente'])) $pesquisar_cobrancas_cliente = $_REQUEST['pesquisar_cobrancas_cliente']; else $pesquisar_cobrancas_cliente = "";
                
                $mostrar_form = "S";
            }

            if (isset($_REQUEST["btn_cadastrar"])){ //Tratamento para quando clica em cadastrar uma nova cobrança.
                
                $dt_emissao = data_converte($dt_emissao_cobranca,"/");
                $dt_vencimento = data_converte($dt_vencimento_cobranca,"/");

                $diferenca_data = data_maior($dt_emissao, $dt_vencimento);
                
                if ($diferenca_data == 1){
                    msg('4','Erro... A data de emissão é maior que a data da vencimento.','0','','','');
                }
                else{
                    //Gera o código do usuário
                    $codigo = gera_codigo("tbl_cobranca","cd_cobranca");

                    //Gera a chave de registro do banco do usuário
                    $chave = gera_chave($codigo);

                    //Processo para cadastrar um novo usuário
                    $vl_pago = "";
                    $dt_pagamento = "";
                    $tipo_baixa = "";
                    $vl_emissao_cobranca = trim(str_replace("R$","",str_replace(",",".",str_replace(".","",$vl_emissao_cobranca))));
                    $desconto_dinheiro = trim(str_replace(",",".",$desconto_dinheiro));
                    $desconto_porcentagem = trim(str_replace(",",".",$desconto_porcentagem));
                    $porcent_juros_cobrar1 = trim(str_replace(",",".",$porcent_juros_cobrar1));
                    $porcent_multa_cobrar2 = trim(str_replace(",",".",$porcent_multa_cobrar2));

                    /*$sql = "INSERT INTO tbl_cobranca(chave, cd_cobranca, chave_empresa, chave_cliente, num_referencia, 
                            dt_emissao, vl_emissao, dt_vencimento, mensagem, chave_cobranca_instrucoes, 
                            desconto_dinheiro, desconto_porcentagem, data_desconto, cobrar1, porcentagem_juros_cobrar1, 
                            diasjuros_cobrar1, cobrar2, porcentagem_multa_cobrar2, diasmulta_cobrar2, vl_pago, 
                            dt_pagamento, tipo_baixa) VALUES
                            ('".$chave."','".$codigo."','".$_SESSION["chave_empresa"]."','".$cliente_cobranca."',
                            '".$num_ref_cobranca."','".data_converte($dt_emissao_cobranca,"/")."','".$vl_emissao_cobranca."',
                            '".data_converte($dt_vencimento_cobranca,"/")."','".$msg_cobranca."','".$chave_instrucao."','".$desconto_dinheiro."',
                            '".$desconto_porcentagem."','".data_converte($data_desconto,"/")."','".$cobrar1."','".$porcent_juros_cobrar1."',
                            '".$diasjuros_cobrar1."','".$cobrar2."','".$porcent_multa_cobrar2."','".$diasmulta_cobrar2."',
                            '".$vl_pago."','".$dt_pagamento."','".$tipo_baixa."')";*/

                    /*$qry = mysqli_query($con,$sql);
                    if (!$qry){
                        msg('4',$cadastro_erro.'cobrança','','','','');
                        $mostrar_form = "S";
                    }
                    else{
                        msg('1','Cobrança'.$cadastro_suces,'1','2','index.php?pg=cobrancasCadastra&chave_cobranca='.$chave.'&gerarBoleto','');
                        $mostrar_form = "N";             
                    }*/
                    
                    $sql = "INSERT INTO tbl_cobranca(chave, cd_cobranca, chave_empresa, chave_cliente, num_referencia, 
                            dt_emissao, vl_emissao, dt_vencimento, mensagem, chave_cobranca_instrucoes, 
                            desconto_dinheiro, desconto_porcentagem, data_desconto, cobrar1, porcentagem_juros_cobrar1, 
                            diasjuros_cobrar1, cobrar2, porcentagem_multa_cobrar2, diasmulta_cobrar2, vl_pago, 
                            dt_pagamento, tipo_baixa) VALUES ";
                    
                    $i=1;
                    while ($i <= $parcelas){
                        if ($i < 10)    $num_ref = $num_ref_cobranca."-0".$i;   else    $num_ref = $num_ref_cobranca."-".$i;
                        $sql .= "('".$chave."','".$codigo."','".$_SESSION["chave_empresa"]."','".$cliente_cobranca."',
                            '".$num_ref."','".data_converte($dt_emissao_cobranca,"/")."','".$vl_emissao_cobranca."',
                            '".data_converte($dt_vencimento_cobranca,"/")."','".$msg_cobranca."','".$chave_instrucao."','".$desconto_dinheiro."',
                            '".$desconto_porcentagem."','".data_converte($data_desconto,"/")."','".$cobrar1."','".$porcent_juros_cobrar1."',
                            '".$diasjuros_cobrar1."','".$cobrar2."','".$porcent_multa_cobrar2."','".$diasmulta_cobrar2."',
                            '".$vl_pago."','".$dt_pagamento."','".$tipo_baixa."'),";
                        
                        $codigo++;  //incrementa o código
                        $chave = gera_chave($codigo);   //gera a chave do novo registro baseado no código incrementado.
                        $dt_vencimento_cobranca = data_mes_adiciona(data_converte($dt_vencimento_cobranca,"/"), 1);
                        $dt_vencimento_cobranca = data_converte($dt_vencimento_cobranca,"-");
                        $i++;
                    }
                    $sql = substr($sql,0,-1);
                    
                    $qry = mysqli_query($con,$sql);
                    if (!$qry){
                        msg('4',$cadastro_erro.'cobrança','','','','');
                        $mostrar_form = "S";
                    }
                    else{
                        msg('1','Cobrança'.$cadastro_suces,'1','2','index.php?pg=cobrancasCadastra&chave_cobranca='.$chave.'&gerarBoleto','');
                        $mostrar_form = "N";             
                    }
                }
            }
            else if (isset($_REQUEST["btn_atualizar"])){
                $vl_emissao_cobranca = trim(str_replace("R$","",str_replace(",",".",str_replace(".","",$vl_emissao_cobranca))));
                $desconto_dinheiro = trim(str_replace(",",".",$desconto_dinheiro));
                $desconto_porcentagem = trim(str_replace(",",".",$desconto_porcentagem));
                $porcent_juros_cobrar1 = trim(str_replace(",",".",$porcent_juros_cobrar1));
                $porcent_multa_cobrar2 = trim(str_replace(",",".",$porcent_multa_cobrar2));
                $sql = "UPDATE tbl_cobranca SET
                        chave_cliente = '".$cliente_cobranca."', num_referencia = '".$num_ref_cobranca."',
                        dt_emissao = '".data_converte($dt_emissao_cobranca,"/")."', vl_emissao = '".$vl_emissao_cobranca."',
                        dt_vencimento = '".data_converte($dt_vencimento_cobranca,"/")."', mensagem = '".$msg_cobranca."',
                        chave_cobranca_instrucoes = '".$chave_instrucao."', desconto_dinheiro = '".$desconto_dinheiro."',
                        desconto_porcentagem = '".$desconto_porcentagem."', data_desconto = '".data_converte($data_desconto,"/")."',
                        cobrar1 = '".$cobrar1."', porcentagem_juros_cobrar1 = '".$porcent_juros_cobrar1."',
                        diasjuros_cobrar1 = '".$diasjuros_cobrar1."',
                        cobrar2 = '".$cobrar2."', porcentagem_multa_cobrar2 = '".$porcent_multa_cobrar2."',
                        diasmulta_cobrar2 = '".$diasmulta_cobrar2."'

                        WHERE chave = '".$_SESSION["chave_cobranca"]."'";

                $qry = user_update($sql);
                if ($qry){
                    msg('1',$atualizacao_suces,'1','3',"index.php?pg=cobrancas&filtrar=".$_REQUEST['filtrar']."&pesquisar_cobrancas_cliente=".$_REQUEST['pesquisar_cobrancas_cliente'],'');
                    //$caminho_voltar = "index.php?pg=cobrancas&filtrar=".$_REQUEST['filtrar']."&pesquisar_cobrancas_cliente=".$_REQUEST['pesquisar_cobrancas_cliente'];

                    $mostrar_form = "N";
                }else{
                    msg('4',$atualizacao_erro,'','5','index.php?pg=cobrancasCadastra','');
                    $mostrar_form = "S";
                    $btn_nome = "btn_atualizar";
                    $btn_texto = "Atualizar";
                }
            }

            if (isset($_REQUEST["gerarBoleto"])){
                $chave_cobranca = $_REQUEST["chave_cobranca"]?>
                <br><br><br><br><br>
                <div align="center">
                    <a class="btn btn-primary btn-lg" href="index.php?pg=cobrancasCadastra" role="button"><i class="fa fa-plus-square fa-fw"></i>&nbsp;Cadastrar Nova Cobrança</a>
                    <a class="btn btn-primary btn-lg" href="index.php?pg=cobrancas" role="button"><i class="fa fa-search fa-fw"></i>&nbsp;Pesquisar Cobranças</a>
                    <a class="btn btn-primary btn-lg" href="index.php?pg=cobrancasBoletos&chave_cobranca=<?php echo $chave_cobranca;?>" role="button"><i class="fa fa-barcode fa-fw"></i>&nbsp;Gerar Boleto</a>
                </div>
                <br><br><br><br><br>
            <?php
                $mostrar_form = "N";
            }
            if ($mostrar_form == "S"){
                form_inicio('formulario', 'POST', 'index.php?pg=cobrancasCadastra','');
                $sql = "SELECT '0' as chave, '- Selecione um cliente -' as nome UNION
                        SELECT chave, nome_fantasia FROM tbl_cliente_empresa WHERE chave_empresa = '".$_SESSION["chave_empresa"]."' AND cnpj <> '' UNION
                        SELECT chave, nome_razaosocial FROM tbl_cliente_empresa WHERE chave_empresa = '".$_SESSION["chave_empresa"]."' AND cpf <> '' ORDER BY nome";
                form_select('Cliente', 'cliente_cobranca', $cliente_cobranca, 'SQL', $sql, "4",'1');

                //form_input_text('Cliente','cliente_cobranca',$cliente_cobranca,'50','4','','','1');
                form_input_text('Número/Referência','num_ref_cobranca',$num_ref_cobranca,'50','3','','','1');
                form_input_data('Data da Emissão','dt_emissao_cobranca',$dt_emissao_cobranca,'3','1');
                form_input_text('Valor','vl_emissao_cobranca',$vl_emissao_cobranca,'50','2','','','1');?>
                <div style="clear: both"></div>
                <?php
                form_input_data('Data de Vencimento','dt_vencimento_cobranca',$dt_vencimento_cobranca,'3','1');
                form_select("Parcelas", "parcelas", "", "", "1,1:2,2:3,3:4,4:5,5:6,6:7,7:8,8:9,9:10,10:11,11:12,12", "2",'1');
                ?>
                <div style="clear: both"></div>
                <?php
                form_input_textarea('Mensagem','msg_cobranca',$msg_cobranca,'12','3','');

                $sql = "SELECT * FROM tbl_cobrancas_instrucoes WHERE 1";
                form_select('Instruções', 'instrucoes', $chave_instrucao, 'SQL',$sql, '4','1');?>
                <!--Código a ser mostrado caso a opção "Valor Fixo até a data informada" seja selecionado-->
                <br><br>
                <?php 
                if ($chave_instrucao == 'L00000120170905201901'){?>
                <div class="form-group col-lg-8" id="op_inst_2" style="display:block;margin-bottom: -1px;">
                <?php
                }else{?>
                <div class="form-group col-lg-8" id="op_inst_2" style="display:none;margin-bottom: -1px;">
                <?php
                }?>
                    <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -40px; margin-right: -55px;">
                        Desconto de R$
                    </div>
                    <div style="margin-left:-25px;">
                        <?php form_input_text_semtitulo('desc_vl_fixo_dt_informada',$desconto_dinheiro,'10','2','margin-top:26px;','','0');?>
                    </div>

                    <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -25px; margin-right: -90px;">
                        até a data
                    </div>
                    <div class="form-group" style="margin-left:-25px;">
                        <?php form_input_data_semtitulo('data_vl_fixo_dt_informada',$data_desconto,'10','3','margin-top:26px;','','0');?>
                    </div>
                </div>

                <!--Código a ser mostrado caso a opção "Percentual até a data informada" seja selecionado-->
                <?php 
                if ($chave_instrucao == 'L00000120170905201902'){?>
                <div class="form-group col-lg-8" id="op_inst_3" style="display:block;margin-bottom: -1px;">
                <?php
                }else{?>
                <div class="form-group col-lg-8" id="op_inst_3" style="display:none;margin-bottom: -1px;">
                <?php
                }?>
                    <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -40px; margin-right: -75px;">
                        Desconto de
                    </div>
                    <div style="margin-left:-25px;">
                        <?php form_input_text_semtitulo('desc_perc_dt_informada',$desconto_porcentagem,'10','2','margin-top:26px; width:50px;','','0');?>
                    </div>

                    <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -55px; margin-right: -75px;">
                        % até a data
                    </div>
                    <div class="form-group" style="margin-left:-25px;">
                        <?php form_input_data_semtitulo('dt_perc_dt_informada',$data_desconto,'10','3','margin-top:26px;','','0');?>
                    </div>
                </div>

                <!--Código a ser mostrado caso uma das opções "Desconto por dia corrido de antecipação" 
                "Desconto por dia útil de antecipação" seja selecionado-->
                <?php 
                if ( ($chave_instrucao == 'L00000120170905201903') || ($chave_instrucao == 'L00000120170905201904') ){?>
                <div class="form-group col-lg-8" id="op_inst_4" style="display:block;margin-bottom: -1px;">
                <?php
                }else{?>
                <div class="form-group col-lg-8" id="op_inst_4" style="display:none;margin-bottom: -1px;">
                <?php
                }?>
                    <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -35px; margin-right: -115px;">
                        de R$
                    </div>
                    <div style="margin-left:-25px;">
                        <?php form_input_text_semtitulo('desc_diacorr_diautil',$desconto_dinheiro,'10','2','margin-top:26px;','','0');?>
                    </div>
                </div>

                <div style="clear: both"></div>
                <div id="cobrar_opcao1" class="form-horizontal col-lg-1" style="margin-left: 2px; margin-right: -14px;">
                    <?php form_checkbox_semtitulo('cobrar1',$cobrar1,'Cobrar',$cobrar1,'1','');?>
                </div>
                <?php form_input_text_semtitulo('porcento1',$porcent_juros_cobrar1,'10','1','',$leitura1,'');?>
                <div class="form-group col-lg-3" style="margin-top: 9px; margin-left: -25px; margin-right: -100px;">
                    % de juros ao dia após
                </div>
                <div class="form-group" style="margin-left:-25px;">
                    <?php form_input_text_semtitulo('diasjuros',$diasjuros_cobrar1,'10','1','',$leitura1,'');?>
                </div>
                <div class="form-group col-lg-1" style="margin-left: -25px; margin-top: -5px;">
                    dias.
                </div>

                <div style="clear: both"></div>
                <div id="cobrar_opcao2" class="form-group col-lg-1" style="margin-left: -13px;">
                    <?php form_checkbox_semtitulo('cobrar2',$cobrar2, 'Cobrar',$cobrar2,'1','');?>
                </div>
                <?php form_input_text_semtitulo('porcento2',$porcent_multa_cobrar2,'10','1','',$leitura2,'');?>
                <div class="form-group col-lg-2" style="margin-top: 9px; margin-left: -25px; margin-right: -60px;">
                    % de multa com
                </div>
                <div class="form-group" style="margin-left:-25px;">
                    <?php form_input_text_semtitulo('diasmulta',$diasmulta_cobrar2,'10','1','',$leitura2,'');?>
                </div>
                <div class="form-group col-lg-2" style="margin-left: -25px; margin-top: -5px;">
                    dias de tolerância.
                </div>

                <div style="clear:both"></div>
                <label style='color:red; font-weight: normal;'>* Campos de Preenchimento Obrigatório</label>
                <br>
                <div align="right">
                    <button type="button" class="btn btn-primary" onclick="window.history.back();">Voltar</button>
                    <?php                    
                    form_btn_reset('Limpar');
                    form_btn('submit',$btn_nome,$btn_texto);
                    ?>
                </div>
                <?php
                    form_input_hidden('filtrar', $filtrar);
                    form_input_hidden('pesquisar_cobrancas_cliente', $pesquisar_cobrancas_cliente);
                form_fim();
            }?>
        </div>
    </div>
    <?php
}else{?>
    <br>
    <?php 
    msg('4','Acesso não autorizado. Redirecionamento para a tela de login.','1','5','login.php','');
}?>