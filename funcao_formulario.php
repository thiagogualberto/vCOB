<?php
//include 'conexaoBD.php';
//INÍCIO DO FORMULÁRIO
function form_inicio($nome, $method, $action, $enctype){?>
    <form id="<?php echo $nome ?>" name="<?php echo $nome ?>" enctype="<?php echo $enctype ?>" 
          method="<?php echo $method ?>" class="form" action="<?php echo $action ?>">
<?php
}

//FIM DO FORMULÁRIO
function form_fim(){?>
    </form>
<?php
}

//BOTÕES DO FORMULÁRIO
/*Função para criar um botão do tipo submit*/
function form_btn_submit($nm_botao){?>
    <button type="submit" id="<?php echo $nm_botao ?>" name="<?php echo $nm_botao ?>" class="btn btn-primary"><?php echo $nm_botao ?></button>
    <?php
}

/*Função para criar um botão do tipo reset*/
function form_btn_reset($nm_botao){?>
    <button type="reset" class="btn btn-primary" ><?php echo $nm_botao ?></button><?php
}

/*Função para criar um botão do tipo voltar*/
function form_btn_voltar($nm_botao,$caminho){?>
    <a href = "<?php echo $caminho;?>" class="btn btn-primary"><?php echo $nm_botao;?></a><?php
}

/*Função para criar um botão*/
function form_btn($tipo,$nm_botao,$nome){?>
    <button 
        type="<?php echo $tipo; ?>" name="<?php echo $nm_botao; ?>" id="<?php echo $nm_botao; ?>"
        class="btn btn-primary" ><?php echo $nome ?>
    </button><?php
}

function form_botao($tipo, $nome, $texto){?>
    <button type="<?php echo $tipo; ?>" name="<?php echo $nome; ?>" id="<?php echo $nome; ?>" 
            class="btn btn-lg btn-success btn-block"> <?php if ($texto != "") echo $texto; ?>
    </button>
<?php
}

/*Função para criar um botão do tipo voltar*/
function form_btn_fechar_modal($nm_botao){?>
    <button class="btn btn-primary" data-dismiss="modal"><?php echo $nm_botao ?>
    </button><?php
}


//FUNÇÕES DO FORMULÁRIO (CAMPOS DO FORMULÁRIO)
/*Função para criar um campo do formulário do tipo input*/
function form_input_text($titulo,$nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$classe,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        <input 
            type="text" 
            class="form-control <?php echo $classe ?>" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>
            placeholder="<?php echo $titulo ?>"
            style="<?php echo $style; ?>">
    </div><?php
}

/*Função para criar um campo do formulário do tipo input com o label e campo na mesma linha*/
function form_input_text2($titulo,$nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$obrigatorio){?>
    <div class="form-inline">
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        <input 
            type="text" 
            class="form-control" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>
            placeholder="<?php echo $titulo ?>"
            style="<?php echo $style; ?>">
    </div><?php
}

/*Função para criar um campo do formulário do tipo input*/
function form_input_text_botao($titulo,$nome,$nm_botao,$valor_padrao,$tamanho,$tamanho_campo,$style,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        <input 
            type="text" 
            class="form-control" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>
            placeholder="<?php echo $titulo ?>"
            style="<?php echo $style; ?>">
        <button type="submit" id="<?php echo $nm_botao ?>" class="btn btn-primary"><?php echo $nm_botao ?></button>
        
    </div><?php
}

/*Função para criar um campo do formulário do tipo input desabilitado*/
function form_input_text_leitura($titulo,$nome,$valor_padrao,$tamanho,$tamanho_campo,$style){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label>
            <?php echo $titulo; ?>
        </label>
        <input 
            type="text" 
            class="form-control" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            readonly="readonly"
            style="<?php echo $style; ?>">
    </div><?php
}

