<?php
//Escrever o conteúdo de uma sessao
foreach($_SESSION['modulos'] as $key)
    echo $key.'<br>';
echo $_SESSION['login_usuario'].'<br>';
echo $_SESSION['senha_usuario'].'<br>';
echo $_SESSION['chave_usuario'].'<br>';
echo $_SESSION['codigo_usuario'].'<br>';
echo $_SESSION['chave_empresa'].'<br>';

?>

/*echo "Matriz antes de enviar:<br>";
                                print_r($modulos);
                                echo "<br><br>";
                                
                                echo "serialize:<br>";
                                $send = serialize($modulos);
                                print_r($send);
                                echo "<br><br>";
                                
                                echo "urlencode:<br>";
                                $send = urlencode($send);
                                print_r($send);
                                echo "<br><br>";*/
                                /*************************************************/
                                /*echo "urldecode:<br>";
                                $received = urldecode($send);//decodifica o valor passado pelo link
                                print_r($received);//imprime o array
                                echo "<br><br>";

                                echo "stripslashes:<br>";
                                $received = stripslashes($received);//limpa a string de  antes de "
                                print_r($received);//imprime o array
                                echo "<br><br>";

                                echo "unserialize:<br>";
                                $received = unserialize($received);//transforma a string em array
                                print_r($received);//imprime o array
                                echo "<br><br><br>";*/
                                
                                //$send = serialize($modulos);
                                //$send = urlencode($send);
                                //form_input_hidden('modulos',$send);