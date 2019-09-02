<?php
if (isset($_SESSION['acessar_modulos'])){
    if ( (($_SESSION['acessar_modulos']["L00000120170808160006"]) == "S") ||
         (($_SESSION['acessar_modulos']["L00000120170808160006"]) == "G") ){?>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title"><strong>Relatórios</strong></h3>
        </div>
        <div class="panel-body">
            <?php
            if (isset($_REQUEST["tipo_cobranca"])) $tipo_cobranca = $_REQUEST["tipo_cobranca"]; else $tipo_cobranca = "td";
            if (isset($_REQUEST["dt_inicio_relat"])) $dt_inicio_relat = $_REQUEST["dt_inicio_relat"]; else $dt_inicio_relat = "";
            if (isset($_REQUEST["dt_final_relat"])) $dt_final_relat = $_REQUEST["dt_final_relat"]; else $dt_final_relat = "";
            if (isset($_REQUEST["cliente_cobranca"])) $cliente_cobranca = $_REQUEST["cliente_cobranca"]; else $cliente_cobranca = "";
            
            form_inicio('formulario', 'post', 'index.php?pg=relatorios','');?>
            <div class="col-md-12">
                <?php 
                form_radio('Tipo Cobrança', 'tipo_cobranca', 'td:ea:li', 'Todas:Em aberto:Liquidadas', $tipo_cobranca, '4');
                form_input_data('Início','dt_inicio_relat',$dt_inicio_relat,'4','1');
                form_input_data('Final','dt_final_relat',$dt_final_relat,'4','1');?>
                <div style="clear: both"></div>
                <?php
                form_input_text_autocomplete('Cliente Cobrança','cliente_cobranca',$cliente_cobranca,'50','5','','','');?>
                <div style="margin-top: 25px;">
                    <?php 
                    form_btn_submit("Consultar");?>
                </div>
            </div>
            <?php
            form_fim();
            if (isset($_REQUEST["cliente_cobranca"])){?>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <?php
                                    if ($tipo_cobranca == "td") $msg_cabecalho = "Todas as cobranças";
                                    else if ($tipo_cobranca == "ea") $msg_cabecalho = "Cobranças em aberto";
                                    else if ($tipo_cobranca == "li") $msg_cabecalho = "Cobranças liquidadas";
                                    
                                    if ($cliente_cobranca != "") : ?>
                                        Relatório de cobranças - Cliente: <b><?php echo $cliente_cobranca?></b> - <?php echo $msg_cabecalho;?>
                                    <?php else : ?>
                                        Relatório das cobranças de todos os clientes - <?php echo $msg_cabecalho;?> - 
                                    <?php endif; ?>
                                    
                                    <a title="Gerar Relatório" target="_blank" href="cobrancasRelatorio.new.php?tipo_cobranca=<?php echo $tipo_cobranca?>&dt_inicio_relat=<?php echo $dt_inicio_relat?>&dt_final_relat=<?php echo $dt_final_relat?>&cliente_cobranca=<?php echo $cliente_cobranca?>">
                                       <i style="color:red" class="fa fa-file-pdf-o fa-fw"></i>
                                    </a>
                                </h3>
                            </div>
                            <div class="panel-body table-responsive">
                                <table class="table table-striped" id="tbl_cobrancas">
                                    <thead>
                                        <tr>
                                            <th class="sorting" style="width: 23%"><b>Cliente</b></th>
                                            <th class="sorting" style="width: 13%"><b>Data Emissão</b></th>
                                            <th class="sorting" style="width: 13%"><b>Valor Emissao</b></th>
                                            <th class="sorting" style="width: 15%"><b>Data Vencimento</b></th>
                                            <th class="sorting" style="width: 15%"><b>Data Pagamento</b></th>
                                            <th class="sorting" style="width: 15%"><b>Valor Pagamento</b></th>
                                            <th class="sorting" style="width: 10%"><b>Baixa</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php                                        
                                        if ($tipo_cobranca == "td") { //Pesquisa por todas as cobranças de um cliente em um espaço de data.
                                            $sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj,tce.cpf,
                                                    DATE_FORMAT(dt_emissao,'%d/%m/%Y'), 
                                                    format(vl_emissao,2,'de_DE'), DATE_FORMAT(dt_vencimento,'%d/%m/%Y'),
                                                    DATE_FORMAT(dt_pagamento,'%d/%m/%Y'), format(vl_pago,2,'de_DE'),vl_pago,vl_emissao,tipo_baixa
                                                    FROM tbl_cobranca AS tc
                                                    INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                                                    where (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND 
                                                    ( (dt_vencimento >='".data_converte($dt_inicio_relat,"/")."') AND
                                                      (dt_vencimento <='".data_converte($dt_final_relat,"/")."') AND (tce.ativo = 'S'))";
                                        }else if ($tipo_cobranca == "ea"){ //Pesquisa pelas cobranças de um cliente em aberto em um espaço de data.
                                            $sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj,tce.cpf,
                                                    DATE_FORMAT(dt_emissao,'%d/%m/%Y'), 
                                                    format(vl_emissao,2,'de_DE'), DATE_FORMAT(dt_vencimento,'%d/%m/%Y'),
                                                    DATE_FORMAT(dt_pagamento,'%d/%m/%Y'), format(vl_pago,2,'de_DE'),vl_pago,vl_emissao,tipo_baixa
                                                    FROM tbl_cobranca AS tc
                                                    INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                                                    where (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND 
                                                    ( (dt_vencimento >='".data_converte($dt_inicio_relat,"/")."') AND (dt_vencimento <='".data_converte($dt_final_relat,"/")."') ) AND
                                                    ( (tipo_baixa = '') OR (tipo_baixa IS NULL) ) AND (tce.ativo = 'S')";
                                        }
                                        else{   //Pesquisa pelas cobranças de um cliente liquidadas em um espaço de data.
                                            $sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj,tce.cpf,
                                                    DATE_FORMAT(dt_emissao,'%d/%m/%Y'), 
                                                    format(vl_emissao,2,'de_DE'), DATE_FORMAT(dt_vencimento,'%d/%m/%Y'),
                                                    DATE_FORMAT(dt_pagamento,'%d/%m/%Y'), format(vl_pago,2,'de_DE'),vl_pago,vl_emissao,tipo_baixa
                                                    FROM tbl_cobranca AS tc
                                                    INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                                                    where (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND 
                                                    ( (dt_pagamento >='".data_converte($dt_inicio_relat,"/")."') AND (dt_pagamento <='".data_converte($dt_final_relat,"/")."') ) AND
                                                    ( (tipo_baixa = 'M') OR (tipo_baixa = 'A') ) AND (tce.ativo = 'S')";
                                        }
                                        if ($cliente_cobranca != "")    $sql .= " AND (tce.nome_fantasia = '".$cliente_cobranca."')";
                                        $sql .= " ORDER BY tce.nome_fantasia, dt_emissao, dt_vencimento";
                                        
                                        $total_pago = 0.0;
                                        $total_receber = 0.0;
                                        $qry = mysqli_query($con,$sql);
                                        if (mysqli_num_rows($qry) > 0){
                                            while($res = mysqli_fetch_array($qry)){?>
                                            <tr>
                                                <td><?php 
                                                    if ( ($res["cnpj"] != "") && ($res["cnpj"] != NULL) )   
                                                        echo $res["nome_fantasia"];
                                                    else if ( ($res["cpf"] != "") && ($res["cpf"] != NULL) ) 
                                                        echo $res["nome_razaosocial"]?>
                                                </td>
                                                <td><?php echo $res["DATE_FORMAT(dt_emissao,'%d/%m/%Y')"]?></td>
                                                <td><?php echo "R$ ".$res["format(vl_emissao,2,'de_DE')"]?></td>
                                                <td><?php echo $res["DATE_FORMAT(dt_vencimento,'%d/%m/%Y')"]?></td>
                                                <?php
                                                if ( ($res["tipo_baixa"] != "") && ($res["tipo_baixa"] != NULL) ){?>
                                                    <td><?php echo $res["DATE_FORMAT(dt_pagamento,'%d/%m/%Y')"];?></td>
                                                    <td><?php echo "R$ ".$res["format(vl_pago,2,'de_DE')"];?></td>
                                                    <td><?php echo $res["tipo_baixa"];?></td>
                                                <?php
                                                }
                                                else{?>
                                                    <td><?php echo "-"; ?></td>
                                                    <td><?php echo "-"; ?></td>
                                                    <td><?php echo "-"; ?></td>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                            $total_pago += $res["vl_pago"];
                                            if ( ($res["tipo_baixa"] != 'M') && ($res["tipo_baixa"] != 'A') )
                                                $total_receber += $res["vl_emissao"];
                                            }
                                        }
                                        else
                                            msg('4','Informação inexistente.','','','','');
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <?php
                                        if ($tipo_cobranca == "td"){?>
                                        <tr>
                                            <td colspan="7" align="right">
                                                <br>
                                                <b>Total Pago: </b> R$ <?php echo number_format($total_pago,2,",",".")?><br>
                                                <b>Valor a receber: </b> R$ <?php echo number_format($total_receber,2,",",".")?>
                                            </td>
                                        </tr>
                                        <?php
                                        }else if ($tipo_cobranca == "ea"){?>
                                        <tr><td colspan="7" align="right"><br><b>Valor a receber: </b> R$ <?php echo number_format($total_receber,2,",",".")?></td></tr>
                                        <?php
                                        }else{?>
                                        <tr><td colspan="7" align="right"><br><b>Total Pago: </b> R$ <?php echo number_format($total_pago,2,",",".")?></td></tr>
                                        <?php
                                        }?>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>	  
                </div>
            <?php
            //form_input_hidden('pesquisar_cobrancas_cliente',$_REQUEST["pesquisar_cobrancas_cliente"]);
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