/*Função para criar um campo do formulário do tipo input text SEM TÍTULO*/
function form_input_text_semtitulo($nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$leitura,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">    
        <input 
            type="text" 
            class="form-control" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } 
            if ($leitura == '1'){?>
                readonly
            <?php } ?>
            style="<?php echo $style; ?>">
    </div><?php
}

/*Função para criar um campo do formulário do tipo input desabilitado*/
function form_input_text_semtitulo_leitura($nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">    
        <input 
            type="text" 
            class="form-control" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>
            readonly
            style="<?php echo $style; ?>">
    </div><?php
}

/*Função para criar um campo do formulário do tipo input text SEM TÍTULO*/
function form_input_text_semtitulo_number($nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">    
        <input 
            type="text" 
            class="form-control sonums" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>
            style="<?php echo $style; ?>">
    </div><?php
}

/*Função para criar um campo do formulário do tipo input text SEM TÍTULO*/
function form_input_text_semtitulo_number_tbl($nome,$valor_padrao,$tamanho,$style,$obrigatorio){?>
    <input 
        type="text" 
        class="form-control sonums" 
        id="<?php echo $nome ?>" 
        name="<?php echo $nome ?>"
        value="<?php echo $valor_padrao ?>"
        maxlength="<?php echo $tamanho ?>"
        <?php 
        if ($obrigatorio == '1') {?> 
            required="required" 
        <?php } ?>
        style="<?php echo $style; ?>"><?php
}

/*Função para criar um campo do formulário do tipo input*/
function form_input_text_senha($titulo,$nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        <input 
            type="password" 
            class="form-control" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>
            placeholder="<?php echo $titulo ?>"
            style="<?php echo $style; ?>">
    </div><?php
}

/*Função para criar um campo do formulário do tipo input*/
function form_input_text_masc($titulo,$nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$mascara,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label class="col-sm-1 control-label">
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        <div class="col-sm-3">
            <input 
                type="text" 
                class="form-control" 
                id="<?php echo $nome ?>" 
                name="<?php echo $nome ?>"
                value="<?php echo $valor_padrao ?>"
                maxlength="<?php echo $tamanho ?>"
                onkeypress="mascara( this, <?php echo $mascara ?>);"
                <?php if ($obrigatorio == '1') {?> required="required" <?php } ?>
                placeholder="<?php echo $titulo ?>"
                style="<?php echo $style; ?>">
        </div>
    </div><?php
}

/*Função para criar um campo do formulário do tipo input desabilitado*/
function form_input_text_leitura_masc($titulo,$nome,$valor_padrao,$tamanho,$tamanho_campo,$style){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label class="col-sm-1 control-label">
            <?php echo $titulo; ?>
        </label>
        <div class="col-sm-3">
            <input 
                type="text" 
                class="form-control" 
                id="<?php echo $nome ?>" 
                name="<?php echo $nome ?>"
                value="<?php echo $valor_padrao ?>"
                maxlength="<?php echo $tamanho ?>"
                disabled="disabled"
                style="<?php echo $style; ?>">
        </div>
    </div><?php
}

function form_input_text_semtitulo_masc($nome,$valor_padrao,$tamanho,$style,$mascara){?>
    <input 
        type="text" class="form-control" 
        id="<?php echo $nome ?>" 
        name="<?php echo $nome ?>"
        value="<?php echo $valor_padrao ?>"
        maxlength="<?php echo $tamanho ?>"
        onkeypress="mascara( this, <?php echo $mascara ?>);"
        style="<?php echo $style; ?>"><?php
}

function form_input_text_semtitulo_leitura_masc($nome,$valor_padrao,$tamanho,$style){?>
    <input 
        type="text" class="form-control" 
        id="<?php echo $nome ?>" 
        name="<?php echo $nome ?>"
        value="<?php echo $valor_padrao ?>"
        maxlength="<?php echo $tamanho ?>"
        disabled="disabled"
        style="<?php echo $style; ?>"><?php
}

