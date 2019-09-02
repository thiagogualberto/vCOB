jQuery(function($){
    $('#formulario').validate({
        rules:{
            cpf:{validateCPF:true},
            cnpj:{validateCNPJ:true},
            email_principal:{validateMAIL:true},
            email_usuario:{validateMAIL:true},
            image_file:{validateFILE:true}
        }
    });
    
    $('.calendario').datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior',
        language: "pt-BR"
    });
    
    //Máscara para o campo CPF dos formulários
    $("#cpf").mask("999.999.999-99");

    //Máscara para o campo CNPJ dos formulários
    $("#cnpj").mask("99.999.999/9999-99");

    //Máscara para o campo CEP dos formulários
    $("#cep").mask("99.999-999");

    //Máscara para os campos DATAS dos formulários
    //$("#dt_vencimento_cobranca").mask("99/99/9999");
    
    
    //Máscara para o campo Telefone dos formulários
    //$("#telefone").mask("(99) 9999-9999");
    
    //Máscara para o campo valor (dinheiro)
    $("#vl_emissao_cobranca").maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
    $("#vl_pago_cobranca").maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
    $("#desc_vl_fixo_dt_informada").maskMoney({thousands:'.', decimal:',', symbolStay: true});
    $("#desc_diacorr_diautil").maskMoney({thousands:'.', decimal:',', symbolStay: true});
    
    //Máscara para o campo Celular dos formulários. Ela se adapta se o número possui um prefixo com 4 ou 5 dígitos
    /*$('#celular').focusout(function(){
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, ''); //remove tudo que não é dígito
        if(phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    }).trigger('focusout');*/
    
    $("input.telefone")
        .mask("(99) 9999-9999?9")
        .focusout(function (event) {  
            var target, phone, element;  
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
            phone = target.value.replace(/\D/g, '');
            element = $(target);  
            element.unmask();  
            if(phone.length > 10) {  
                element.mask("(99) 99999-999?9");  
            } else {  
                element.mask("(99) 9999-9999?9");  
            }  
        });
    
    //Campo texto aceitar somente números
    $('.sonums').keypress(function(event) {
       var tecla = (window.event) ? event.keyCode : event.which;
        if ((tecla > 47 && tecla < 58)) return true;
        else {
            if (tecla != 8) return false;
            else return true;
        }
    });
    
    //Tratamento para habilitar o campo CPF e desabilitar os campos de pessoa jurídica, insc. municipa e insc. estadual
    $('#PF').click(function(){
        $("#formulario div").eq(7).children('label:eq(0)').text("Nome");
        $("#formulario div").eq(7).children('input:eq(0)').attr({'placeholder':'Nome'});
        
        $("#cnpj").val("");
        $("#cnpj").removeAttr('required');
        $("#insc_municipal").val("");
        $("#insc_estadual").val("");
        $("#nm_fantasia").val("");
        $("#cnpj").attr('readonly','readonly');
        $("#insc_municipal").attr('readonly','readonly');
        $("#insc_estadual").attr('readonly','readonly');
        $("#nm_fantasia").attr('readonly','readonly');
        $("#cpf").removeAttr('readonly');
        $("#cpf").attr('required','required');
        $('label[for=cnpj]').remove();
        $('label[for=insc_municipal]').remove();
        $('label[for=insc_estadual]').remove();
    });
    
    //Tratamento para habilitar os campos de pessoa jurídica, insc. municipa e insc. estadual e desabilitar o campo CPF
    $('#PJ').click(function(){
        $("#formulario div").eq(7).children('label:eq(0)').text("Razão Social");
        $("#formulario div").eq(7).children('input:eq(0)').attr({'placeholder':'Razão Social'});
        
        $("#cpf").val("");
        $("#cpf").removeAttr('required');
        $("#cpf").attr('readonly','readonly');
        $("#cnpj").removeAttr('readonly');
        $("#cnpj").attr('required','required');
        $("#insc_municipal").removeAttr('readonly');
        $("#insc_estadual").removeAttr('readonly');
        $("#nm_fantasia").removeAttr('readonly');
        $('label[for=cpf]').remove();
    });
    
    $("#cnpj,#cpf").blur(function(){
        var url;
        if( ($.trim($("#cnpj").val()) != "") || ($.trim($("#cpf").val()) != "") ){
            if($.trim($("#cnpj").val()) != "")  info_cliente = $.trim($("#cnpj").val());
            else if ($.trim($("#cpf").val()) != "") info_cliente = $.trim($("#cpf").val());
            
            if (info_cliente.length == 18)  url = 'clienteVerifica.php?cnpj='+info_cliente;
            else url = 'clienteVerifica.php?cpf='+info_cliente;
            
            $.get(url, function(dataReturn) {
                dados_cnpj = JSON.parse(dataReturn);
                $('#tipo_pessoa').val(dados_cnpj.tipo_cliente);
                $('#insc_estadual').val(dados_cnpj.insc_estadual);
                $('#insc_municipal').val(dados_cnpj.insc_municipal);
                $('#nm_fantasia').val(dados_cnpj.nome_fantasia);
                $('#razao_social_nome').val(dados_cnpj.nome_razaosocial);
                $('#cep').val(dados_cnpj.cep);
                $('#tipo').val(dados_cnpj.tipo);
                $('#logradouro').val(dados_cnpj.logradouro);
                $('#numero').val(dados_cnpj.numero);
                $('#complemento').val(dados_cnpj.complemento);
                $('#bairro').val(dados_cnpj.bairro);
                $('#cidade').val(dados_cnpj.cidade);
                $('#uf').val(dados_cnpj.uf);
                $('#telefone').val(dados_cnpj.telefone);
                $('#email_principal').val(dados_cnpj.email_principal);
                $('#site').val(dados_cnpj.site);
                $('#status').val(dados_cnpj.ativo);
                $('#logomarca').val(dados_cnpj.logomarca);
                $('#nm_contato1').val(dados_cnpj.nome1);
                $('#email_contato1').val(dados_cnpj.email1);
                $('#telefone_contato1').val(dados_cnpj.telefone1);
                $('#celular_contato1').val(dados_cnpj.celular1);
                $('#nm_contato2').val(dados_cnpj.nome2);
                $('#email_contato2').val(dados_cnpj.email2);
                $('#telefone_contato2').val(dados_cnpj.telefone2);
                $('#celular_contato2').val(dados_cnpj.celular2);
            });
        }
    });
    
    //Validação do CEP para buscar os dados do endereço relacionado
    $("#cep").blur(function(){
        if($.trim($("#cep").val()) != ""){
            $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), 
            function(){
                if( (resultadoCEP["resultado"]) == '1' ){
                    $("#tipo").val(unescape(resultadoCEP["tipo_logradouro"]));
                    $("#logradouro").val(unescape(resultadoCEP["logradouro"]));
                    $("#bairro").val(unescape(resultadoCEP["bairro"]));
                    $("#cidade").val(unescape(resultadoCEP["cidade"]));
                    $("#uf").val(unescape(resultadoCEP["uf"]));
                }else{
                    alert("Não foi possivel encontrar o endereço");
                    //Coloca aqui o tratamento para mostrar a msg na tela, sem ser como alert, do erro
                }
            });             
        }
    });
    
    //Tratmento da tela de cadastro de mensagem
    i=1
    //$('#msg_linha'+i).keyup(function(){
    $('#msg_linha'+i).delegate('', 'keyup', function(){
        $("#msg_linha"+i).val();
        if ( ($("#msg_linha"+i).val().length) == 100 ){
            i++;
            $('#msg_linha'+i).focus();
        }
    });
    
    //Pega o que foi selecionado no combobox de filtrar e coloca a máscara no campo
    $("#filtrar").change(function(){
        op_filtro = $('#filtrar :selected').val();
        $("#pesquisar_cliente_empresa,#inputString").val("");
        if(op_filtro == "cpf")
            $("#pesquisar_cliente_empresa,#inputString").mask("999.999.999-99");
        else if(op_filtro == "cnpj")
            $("#pesquisar_cliente_empresa,#inputString").mask("99.999.999/9999-99");
        else    $("#pesquisar_cliente_empresa,#inputString").unmask();
    });
    
    //Atualiza o status das cobranças que foram liquidadas
    $('#desativar_cliente_empresa').click(function(){
        $("#tbl_cliente_empresa tr").eq(1).children('td:eq(8)').children().children().attr({'class':'fa fa-thumbs-o-down fa-fw'});
    });
    
    //Atualiza o status das cobranças que foram liquidadas
