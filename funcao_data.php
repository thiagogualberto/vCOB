<?php
//Converte data para formato MySQL e do MySQL para o Normal
function data_converte($data, $parametro){
    if($data == false)
        return null;
    
    if ($parametro == "-"){
        $dt = explode("-", $data);
        $data_nova = $dt[2] . "/" . $dt[1] . "/" . $dt[0];
        if($data_nova == "0/0/0" || $data_nova == "00/00/0000")
            $data_nova = "";
        return $data_nova;
    } 
    else{
        $dt = explode("/", $data);
        $data_nova = $dt[2] . "-" . $dt[1] . "-" . $dt[0];
        if($data_nova == "0000-00-00")
            $data_nova = "";
        return $data_nova;
    }
}

//Função para adicionar dias a uma dasta e retornar a nova data.
function data_dia_adiciona($data_mysql, $dias){
    $thisyear = substr($data_mysql, 0, 4);
    $thismonth = substr($data_mysql, 5, 2);
    $thisday = substr($data_mysql, 8, 2);
    $nextdate = mktime(0, 0, 0, $thismonth, $thisday + $dias, $thisyear);
    return strftime("%Y-%m-%d", $nextdate);
}

//Verifica a diferença entre duas datas. Pode ser em ano, mês, dia, hora e minuto.
function data_maior($data1, $data2){
    // Comparando as Datas
    if(strtotime($data1) > strtotime($data2))   return 1;
    else    return 0;
}

function data_mes_adiciona($data_mysql, $mes){
    $thisyear = substr($data_mysql, 0, 4);
    $thismonth = substr($data_mysql, 5, 2);
    $thisday = substr($data_mysql, 8, 2);
    $mesresto = 12 - $thismonth;
    $mesresto = 12 - $thismonth;
    $nextdate = mktime(0, 0, 0, $thismonth + $mes, $thisday, $thisyear);
    return strftime("%Y-%m-%d", $nextdate);
}?>