<?php
    header ('Content-Type: image/png');
    // LÊ O ARQUIVO E RETORNA UMA STRING
    $imagem = file_get_contents('img/marca.png');

    // CONVERTE A STRING GERADA PARA BASE64
    $img_base64 = base64_encode($imagem);
    
    // CONVERTE A STRING GERADA PARA BASE64
    //echo '<img src="'.base64_decode($img_base64).'">';
    echo base64_decode($img_base64);
?>