//    $('#liquidar').click(function(){
//        $("#tbl_cobrancas tr").eq(1).children('td:eq(6)').children().attr({'style':'color:green;'});
//    });
    
    //$("a[data-toggle='modal']").on('click', function(event){
    $("a[data-toggle='modal']").click(function(){
        var id_cobranca = $(this).data('id');
        var nm_fantasia = $(this).data('nm_fantasia');
        var dt_emissao = $(this).data('dt_emissao');
        var vl_emissao = $(this).data('vl_emissao');
        var dt_vencimento_cobranca = $(this).data('dt_vencimento');
        
        $('#id_cobranca').val(id_cobranca);
        $('#cliente').val(nm_fantasia);
        $('#dt_emissao_cobranca').val(dt_emissao);
        $('#vl_emissao_cobranca').val(vl_emissao);
        $('#dt_vencimento_cobranca').val(dt_vencimento_cobranca);
    })
          
    
    //Tratamento para mostrar os campos das instruções de cobrança.
    $("#instrucoes").change(function(){
        op_instrucoes = $('#instrucoes :selected').val();
        if(op_instrucoes == "L00000120170905201901"){
            $("#op_inst_3").css("display", "none");
            $("#op_inst_4").css("display", "none");
            $("#op_inst_2").css("display", "block");
            $("#desc_perc_dt_informada").val("");
            $("#dt_perc_dt_informada").val("");
            $("#desc_diacorr_diautil").val("");
        }
        else if(op_instrucoes == "L00000120170905201902"){
            $("#op_inst_4").css("display", "none");
            $("#op_inst_2").css("display", "none");
            $("#op_inst_3").css("display", "block");
            $("#desc_vl_fixo_dt_informada").val("");
            $("#data_vl_fixo_dt_informada").val("");
            $("#desc_diacorr_diautil").val("");
        }
        else if( (op_instrucoes == "L00000120170905201903") || (op_instrucoes == "L00000120170905201904") ){
            $("#op_inst_2").css("display", "none");
            $("#op_inst_3").css("display", "none");
            $("#op_inst_4").css("display", "block");
            $("#desc_perc_dt_informada").val("");
            $("#dt_perc_dt_informada").val("");
            $("#desc_vl_fixo_dt_informada").val("");
            $("#data_vl_fixo_dt_informada").val("");
        }
        else{
            $("#op_inst_2").css("display", "none");
            $("#op_inst_3").css("display", "none");
            $("#op_inst_4").css("display", "none");
            $("#desc_perc_dt_informada").val("");
            $("#dt_perc_dt_informada").val("");
            $("#desc_vl_fixo_dt_informada").val("");
            $("#data_vl_fixo_dt_informada").val("");
            $("#desc_diacorr_diautil").val("");
        }
    });
    
    //Tratamento para bloquear/desbloquear a 1ª opção de cobranças
    $('#cobrar1').click(function(){
        if ( $("#cobrar1").val() == "N"){
            $("#cobrar1").val("S");
            $("#cobrar1").attr('checked','checked');
            $("#porcento1").attr('required','required');
            $("#porcento1").removeAttr('readonly');
            $("#diasjuros").attr('required','required');
            $("#diasjuros").removeAttr('readonly');
        }else{
            $("#cobrar1").val("N");
            $("#cobrar1").removeAttr('checked');
            $("#porcento1").removeAttr('required');
            $("#porcento1").val("");
            $("#porcento1").attr('readonly','readonly');
            $("#diasjuros").removeAttr('required');
            $("#diasjuros").val("");
            $("#diasjuros").attr('readonly','readonly');
        } 
    });
    
    //Tratamento para bloquear/desbloquear a 2ª opção de cobranças
    $('#cobrar2').click(function(){
        if ( $("#cobrar2").val() == "N"){
            $("#cobrar2").val("S");
            $("#cobrar2").attr('checked','checked');
            $("#porcento2").attr('required','required');
            $("#porcento2").removeAttr('readonly');
            $("#diasmulta").attr('required','required');
            $("#diasmulta").removeAttr('readonly');
        }else{
            $("#cobrar2").val("N");
            $("#cobrar2").removeAttr('checked');
            $("#porcento2").removeAttr('required');
            $("#porcento2").val("");
            $("#porcento2").attr('readonly','readonly');
            $("#diasmulta").removeAttr('required');
            $("#diasmulta").val("");
            $("#diasmulta").attr('readonly','readonly');
        } 
    });
    
    //Padronizar a data no formato brasileiro
    $(".data").datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
    
    //Tratamento para gerar carnê por um botão.
    $('#gera_carne').click(function(){
        qtde_cobs = ($("#tbl_cobrancas tr").length) - 2;
        chave_cobs = new Array();
        for (i=1; i<=qtde_cobs; i++){
            chave_cobs[i-1] = $("#tbl_cobrancas tr").eq(i).attr('id');
        }
        url = 'cobrancasBoletos.php?chave_cobranca='+chave_cobs;
        
        $.get(window.open(url), function(){});
    });
    
    //tratamento para selecionar todos os elementos da tabela para gerar o arquivo de remessa
    $('#seleciona_tudo').click(function(){
       $("#tbl_remessa_cob tbody input").prop('checked', !!this.checked);
    });

    $('#gerar_remessa').click(function(){
        var chaves = $("#tbl_remessa_cob tbody input:checked").map(function() {
            return this.value;
        }).get()
        if (chaves.length > 0) {
            $('#remessa').submit();
        }
    });
    
    $('#btn_liquidar').click(function(){
        //Faz o tratamento para verificação das datas no modal de liquidar cobrança.
        var dt_emissao = $('#dt_emissao_cobranca').val();
        var dt_pgto = $('#dt_pgto_cobranca').val();
        
        var dtEmissao = dt_emissao.split("/");
        var edia = dtEmissao[0];
        var emes = dtEmissao[1];
        var eano = dtEmissao[2];
        var emissaoDate = new Date(emes +"/"+edia+"/"+eano)

        var dtPgto = dt_pgto.split("/");
        var pdia = dtPgto[0];
        var pmes = dtPgto[1];
        var pano = dtPgto[2];
        var pgtoDate = new Date(pmes +"/"+pdia+"/"+pano);
        
        if ( new Date(emissaoDate.getFullYear(), emissaoDate.getMonth(), emissaoDate.getDate()) > 
         new Date(pgtoDate.getFullYear(), pgtoDate.getMonth(), pgtoDate.getDate()) ){
            $('.msg_dt').css("display", "block");
            return false;
        }
        else    $('.msg_dt').css("display", "none");
        
        //Faz o tratamento para verificação o valor de pagamento no modal de liquidar cobrança.
        var vl_emissao_cob = $('#vl_emissao_cobranca').val();
        var vl_pago_cob = $('#vl_pago_cobranca').val();
        vl_emissao_cob = parseFloat(vl_emissao_cob.replace("R$", "").replace(/\./g,"").replace(",","."));
        vl_pago_cob = parseFloat(vl_pago_cob.replace("R$", "").replace(/\./g,"").replace(",","."));
        
        if (vl_emissao_cob > vl_pago_cob){
            $('.msg_vl').css("display", "block");
            return false;
        }
        else    $('.msg_vl').css("display", "none");
    });    
});

