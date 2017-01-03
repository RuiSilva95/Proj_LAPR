<?php 
require ('core/init.php');
if(!isset($_SESSION['id'])){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style/default/css/print.css">
    </head>
    <body>
        <?php 
        $client = protect($_GET['client']);
        $status = protect($_GET['status']);
        $date1 = protect($_GET['date1']);
        $date2 = protect($_GET['date2']);
        $employee = protect($_GET['employee']);
		$entity = protect($_GET['entity']);

        ?>
        <div id="A4">
            <img class="logo" src="style/default/img/partner/logo.png"/>
            <p>
			<?php echo 'Filtered by Map:';?> 
			<?php 
				if(empty($client)){
					echo 'Cliente - ALL | ';
				}elseif($client=='priv'){
					echo 'Client - Private | ';
				}else{ 
					$SQL = mysql_query("SELECT `name` FROM `client` WHERE `id_client`='".$client."'");
					$result = mysql_fetch_assoc($SQL);
					echo 'Client - '.$result.' | ';
					} 
                if($status=='0' || empty($status)){
					echo 'Status - ALL | ';
				}else{
					echo 'Status - '.$status.' | ';
					} 
				if(empty($date1) && empty($date2)){
					echo 'Data - ALL | ';
				}else{
					echo 'Between - '.$date1.' to '.$date2.' | ';
					} 
            	if($employee=='0' || empty($employee)){
				   echo 'Employee - ALL | ';
				}else{
					$SQL = mysql_query("SELECT `name` FROM `users` WHERE `id_user`='".$employee."'");
					$result = mysql_fetch_assoc($SQL);
				   echo 'Employee - '.$result.' | ';
				   } 
				if(empty($entity)){
					echo 'Sheet Repair - ALL | ';
				}elseif($entity=='2'){
					echo 'Sheet Repair - Internal | ';
				}elseif($entity=='1'){
					echo 'Sheet Repair - External | ';}?></p>
            <table id="tab" class="list">
                <tr>
                    <th>Id:</th>
                    <th>Client:</th>
                    <th>Mark/Modelo: </th>
                    <th>Status:</th>
                    <th>Employee:</th>
                    <th>Time Work:</th>          
                </tr>
                <?php 
                if($client != 0){
                    $ext1 ='`client`.`id_client`='.$client.' AND ';
                }elseif($client=='priv'){
                    $ext1 ='`client`.`private`=1 AND';
                }else{
                    $ext1 = ' ';    
                }
				//*************************************************************
                if($status){
                    $ext2 = "`equip_status`.`status` LIKE '".$status."' AND ";
                }else{
                    $ext2 = ' ';  
                }
				//*************************************************************
                if(!empty($date1) AND !empty($date2)){
                    $ext3 = "(`start_date`>='".$date1."' AND `end_date`<='".$date2."') AND "; 
                }else{
                    $ext3 = ' ';  
                } 
				//*************************************************************
				 if(!empty($entity)){
                    $ext4 =  '`equipment`.`entity`='.$entity.' AND '; 
                }else{
                    $ext4 = ' ';  
                }  
				//*************************************************************
                if($employee!=0){
                    $ext5 =  '`users`.`id_user`='.$employee.'' ; 
                }else{
                    $ext5 = ' `users`.`id_user`=`users`.`id_user` ';  
                }
                $SQL = "SELECT `client`.`name` AS 'clientname' , `equip_status`.`status` AS 'stats' , `equipment`.`id_client` AS 'idcli' ,`users`.`username` AS 'employname' ,`equipment`.`mark/model` AS 'mark' , `equipment`.`id` AS 'idd' , `equip_status`.`final_time` AS 'work' 
                            FROM `equipment` 
                            INNER JOIN `equip_status`ON `equip_status`.`id` = `equipment`.`id`
                            INNER JOIN `client`ON `client`.`id_client` = `equipment`.`id_client`
                            INNER JOIN `users`ON `users`.`id_user` = `equipment`.`id_user` 
                            WHERE ".$ext1." ".$ext2." ".$ext3." ".$ext4." ".$ext5."
                            ORDER BY `equipment`.`id`";
                                
                $SQL = mysql_query($SQL) or die(mysql_error());  
                if(mysql_num_rows($SQL)>=1){
                    while($result_SQL = mysql_fetch_assoc($SQL)){
                        echo '<tr>';   
                        echo '<td>'.$result_SQL['idd'].'</td>';  
                        echo '<td>'.$result_SQL['clientname'].'</td>';
                        echo '<td>'.$result_SQL['mark'].'</td>';
                        echo '<td>'.$result_SQL['stats'].'</td>';
                        echo '<td>'.$result_SQL['employname'].'</td>';
                        echo '<td>'.$result_SQL['work'].'</td>';
						echo '<tr>';
						$value = explode(" ",$result_SQL['work']); 
			  			$hora += $value[0];
			  			$minutos += $value[2];
                    }
                    echo '<tr><td colspan="7"></td></tr>';
                    echo '<td colspan="4"></td>';
                    echo '<td>Total Hours:</td>';
					$h = floor($minutos / 60);
					$m = ($minutos - ($h * 60)) / 100;
					$horas = $h + $m;
		
					$sep = explode('.', $horas);
					$hora += $sep[0];
					$minutos = $sep[1];
                    echo '<td>'.sprintf('%02d Horas e %02d Minutos', $hora, $minutos).'</td>';
                    echo '</tr>';
                }            
                ?>
            </table>
        </div>
    </body>
</html>
<script>
    window.print();return;
</script>