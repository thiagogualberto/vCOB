<?php
ob_start();
include("mpdf60/mpdf.php");
if (isset($_SESSION['acessar_modulos'])){
    if ( (($_SESSION['acessar_modulos']["L00000120170808160006"]) == "S") ||
         (($_SESSION['acessar_modulos']["L00000120170808160006"]) == "G") ){
            $tipo_cobranca = $_REQUEST["tipo_cobranca"];
            $dt_inicio_relat = $_REQUEST["dt_inicio_relat"];
            $dt_final_relat = $_REQUEST["dt_final_relat"];
            $cliente_cobranca = $_REQUEST["cliente_cobranca"];

            $sql = "SELECT chave, cnpj, cpf, tipo, logradouro, numero, bairro, cidade, uf, cep, telefone
                        FROM tbl_cliente_empresa
                        where (nome_fantasia = '".$cliente_cobranca."')";
            echo $sql;
            $qry = mysqli_query($con,$sql);
            $res = mysqli_fetch_array($qry);

            $chave_cliente = $res["chave"];
            $cnpj = $res["cnpj"];
            $cpf = $res["cpf"];
            $tipo = $res["tipo"];
            $logradouro = $res["logradouro"];
            $numero = $res["numero"];
            $bairro = $res["bairro"];
            $cidade = $res["cidade"];
            $uf = $res["uf"];
            $cep = $res["cep"];
            $telefone = $res["telefone"];

            $endereco = $tipo." ".$logradouro.", ".$numero.", ".$bairro.", ".$cidade."-".$uf." ".$cep;

            if ($tipo_cobranca == "td") { //Pesquisa por todas as cobranças de um cliente em um espaço de data.
                $sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj,tce.cpf,
                            DATE_FORMAT(dt_emissao,'%d/%m/%Y'), 
                            format(vl_emissao,2,'de_DE'), DATE_FORMAT(dt_vencimento,'%d/%m/%Y'),
                            DATE_FORMAT(dt_pagamento,'%d/%m/%Y'), format(vl_pago,2,'de_DE'),vl_pago,vl_emissao,tipo_baixa
                        FROM tbl_cobranca AS tc
                        INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                        WHERE (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND 
                              ( (dt_vencimento >='".data_converte($dt_inicio_relat,"/")."') AND
                                (dt_vencimento <='".data_converte($dt_final_relat,"/")."') ) AND (tce.ativo = 'S')";
            }
            else if ($tipo_cobranca == "ea"){ //Pesquisa pelas cobranças de um cliente em aberto ou liquidadas em um espaço de data.
                $sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj,tce.cpf,
                            DATE_FORMAT(dt_emissao,'%d/%m/%Y'),
                            format(vl_emissao,2,'de_DE'), DATE_FORMAT(dt_vencimento,'%d/%m/%Y'),
                            DATE_FORMAT(dt_pagamento,'%d/%m/%Y'), format(vl_pago,2,'de_DE'),vl_pago,vl_emissao,tipo_baixa
                        FROM tbl_cobranca AS tc
                        INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                        WHERE (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND 
                              ( (dt_vencimento >='".data_converte($dt_inicio_relat,"/")."') AND (dt_vencimento <='".data_converte($dt_final_relat,"/")."') ) AND
                              ( (tipo_baixa = '') OR (tipo_baixa IS NULL) ) AND (tce.ativo = 'S')";
            }
            else{
                $sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial, tce.cnpj,tce.cpf,
                            DATE_FORMAT(dt_emissao,'%d/%m/%Y'),
                            format(vl_emissao,2,'de_DE'), DATE_FORMAT(dt_vencimento,'%d/%m/%Y'),
                            DATE_FORMAT(dt_pagamento,'%d/%m/%Y'), format(vl_pago,2,'de_DE'),vl_pago,vl_emissao,tipo_baixa
                        FROM tbl_cobranca AS tc
                        INNER JOIN tbl_cliente_empresa AS tce on tc.chave_cliente = tce.chave
                        WHERE (tc.chave_empresa = '".$_SESSION["chave_empresa"]."') AND 
                            ( (dt_pagamento >='".data_converte($dt_inicio_relat,"/")."') AND (dt_pagamento <='".data_converte($dt_final_relat,"/")."') ) AND
                            ( (tipo_baixa = 'M') OR (tipo_baixa = 'A') ) AND (tce.ativo = 'S')";
            }
            if ($cliente_cobranca != "")    $sql .= " AND (tce.nome_fantasia = '".$cliente_cobranca."')";
            $sql .= " ORDER BY tce.nome_fantasia, dt_emissao, dt_vencimento";

            $total_pago = 0.0;
            $total_receber = 0.0;
            $qry = mysqli_query($con,$sql);
            while ($res = mysqli_fetch_array($qry)){
                if ( ($res["cnpj"] != "") && ($res["cnpj"] != NULL) )   
                    $nome = $res["nome_fantasia"];
                else if ( ($res["cpf"] != "") && ($res["cpf"] != NULL) ) 
                    $nome = $res["nome_razaosocial"];
                $dt_emissao = $res["DATE_FORMAT(dt_emissao,'%d/%m/%Y')"];
                $vl_emissao = $res["format(vl_emissao,2,'de_DE')"];
                $dt_vencimento = $res["DATE_FORMAT(dt_vencimento,'%d/%m/%Y')"];
                $dt_pagamento = $res["DATE_FORMAT(dt_pagamento,'%d/%m/%Y')"];
                $vl_pago = $res["format(vl_pago,2,'de_DE')"];
                $baixa = $res["tipo_baixa"];
                if ( ($baixa == "") || ($baixa == NULL) )   $baixa = "-";
                $arrayCobrancas[] = array('nome' => $nome,
                                          'dt_emissao' => $dt_emissao,
                                          'vl_emissao' => $vl_emissao,
                                          'dt_vencimento' => $dt_vencimento,
                                          'dt_pagamento' => $dt_pagamento,
                                          'vl_pago' => $vl_pago,
                                          'baixa' => $baixa);
                $total_pago += $res["vl_pago"];
                if ( ($res["tipo_baixa"] != 'M') && ($res["tipo_baixa"] != 'A') )
                    $total_receber += $res["vl_emissao"];
            }

            $mpdf=new mPDF('pt','A4','12','',10,10,10,10,'','','L');
            $stylesheet = file_get_contents('bootstrap/css/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);

            $html = '
                <html>
                    <head>
                        <meta charset="utf-8">
                        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
                        <title>Relatórios de Cobranças</title>
                    </head>
                    <body>
                        <div style="width:100%; margin-left: 0px;">
                            <table class="table table-bordered table-striped" style="font-size:12px;">
                                <thead>';
                                if ($cliente_cobranca != ""){
                                    $html .= '
                                        <tr><th colspan="7" align="center"> RELATÓRIO DAS COBRANÇAS DA(O) CLIENTE '.strtoupper($cliente_cobranca).'</th></tr>
                                        <tr>
                                            <th colspan="7" align="center">';
                                                if ($cpf != "") $html .= $cpf;
                                                else    $html .= $cnpj;
                                                $html .= '<br>'.strtoupper($endereco).'<br>Contatos: '.strtoupper($telefone).
                                            '</th>
                                        </tr>';
                                }
                                else{
                                    $html .= '<tr><th colspan="7" align="center">RELATÓRIO DAS COBRANÇAS DE TODOS OS CLIENTES</th></tr>';
                                }
                                if ($tipo_cobranca == "td")
                                    $html .= '<tr><th colspan="7" align="center">RELATÓRIO DE TODAS AS COBRANÇAS </th></tr>';
                                else if ($tipo_cobranca == "ea")
                                    $html .= '<tr><th colspan="7" align="center">RELATÓRIO DE COBRANÇAS EM ABERTO - Período: '.$dt_inicio_relat.' a '.$dt_final_relat.'</th></tr>';
                                else if ($tipo_cobranca == "li")
                                    $html .= '<tr><th colspan="7" align="center">RELATÓRIO DE COBRANÇAS LIQUIDADAS - Período: '.$dt_inicio_relat.' a '.$dt_final_relat.'</th></tr>';
                                $html .= '
                                <tr>
                                    <th align="center" style="width: 23%">Cliente</th>
                                    <th align="center" style="width: 13%">Data da Emissão</th>
                                    <th align="center" style="width: 13%">Valor da Emissão</th>
                                    <th align="center" style="width: 15%">Data de Vencimento</th>
                                    <th align="center" style="width: 15%">Data de Pagamento</th>
                                    <th align="center" style="width: 15%">Valor do Pagamento</th>
                                    <th align="center" style="width: 10%">Baixa</th>
                                </tr>
                                </thead>
                                <tbody>';
                                    foreach($arrayCobrancas as $cobr){
                                    $html .= '
                                    <tr>
                                        <td align="center">'.$cobr['nome'].'</td>
                                        <td align="center">'.$cobr['dt_emissao'].'</td>
                                        <td align="center"> R$ '.$cobr['vl_emissao'].'</td>
                                        <td align="center">'.$cobr['dt_vencimento'].'</td>';
                                        if ( ($cobr['dt_pagamento']!="00/00/0000") && ($cobr['dt_pagamento']!=NULL) )  $html .= '<td align="center">'.$cobr['dt_pagamento'].'</td>';
                                        else    $html .= '<td align="center"> - </td>';
                                        if ( ($cobr['vl_pago']!="0,00") && ($cobr['vl_pago']!=NULL))   $html .= '<td align="center"> R$ '.$cobr['vl_pago'].'</td>';
                                        else    $html .= '<td align="center"> - </td>';
                                    $html .= 
                                          '<td align="center">'.$cobr['baixa'].'</td>
                                    </tr>';
                                    }
                                $html .= '
                                </tbody>
                                <tfoot>';
                                    if ($tipo_cobranca == "td"){
                                    $html .='
                                    <tr>
                                        <td colspan="7" align="right">
                                            <br>
                                            <b>Total Pago: </b> R$ '.number_format($total_pago,2,",",".").'<br>
                                            <b>Valor a receber: </b> R$ '.number_format($total_receber,2,",",".").'
                                        </td>
                                    </tr>';
                                    }else if ($tipo_cobranca == "ea"){
                                    $html .='
                                    <tr><td colspan="7" align="right"><br><b>Valor a receber: </b> R$ '.number_format($total_receber,2,",",".").'</td></tr>';
                                    }else{
                                    $html .='
                                    <tr><td colspan="7" align="right"><br><b>Total Pago: </b> R$ '.number_format($total_pago,2,",",".").'</td></tr>';
                                    }
                                    $html .='
                                </tfoot>
                            </table>
                        </div>
                    </body>
                </html>';

            $mpdf->WriteHTML($html);
            //ob_clean();
            $mpdf->Output();
            exit();
        }
}else{?>
    <br>
    <?php 
    msg('4','Acesso não autorizado. Redirecionamento para a tela de login.','1','5','login.php','');
}?>