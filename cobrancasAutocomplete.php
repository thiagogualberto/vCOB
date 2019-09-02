<?php
include 'conexaoBD.php';
if(isset($_POST['queryString'])) {
    $queryString = $_POST['queryString'];
    if(strlen($queryString) >=3) {
        $chave = $_POST['chave_empresa_usuario'];
        if ( (strcmp($_POST['modulo_sistema'],"pesquisar_cliente_empresa") == 0) ||
             (strcmp($_POST['modulo_sistema'],"pesquisar_cobrancas_cliente") == 0) ||
             (strcmp($_POST['modulo_sistema'],"cliente_cobranca") == 0)){
            /*$sql = "SELECT tce.nome_fantasia, tce.nome_razaosocial
                FROM tbl_cliente_empresa AS tce
                INNER JOIN tbl_empresa AS te on tce.chave_empresa = te.chave
                WHERE (tce.nome_fantasia LIKE '".$queryString."%' OR tce.nome_razaosocial LIKE '".$queryString."%' OR
                       tce.cpf = '".$queryString."' OR 
                       tce.cnpj = '".$queryString."' OR cd_cliente_empresa = '".$queryString."') AND
                        (chave_empresa='".$chave."')";*/
            $sql = "SELECT tce.nome_fantasia FROM tbl_cliente_empresa AS tce
                        INNER JOIN tbl_empresa AS te on tce.chave_empresa = te.chave
                        WHERE (tce.nome_fantasia LIKE '".$queryString."%' OR tce.cpf = '".$queryString."' OR
                               tce.cnpj = '".$queryString."' OR cd_cliente_empresa = '".$queryString."') AND (chave_empresa='".$chave."') AND
                               (tce.cnpj <> '')
                    UNION
                    SELECT tce.nome_razaosocial FROM tbl_cliente_empresa AS tce
                        INNER JOIN tbl_empresa AS te on tce.chave_empresa = te.chave
                        WHERE (tce.nome_razaosocial LIKE '".$queryString."%' OR tce.cpf = '".$queryString."' OR
                               tce.cnpj = '".$queryString."' OR cd_cliente_empresa = '".$queryString."') AND (chave_empresa='".$chave."') AND
                               (tce.cpf <> '')";
        }
        else if (strcmp($_POST['modulo_sistema'],"pesquisar_usuario") == 0){
            $sql = "SELECT tu.nm_usuario
                FROM tbl_usuario AS tu
                INNER JOIN tbl_empresa AS te on tu.chave_empresa = te.chave
                WHERE (tu.nm_usuario LIKE '".$queryString."%') AND (tu.chave_empresa = '".$chave."')";
        }
        else if (strcmp($_POST['modulo_sistema'],"pesquisar_empresa") == 0) {
            $sql = "SELECT nome_fantasia FROM tbl_empresa WHERE nome_fantasia LIKE '$queryString%' OR cnpj = '$queryString'";
        }
        $qry = mysqli_query($con,$sql) or die("Erro na consulta.");
        if (mysqli_num_rows($qry) > 0){
            while($res = mysqli_fetch_array($qry)){
                echo '<div class="tt-suggestion tt-selectable" onClick="fill(\''.$res[0].'\');">'.$res[0].'</div>';
            }
        }
        else{
            echo '<div class="tt-suggestion tt-selectable">Não há dados para essa pesquisa!!!</div>';
        }
    }
}	