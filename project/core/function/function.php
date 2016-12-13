<?php

//Detetar pagina que utilizador está
$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
$current_file = end($current_file);

//Verifica url dos componentes
function check($link)
{
    if(is_file($link)) {
        return $link;
    }else{
        return '../'.$link;
    }
}

?>
