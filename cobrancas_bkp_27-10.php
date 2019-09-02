<?php
if (isset($_SESSION['acessar_modulos'])){
    if (($_SESSION['acessar_modulos']["L00000120170808160005"]) != "N"){
    //Define o número de itens por página.
    $itens_por_pagina = 10;

    //Pegar a página atual.
    if (isset($_REQUEST["pagina"]))     $pagina = intval($_REQUEST["pagina"]);
    else    $pagina = 1;

    //Seleciona todos os registros ta tabela
    $sql = "select nome, preco from produto";
    $qry = mysqli_query($con,$sql);
    $num_total = mysqli_num_rows($qry);
    
    //Calcula o número de páginas
    $num_paginas = ceil($num_total/$itens_por_pagina);
    
    //Calcular o início da visualização
    $inicio = ($itens_por_pagina * $pagina) - $itens_por_pagina;
    
    //Seleciona os registros da tabela a serem mostrados na página.
    $sql = "select nome, preco from produto LIMIT $pagina,$itens_por_pagina";
    $qry = mysqli_query($con,$sql);
    $num = mysqli_num_rows($qry);
    ?>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title"><strong>Cobranças</strong></h3>
        </div>
        <div class="panel-body">
            <?php
            if (isset($_REQUEST["desquitar"])){
                $sql = "UPDATE tbl_cobranca SET 
                        dt_pagamento = NULL,
                        vl_pago = NULL,
                        tipo_baixa = NULL 
                        WHERE chave = '".$_REQUEST["desquitar"]."'";
                $qry = user_update($sql);
            }
            if (isset($_REQUEST["filtrar"])) $filtrar = $_REQUEST["filtrar"]; else $filtrar = "";
            if (isset($_REQUEST["pesquisar_cobrancas_cliente"])){
                $pesquisar = $_REQUEST["pesquisar_cobrancas_cliente"];
                $filtrou = $filtrar;
                $filtrar = "";
            }
            else $pesquisar = "";
            
            form_inicio('formulario', 'post', 'index.php?pg=cobrancas','');?>
            <div class="col-md-12">
                <?php 
                form_select("Filtrar por", "filtrar", $filtrar, "", ",Selecione:nome,Nome:cd_cliente_empresa,Código:cpf,CPF:cnpj,CNPJ", "2",'1');
                form_input_text_autocomplete('Pesquisar','pesquisar_cobrancas_cliente',$pesquisar,'50','5','','','');?>
                <div style="margin-top: 25px;">
                    <?php form_btn_submit("Buscar");
                    if ( (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "S") ||
                         (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "G") ){?>
                    <button id="addLinhaPit" type="button" class="btn btn-large btn-success" onclick="location.href = 'index.php?pg=cobrancasCadastra'"> 
                        Adicionar Cobrança
                    </button>
                    <?php
                    }?>
                </div>
            </div>
            <?php
            form_fim();
            if (isset($_REQUEST["pesquisar_cobrancas_cliente"])){?>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (($filtrou) == ""){
                        msg('4','Selecione um filtro, preencha o campo pesquisar e clique em buscar.','','','','');
                        }
                        else{?>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    Resultado da Busca - Cliente: <b><?php echo $pesquisar?></b>
                                </h3>
                            </div>
                            <div class="panel-body table-responsive">
<!--                                Fazer tratamento de paginação posteriormente-->
<!--                                <table style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                            <?php
                                                //form_select2("Exibir", "registros", "", "", "10,10:30,30:50,50:100,100", "1");
                                            ?>
                                            </td>
                                            <td style="text-align: center">
                                            <?php
                                                //form_select2("Mostrar Cobranças em", "", "", "", "cobranca_aberta,Aberto:cobranca_liquidada,Liquidada", "1");
                                            ?>
                                            </td>
                                            <td style="text-align: right">
                                            <?php
                                                //form_input_text2('Pesquisar','pesquisar','','50','3','','');
                                            ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>-->
                                <table class="table table-striped" id="tbl_cobrancas">
                                    <thead>
                                        <tr>
                                            <th class="sorting" style="width: 20%"><b>Data Emissão</b></th>
                                            <th class="sorting" style="width: 20%"><b>Valor Emissao</b></th>
                                            <th class="sorting" style="width: 20%"><b>Data Vencimento</b></th>
                                            <th class="sorting" style="width: 20%"><b>Data Pagamento</b></th>
                                            <th class="sorting" style="width: 20%"><b>Valor Pagamento</b></th>
                                            <?php
                                            if ( (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "S") ||
                                                 (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "G") ){
                                                 echo "<th colspan='4' style='width: 10%; text-align: center'><b>Ações</b></th>";
                                            }?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        /*$sql = "SELECT tm.nm_modulo, tem.chave_modulo, tem.permissao
                                            FROM tbl_empresa_modulos AS tem
                                            INNER JOIN tbl_modulos AS tm on tem.chave_modulo = tm.chave
                                            WHERE tem.chave_empresa = '".$_SESSION["chave_empresa"]."' 
                                                AND tem.permissao!='N'";*/
                                        //PRECISA MELHORAR ESTA SQL PARA CONTEMPLAR O FILTRO ?????????????
                                        $sql = "SELECT tc.chave, tce.nome_razaosocial, DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y'), 
                                                DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y'), format(tc.vl_emissao,2,'de_DE'),
                                                DATE_FORMAT(tc.dt_pagamento,'%d/%m/%Y'), format(tc.vl_pago,2,'de_DE'),
                                                tipo_baixa, linha
                                                FROM tbl_cobranca AS tc 
                                                INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                                                where (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND
                                                      (tce.nome_razaosocial = '".$pesquisar."')";
                                       
                                        $qry = mysqli_query($con,$sql);
                                        if (mysqli_num_rows($qry) > 0){
                                            while($res = mysqli_fetch_array($qry)){?>
                                            <tr>
                                                <td><?php echo $res["DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y')"]?></td>
                                                <td><?php echo "R$ ".$res["format(tc.vl_emissao,2,'de_DE')"]?></td>
                                                <td><?php echo $res["DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y')"]?></td>
                                                <td><?php 
                                                    if ($res["tipo_baixa"] != "")
                                                        echo $res["DATE_FORMAT(tc.dt_pagamento,'%d/%m/%Y')"];
                                                    else echo "-";
                                                    ?>
                                                </td>
                                                <td><?php 
                                                    if ($res["tipo_baixa"] != "")
                                                        echo "R$ ".$res["format(tc.vl_pago,2,'de_DE')"];
                                                    else echo "-";
                                                    ?>
                                                </td>
                                                <?php
                                                if ( (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "S") ||
                                                     (($_SESSION['acessar_modulos']["L00000120170808160005"]) == "G") ){
                                                    if ($res["tipo_baixa"] == "M"){?>
                                                        <td colspan="4" align="center"><span class="label label-danger" onclick="desquitacobranca('<?php echo $res["chave"]?>','<?php echo $filtrou?>','<?php echo $pesquisar?>')">Desquitar</span></a></td>
                                                    <?php
                                                    }else if ($res["tipo_baixa"] == ""){?>
                                                        <td><a title="Editar" href="index.php?pg=cobrancasCadastra&editar=<?php echo $res["chave"];?>&filtrar=<?php echo $filtrou;?>&pesquisar_cobrancas_cliente=<?php echo $pesquisar;?>"><i class="fa fa-edit fa-fw"></i></a></td>
                                                        <td><a title="Excluir" onclick="apagacobranca('<?php echo $res["chave"]?>')"><i class="fa fa-trash fa-fw"></i></a></td>
                                                        <td><a class ="liquidar" data-toggle="modal" data-target="#exampleModal" title="Liquidar" href="#" style="color: red;"
                                                           data-id="<?php echo $res["chave"];?>" data-nm_razaosocial="<?php echo $res["nome_razaosocial"]?>" 
                                                           data-dt_emissao="<?php echo $res["DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y')"]?>"
                                                           data-vl_emissao="<?php echo "R$ ".$res["format(tc.vl_emissao,2,'de_DE')"]?>"
                                                           data-dt_vencimento="<?php echo $res["DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y')"]?>"><i class="fa fa-money fa-fw"></i></a></td>
                                                        <?php
                                                        if ($res["linha"] == ""){?>
                                                        <td><a title="Gerar Boleto" href="index.php?pg=cobrancasBoletos&chave_cobranca=<?php echo $res["chave"];?>"><i class="fa fa-barcode fa-fw"></i></a></td>
                                                        <?php
                                                        }else{?>
                                                        <td><a title="Baixar Boleto" href="index.php?pg=cobrancasBoletos&chave_cobranca=<?php echo $res["chave"];?>"><i class="fa fa-file-pdf-o fa-fw"></i></a></td>
                                                        <?php
                                                        }?>                                                        
                                                    <?php
                                                    }else{?>
                                                        <td></td>   <td></td>   <td></td>   <td></td>
                                                    <?php
                                                    }
                                                }?>
                                            </tr>
                                            <?php
                                            }
                                        }
                                        else
                                            msg('4','Não existe cobranças para este usuário.','','','','');
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <?php
                                        //Verificar a pagina anterior e posterior
                                        $pagina = 4;
                                        $pagina_anterior = $pagina - 1;
                                        $pagina_posterior = $pagina + 1;
                                        ?>
                                        <tr>
                                            <td colspan="9">
                                                <div class="dataTables_paginate paging_bootstrap" style="text-align: center;">
                                                    <ul class="pagination">
                                                        <?php
                                                        if ($pagina_anterior != 0){?>
                                                            <li><a href="index.php?pg=cobrancas&pagina=<?php echo $pagina_anterior;?>">← Anterior</a></li>
                                                        <?php
                                                        }else{?>
                                                            <li class="prev disabled"><a href="index.php?pg=cobrancas&pagina=0">← Anterior</a></li>
                                                        <?php
                                                        } 
                                                        for ($i=1;$i<=$num_paginas;$i++){
                                                            $estilo = "";
                                                            if ($pagina == $i)  $estilo = "class=\"active\"";?>
                                                                <li <?php echo $estilo;?> ><a href="index.php?pg=cobrancas&pagina=<?php echo $i;?>" ><?php echo $i;?></a></li>
                                                        <?php
                                                        }?>
                                                        <?php
                                                        if($pagina_posterior <= $num_paginas){ ?>
                                                            <li class="next"><a href="index.php?pg=cobrancas&pagina=<?php echo $pagina_posterior;?>">Próximo → </a></li>
                                                        <?php }else{ ?>
                                                            <li class="prev disabled"><a href="index.php?pg=cobrancas&pagina=<?php echo $num_paginas;?>">Próximo → </a></li>
                                                        <?php
                                                        }?>
                                                        
                                                        
                                                        
                                                        
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <?php
                        }?>
                    </div>	  
                </div>
            <?php
            form_input_hidden('pesquisar_cobrancas_cliente',$_REQUEST["pesquisar_cobrancas_cliente"]);
            }?>
        </div>
    </div>
    
    <div class="modal fade bs-example-modal-lg" id="exampleModal" tabindex="-1" 
         role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Dados da Cobrança</h4>
                </div>
                <div class="modal-body">
                    <?php
                    form_inicio('formulario', 'POST', 'index.php?pg=cobrancasLiquidar',' ');
                    form_input_text_leitura("Cliente","cliente","","","8","");
                    form_input_text_leitura("Data da Emissão","dt_emissao_cobranca","","","4","");
                    form_input_text_leitura("Valor Emitido","vl_emissao_cobranca","","","4","");
                    form_input_text_leitura("Data de Vencimento","dt_vencimento_cobranca","","","4","");?>
                    <div style="clear: both"></div>
                    <?php
                    form_input_data("Data de Pagamento", "dt_pgto_cobranca","", "4", "1");
                    form_input_text("Valor Pago","vl_pago_cobranca","","20","4","","","1");
                    form_input_hidden("id_cobranca", "");
                    form_input_hidden("filtrar", $_REQUEST["filtrar"]);
                    form_input_hidden("pesquisar_cobrancas_cliente", $_REQUEST["pesquisar_cobrancas_cliente"]);
                    ?>         
                    <br>
                    <div style="clear: both"></div>
                    <div class="modal-footer">
                    <?php
                    //Verificar a questão dos botões serem do tipo button
                    form_btn_fechar_modal('Cancelar');
                    form_btn('submit','btn_liquidar','Liquidar Cobrança');
                    ?>
                    </div>
                    <?php
                    //form_fim();?>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
}else{?>
    <br>
    <?php 
    msg('4','Acesso não autorizado. Redirecionamento para a tela de login.','1','5','login.php','');
}?>