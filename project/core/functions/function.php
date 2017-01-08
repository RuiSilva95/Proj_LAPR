<?php

//proteção sobre injecção no SQL
function protect($string)
{
    global $conn;
    return mysqli_real_escape_string($conn, strip_tags(addslashes($string)));
}

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

//Acede informação do utilizador
function access($fill)
{
    global $conn;
    $query = 'SELECT * FROM users WHERE id_user='.$_SESSION['id'].';';
    $result=mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    return $row[$fill];
}

//Activar forms Select quando se retorna valor
function active($valor1,$valor2)
{
    if ($valor1 == $valor2) {
          return 'selected';
    }
}

//Pintar entity dependedo a escolha
function tint($var)
{
    switch($var){
    case 'Waits':
        echo 'bgcolor="#eff773"';
        break;
    case 'Budgeted':
        echo 'bgcolor="#1c85fb"';
        break;
    case 'Under Repair':
        echo 'bgcolor="#ffffff"';
        break;
    case 'Closed Billing':
        echo 'bgcolor="#0dfd01"';
        break;
    case 'Closed Guaranty':
        echo 'bgcolor="#08b000"';
        break;
    case 'Closed Contract':
        echo 'bgcolor="#98FF92"';
        break;
    case 'Archive':
        echo 'bgcolor="b3b3b3"';
        break;
    }
}

//Fazer calculo das horas de trabalho nas fichas
if ($_GET['code'] == "1") {
    $input1 = $_GET['input1'];
    $input2 = $_GET['input2'];

    if(!empty($input1) && !empty($input2)) {
        $horaInicial  = strtotime($input1);
        $horaFinal    = strtotime($input2);
        $totalSegundos = ($horaFinal - $horaInicial);

        $hora = sprintf("%02s", floor($totalSegundos / (60*60)));
        $totalSegundos = ($totalSegundos % (60*60));

        $minuto = sprintf("%02s", floor($totalSegundos / 60));
        $totalSegundos = ($totalSegundos % 60);

        echo $hora."H : ".$minuto." M";
    }
}


//Verificação da password
function hash_equals($str1, $str2)
{
    if(strlen($str1) != strlen($str2)) {
        return false;
    }
    else{
           // XOR
           $res = $str1 ^ $str2;
           $ret = 0;
        for($i = strlen($res) - 1; $i >= 0; $i--){
             // OR to ret - if all equal then return 0
            $ret |= ord($res[$i]);
        }
           return !$ret;
    }
}

?>
