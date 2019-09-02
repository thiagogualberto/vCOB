<?php
if (isset($_SESSION['acessar_modulos'])){
    if ( (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "S") ||
         (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "G") ){?>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading" >
                <h3 class="panel-title"><strong>Parâmetros de Cobrança</strong></h3>
            </div>
            <div class="panel-body">
                    <?php
                    if (isset($_REQUEST['desc_vl_fixo_dt_informada'])) $desconto_dinheiro = $_REQUEST['desc_vl_fixo_dt_informada']; else $desconto_dinheiro = "";
                    if (isset($_REQUEST['data_vl_fixo_dt_informada'])) $data_desconto = $_REQUEST['data_vl_fixo_dt_informada']; else $data_desconto = "";
                    if (isset($_REQUEST['desc_perc_dt_informada'])) $desconto_porcentagem = $_REQUEST['desc_perc_dt_informada']; else $desconto_porcentagem = "";
                    if (isset($_REQUEST['dt_perc_dt_informada'])) $data_desconto = $_REQUEST['dt_perc_dt_informada']; else $data_desconto = "";
                    if (isset($_REQUEST['desc_diacorr_diautil'])) $desconto_dinheiro = $_REQUEST['desc_diacorr_diautil']; else $desconto_dinheiro = "";

                    //Pega os elementos do 1º checkbox da cobrança
                    $cobrar1 = "S";
                    if (isset($_REQUEST['porcento1'])) $porcent_juros_cobrar1 = $_REQUEST['porcento1']; else $porcent_juros_cobrar1 = "";
                    if (isset($_REQUEST['diasjuros'])) $diasjuros_cobrar1 = $_REQUEST['diasjuros']; else $diasjuros_cobrar1 = "";

                    //Pega os elementos do 2º checkbox da cobrança
                    $cobrar2 = "S";
                    if (isset($_REQUEST['porcento2'])) $porcent_multa_cobrar2 = $_REQUEST['porcento2']; else $porcent_multa_cobrar2 = "";
                    if (isset($_REQUEST['diasmulta'])) $diasmulta_cobrar2 = $_REQUEST['diasmulta']; else $diasmulta_cobrar2 = "";

                    if (isset($_REQUEST['instrucoes'])) $chave_instrucao = $_REQUEST['instrucoes']; else $chave_instrucao = "";

                    $sql = "SELECT * FROM tbl_cobranca_parametro WHERE chave_empresa = '".$_SESSION["chave_empresa"]."'";
                    $qry = mysqli_query($con,$sql);
                    $num_reg = mysqli_num_rows($qry);
                    if ($num_reg > 0){
                        $res = mysqli_fetch_array($qry);

                        $chave_instrucao = $res["chave_instrucao"];

                        $desconto_dinheiro = $res["desconto_dinheiro"];
                        $desconto_porcentagem = $res["desconto_porcentagem"];
                        $data_desconto = $res["data_desconto"];

                        $cobrar1 = $res["cobrar1"];
                        $porcent_juros_cobrar1 = $res["porcentagem_juros_cobrar1"];
                        $diasjuros_cobrar1 = $res["diasjuros_cobrar1"];
                        $cobrar2 = $res["cobrar2"];
                        $porcent_multa_cobrar2 = $res["porcentagem_multa_cobrar2"];
                        $diasmulta_cobrar2 = $res["diasmulta_cobrar2"];
                        /*if (strcmp($_REQUEST["instrucoes"],"n_consta_desc") == 0){}
                        else if (strcmp($_REQUEST["instrucoes"],"L00000120170905201901") == 0){}
                        else if (strcmp($_REQUEST["instrucoes"],"L00000120170905201902") == 0){}
                        else if (strcmp($_REQUEST["instrucoes"],"L00000120170905201903") == 0){}
                        else if (strcmp($_REQUEST["instrucoes"],"L00000120170905201904") == 0){}*/

                    }

                    if (isset($_REQUEST["instrucoes"])){
                            if (!isset($_REQUEST['cobrar1'])) $cobrar1 = "N";
                            if (!isset($_REQUEST['cobrar2'])) $cobrar2 = "N";

                            //Gera o código do usuário
                            $codigo = gera_codigo("tbl_cobranca_parametro","cd_parametro_cobranca");

                            //Gera a chave de registro do banco do usuário
                            $chave = gera_chave($codigo);

                            echo 'desconto_dinheiro: '.$desconto_dinheiro.'<br>';
                            echo 'data_desconto: '.$data_desconto.'<br>';
                            echo 'desconto_porcentagem: '.$desconto_porcentagem.'<br>';
                            echo 'cobrar1: '.$cobrar1.'<br>';
                            echo 'porcent_juros_cobrar1: '.$porcent_juros_cobrar1.'<br>';
                            echo 'diasjuros_cobrar1: '.$diasjuros_cobrar1.'<br>';
                            echo 'cobrar2: '.$cobrar2.'<br>';
                            echo 'porcent_multa_cobrar2: '.$porcent_multa_cobrar2.'<br>';
                            echo 'diasmulta_cobrar2: '.$diasmulta_cobrar2.'<br>';

                            $sql="INSERT INTO tbl_cobranca_parametro (chave, cd_parametro_cobranca, chave_empresa, 
                                    chave_instrucao, desconto_dinheiro, desconto_porcentagem, data_desconto, 
                                    cobrar1, porcentagem_juros_cobrar1, diasjuros_cobrar1, 
                                    cobrar2, porcentagem_multa_cobrar2, diasmulta_cobrar2) VALUES
                                    ('".$chave."','".$codigo."','".$_SESSION["chave_empresa"]."','".$chave_instrucao."',
                                    '".$desconto_dinheiro."','".$desconto_porcentagem."','".$data_desconto."',
                                    '".$cobrar1."','".$porcent_juros_cobrar1."','".$diasjuros_cobrar1."',
                                    '".$cobrar2."','".$porcent_multa_cobrar2."','".$diasmulta_cobrar2."')";
                            //$qry = mysqli_query($con,$sql);
                            if($qry){
                                //msg('1','Parâmetros de cobrança definidos com sucesso.','1','2','index.php?pg=cobrancasParametros','');
                                $mostrar_form = "N";
                            }else{
                                msg('4','Erro na na definição dos parâmetros de cobrança.','','','index.php?pg=cobrancasParametros','');
                                $mostrar_form = "S";
                            }
                            $mostrar_form = "N";
                    }

                    form_inicio('formulario', 'POST', 'index.php?pg=cobrancasParametros','');
                    $sql = "SELECT * FROM tbl_cobrancas_instrucoes WHERE 1";
                    form_select("Instruções", "instrucoes", "", "SQL",$sql, "4",'1');?>
                    <!--Código a ser mostrado caso a opção "Valor Fixo até a data informada" seja selecionado-->
                    <div class="form-group col-lg-8" id="op_inst_2" style="display:none;margin-bottom: -1px;">
                        <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -40px; margin-right: -55px;">
                            Desconto de R$
                        </div>
                        <div style="margin-left:-25px;">
                            <?php form_input_text_semtitulo('desc_vl_fixo_dt_informada',$desconto_dinheiro,'10','2','margin-top:26px;','0');?>
                        </div>

                        <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -25px; margin-right: -90px;">
                            até a data
                        </div>
                        <div class="form-group" style="margin-left:-25px;">
                            <?php form_input_text_semtitulo('data_vl_fixo_dt_informada',$data_desconto,'10','2','margin-top:26px;','0');?>
                        </div>
                    </div>

                    <!--Código a ser mostrado caso a opção "Percentual até a data informada" seja selecionado-->
                    <div class="form-group col-lg-8" id="op_inst_3" style="display:none;margin-bottom: -1px;">
                        <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -40px; margin-right: -75px;">
                            Desconto de
                        </div>
                        <div style="margin-left:-25px;">
                            <?php form_input_text_semtitulo('desc_perc_dt_informada',$desconto_porcentagem,'10','2','margin-top:26px; width:50px;','0');?>
                        </div>

                        <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -55px; margin-right: -75px;">
                            % até a data
                        </div>
                        <div class="form-group" style="margin-left:-25px;">
                            <?php form_input_text_semtitulo('dt_perc_dt_informada',$data_desconto,'10','3','margin-top:26px; width:100px;','0');?>
                        </div>
                    </div>

                    <!--Código a ser mostrado caso uma das opções "Desconto por dia corrido de antecipação" 
                    "Desconto por dia útil de antecipação" seja selecionado-->
                    <div class="form-group col-lg-8" id="op_inst_4" style="display:none;margin-bottom: -1px;">
                        <div class="form-group col-lg-3" style="margin-top: 32px; margin-left: -35px; margin-right: -115px;">
                            de R$
                        </div>
                        <div style="margin-left:-25px;">
                            <?php form_input_text_semtitulo('desc_diacorr_diautil',$desconto_dinheiro,'10','2','margin-top:26px;','0');?>
                        </div>
                    </div>

                    <div style="clear: both"></div>
                    <div id="cobrar_opcao1" class="form-horizontal col-lg-1" style="margin-left: 2px; margin-right: -14px;">
                        <?php form_checkbox_semtitulo('cobrar1',$cobrar1,'Cobrar',$cobrar1,'1','');?>
                    </div>
                    <?php form_input_text_semtitulo('porcento1',$porcent_juros_cobrar1,'10','1','','1');?>
                    <div class="form-group col-lg-2" style="margin-top: 9px; margin-left: -25px; margin-right: -60px;">
                        % de juros após
                    </div>
                    <div class="form-group" style="margin-left:-25px;">
                        <?php form_input_text_semtitulo('diasjuros',$diasjuros_cobrar1,'10','1','','1');?>
                    </div>
                    <div class="form-group col-lg-1" style="margin-left: -25px; margin-top: -5px;">
                        dias.
                    </div>

                    <div style="clear: both"></div>
                    <div id="cobrar_opcao2" class="form-group col-lg-1" style="margin-left: -13px;">
                        <?php form_checkbox_semtitulo('cobrar2',$cobrar2, 'Cobrar',$cobrar2,'1','');?>
                    </div>
                    <?php form_input_text_semtitulo('porcento2',$porcent_multa_cobrar2,'10','1','','1');?>
                    <div class="form-group col-lg-2" style="margin-top: 9px; margin-left: -25px; margin-right: -60px;">
                        % de multa com
                    </div>
                    <div class="form-group" style="margin-left:-25px;">
                        <?php form_input_text_semtitulo('diasmulta',$diasmulta_cobrar2,'10','1','','1');?>
                    </div>
                    <div class="form-group col-lg-2" style="margin-left: -25px; margin-top: -5px;">
                        dias de tolerância.
                    </div>




                    <?php
                    /*form_checkbox_semtitulo('cobrar2');
                    form_input_text_semtitulo('porcento2','','10','1','','1');
                    form_input_text_semtitulo('qtdediasmulta','','10','1','','1');*/
                    ?>
                    <br>
                    <br>

                    <div style="clear: both"></div>
                    <br>
                    <label style='color:red; font-weight: normal;'>* Campos de Preenchimento Obrigatório</label>
                    <br>
                    <div align="right">
                        <?php
                        form_btn_submit('Voltar');
                        form_btn_reset('Limpar');
                        form_btn_submit('Cadastrar');
                        ?>
                    </div>
                <?php
                form_fim();
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