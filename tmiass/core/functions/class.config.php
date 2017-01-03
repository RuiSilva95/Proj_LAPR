<?php
//proteção sobre injecção no SQL
function protect($string) {
    return mysql_real_escape_string(strip_tags(addslashes($string)));
}

//Detetar pagina que utilizador está
$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
$current_file = end($current_file);

//Verifica url dos componentes
function check($link){
	if(is_file($link)){
		return $link;
	}else{
		return '../'.$link;
	}
}
	
//Acede informação do utilizador	
function access($fill){
	$login_check=mysql_query("SELECT * FROM `users` WHERE `id_user`='".$_SESSION['id']."'");
	$get_if = mysql_fetch_assoc($login_check);
	return $get_if[$fill];
}

//Activar forms Select quando se retorna valor	
function active($valor1,$valor2){
	if ($valor1 == $valor2) {
	   echo 'selected';
	}
}

//Pintar entity dependedo a escolha
function tint($var){
switch($var){
	case 'Waits':
	echo 'bgcolor="#eff773"';
	break;
	case 'In Execution':
	echo 'bgcolor="#eaf44c"';
	break;
	case 'Budgeted':
	echo 'bgcolor="#1c85fb"';
	break;
	case 'Under Repair':
	echo 'bgcolor="#ffffff"';
	break;
	case 'Ready':
	echo 'bgcolor="#ff3737"';
	break;
	case 'Closed Billing':
	echo 'bgcolor="#0dfd01"';
	break;
	case 'Closed Guaranty':
	echo 'bgcolor="#08b000"';
	break;
	case 'Closed Contract':
	echo 'bgcolor="#076f02"';
	break;
	case 'Archive':
	echo 'bgcolor="b3b3b3"';
	break;
	}
}
              
//Fazer calculo das horas de trabalho nas fichas
If ($_GET['code'] == "1"){
    $input1 = $_GET['input1'];
    $input2 = $_GET['input2'];
    
    If(!empty($input1) && !empty($input2)) {
        $horaInicial  = strtotime($input1);
        $horaFinal    = strtotime($input2);
        $totalSegundos = ($horaFinal - $horaInicial);
                    
        $hora = sprintf("%02s",floor($totalSegundos / (60*60)));
        $totalSegundos = ($totalSegundos % (60*60));
        			
        $minuto = sprintf("%02s",floor ($totalSegundos / 60 ));
        $totalSegundos = ($totalSegundos % 60);
        
        echo $hora."H : ".$minuto." M";
    }
}
?>