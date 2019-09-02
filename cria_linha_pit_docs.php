<?php
include 'funcao_formulario.php';
if (isset($_POST['novaLinhaPit'])) {
    $num_linha_tabela_pit = $_POST['novaLinhaPit'];
    ?>
    <tr id="linha_pit_<?php echo $num_linha_tabela_pit; ?>">
        <td style="text-align: center; vertical-align: middle">
            <?php
            form_select_semtitulo("pit_grupo_$num_linha_tabela_pit", "", "", "chapas_perfis_laminados,Chapas e perfis laminados:elementos_fixacao,Elementos de fixação");
            ?>
        </td>
        <td style="text-align: center; vertical-align: middle">
            <?php
            form_select_semtitulo("pit_item_$num_linha_tabela_pit", "", "", "inspencao_dimensional,Inspenção dimensional:inspencao_visual,Inspenção visual");
            ?>
        </td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('rq_'.$num_linha_tabela_pit); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('na_'.$num_linha_tabela_pit); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('hp_'.$num_linha_tabela_pit); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('hpc_'.$num_linha_tabela_pit); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('rd_'.$num_linha_tabela_pit); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('efc_'.$num_linha_tabela_pit); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('ri_'.$num_linha_tabela_pit); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('pm_'.$num_linha_tabela_pit); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('db_'.$num_linha_tabela_pit); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_input_textarea_no_label('normas_'.$num_linha_tabela_pit, 250, 2) ?></td>
        <td style="text-align: center; vertical-align: middle">
            <button 
                type="button" title="Remover Elemento"
                class="btn btn-outline btn-danger btn-xs btn_exclui_linha_pit">
                <span> <i class="fa fa-times"></i></span>
            </button>
        </td>
    </tr>
    <?php
} 
else if (isset($_POST['novaLinhaDoc'])) {
    $num_linha_tabela_doc = $_POST['novaLinhaDoc'];
    ?>
    <tr id="linha_doc_anexo_<?php echo $num_linha_tabela_doc; ?>">
        <td><?php form_input_text_semtitulo("nome_doc_$num_linha_tabela_doc", '', '40', '', ''); ?></td>
        <td><?php form_select_semtitulo("tipo_documento_$num_linha_tabela_doc", "", "", "desenho,Desenho:pit,Pit:ieis,IEIS:procedimento,Procedimento"); ?></td>
        <td><?php form_input_file_semtitulo("doc_$num_linha_tabela_doc",'1'); ?></td>
        <td>
            <button title="Remover Elemento"
                type="button"
                style="margin-top: 7px;"
                class="btn btn-outline btn-danger btn-xs btn_exclui_linha_doc">
                <span><i class="fa fa-times"></i></span>
            </button>
        </td>
    </tr>
    <?php
}
else if (isset($_POST['novaLinhaCertDigitMat'])){
    $num_linha_tabela_cert_digit = $_POST['novaLinhaCertDigitMat'];
    ?>
    <tr>
        <td><?php form_input_file_semtitulo('arq_cert_digitalizado_mat_'.$num_linha_tabela_cert_digit,'0'); ?></td>
        <td>
            <button title="Remover Elemento"
                type="button"
                style="margin-top: 7px;"
                class="btn btn-outline btn-danger btn-xs btn_exclui_linha_cert_digit">
                <span><i class="fa fa-times"></i></span>
            </button>
        </td>
    </tr>
    <?php    
}
else if (isset($_POST['novaLinhaCertDigitInst'])){
    $num_linha_tabela_cert_digit = $_POST['novaLinhaCertDigitInst'];
    ?>
    <tr>
        <td><?php form_input_file_semtitulo('arq_cert_digitalizado_inst_'.$num_linha_tabela_cert_digit,'0'); ?></td>
        <td>
            <button title="Remover Elemento"
                type="button"
                style="margin-top: 7px;"
                class="btn btn-outline btn-danger btn-xs btn_exclui_linha_cert_digit">
                <span><i class="fa fa-times"></i></span>
            </button>
        </td>
    </tr>
    <?php    
}
else if (isset($_POST['novaLinhaDesenhoEP'])) {
    $num_linha_tabela_desenhoEP = $_POST['novaLinhaDesenhoEP'];
    ?>
    <tr id="linha_ep_desenho_<?php echo $num_linha_tabela_desenhoEP; ?>">
        <td><?php form_input_text_semtitulo('ep_des_num_desenho_'.$num_linha_tabela_desenhoEP,"","20","","1"); ?></td>
        <td><?php form_input_text_semtitulo('ep_des_num_revisao_'.$num_linha_tabela_desenhoEP,"","20","","1"); ?></td>
        <td><?php form_input_text_semtitulo_leitura('ep_des_peso_'.$num_linha_tabela_desenhoEP,"","14",""); ?></td>
        <td style="text-align: center; vertical-align: middle">
            <button title="Remover Desenho" type="button"
                class="btn btn-outline btn-danger btn-xs btn_exclui_desenho_ep">
                <span><i class="fa fa-times"></i></span>
            </button>
            <button title="Insere Desenho" type="button" 
                class="btn btn-outline btn-success btn-xs addLinhaDesenhoEP">
                <span><i class="fa fa-plus"></i></span>
            </button>
        </td>
    </tr>
    <?php
}
else if (isset($_POST['novaLinhaPosicaoEP'])) {
    $num_linha_tabela_posicaoEP = $_POST['novaLinhaPosicaoEP'];
    ?>
    <tr id="linha_ep_posicao_<?php echo $num_linha_tabela_posicaoEP; ?>">
        <td> <?php form_select_semtitulo('ep_pos_num_desenho_'.$num_linha_tabela_posicaoEP, "", "", "512-175-455-9,512-175-455-9:1025-1258-1010,1025-1258-1010"); ?></td>
        <td> <?php form_input_text_semtitulo('ep_pos_descricao_'.$num_linha_tabela_posicaoEP,"","100","",""); ?> </td>
        <td style="text-align: center; vertical-align: middle; width: 15%"> <?php form_input_text_semtitulo('ep_pos_posicao_'.$num_linha_tabela_posicaoEP,"","50","",""); ?> </td>
        <td style="text-align: center; vertical-align: middle; width: 10%"> <?php form_input_text_semtitulo_number_tbl('ep_pos_quantidade_'.$num_linha_tabela_posicaoEP,"","20","","");?> </td>
        <td style="text-align: center; vertical-align: middle; width: 15%"> <?php form_input_text_semtitulo_masc('ep_pos_peso_unit_'.$num_linha_tabela_posicaoEP,"","14","","mep");?> </td>
        <td style="text-align: center; vertical-align: middle; width: 15%"> <?php form_input_text_semtitulo_leitura_masc('ep_pos_peso_total_'.$num_linha_tabela_posicaoEP,"","14","");?> </td>
        <td style="text-align: center; vertical-align: middle">
            <button title="Remover Elemento" type="button" 
                class="btn btn-outline btn-danger btn-xs btn_exclui_posicao_ep">
                <span><i class="fa fa-times"></i></span>
            </button>
            <button title="Insere Posição" type="button" 
                class="btn btn-outline btn-success btn-xs addLinhaPosicaoEP">
                <span><i class="fa fa-plus"></i></span>
            </button>
        </td>
    </tr>
    <?php
}
else if (isset($_POST['novaLinhaItemEP'])) {
    $num_linha_tabela_itemEP = $_POST['novaLinhaItemEP'];
    ?>
    <tr id="linha_ep_item_<?php echo $num_linha_tabela_itemEP; ?>">
        <td> <?php form_select_semtitulo('ep_itens_pos_'.$num_linha_tabela_itemEP, "", "", "4A,4A:5A,5A:6A,6A"); ?></td>
        <td> <?php form_input_text_semtitulo('ep_itens_cod_item_'.$num_linha_tabela_itemEP,"","100","",""); ?> </td>
        <td> <?php form_input_text_semtitulo('ep_itens_material_'.$num_linha_tabela_itemEP,"","20","",""); ?> </td>
        <td style="text-align: center; vertical-align: middle; width: 10%"> <?php form_select_semtitulo('ep_itens_espessura_material_'.$num_linha_tabela_itemEP, "", "", "4A,4A:5A,5A:6A,6A"); ?> </td>
        <td style="text-align: center; vertical-align: middle; width: 15%"> <?php form_select_semtitulo('ep_itens_categoria_'.$num_linha_tabela_itemEP, "", "", "astm36,ASTM36:astm37,ASTM37:astm38,ASTM38"); ?></td>
        <td style="text-align: center; vertical-align: middle; width: 15%"> <?php form_select_semtitulo('ep_itens_cert_material_'.$num_linha_tabela_itemEP,"","","astm36,ASTM36:astm37,ASTM37:astm38,ASTM38");?></td>
        <td style="text-align: center; vertical-align: middle">
            <button title="Remover Ítem" type="button" 
                class="btn btn-outline btn-danger btn-xs btn_exclui_item_ep">
                <span><i class="fa fa-times"></i></span>
            </button>
            <button title="Insere Ítem" type="button" 
                class="btn btn-outline btn-success btn-xs addLinhaItemEP">
                <span><i class="fa fa-plus"></i></span>
            </button>
        </td>
    </tr>
    <?php
}
else if (isset($_POST['novaQualificacao'])) {
    $num_linha_qualificacao = $_POST['novaQualificacao'];
    $num_linha_qualificacao++;
    $tam = strlen($num_linha_qualificacao);
    ?>
    <div class="panel panel-default" id="qualificacao_<?php echo $num_linha_qualificacao;?>">
        <div class="panel-heading" role="tab" id="heading_<?php echo $num_linha_qualificacao;?>">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $num_linha_qualificacao;?>" aria-expanded="false" aria-controls="collapse_<?php echo $num_linha_qualificacao;?>">
                <?php echo "Qualificação ".$num_linha_qualificacao; ?>
            </a>
            <button class="btn label label-danger apagar_qualificacao" disabled type="button" id="apagar_qualificacao">Apagar</button>
            <button class="btn label label-warning atualizar_qualificacao" type="button" id="atualizar_qualificacao" style="display: none">Editar</button>
            <button class="btn label label-success salvar_qualificacao" type="button" id="salvar_qualificacao">Salvar</button>
        </div>
        <div id="collapse_<?php echo $num_linha_qualificacao;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?php echo $num_linha_qualificacao;?>">
            <div class="panel-body">
                <?php 
                form_input_text("Nº Certificado",'num_cert_sold_soldador_'.$num_linha_qualificacao,"","20","3","","1");
                form_input_data("Data Certificado",'dt_certificado_soldador_'.$num_linha_qualificacao,"3","1");
                form_select_addelem("Norma Aplicável",'norma_aplicavel_soldador_'.$num_linha_qualificacao,"","","ASME IX,ASME IX:AWS D1.1,AWS D1.1","3","1");
                form_select("EPS",'eps_soldador_'.$num_linha_qualificacao,"","","eps1,EPS1:eps2,EPS2:eps3,EPS3","2","1");?>
                <div style="clear: both"></div>
                <?php
                form_input_text("Código RQS",'cd_rqs_soldador_'.$num_linha_qualificacao,"","20","3","","1");
                form_input_file("RQS", 'arq_rqs_soldador_'.$num_linha_qualificacao,"5","1");
                form_input_data("Vencimento da Qualificação",'dt_venc_qualificacao_soldador_'.$num_linha_qualificacao,"3","1");?>
                <div style="clear: both"></div>
                <?php
                form_select("RQPS",'rqps_soldador_'.$num_linha_qualificacao,"","","rqps1,RQPS1:rqps2,RQPS2:rqps3,RQPS3","2","1");
                form_select("Processo de Soldagem",'procsold_soldador_'.$num_linha_qualificacao,"","","smaw,SMAW:gtaw,GTAW:gmaw,GMAW:fcaw,FCAW:saw,SAW:na,NA","3","1");
                form_input_text("Nº P",'numP_soldador_'.$num_linha_qualificacao,"","50","2","","1");
                form_input_text("Nº F",'numF_soldador_'.$num_linha_qualificacao,"","50","2","","1");
                form_checkbox("Posição",'posicao_soldador_'.$num_linha_qualificacao,"1G/1F:2G/2F:3G/3F:4G/4F:5G/5F:6G:G:F", "1G/1F:2G/2F:3G/3F:4G/4F:5G/5F:6G:G:F","N:N:N:N:N:N:N:N","6");
                form_select("Espessura(mm)",'espessura_soldador_'.$num_linha_qualificacao,"","","T &ge;,T &ge;:T &gt;,T &gt;:T &le;,T &le;:T &lt;,T &lt;:ilimitado,Ilimitado", "2","1");
                form_input_text_semtitulo_number("vl_espessura_soldador_".$num_linha_qualificacao,"","2","1","margin-top: 25px;","");
                form_select("Diâmetro Ext.(mm)",'diametro_soldador_'.$num_linha_qualificacao,"","","T &ge;,T &ge;:T &gt;,T &gt;:T &le;,T &le;:T &lt;,T &lt;:ilimitado,Ilimitado", "2","1");
                form_input_text_semtitulo_number('vl_diametro_soldador_'.$num_linha_qualificacao,"","2","1","margin-top: 25px;","");?>
                <div style="clear: both"></div>
                <?php
                form_select("Corrente/Polaridad.",'corrente_popularidade_soldador_'.$num_linha_qualificacao,"","","CC+,CC+:CC-,CC-:CA,CA:NA,NA","3","1");
                form_select("Progressão",'progressao_soldador_'.$num_linha_qualificacao,"","","ASC,ASC:DSC,DSC:NA,NA","3","1");
                form_checkbox("Cobre Junta",'cobrejunta_soldador_'.$num_linha_qualificacao,"COM:SEM:NA","COM:SEM:NA","N:N:N","3");
                form_input_text("Gás de Purga",'gaspurga_soldador_'.$num_linha_qualificacao,"","20","3","","1");
                form_input_textarea('Observações_soldador_'.$num_linha_qualificacao,"obs_pit","12","2","1");
                ?>
            </div>
        </div>
    </div>
    <?php
}
else if (isset($_POST['novaLinhaMapJuntaSolda'])) {
    $num_linha_map_junta_solda = $_POST['novaLinhaMapJuntaSolda'];
    ?>
    <tr id="linha_map_junta_solda_<?php echo $num_linha_map_junta_solda; ?>">
        <td style="text-align: center; vertical-align: middle"><?php form_select_semtitulo("item_desenho_1_$num_linha_map_junta_solda", "", "", "1,1:2,2:3,3:4,4:5,5:6,6:7,7");?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_select_semtitulo("item_desenho_2_$num_linha_map_junta_solda", "", "", "1,1:2,2:3,3:4,4:5,5:6,6:7,7");?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_select_semtitulo("tipo_junta_$num_linha_map_junta_solda", "", "", "1,1:2,2:3,3:4,4:5,5:6,6:7,7");?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_select_semtitulo("material_1_$num_linha_map_junta_solda", "", "", "310H,310H:A516,A516");?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_select_semtitulo("material_2_$num_linha_map_junta_solda", "", "", "310H,310H:A516,A516");?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_select_semtitulo("espessura_1_$num_linha_map_junta_solda", "", "", "16,16:1/2'',1/2''"); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_select_semtitulo("espessura_2_$num_linha_map_junta_solda", "", "", "16,16:1/2'',1/2''");?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_select_semtitulo("chanfro_$num_linha_map_junta_solda", "", "", "60,60:N,N");?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_select_semtitulo("filete_$num_linha_map_junta_solda", "", "", "NA,NA:4,4");?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('evs_'.$num_linha_map_junta_solda); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('lp_'.$num_linha_map_junta_solda); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('us_'.$num_linha_map_junta_solda); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('er_'.$num_linha_map_junta_solda); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_checkbox_semtitulo('ed_'.$num_linha_map_junta_solda); ?></td>
        <td style="text-align: center; vertical-align: middle"><?php form_input_text_semtitulo("sinete_$num_linha_map_junta_solda","","","","");?></td>
        <td style="text-align: center; vertical-align: middle">
            <button title="Remover Elemento"
                type="button" 
                class="btn btn-outline btn-danger btn-xs btn_exclui_linha_mapa_junta_solda">
                <span><i class="fa fa-times"></i></span>
            </button>
        </td>
    </tr>
    <?php
}
else if (isset($_POST['novaLinhaMJSDigit'])){
    $num_linha_MJSDigit = $_POST['novaLinhaMJSDigit'];
    ?>
    <tr>
        <td><?php form_input_file_semtitulo('arq_mjs_digit_'.$num_linha_MJSDigit,'0'); ?></td>
        <td>
            <button title="Remover Elemento"
                type="button"
                style="margin-top: 7px;"
                class="btn btn-outline btn-danger btn-xs btn_exclui_linha_mjs_digit">
                <span><i class="fa fa-times"></i></span>
            </button>
        </td>
    </tr>
    <?php    
}
else if (isset($_POST['novaLinhaHistoricoIEIS'])) {
    $num_linha_tbl_historico_ieis = $_POST['novaLinhaHistoricoIEIS'];
    ?>
    <tr id="linha_historico_ieis_<?php echo $num_linha_tbl_historico_ieis; ?>">
        <td style="text-align: center; vertical-align: middle;"><?php echo date("d/m/Y"); ?></td>
        <td><?php form_input_file_semtitulo('arq_ieis_'.$num_linha_tbl_historico_ieis,'0'); ?></td>
        <td style="text-align: center; vertical-align: middle">
            <button title="Remover Desenho" type="button"
                class="btn btn-outline btn-danger btn-xs btn_exclui_ieis">
                <span><i class="fa fa-times"></i></span>
            </button>
            <button title="Insere Desenho" type="button" 
                class="btn btn-outline btn-success btn-xs addLinhaIEIS">
                <span><i class="fa fa-plus"></i></span>
            </button>
        </td>
    </tr>
    <?php
}
else if (isset($_POST['novaLinhaDSDigit'])){
    $num_linha_DSDigit = $_POST['novaLinhaDSDigit'];
    ?>
    <tr>
        <td><?php form_input_file_semtitulo('arq_ds_digit_'.$num_linha_DSDigit,'0'); ?></td>
        <td>
            <button title="Remover Elemento"
                type="button"
                style="margin-top: 7px;"
                class="btn btn-outline btn-danger btn-xs btn_exclui_linha_ds_digit">
                <span><i class="fa fa-times"></i></span>
            </button>
        </td>
    </tr>
    <?php    
}?>