/*Função para criar um campo do formulário do tipo input*/
function form_input_text_number($titulo,$nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        <input 
            type="text" 
            class="form-control sonums" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>
            placeholder="<?php echo $titulo ?>"
            style="<?php echo $style; ?>">
    </div><?php
}

/*Função para criar um campo do formulário do tipo input para o autocomplete*/
function form_input_text_autocomplete($titulo,$nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$classe,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        
        <input 
            type="text"
            class="form-control <?php echo $classe ?>" 
            id="inputString" 
            name="<?php echo $nome ?>"
            value="<?php echo $valor_padrao ?>"
            maxlength="<?php echo $tamanho ?>"
            onKeyUp="lookup(this.value,'<?php echo $nome ?>','<?php echo $_SESSION["chave_empresa"] ?>');" 
            onBlur="fill();" 
            <?php //ARRUMAR A QUESTÃO DO AUTOCOMPLETE DO SISTEMA+
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>
            placeholder="<?php echo $titulo ?>"
            style="<?php echo $style; ?>"
            autocomplete="off">
				
        <div class="tt-menu tt-open" id="suggestions" style="display: none;">
            <div class="tt-dataset" id="autoSuggestionsList">
            </div>
        </div>
    </div><?php
}

/*Função para criar um campo do formulário do tipo Select*/
function form_select($titulo, $nome, $valor_padrao, $tipo_dado, $dado, $tamanho_campo, $obrigatorio){
    global $con;?>
    <div class="form-group col-lg-<?php echo $tamanho_campo; ?>">
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        <select class="form-control" name="<?php echo $nome;?>" id="<?php echo $nome;?>">
            <?php
            if ($tipo_dado == "SQL"){
		$qry_select = mysqli_query($con,$dado);
		while ($res_select = mysqli_fetch_array($qry_select)){
                    if ($res_select[0]==$valor_padrao)  $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $res_select[0] ?>" <?php echo $sel ?>><?php echo ($res_select[1]); ?></option>
                    <?php
		}
            }
            else{
                $linha = explode(":",$dado);
                //echo ': '.."<br>";
                echo 'dado: '.$dado."<br><br>";
                print_r($linha);
                $qd = count($linha);
                echo 'qd: '.$qd."<br>";
                for ($x=0;$x<$qd;$x++){
                    $dados = explode(",",$linha[$x]);
                    echo 'dados[0]: '.$dados[0]."<br>";
                    echo 'dados[1]: '.$dados[1]."<br>";
                    if ($dados[0] == $valor_padrao)     $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $dados[0];?>" <?php echo $sel ?>> <?php echo ($dados[1]);?> </option>
                    <?php							
                }
            }?>
        </select>
    </div><?php
}

/*Função para criar um campo do formulário do tipo Select com o "mais" como opção para add novos elementos*/
function form_select_addelem($titulo, $nome, $valor_padrao, $tipo_dado, $dado, $tamanho_campo, $obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo; ?>">
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
            <button data-toggle="modal" data-target="#modal<?php echo $nome;?>" title="Adicionar <?php echo $titulo;?>" type="button" 
                    class="btn btn-outline btn-success btn-xs">
                <span><i class="fa fa-plus"></i></span>
            </button>
        </label>
        <select class="form-control" name="<?php echo $nome;?>" id="<?php echo $nome;?>">
            <?php
            if ($tipo_dado == "SQL"){
		$qry_select = mysql_query($dado,$con);
		while ($res_select = mysql_fetch_array($qry_select)){
                    if ($res_select[0]==$valor_padrao)  $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $res_select[0] ?>" <?php echo $sel ?>><?php echo ($res_select[1]); ?></option>
                    <?php
		}
            }
            else{
                $linha = explode(":",$dado);
                //echo ': '.."<br>";
                echo 'dado: '.$dado."<br><br>";
                print_r($linha);
                $qd = count($linha);
                echo 'qd: '.$qd."<br>";
                for ($x=0;$x<$qd;$x++){
                    $dados = explode(",",$linha[$x]);
                    echo 'dados[0]: '.$dados[0]."<br>";
                    echo 'dados[1]: '.$dados[1]."<br>";
                    if ($dados[0] == $valor_padrao)     $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $dados[0];?>" <?php echo $sel ?>> <?php echo ($dados[1]);?> </option>
                    <?php							
                }
            }?>
        </select>
    </div><?php
}

