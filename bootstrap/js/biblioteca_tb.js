/*Validação se o número do CPF é válido.*/
jQuery.validator.addMethod('validateCPF',function(value){
    //var digitsString = value.replace(/[^0-9]/g, '');
    var Soma;
    var Resto;
    Soma = 0;   
    strCPF  = value.replace(/[^0-9]/g, '');
    if (strCPF == "00000000000" || strCPF == "11111111111" || strCPF == "22222222222" || 
        strCPF == "33333333333" || strCPF == "44444444444" || strCPF == "55555555555" || 
        strCPF == "66666666666" || strCPF == "77777777777" || strCPF == "88888888888" || 
        strCPF == "99999999999")
            return false;
        
    //alert(strCPF+" - TESTE1");    
    /*if (!isNaN(strCPF))
        if( $("#PF").is(":checked") == true ){
            alert("PF");
        }else
            alert("PJ");*/
    if (strCPF != ""){
        for (i=1; i<=9; i++)
        Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i); 
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11)) 
            Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10)) )
            return false;
        Soma = 0;
        for (i = 1; i <= 10; i++)
            Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11)) 
            Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11) ) )
            return false;
    }
    else{
        if( $("#PF").is(":checked") == true )
            return false;
    }
    
    
    /*Tratamento para verificar no banco se existe o CPF*/
    /*jQuery.ajax({
        url: 'verifica_cpf.php?cpf='+cpf,
        async: false,
        success: function(data) {
           if(data == 0) verifica = true; 
    }});*/
    
    return true;
},"<span style='color:red; font-weight: normal;'>CPF inválido ou já cadastrado.</span>");

/*Validação se o número do CNPJ é válido.*/
jQuery.validator.addMethod('validateCNPJ',function(value){
    cnpj = value.replace(/[^\d]+/g,'');
 
    //if(cnpj == '') return false;
     
    //if (cnpj.length != 14)
        //return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || cnpj == "11111111111111" || 
        cnpj == "22222222222222" || cnpj == "33333333333333" || 
        cnpj == "44444444444444" || cnpj == "55555555555555" || 
        cnpj == "66666666666666" || cnpj == "77777777777777" || 
        cnpj == "88888888888888" || cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
      
    /*Tratamento para verificar no banco se existe o CNPJ*/
    /*jQuery.ajax({
        url: 'verifica_cnpj.php?cnpj='+cnpj,
        async: false,
        success: function(data) {
           if(data == 0) verifica = true; 
    }});*/
    return true;
},"<span style='color:red; font-weight: normal;'>CNPJ inválido ou já cadastrado.</span>");

/*Validação se arquivo selecionado para o upload é uma imagem com o tamanho menor ou igual a 1MB.*/
jQuery.validator.addMethod('validateFILE',function(){
    alert("TESTANDO");
    var iMaxFilesize = 1048576; // 1MB
    var oFile = document.getElementById('image_file').files[0];
    var rFilter = /^(image\/gif|image\/jpeg|image\/png)$/i;
    if ( (!rFilter.test(oFile.type)) || (oFile.size > iMaxFilesize) ) {
        return false;
    }
    return true;
},"<span style='color:red; font-weight: normal;'>Arquivo inválido.</span>");

/*Validação se é um e-mail válido.*/
jQuery.validator.addMethod('validateMAIL',function(value){
    //atribuindo o valor do campo
    strEMAIL = value;
    // filtros
    var emailFilter=/^.+@.+\..{2,}$/;
    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
    // condição
    if(!(emailFilter.test(strEMAIL))||strEMAIL.match(illegalChars)){
        return false;
    }
    return true;
},"<span style='color:red; font-weight: normal;'>E-mail inválido.</span>");

