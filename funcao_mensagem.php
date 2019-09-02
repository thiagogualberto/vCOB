<style>
/* MENSAGENS */
.msg_alerta {
    background-image: url("funcao/mensagem/msg_alerta.gif");
	background-repeat: no-repeat;
	background-position: 15px center;
	background-color: #FFFF7F;
	border: 1px solid #B6B60C;
	color: #B6B60C;
	font-family: helvetica;
	font-size: 12px;
	font-weight: bold;
	margin: 15px;
	padding-left: 50px;
	padding-top: 5px;
	padding-bottom: 5px;
	text-align: left;
	width: 70%;
}
.msg_erro {
    background-image: url("funcao/mensagem/msg_erro.gif");
	background-repeat: no-repeat;
	background-position: 15px center;
	background-color: #FFD4D4;
	border: 1px solid #D60202;
	color: #D60202;
	font-family: helvetica;
	font-size: 12px;
	font-weight: bold;
	margin: 0px;
	padding-left: 50px;
	padding-top: 5px;
	padding-bottom: 5px;
	text-align: left;
	width: 70%;
    margin-top: 3px;
    margin-bottom: 3px;
}
.msg_ok {
    background-image: url("funcao/mensagem/msg_ok.gif");
	background-repeat: no-repeat;
	background-position: 15px center;
	background-color: #D4FFAA;
	border: 1px solid #106510;
	color: #106510;
	font-family: helvetica;
	font-size: 12px;
	font-weight: bold;	
	margin: 15px;
	padding-left: 50px;
	padding-top: 5px;
	padding-bottom: 5px;
	text-align: left;
	width: 70%;
}
.msg_info
{
    background-image: url("funcao/mensagem/msg_info.gif");
	background-repeat: no-repeat;
	background-position: 15px center;
	background-color: #D4D4FF;
	border: 1px solid #3A3A8F;
    color: #3A3A8F;
	font-family: helvetica;
	font-size: 12px;
	font-weight: bold;
	margin: 15px;
	padding-left: 50px;
	padding-top: 20px;
	padding-bottom: 20px;
	text-align: left;
	width: 70%;
}		
</style>	
<?php
function msg($tp,$txt,$rf,$tempo,$url,$class=null){
    if ($tp==1){
        $classe="alert alert-success";
        $classe2="glyphicon glyphicon-ok";
    }
    if ($tp==2){
        $classe="alert alert-info";
        $classe2="glyphicon glyphicon-info-sign";
    }
    if ($tp==3){
        $classe="alert alert-warning";
        $classe2="glyphicon glyphicon-exclamation-sign";
    }
    if ($tp==4){
        $classe="alert alert-danger";
        $classe2="glyphicon glyphicon-remove";
    }
    echo "<center><div class='$classe $class' role='alert'><span class='$classe2' aria-hidden='true' style='margin-right: 5px;'></span>$txt</div></center>";
    if ($rf==1) echo "<meta HTTP-EQUIV='refresh' CONTENT='".$tempo.";URL=".$url."'>";
}				
?>