/*Função para criar um campo do formulário do tipo Select sem título*/
function form_select_semtitulo($nome, $valor_padrao, $tipo_dado, $dado,$tamanho_campo){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo; ?>">
        <select class="form-control" name="<?php echo $nome;?>" id="<?php echo $nome;?>">
            <?php
            if ($tipo_dado == "SQL"){
                $qry_select = mysql_query($dado,$con);
                while ($res_select = mysql_fetch_array($qry_select)){
                    if ($res_select[0]==$valor_padrao)  $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $res_select[0] ?>" <?php echo $sel ?>><?php echo ($res_select[1]); ?></option>
                    <?php
                }
            }
            else{
                $linha = explode(":",$dado);
                //echo ': '.."<br>";
                echo 'dado: '.$dado."<br><br>";
                print_r($linha);
                $qd = count($linha);
                echo 'qd: '.$qd."<br>";
                for ($x=0;$x<$qd;$x++){
                    $dados = explode(",",$linha[$x]);
                    echo 'dados[0]: '.$dados[0]."<br>";
                    echo 'dados[1]: '.$dados[1]."<br>";
                    if ($dados[0] == $valor_padrao)     $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $dados[0];?>" <?php echo $sel ?>> <?php echo ($dados[1]);?> </option>
                    <?php							
                }
            }?>
        </select>
    </div><?php
}

function form_select_semtitulo_horizontal($nome, $valor_padrao, $tipo_dado, $dado,$tamanho_campo){?>
    <div class="form-horizontal col-lg-<?php echo $tamanho_campo; ?>">
        <select class="form-control" name="<?php echo $nome;?>" id="<?php echo $nome;?>">
            <?php
            if ($tipo_dado == "SQL"){
                $qry_select = mysql_query($dado,$con);
                while ($res_select = mysql_fetch_array($qry_select)){
                    if ($res_select[0]==$valor_padrao)  $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $res_select[0] ?>" <?php echo $sel ?>><?php echo ($res_select[1]); ?></option>
                    <?php
                }
            }
            else{
                $linha = explode(":",$dado);
                //echo ': '.."<br>";
                //echo 'dado: '.$dado."<br><br>";
                print_r($linha);
                $qd = count($linha);
                //echo 'qd: '.$qd."<br>";
                for ($x=0;$x<$qd;$x++){
                    $dados = explode(",",$linha[$x]);
                    //echo 'dados[0]: '.$dados[0]."<br>";
                    //echo 'valor_padrao: '.$valor_padrao."<br>";
                    //echo 'dados[1]: '.$dados[1]."<br>";
                    if ($dados[0] == $valor_padrao)     $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $dados[0];?>" <?php echo $sel ?>> <?php echo ($dados[1]);?> </option>
                    <?php							
                }
            }?>
        </select>
    </div><?php
}

/*Função para criar um campo do formulário do tipo Select sem título com escritos antes e depois do combobox*/
function form_select2($antes, $depois, $valor_padrao, $tipo_dado, $dado, $tamanho_campo){?>
    <div class="form-inline">
        <?php echo $antes; ?>
        <select class="form-control" name="<?php echo $antes.'_'.$depois;?>" id="<?php echo $nome;?>">
            <?php
            if ($tipo_dado == "SQL"){
		$qry_select = mysql_query($dado,$con);
		while ($res_select = mysql_fetch_array($qry_select)){
                    if ($res_select[0]==$valor_padrao)  $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $res_select[0] ?>" <?php echo $sel ?>><?php echo ($res_select[1]); ?></option>
                    <?php
		}
            }
            else{
                $linha = explode(":",$dado);
                //echo ': '.."<br>";
                echo 'dado: '.$dado."<br><br>";
                print_r($linha);
                $qd = count($linha);
                echo 'qd: '.$qd."<br>";
                for ($x=0;$x<$qd;$x++){
                    $dados = explode(",",$linha[$x]);
                    echo 'dados[0]: '.$dados[0]."<br>";
                    echo 'dados[1]: '.$dados[1]."<br>";
                    if ($dados[0] == $valor_padrao)     $sel = "selected";
                    else    $sel = "";?>
                    <option value="<?php echo $dados[0];?>" <?php echo $sel ?>> <?php echo ($dados[1]);?> </option>
                    <?php							
                }
            }?>
        </select>
        <?php echo $depois; ?>
    </div><?php
}

