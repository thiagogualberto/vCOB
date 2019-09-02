<?php
if (isset($_SESSION['acessar_modulos'])){
    if (($_SESSION['acessar_modulos']["L00000120170808160002"]) != "N"){
        //Define o número de itens por página.
        $itens_por_pagina = 10;

        //Pegar a página atual.
        if (isset($_REQUEST["pagina"]))     $pagina = intval($_REQUEST["pagina"]);
        else    $pagina = 1;

        //Calcular o início da visualização
        $inicio = ($itens_por_pagina * $pagina) - $itens_por_pagina;?>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading" >
                <h3 class="panel-title"><strong>Usuários</strong></h3>
            </div>
            <div class="panel-body">
                <?php
                if (isset($_REQUEST["desativar"])){
                    $sql = "UPDATE tbl_usuario SET ativo = 'N' WHERE chave = '".$_REQUEST["desativar"]."'";
                    $qry = user_update($sql);
                    $titulo = "Ativar";
                    $param_titulo = "ativar";
                    $cor = "color:red;";
                    $class_ativ_desat = "fa fa-thumbs-o-up fa-fw";
                }
                else if (isset($_REQUEST["ativar"])){
                    $sql = "UPDATE tbl_usuario SET ativo = 'S' WHERE chave = '".$_REQUEST["ativar"]."'";
                    $qry = user_update($sql);
                    $titulo = "Desativar";
                    $param_titulo = "desativar";
                    $cor = "color:#337ab7;";
                    $class_ativ_desat = "fa fa-thumbs-o-down fa-fw";
                }

                if (isset($_REQUEST["pesquisar_usuario"])) $pesquisar = $_REQUEST["pesquisar_usuario"]; else $pesquisar = "";

                form_inicio('formulario', 'post', 'index.php?pg=usuarios','');?>
                <div class="col-md-12">
                    <?php form_input_text_autocomplete('Pesquisar','pesquisar_usuario',$pesquisar,'50','3','','','');?>
                    <div style="margin-top: 25px;">
                        <?php form_btn_submit("Buscar");
                        if ( (($_SESSION['acessar_modulos']["L00000120170808160002"]) == "S") ||
                             (($_SESSION['acessar_modulos']["L00000120170808160002"]) == "G") ){?>
                        <button id="addLinhaPit" type="button" class="btn btn-large btn-success" onclick="location.href = 'index.php?pg=usuariosCadastra'"> 
                            Adicionar Usuário
                        </button>
                        <?php
                        }?>
                    </div>
                </div>
                <?php
                if (isset($_REQUEST["pesquisar_usuario"])){?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Resultado da Busca</h3>
                                </div>
                                <div class="panel-body table-responsive">
    <!--                                <table style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                <?php
                                                    //form_select2("Exibir", "registros", "", "", "10,10:30,30:50,50:100,100", "1");
                                                ?>
                                                </td>
                                                <td style="text-align: right">
                                                <?php
                                                    //form_input_text2('Pesquisar','pesquisar','','50','3','','');
                                                ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br><br>-->
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="sorting_asc" style="width: 45%"><b>Nome</b></th>
                                                <th class="sorting" style="width: 45%"><b>E-Mail</b></th>
                                                <?php
                                                if ( (($_SESSION['acessar_modulos']["L00000120170808160002"]) == "S") ||
                                                     (($_SESSION['acessar_modulos']["L00000120170808160002"]) == "G") ){
                                                    echo "<th colspan='4' style='width: 10%; text-align: center'><b>Ações</b></th>";
                                                }?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //Seleciona todos os registros ta tabela
                                            if ($_REQUEST["pesquisar_usuario"] == "")
                                                $sql = "SELECT chave, nm_usuario, sobrenome, email, ativo FROM tbl_usuario 
                                                        WHERE chave_empresa='".$_SESSION["chave_empresa"]."'";
                                            else
                                                $sql = "SELECT chave, nm_usuario, sobrenome, email, ativo FROM tbl_usuario 
                                                        WHERE (chave_empresa='".$_SESSION["chave_empresa"]."') AND (nm_usuario like '%".$_REQUEST["pesquisar_usuario"]."%') order by nm_usuario ASC";
                                            $qry = mysqli_query($con,$sql);
                                            $num_total = mysqli_num_rows($qry);
                                            
                                            //Seleciona os registros da tabela a serem mostrados na página.
                                            $sql .= " LIMIT $inicio,$itens_por_pagina";
                                            $qry = mysqli_query($con,$sql);
                                            $num_paginas = ceil($num_total/$itens_por_pagina);
                                            if (mysqli_num_rows($qry) > 0){
                                                while($res = mysqli_fetch_array($qry)){?>
                                                <tr>
                                                    <td>
                                                        <a title="Razão Social/Nome" href="index.php?pg=usuariosCadastra&visualizar=<?php echo $res["chave"]?>" ><?php echo $res["nm_usuario"]." ".$res["sobrenome"]?></a></td>
                                                    <td><?php echo $res["email"]?></td>
                                                    <?php
                                                    if ( (($_SESSION['acessar_modulos']["L00000120170808160002"]) == "S") ||
                                                         (($_SESSION['acessar_modulos']["L00000120170808160002"]) == "G") ){?>
                                                            <td id="editar_usuario"><a title="Editar" href="index.php?pg=usuariosCadastra&editar=<?php echo $res["chave"];?>"><i class="fa fa-edit fa-fw"></i></a></td>
                                                            <td id="excluir_usuario"><a title="Excluir" onclick="apagausuario('<?php echo utf8_encode($res["nm_usuario"])." ".utf8_encode($res["sobrenome"])?>','<?php echo $res["chave"]?>');"><i class="fa fa-trash fa-fw"></i></a></td>
                                                            <?php
                                                            if ($res["ativo"] == "S"){
                                                                $titulo = "Desativar";
                                                                $param_titulo = "desativar";
                                                                $cor = "color:#337ab7;";
                                                                $class_ativ_desat = "fa fa-thumbs-o-up fa-fw";
                                                            }
                                                            else{
                                                                $titulo = "Ativar";
                                                                $param_titulo = "ativar";
                                                                $cor = "color:red;";
                                                                $class_ativ_desat = "fa fa-thumbs-o-down fa-fw";
                                                            }
                                                            ?>
                                                            <td><a title="<?php echo $titulo;?>" href="index.php?pg=usuarios&pesquisar_usuario=<?php echo $_REQUEST["pesquisar_usuario"]?>&<?php echo $param_titulo?>=<?php echo $res["chave"];?>" style="<?php echo $cor;?>"><i class="<?php echo $class_ativ_desat?>"></i></a></td>
                                                    <?php
                                                    }?>
                                                </tr>
                                                <?php
                                                }
                                            }
                                            else    msg('4','Usuário inexistente.','','','','');?>
                                        </tbody>
                                        <tfoot>
                                            <?php
                                            //Verificar a pagina anterior e posterior
                                            $pagina_anterior = $pagina - 1;
                                            $pagina_posterior = $pagina + 1;
                                            ?>
                                            <tr>
                                                <td colspan="9">
                                                    <div class="dataTables_paginate paging_bootstrap" style="text-align: center;">
                                                        <ul class="pagination">
                                                            <?php
                                                            if ($pagina_anterior != 0){?>
                                                                <li><a href="index.php?pg=usuarios&pagina=<?php echo $pagina_anterior;?>&pesquisar_usuario=<?php echo $pesquisar;?>">← Anterior</a></li>
                                                            <?php
                                                            }else{?>
                                                                <li class="prev disabled"><a>← Anterior</a></li>
                                                            <?php
                                                            } 
                                                            for ($i=1;$i<=$num_paginas;$i++){
                                                                $estilo = "";
                                                                if ($pagina == $i)  $estilo = "class=\"active\"";?>
                                                                    <li <?php echo $estilo;?> ><a href="index.php?pg=usuarios&pagina=<?php echo $i;?>&pesquisar_usuario=<?php echo $pesquisar;?>"><?php echo $i;?></a></li>
                                                            <?php
                                                            }?>
                                                            <?php
                                                            if($pagina_posterior <= $num_paginas){ ?>
                                                                <li class="next"><a href="index.php?pg=usuarios&pagina=<?php echo $pagina_posterior;?>&pesquisar_usuario=<?php echo $pesquisar;?>">Próximo → </a></li>
                                                            <?php }else{ ?>
                                                                <li class="prev disabled"><a>Próximo → </a></li>
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
                        </div>	  
                    </div>
                <?php
                //form_input_hidden('pesquisar_usuario',$_REQUEST["pesquisar_usuario"]);
                }
                ?>

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