<?php 
if (isset($_SESSION['acessar_modulos'])){
    if (in_array(array("L00000120170808160003","G"),$_SESSION['acessar_modulos'])){?>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title"><strong>Cadastro de Planos</strong></h3>
        </div>
        <div class="panel-body">
                <?php
                form_inicio('formulario', 'post', 'index.php?pg=cadastraPlanos','');
                form_input_text('Nome do Plano','nm_plano','','30','3','','1');
                form_input_text('Valor do Plano','vl_plano','','10','3','','1');?>
                <br>
                <br>
                <div style="clear:both"></div>
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