/*Função para criar um campo do formulário do tipo Checkbox*/
function form_checkbox($titulo, $nome, $opcoes, $labels, $indicesmarcados, $tamanho_campo){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo; ?>">
        <label><?php echo $titulo ?></label>
        <div class="checkbox">
            <?php
                $dados = explode(":",$opcoes);
		$texto = explode(":",$labels);
                $indice = explode(":",$indicesmarcados);
		$qd = count($dados);
		for ($x=0;$x<$qd;$x++){?>
                    <label>
                        <input type="checkbox" 
                                   name="<?php echo $nome ?>_<?php echo $dados[$x] ?>" 
                                   id="<?php echo $nome ?>_<?php echo $dados[$x] ?>" 
                                   value="<?php echo $dados[$x] ?>"
                                   <?php if ($indice[$x] == "S") echo "checked"; ?>/>
                            <?php echo $texto[$x];?>
                    </label><?php
                }?>
        </div>  
    </div><?php
}

/*Função para criar um campo do formulário do tipo Checkbox*/
function form_checkbox_semtitulo($nome, $opcoes, $labels, $indicesmarcados, $tamanho_campo,$eventos){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo; ?>">
        <div class="checkbox">
            <?php
                $dados = explode(":",$opcoes);
		$texto = explode(":",$labels);
                $indice = explode(":",$indicesmarcados);
		$qd = count($dados);
		for ($x=0;$x<$qd;$x++){?>
                    <label>
                        <input type="checkbox" 
                                   name="<?php echo $nome ?>" 
                                   id="<?php echo $nome ?>" 
                                   value="<?php echo $dados[$x] ?>"
                                   <?php if ($indice[$x] == "S") echo "checked"; 
                                   echo $eventos;?>/>
                            <?php echo $texto[$x];?>
                    </label><?php
                }?>
        </div>  
    </div><?php
}

/*Função para criar um campo do formulário do tipo Checkbox*/
function form_checkbox_semformat($nome, $opcoes, $labels, $indicesmarcados, $eventos){
    $dados = explode(":",$opcoes);
    $texto = explode(":",$labels);
    $indice = explode(":",$indicesmarcados);
    $qd = count($dados);
    for ($x=0;$x<$qd;$x++){?>
        <label>
            <input type="checkbox" 
                   name="<?php echo $nome ?>" 
                   id="<?php echo $nome ?>" 
                   value="<?php echo $dados[$x] ?>"
                   <?php if ($indice[$x] == "S") echo "checked"; 
                   echo $eventos;?>/>
                <?php echo $texto[$x];?>
        </label><?php
    }
}

/*Função para criar um campo do formulário do tipo radio*/
function form_radio($titulo, $nome, $opcoes, $labels, $valor_padrao, $tamanho_campo){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo; ?>">
        <label><?php echo $titulo;?></label>
        <div class="radio">
            <?php
            $dados = explode(":",$opcoes);
            $texto = explode(":",$labels);
            $qd = count($dados);
            for ($x=0;$x<$qd;$x++){
		if ($dados[$x] == $valor_padrao)    $sel = "checked";
		else    $sel = "";
		if (($x==0)&&($valor_padrao=="")) $sel = "checked";?>
                <label>
                    <input type="radio" 
                           name="<?php echo $nome ?>" 
                           id="<?php echo $dados[$x] ?>" 
                           value="<?php echo $dados[$x] ?>"
                           <?php echo $sel ?> 
                    />
                    <?php echo $texto[$x] ?>
                </label><?php
            }?>
        </div>
    </div><?php
}

