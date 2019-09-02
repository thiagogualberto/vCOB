<?php
    include 'conexaoBD.php';
    include('boletos/funcoes_cef.php');
    header( 'Content-type: application/csv' );   
    header( 'Content-Disposition: attachment; filename=file.csv' );
    header( 'Content-Transfer-Encoding: binary' );
    header( 'Pragma: no-cache');

    $idProduto = 8;
    $idSegmento = 6;
    $idValorReal_referencia = 8;
    
    $out = fopen( 'php://output', 'w' );
    
    $sql = "SELECT te.nome_razaosocial AS empresa, tce.nome_razaosocial AS cliente_empresa, tce.cd_cliente_empresa,
            tce.cnpj, tce.cpf, tce.cep, tce.tipo, tce.logradouro, tce.numero, tce.bairro, tce.cidade, tce.uf, tce.telefone, 
            tc.chave, tc.cd_cobranca, tc.num_referencia, DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y'), 
            format(tc.vl_emissao,2,'de_DE'), DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y'), dt_vencimento,
            tipo_baixa, mensagem, chave_cobranca_instrucoes, format(tc.desconto_dinheiro,2,'de_DE'),desconto_dinheiro, 
            desconto_porcentagem, DATE_FORMAT(data_desconto,'%d/%m/%Y'),
            cobrar1, porcentagem_juros_cobrar1, diasjuros_cobrar1, 
            cobrar2, porcentagem_multa_cobrar2, diasmulta_cobrar2,
            linha
            FROM tbl_cobranca AS tc 
            INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
            INNER JOIN tbl_empresa AS te on tce.chave_empresa = te.chave
            where (te.chave = 'L00000620171117185734') AND ( (tipo_baixa = '') OR (tipo_baixa is null) ) AND (tce.cpf <> '')
            
            UNION
            
            SELECT te.nome_razaosocial AS empresa, tce.nome_fantasia AS cliente_empresa, tce.cd_cliente_empresa,
            tce.cnpj, tce.cpf, tce.cep, tce.tipo, tce.logradouro, tce.numero, tce.bairro, tce.cidade, tce.uf, tce.telefone, 
            tc.chave, tc.cd_cobranca, tc.num_referencia, DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y'), 
            format(tc.vl_emissao,2,'de_DE'), DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y'), dt_vencimento,
            tipo_baixa, mensagem, chave_cobranca_instrucoes, format(tc.desconto_dinheiro,2,'de_DE'),desconto_dinheiro, 
            desconto_porcentagem, DATE_FORMAT(data_desconto,'%d/%m/%Y'),
            cobrar1, porcentagem_juros_cobrar1, diasjuros_cobrar1, 
            cobrar2, porcentagem_multa_cobrar2, diasmulta_cobrar2,
            linha
            FROM tbl_cobranca AS tc 
            INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
            INNER JOIN tbl_empresa AS te on tce.chave_empresa = te.chave
            where (te.chave = 'L00000620171117185734') AND ( (tipo_baixa = '') OR (tipo_baixa is null) ) AND (tce.cnpj <> '')";
    $qry = mysqli_query($con,$sql);
    $cabecalho = array("empresa","cliente","cd_cobranca","documento","endereco","NR","vl_emissao","dt_vencimento","msg","instrucoes","msg_cob1","msg_cob2","cod_barras","linha_digitavel");
    fputcsv($out, $cabecalho,";",'"');
    
    while($res = mysqli_fetch_assoc($qry)){
        $empresa = $res["empresa"];
        $cd_cliente_empresa = $res["cd_cliente_empresa"];
        $chave_cobranca = $res["chave"];
        $cnpj = $res["cnpj"];
        $cpf = $res["cpf"];
        $cliente_empresa = $res["cliente_empresa"];
        $cd_cobranca = $res["cd_cobranca"];
        $num_referencia = $res["num_referencia"];
        $dt_emissao = $res["DATE_FORMAT(tc.dt_emissao,'%d/%m/%Y')"];
        $vl_emissao = $res["format(tc.vl_emissao,2,'de_DE')"];
        $dt_vencimento = $res["DATE_FORMAT(tc.dt_vencimento,'%d/%m/%Y')"];
        $dt_vencimento_BD = $res["dt_vencimento"];
        $desconto_dinheiro = $res["format(tc.desconto_dinheiro,2,'de_DE')"];
        $desconto_porcentagem = trim(str_replace(".",",","0.33"));
        $data_desconto = $res["DATE_FORMAT(data_desconto,'%d/%m/%Y')"];
        $endereco = $res["tipo"]." ".$res["logradouro"].", ".$res["numero"].", ".$res["bairro"].", ".$res["cidade"]."-".$res["uf"]." - ".$res["cep"];
        $telefone = $res["telefone"];
        
        //pega o conteúdo do campo menssagem
        $mensagem = $res["mensagem"];
        
        //Pega a msg da instrução selecionada
        $chave_cobranca_instrucoes = $res["chave_cobranca_instrucoes"];
        if ($chave_cobranca_instrucoes == "L00000120170905201901")
            $instrucoes = "Desconto de R$ ".$desconto_dinheiro." até ".$data_desconto.".";
        else if ($chave_cobranca_instrucoes == "L00000120170905201902")
            $instrucoes = "Desconto de ".$desconto_porcentagem."% até ".$data_desconto.".";
        else if ($chave_cobranca_instrucoes == "L00000120170905201903")
            $instrucoes = "Desconto de R$ ".$desconto_dinheiro." por dia corrido de antecipação.";
        else if ($chave_cobranca_instrucoes == "L00000120170905201904")
            $instrucoes = "Desconto de R$ ".$desconto_dinheiro." por dia útil de antecipação.";
        else $instrucoes = "";
        
        //Pega a msg do primeiro checbox cobrar
        $cobrar1 = $res["cobrar1"];
        if ($cobrar1 == "S"){
            $porcentagem_juros_cobrar1 = $res["porcentagem_juros_cobrar1"];
            $diasjuros_cobrar1 = $res["diasjuros_cobrar1"];
            $valor_juros_dia = $res["vl_emissao"] * ($porcentagem_juros_cobrar1/100);
            $valor_juros_dia = "R$ ".number_format($valor_juros_dia, 2, ',', '.');
            $msg_cobrar1 = "Cobrar $valor_juros_dia de juros ao dia após $diasjuros_cobrar1 dias de atraso.";
        }
        else    $msg_cobrar1 = "";
        
        //Pega a msg do segunda checbox cobrar
        $cobrar2 = $res["cobrar2"];
        if ($cobrar2 == "S"){
            $porcentagem_multa_cobrar2 = $res["porcentagem_multa_cobrar2"];
            $diasmulta_cobrar2 = $res["diasmulta_cobrar2"];
            $valor_multa = $res["vl_emissao"] * ($porcentagem_multa_cobrar2/100);
            $valor_multa = "R$ ".number_format($valor_multa, 2, ',', '.');
            $data_multa = data_dia_adiciona($dt_vencimento_BD, $diasmulta_cobrar2);
            $data_multa = data_converte($data_multa, "-");
            $msg_cobrar2 = "Cobrar multa de $valor_multa após ".$data_multa.".";
        }
        else    $msg_cobrar2 = "";
        
        $linha = $res["linha"]; //Pega o código de barras caso o mesmo ja tenha sido gerado.
        
        //Pega o CNPJ ou CPF do cliente e armazena em uma variável única para a geração do código de barras.
        if ($cpf != ""){
            $documento = str_replace('.', '', $cpf);
            $cpf_cnpj = $cpf;
        }
        else{
            $documento = str_replace('.', '', $cnpj);
            $cpf_cnpj = $cnpj;
        }
        $documento = substr($documento, 0,8);
        
        $cd_cobranca = formata_numero($cd_cobranca,13,0);
        $dt_vencimento_BD = str_replace('-', '', $dt_vencimento_BD);
        $dt_vencimento_BD = str_replace('/', '', $dt_vencimento_BD);
        $valor = str_replace('.', '', $vl_emissao);
        $valor = formata_numero($valor,11,0);
        $linha_parte1 = $idProduto.$idSegmento.$idValorReal_referencia;
        $linha_parte2 = $valor.$documento.$dt_vencimento_BD.$cd_cobranca;
        $linha_aux = $linha_parte1.$linha_parte2;
        $mod_11 = modulo_11($linha_aux);
        $cod_barras = $linha_parte1.$mod_11.$linha_parte2;
        
        if ( ($linha == "") || ($linha == NULL) ){
            $sql2 = "UPDATE tbl_cobranca SET 
                        linha = '".$cod_barras."',
                        tipo_impressao = 'R'
                    WHERE chave = '".$chave_cobranca."'";
            $qry2 = user_update($sql2) or die("Não atualizou a cobrança de chave: ".$chave_cobranca); 
        }
        
        $linha = $cod_barras;
        $ld1 = substr($linha,0,11).modulo_11(substr($linha,0,11));
        $ld2 = substr($linha,11,11).modulo_11(substr($linha,11,11));
        $ld3 = substr($linha,22,11).modulo_11(substr($linha,22,11));
        $ld4 = substr($linha,33,11).modulo_11(substr($linha,33,11));
        $linha_digitavel = $ld1.$ld2.$ld3.$ld4;
        
        $linha_remessa_csv = array($empresa,$cliente_empresa,$cd_cobranca,$cpf_cnpj, $endereco, $num_referencia, $vl_emissao, 
                                   $dt_vencimento, $mensagem, $instrucoes, $msg_cobrar1, $msg_cobrar2, $cod_barras, $linha_digitavel);
        fputcsv($out, $linha_remessa_csv,";",'"');
    }
    fclose( $out );
    $nm_arq_csv = time().'.csv';
    header("Content-Disposition: attachment; filename=$nm_arq_csv" );
?>