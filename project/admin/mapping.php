<?php include("../inc/head.php"); 

if(!isset($_SESSION['id']) && $_SESSION['id']==2){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<title>Takemore.com - Mapping</title>
<?php include("../inc/header.php"); ?>
<?php include("../inc/menu.php"); ?>
<div id="content">
  <div class="titlecontent">
    <p><a href="<?php echo check('home.php'); ?>">Home</a> <span> >> </span> Administrador <span> >> </span><a href="<?php echo check('mapping.php'); ?>">Mapping</a></p>
  </div>
  <div class="bodycontent">
  <form id="filter" name="filter" method="POST" action="<?php echo $current_file; ?>">
      <fieldset>
        <legend>filter</legend>
        <table width="300" border="0">
          <tr>
            <td width="70"><label for="Client">Client</label></td>
            <td width="173">
            <select name="client" id="client">
               <?php
				echo '<option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp- See All -</option>';
				echo '<option ';?><?php active('priv',$_POST['client'])?><?php echo ' value="priv">Private</option>';
                $SQL = mysqli_query($conn,"SELECT * FROM `client` WHERE `private`='0' ORDER BY `name` ASC");
                  if(mysqli_num_rows($SQL)>=1){
                     while($field = mysqli_fetch_assoc($SQL)){
                       echo '<option ';?><?php active($field['id_client'],$_POST['client'])?><?php echo ' value="'.$field['id_client'].'">'.$field['name'].'</option>';
                     }
                  }else{
                       echo '<option value="0">No value found</option>';
                  }
               ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="Status">Status</label></td>
            <td>
            <select name="status" id="status">
               <option <?php active('0',$_POST['status'])?> value='0'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp- See All -</option>
               <option <?php active('Waits',$_POST['status'])?> value="Waits">Waits</option>
               <option <?php active('Budgeted',$_POST['status'])?> value="Budgeted">Budgeted</option>
               <option <?php active('Under Repair',$_POST['status'])?> value="Under Repair">Under Repair</option>
               <option <?php active('Closed Billing',$_POST['status'])?> value="Closed Billing">Closed Billing</option>
               <option <?php active('Closed Guaranty',$_POST['status'])?> value="Closed Guaranty">Closed Guaranty</option>
               <option <?php active('Archive',$_POST['status'])?> value="Archive">Archive</option>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="Employee">Employee</label></td>
            <td>
             <select name="employee" id="employee">
               <?php
				echo '<option value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp- See All -</option>';
                $SQL = mysqli_query($conn,"SELECT * FROM `users` ORDER BY `name` ASC");
                  if(mysqli_num_rows($SQL)>=1){
                     while($field = mysqli_fetch_assoc($SQL)){
                       echo '<option ';?><?php active($field['id_user'],$_POST['employee'])?><?php echo ' value="'.$field['id_user'].'">'.$field['name'].'</option>';
                     }
                  }else{
                       echo '<option value="0">No value found</option>';
                  }
               ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="Entity">Entity</label></td>
            <td>
            <select name="entity" id="Entity">
              <option <?php active(' ',$_POST['entity'])?> value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp- See All -</option>
              <option <?php active('1',$_POST['entity'])?> value="1">External</option>
              <option <?php active('2',$_POST['entity'])?> value="2">Internal</option>
            </select>
            </td>
          </tr>
          <tr>
            <td>Data Inicial</td>
            <td>
            <input type="text" value="<?php if(!empty($_POST['date1'])){echo $_POST['date1'];} ?>" placeholder="0000-00-00 00:00:00" name="date1" />
            </td>
          </tr>
          <tr>
            <td>Data Final</td>
            <td>
            <input type="text" value="<?php if(!empty($_POST['date2'])){echo $_POST['date2'];} ?>" placeholder="0000-00-00 00:00:00" name="date2" />
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" class="myButton" id="submit" value="Filter" /></td>
          </tr>
        </table>
      </fieldset>
      <p>&nbsp;</p>
      <table  name="list" id="list" align="center">
        <tr>
          <th width="42" scope="col">Id:</th>
          <th scope="col">Client:</th>
          <th scope="col">Description:</th>
          <th scope="col">Status:</th>
          <th scope="col">Employee:</th>
          <th scope="col">Time Work:</th>
          <th scope="col">Entity:</th>
          <th width="170" scope="col">Edit:</th>
        </tr>
        <?php
             if($_POST['client']!=0){
                    $ext1 ='`client`.`id_client`='.$_POST['client'].' AND ';
                }elseif($_POST['client']=='priv'){
                    $ext1 ='`client`.`private`=1 AND';
                }else{
                    $ext1 = ' ';
                }
			//*************************************************************
                if($_POST['status']){
                    $ext2 = "`equip_status`.`status` LIKE '".$_POST['status']."' AND ";
                }else{
                    $ext2 = ' ';
                }

			//*************************************************************
                if(!empty($_POST['entity'])){
                    $ext3 =  "`equipment`.`entity`='".$_POST['entity']."' AND ";
                }else{
                    $ext3 = ' ';
                }
			//*************************************************************
				if(!empty($_POST['date1']) AND !empty($_POST['date2'])){
                     $ext4 = "(`start_date`>='".$_POST['date1']."' AND `end_date`<='".$_POST['date2']."') AND ";
                }else{
                     $ext4 = ' ';
                }
			//*************************************************************
                if($_POST['employee']!=0){
                    $ext5 =  "`users`.`id_user`='".$_POST['employee']."'" ;
                }else{
                    $ext5 = ' `users`.`id_user`=`users`.`id_user` ';
                }

            //*************************************************************
			$campos_query = "`client`.`name` AS 'client_name' ,`equipment`.`entity` AS 'enty' , `equip_status`.`status` AS 'stats' , `equipment`.`id_client` AS 'id_cli' , `users`.`name` AS 'user_name' ,`equip_problem`.`description(employee)` AS 'descript' , `equipment`.`id` AS 'idd' ,`equip_status`.`final_time` AS 'total_temp' ";

            $final_query  = "FROM `equipment`
                             INNER JOIN `equip_status` ON `equip_status`.`id` = `equipment`.`id`
                             INNER JOIN `client` ON `client`.`id_client` = `equipment`.`id_client`
                             INNER JOIN `users` ON `users`.`id_user` = `equipment`.`id_user`
							 INNER JOIN `equip_problem` ON `equip_problem`.`id` = `equipment`.`id`
                             WHERE ".$ext1." ".$ext2." ".$ext3." ".$ext4." ".$ext5." ORDER BY `equipment`.`id`";
			$maximo = 5;
                $pagina = $_GET["pagina"];
                if($pagina == "") {
                    $pagina = "1";
                }
                $inicio = $pagina - 1;
                $inicio = $maximo * $inicio;

                $strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
                $query = mysqli_query($conn,$strCount);
                $row = mysqli_fetch_array($query);
                $total = $row["num_registros"];
                $sql = mysqli_query($conn,"SELECT $campos_query $final_query LIMIT $inicio,$maximo") or die("Error:".mysqli_error($conn));
                while ($result_SQL = mysqli_fetch_assoc($sql)) {
              echo '<tr>';
              echo '<td>'.$result_SQL['idd'].'</td>';
              echo '<td>'.$result_SQL['client_name'].'</td>';
              echo '<td>'.$result_SQL['descript'].'</td>';
              echo '<td '; echo ''.tint($result_SQL['stats']).'>'.$result_SQL['stats'].'</td>';
              echo '<td>'.$result_SQL['user_name'].'</td>';
			  echo '<td>'.$result_SQL['total_temp'].'</td>';
              if($result_SQL['enty']=='2'){
                echo '<td>Internal</td>';
                echo '<td>
				<a class="myButton" href="'.check('internal.edit.php').'?id='.$result_SQL['idd'].'&cli='.$result_SQL['id_cli'].'&empr='.$result_SQL['user_name'].'">Edit</a>
				<a class="myButton" href="'.check('internal.edit.php').'?apg='.$result_SQL['idd'].'&cli='.$result_SQL['id_cli'].'">Delete</a> </td>';
              }else{
                echo '<td>External</td>';
                echo '<td>
				<a class="myButton" href="'.check('external.edit.php').'?id='.$result_SQL['idd'].'&cli='.$result_SQL['id_cli'].'&empr='.$result_SQL['user_name'].'">Edit</a>
				<a class="myButton" href="'.check('external.edit.php').'?apg='.$result_SQL['idd'].'&cli='.$result_SQL['id_cli'].'">Delete</a> </td>';
              }
			  $value = explode(" ",$result_SQL['total_temp']);
			  $hora += $value[0];
			  $minutos += $value[2];
            }
			echo '<tr><td colspan="8"></td></tr>';
            echo '</tr>';
            echo '<tr></tr>';
            echo '<td colspan="4"></td>';
            echo '<th scope="col">Total Hours:</hd>';
			$h = floor($minutos / 60);
			$m = ($minutos - ($h * 60)) / 100;
			$horas = $h + $m;

			$sep = explode('.', $horas);
			$hora += $sep[0];
			$minutos = $sep[1];

            echo '<td colspan="2">'.sprintf('%02d Horas e %02d Minutos', $hora, $minutos).'</td>';
            echo '<td><a class="myButton" href="'.check('print_maps.php').'?client='.$_POST['client'].'&status='.$_POST['status'].'&date1='.$_POST['date1'].'&date2='.$_POST['date2'].'&employee='.$_POST['employee'].'&entity='.$_POST['entity'].'" target="_black">Print Table</a></td>';
                    echo '</tr>';
			$menos = $pagina - 1;
                $mais = $pagina + 1;
                $pgs = ceil($total / $maximo);
                if($pgs > 1 ) {
                    echo "<br /><span>";

                    if($menos > 0) {
                        echo "<a href=".$_SERVER['PHP_SELF']."?pagina=$menos>anterior</a>&nbsp; ";
                    }
                    for($i=1;$i <= $pgs;$i++) {
                        if($i != $pagina) {
                            echo " <a href=".$_SERVER['PHP_SELF']."?pagina=".($i).">$i</a> | ";
                        }else{
                            echo " <strong>".$i."</strong> | ";
                        }
                    }
                    if($mais <= $pgs) {
                        echo " <a href=".$_SERVER['PHP_SELF']."?pagina=$mais>próxima</a>";
                    }
					echo '</span>';
                }
		?>
        </tr>
      </table>
      <p>&nbsp;</p>
    </form>
  </div>
</div>
<?php include("../inc/footer.php"); ?>