/*Função para criar um campo do tipo arquivo e mostrar na tela a imagem*/
function form_input_file_imagem($titulo,$nome, $tamanho_campo, $valor_padrao, $obrigatorio){?>
    <div style="clear: both"></div>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label for="image_file"><?php echo $titulo ?></label>
        <input type="file" id="<?php echo $nome ?>" name="<?php echo $nome ?>" 
               onchange="fileSelected('<?php echo $nome ?>');" value="<?php //echo $valor_padrao ?>" 
               <?php if ($obrigatorio == '1') {?> required="required" <?php } ?>
        />
    </div>
    <img id="preview" src="<?php echo $valor_padrao ?>" />
    <div style="clear: both"></div>
    <div id="fileinfo">
        <div id="filename"></div>
        <div id="filesize"></div>
        <div id="filetype"></div>
        <div id="filedim"></div>
    </div>
    <div id="error" >Arquivo ou imagem inválida. A extenção do arquivo deve ser .jpg, .png ou .gif.</div>
    <div id="warnsize">Arquivo muito grande. Por favor, selecione um arquivo menor (tamanho até 1MB).</div>
<?php    
}

/*Função para criar um campo do tipo arquivo sem mostrar imagem.*/
function form_input_file($titulo, $tamanho_campo, $obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label for="file"><?php echo $titulo ?></label>
        <input type="file" id="arquivo" name="arquivo" id="arquivo"
               <?php if ($obrigatorio == '1') {?> required="required" <?php } ?>
        />
    </div>
<?php    
}

/*Função para criar um campo do tipo arquivo.*/
function form_input_file_semtitulo($nome, $obrigatorio){?>
    <input 
        type="file" 
        id="<?php echo $nome ?>" 
        name="<?php echo $nome ?>"
        <?php if ($obrigatorio == '1') {?> required="required" <?php } ?>
        />
<?php    
}

/*Função para criar um campo do formulário do tipo data.*/
function form_input_data($titulo, $nome, $valor_padrao, $tamanho_campo, $obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label><?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; ?>
        </label>
        <div class='input-group date' id='datetimepicker6'>
            <input 
                type="text" 
                class="form-control calendario" 
                id="<?php echo $nome ?>" 
                name="<?php echo $nome ?>"
                value="<?php echo $valor_padrao ?>"
                required="required">

            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
<?php 
}

function form_input_data_semtitulo($nome,$valor_padrao,$tamanho,$tamanho_campo,$style,$leitura,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <div class='input-group date' id='datetimepicker6' style="<?php echo $style; ?>">
            <input 
                type="text" 
                class="form-control calendario" 
                id="<?php echo $nome ?>" 
                name="<?php echo $nome ?>"
                value="<?php echo $valor_padrao ?>"
                required="required"
                <?php 
                if ($obrigatorio == '1') {?> 
                    required="required" 
                <?php } 
                if ($leitura == '1'){?>
                    readonly
                <?php } ?>
                >

            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
<?php 
}

/*Função para criar um campo de formulário do tipo textarea*/
function form_input_textarea($titulo, $nome, $valor_padrao, $tamanho_campo, $qtde_linhas, $obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label><?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; ?>
        </label>
        <textarea 
            class="form-control"
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            rows="<?php echo $qtde_linhas ?>"><?php echo $valor_padrao ?></textarea>
    </div>
<?php
}

/*Função para criar um campo de formulário do tipo textarea sem a label*/
function form_input_textarea_no_label($nome, $tamanho_campo, $qtde_linhas){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        
        <textarea 
            class="form-control"
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            rows="<?php echo $qtde_linhas ?>"></textarea>
    </div>
<?php
}

