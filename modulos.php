<?php 
if (isset($_SESSION['acessar_modulos'])){
    if (in_array(array("L00000120170808160004","G"),$_SESSION['acessar_modulos'])){?>
    <div class="panel panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title"><strong>Permissões de Acesso aos Módulos do Sistema</strong></h3>
        </div>
        <div class="panel-body">
            <?php
            form_inicio('formulario', 'post', 'index.php?pg=modulos','');
            ?>
            <div class="col-md-10"></div>
            <div class="col-md-2">
            <?php
                form_btn("Adicionar Módulo","index.php?pg=cadastraModulos");
            ?>
            </div>
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
                            <tr>
                                <td style="text-align: center;">Empresa</td>
                                <td style="text-align: center;">
                                    <?php 
                                    form_select_semtitulo_horizontal('modulo_1',"","","acessar,Acessar:gravar,Gravar:nenhum,Nenhum","10");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Cliente das Empresas</td>
                                <td style="text-align: center;">
                                    <?php 
                                    form_select_semtitulo_horizontal('modulo_2',"","","acessar,Acessar:gravar,Gravar:nenhum,Nenhum","10");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Usuários</td>
                                <td style="text-align: center;">
                                    <?php 
                                    form_select_semtitulo_horizontal('modulo_3',"","","acessar,Acessar:gravar,Gravar:nenhum,Nenhum","10");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Planos</td>
                                <td style="text-align: center;">
                                    <?php 
                                    form_select_semtitulo_horizontal('modulo_4',"","","acessar,Acessar:gravar,Gravar:nenhum,Nenhum","10");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Módulos</td>
                                <td style="text-align: center;">
                                    <?php 
                                    form_select_semtitulo_horizontal('modulo_5',"","","acessar,Acessar:gravar,Gravar:nenhum,Nenhum","10");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Cobranças</td>
                                <td style="text-align: center;">
                                    <?php 
                                    form_select_semtitulo_horizontal('modulo_6',"","","acessar,Acessar:gravar,Gravar:nenhum,Nenhum","10");
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div style="clear: both"></div>
            <div align="right">
                <?php
                form_btn_submit('Voltar');
                form_btn_reset('Limpar');
                form_btn_submit('Atualizar');
                ?>
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