/*Tratamento dos módulos vinculados a uma empresa*/
function muda_opcao(opcao){
    if (opcao.value == "N") opcao.value = "S";
    else    opcao.value = "N";
}

//Função para tratamento de remover cliente de empresa do sistema
function apaga_cliente_empresa(cliente_empresa,chave_cliente_empresa){
    if(confirm("Deseja remover o cliente de empresa <b>"+cliente_empresa+"</b>?")){
        window.location = "index.php?pg=clienteEmpresaCadastra&excluir="+chave_cliente_empresa;
    }
}

//Função para tratamento de remover uma empresa do sistema
function apaga_empresa(empresa, chave) {
    if(confirm("Deseja remover a empresa "+empresa+"?")){
        window.location = "index.php?pg=empresaCadastra&excluir="+chave;
    }
}

//Função para tratamento de remover usuário do sistema
function apagausuario(nome_usuario,chave_usuario){
    if(confirm("Deseja remover o usuário "+nome_usuario+"?")){
        window.location = "index.php?pg=usuariosCadastra&excluir="+chave_usuario;
    }
}

//Função para tratamento de remover cobrança do sistema
function apagacobranca(chave_cobranca){
    if(confirm("Deseja remover a cobrança selecionada?")){
        window.location = "index.php?pg=cobrancasCadastra&excluir="+chave_cobranca;
    }
}