/*Função para criar um campo de formulário do tipo textarea com a possibilidade de incremento.*/
function form_input_textarea_incremento($titulo,$nome,$tamanho_campo,$style,$obrigatorio){?>
    <div class="form-group col-lg-<?php echo $tamanho_campo ?>">
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        <input 
            type="number" 
            class="form-control" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            value="1"
            min="1"
            max="10"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>
            style="<?php echo $style; ?>">
    </div>
<?php
}

//Função para gerar um input do tipo hidden (invisivel)
function form_input_hidden($nome,$valor_padrao){?>
    <input 
        type="hidden" 
        name="<?php echo $nome; ?>"
        id="<?php echo $nome; ?>"  
        value="<?php echo $valor_padrao; ?>"/>
<?php
}

/*Função para criar o campo captch do login*/
function form_input_captch($titulo,$nome,$tamanho_campo,$obrigatorio){?>
    <div class="form-group text-center col-md-<?php echo $tamanho_campo ?>">
        <img src="captch/captcha.php" alt="código captcha"/>
        <label>
            <?php 
            echo $titulo; 
            if ($obrigatorio == '1') echo '*'; 
            ?>
        </label>
        <input 
            type="text" 
            class="form-control" 
            id="<?php echo $nome ?>" 
            name="<?php echo $nome ?>"
            <?php 
            if ($obrigatorio == '1') {?> 
                required="required" 
            <?php } ?>>
            <div class="clearfix"></div>
            <br>
    </div>      
    <?php
}

//Função para gerar uma senha aleatória para usuário master
function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
  $ma = "ABCDEFGHIJKLMNPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
  $mi = "abcdefghijkmnopqrstuvyxwz"; // $mi contem as letras minusculas
  $nu = "23456789"; // $nu contem os números
  $si = "!@#$%¨-&*()_+="; // $si contem os símbolos
  //tirei os caracteres l(minúsculo), o,O e o 0(zero) para evitar conflito.
  $senha = "";
  
  if ($maiusculas){
        // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($ma);
  }
 
    if ($minusculas){
        // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($mi);
    }
 
    if ($numeros){
        // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($nu);
    }
 
    if ($simbolos){
        // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($si);
    }
 
    // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
    return substr(str_shuffle($senha),0,$tamanho);
}

//função para gerar o código de registro
function gera_codigo($tabela,$campo,$dir=null){
    include "conexaoBD.php";
    $sql = "select count(*) as qtd from $tabela";
    $qry = mysqli_query($con,$sql);
    $res = mysqli_fetch_array($qry);
    if ($res["qtd"] == 0){	
        return 1;
    }
    else{
        $sql = "select $campo as cod from $tabela order by $campo desc limit 1";
        $qry = mysqli_query($con,$sql);
        $res = mysqli_fetch_array($qry);
        $codigo = $res["cod"]+1;
        return $codigo;
    }
}

//função para gerar a chave de um registro de banco
function gera_chave($codigo){
    $tam_cod = strlen($codigo);
    if ($tam_cod == 1)  $codigo = '00000'.$codigo;
    else if ($tam_cod == 2)  $codigo = '0000'.$codigo;
    else if ($tam_cod == 3)  $codigo = '000'.$codigo;
    else if ($tam_cod == 4)  $codigo = '00'.$codigo;
    else if ($tam_cod == 5)  $codigo = '0'.$codigo;

    $chave = 'L'.$codigo.date("Y").date("m").date("d").date("H").date("i").date("s");
    return $chave;
}

//Função para limpar CPF e CNPJ
function limpaCPF_CNPJ($valor){
 $valor = trim($valor);
 $valor = str_replace(".", "", $valor);
 $valor = str_replace(",", "", $valor);
 $valor = str_replace("-", "", $valor);
 $valor = str_replace("/", "", $valor);
 return $valor;
}?>