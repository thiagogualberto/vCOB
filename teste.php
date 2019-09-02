<?php
    $hash = password_hash("tgsdtmg1984", PASSWORD_BCRYPT);
    echo "Hash: ".$hash."<br>";
    $verifica = password_verify("tgsdtmg1984", $hash);
    echo "Verifica: ".$verifica."<br>";
?>