//Função para tratamento de desquitar uma cobrança do sistema que já foi liquidada
function desquitacobranca(chave_cobranca,filtro,pesquisa){
    if(confirm("Deseja desquitar a cobrança selecionada?")){
        window.location = "index.php?pg=cobrancas&desquitar="+chave_cobranca+"&filtrar="+filtro+"&pesquisar_cobrancas_cliente="+pesquisa;
    }
}

/*Verifica o tamanho da logo da empresa*/
function fileSelected(nome_id) {
    var iMaxFilesize = 1048576; // 1MB
    document.getElementById('error').style.display = 'none';
    document.getElementById('warnsize').style.display = 'none';
    
    //Obtem o objeto do elemento arquivo.
    //var oFile = document.getElementById('image_file').files[0];
    var oFile = document.getElementById(nome_id).files[0];
    
    var rFilter = /^(image\/gif|image\/jpeg|image\/png)$/i;
    if (!rFilter.test(oFile.type)) { //Verifica se o arquivo possui uma extensão de imagem.
        document.getElementById('error').style.display = 'block';
        document.getElementById('preview').style.display = 'none';
        return;
    }
    
    if (oFile.size > iMaxFilesize) { //Verifica o tamanho do arquivo
        document.getElementById('warnsize').style.display = 'block';
        document.getElementById('preview').style.display = 'none';
        return;
    }
    
    // Obtém o elemento de pré-visualização
    var oImage = document.getElementById('preview');
    
    // prepare HTML5 FileReader
    var oReader = new FileReader();
    oReader.onload = function(e){
        //e.target.result contém o DataURL, que serão utilizados como fonte da imagem.
        oImage.src = e.target.result;
        document.getElementById('preview').style.display = 'block';
    };
    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}

//Tratamento para o autocomplete da tela de cobrança
function lookup(inputString,modulo,chave) {
    if(inputString.length == 0) {
            $('#suggestions').hide();
    } else if (inputString.length >= 3){
        $.post("cobrancasAutocomplete.php", {
                queryString: ""+inputString+"",
                modulo_sistema: ""+modulo+"",
                chave_empresa_usuario: ""+chave+""
            }, function(data){
            if(data.length >0) {
                $('#suggestions').show();
                $('#autoSuggestionsList').html(data);
            }
        });
    }
} // lookup
function fill(thisValue) {
    $('#inputString').val(thisValue);
    setTimeout("$('#suggestions').hide();", 200);
}