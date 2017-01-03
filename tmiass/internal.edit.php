<?php include("inc/head.php"); 

if(!isset($_SESSION['id'])){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<?php include("inc/header.php"); ?>
<?php include("inc/menu.php"); ?>
<div id="content">
  <div class="titlecontent">
    <p><a href="<?php echo check('home.php'); ?>">Home</a> <span> >> </span><a href="#">Sheet Repair</a><span> >> </span><a href="#">Internal</a><span> >> </span><a href="#">Internal Edit</a></p>
  </div>
  <div class="bodycontent">
        <?php
        $id = protect($_GET['id']);
        $apg = protect($_GET['apg']);
        $cli = protect($_GET['cli']);
        $empr = protect($_GET['empr']);
        
        if(!empty($apg)){
            mysql_query("DELETE FROM `equip_problem` WHERE `id`='$apg'")or die(mysql_error());
            mysql_query("DELETE FROM `equipment` WHERE `id`='$apg'")or die(mysql_error());
            mysql_query("DELETE FROM `equip_status` WHERE `id`='$apg'")or die(mysql_error());
            mysql_query("DELETE FROM `service_problem` WHERE `id`='$apg'")or die(mysql_error());
            mysql_query("DELETE FROM `client` WHERE `id_client`='$cli' AND `private`='1'")or die(mysql_error());
            
            header('Location:'.'home.php');
        }elseif(!empty($id)){
            $SQL1 = mysql_query("SELECT * FROM `equip_problem` WHERE `id`='$id'")or die(mysql_error());
            $SQL2 = mysql_query("SELECT * FROM `equipment` WHERE `id`='$id'")or die(mysql_error());
            $SQL3 = mysql_query("SELECT * FROM `equip_status` WHERE `id`='$id'")or die(mysql_error());
            $SQL4 = mysql_query("SELECT * FROM `client` WHERE `id_client`='$cli'")or die(mysql_error());
            $SQL5 = mysql_query("SELECT * FROM `service_problem` WHERE `id`='$id'")or die(mysql_error());
			
            $field1 = mysql_fetch_assoc($SQL1);
            $field2 = mysql_fetch_assoc($SQL2);
            $field3 = mysql_fetch_assoc($SQL3);
            $field4 = mysql_fetch_assoc($SQL4);
            $field5 = mysql_fetch_assoc($SQL5);
        }
      ?>  
  <form id="repair_form" name="repair_form" method="POST">      
      <table>
        <tr>
          <td><label for="client">Client:</label></td>
          <td>
              <select name="client" onchange="verificaOpcao(this.value)">
               <?php 
				echo '<option value="0">Select Client</option>';
                $SQL = mysql_query("SELECT * FROM `client` WHERE `private`='0' ORDER BY `name` ASC");
                  if(mysql_num_rows($SQL)>=1){
                     while($field = mysql_fetch_assoc($SQL)){
                       echo '<option ';?><?php active($field['id_client'],$cli)?><?php echo' value="'.$field['id_client'].'">'.$field['name'].'</option>'; 
                     }
                  }else{
                       echo '<option value="0">No value found</option>'; 
                  }
               ?>
              </select>
          </td>
          <td><label for="status">Status*:</label></td>
          <td>
              <select name="status" id="status">
               <option <?php active('0',$field3['status'])?> value='0'>Select Status</option>
               <option <?php active('Waits',$field3['status'])?> value="Waits">Waits</option>
               <option <?php active('Budgeted',$field3['status'])?> value="Budgeted">Budgeted</option>
               <option <?php active('Under Repair',$field3['status'])?> value="Under Repair">Under Repair</option>
               <option <?php active('Closed Billing',$field3['status'])?> value="Closed Billing">Closed Billing</option>
               <option <?php active('Closed Guaranty',$field3['status'])?> value="Closed Guaranty">Closed Guaranty</option>
               <option <?php active('Closed Contract',$field3['status'])?> value="Closed Contract">Closed Contract</option>
               <option <?php active('Archive',$_POST['status'])?> value="Archive">Archive</option>
              </select>
          </td>
          <td><label for="employee">Employee*:</label></td>
          <td>
             <select name="employee" id="employee">
               <?php 
				echo '<option value="">Select Status</option>';
                $SQL = mysql_query("SELECT * FROM `users` ORDER BY `name` ASC");
                  if(mysql_num_rows($SQL)>=1){
                     while($field = mysql_fetch_assoc($SQL)){
                       echo '<option ';?><?php active($field['name'],$empr)?><?php echo ' value="'.$field['id_user'].'">'.$field['name'].'</option>';
                     }
                  }else{
                       echo '<option value="0">No value found</option>'; 
                  }
               ?>
              </select>
          </td>
        </tr>
        <tr>
          <td><label for="name">Name:</label></td>
          <td><input <?php if($field4['private']!=1){echo 'disabled="true"';}else{$var = $field4['name'];}?> type="text" name="name" id="client" value="<?php echo $var; ?>"/></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><label for="address">Address:</label></td>
          <td><input <?php if($field4['private']!=1){echo 'disabled="true"';}else{$var = $field4['address'];}?> type="text" name="address" id="client1" value="<?php echo $var; ?>"/></td>
          <td><label for="phone">Phone:</label></td>
          <td><input <?php if($field4['private']!=1){echo 'disabled="true"';}else{$var = $field4['phone'];}?> type="text" name="phone" id="client2" value="<?php echo $var; ?>"/></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><label for="initial_date">Initial Date:</label></td>
          <td><input type="text" value="<?php echo $field3['start_date']; ?>" placeholder="0000-00-00 00:00:00" name="initial_date" id="initial_date" onchange="javascript('1')"/></td>
          <td><label for="final_date">Final Date:</label></td>
          <td><input type="text" value="<?php echo $field3['end_date']; ?>" placeholder="0000-00-00 00:00:00" name="final_date" id="final_date" onchange="javascript('1')"/></td>
          <td><label for="working_hours">Working Hours:</label></td>
          <td><input type="text" value="<?php echo $field3['final_time']; ?>" name="working_hours" id="working_hours" readonly/></td>
        </tr>
      </table>
      <table>
        <tr>
          <td><label for="equipment">Equipment:</label></td>
          <td><label for="mark">Mark/Model:</label></td>
          <td><label for="n_serie">NºSerie:</label></td>
          <td><label for="accessories">Extra Accessories:</label></td>
        </tr>
        <tr>
          <td><input type="text" value="<?php echo $field2['equipment']; ?>" name="equipment" id="equipment" /></td>
          <td><input type="text" value="<?php echo $field2['mark/model']; ?>" name="mark" id="mark" /></td>
          <td><input type="text" value="<?php echo $field2['n_serie']; ?>" name="n_serie" id="n_serie" /></td>
          <td><input type="text" value="<?php echo $field2['accessories']; ?>" name="accessories" id="accessories" /></td>
        </tr>
      </table>
      <table>
        <tr>
          <td><label for="problem">Problem/Damage:</label></td>
          <td><textarea name="problem" id="problem" cols="45" rows="2"><?php echo $field1['problem/damage']; ?></textarea></td>
        </tr>
        <tr>
          <td><label for="descri_client">Description(Client):</label></td>
          <td><textarea name="descri_client" id="descri_client" cols="45" rows="2"><?php echo $field1['description(client)']; ?></textarea></td>
        </tr>
        <tr>
          <td><label for="descri_employee">Description(Employee):</label></td>
          <td><textarea name="descri_employee" id="descri_employee" cols="45" rows="2"><?php echo $field1['description(employee)']; ?></textarea></td>
        </tr>
        <tr>
          <td><label for="service_provided">Service Provided:</label></td>
          <td><textarea name="service_provided" id="service_provided" cols="45" rows="2"><?php echo $field2['service']; ?></textarea></td>
        </tr>
        <tr>
          <td><label for="material_supplied">Material Supplied:</label></td>
          <td><textarea name="material_supplied" id="material_supplied" cols="45" rows="2"><?php echo $field2['provided']; ?></textarea></td>
        </tr>
      </table>
      <fieldset id="fieldset" <?php if($field5['check'] != '1'){echo 'disabled';}?> >
        <legend>Service<input name="check" type="checkbox" value="1" <?php if($field5['check'] == '1') echo 'checked = "checked"'; ?> onclick="document.getElementById('fieldset').disabled = !this.checked;" /></legend>
        <table>
          <tr>
            <td><label for="service">Service:</label></td>
            <td>
                <select name="service" id="service">
                	<?php
					  echo '<option value="0">Select Employee</option>';
						$SQL = mysql_query("SELECT * FROM `service` ORDER BY `name` ASC");
						  if(mysql_num_rows($SQL)>=1){
							 while($field = mysql_fetch_assoc($SQL)){
							   echo '<option ';?><?php active($field['id_service'],$field2['id_service'])?><?php echo' value='.$field['id_service'].'>'.$field['name'].'</option>'; 
							 }
						  }else{
							   echo '<option value="0">No value found</option>'; 
						  }
					  ?>
                </select>
            </td>
            <td><label for="budget_service">Budget Service:</label></td>
            <td><input type="text" value="<?php echo $field5['budget'];?>" name="budget_service" id="budget_service" /></td>
          </tr>
          <tr>
            <td><label for="sending_date">Sending Date:</label></td>
            <td colspan="3"><input type="text"value="<?php echo $field5['sending_date'];?>" placeholder="0000-00-00 00:00:00" name="sending_date" id="sending_date" /></td>

          </tr>
          <tr>
            <td><label for="delivery_date">Delivery Date:</label></td>
            <td colspan="3"><input type="text" value="<?php echo $field5['delivery_date'];?>" placeholder="0000-00-00 00:00:00" name="delivery_date" id="delivery_date" /></td>

          </tr>
          <tr>
            <td colspan="4"><label for="reported_problem">Reported Problem:</label></td>

          </tr>
          <tr>
            <td colspan="4"><textarea name="reported_problem" id="reported_problem" cols="45" rows="2"><?php echo $field5['reported_problem'];?></textarea></td>
          </tr>
          <tr>
            <td colspan="2">Equipment has been Repaired:</td>
            <td colspan="2"><input type="radio" name="radio" id="radio" value="1" <?php if($field5['confirmation']=='1'){ echo 'checked="checked"';}?>/>
            <label for="radio">Yes</label>
              <input type="radio" name="radio" id="radio" value="0" <?php if($field5['confirmation']=='0'){ echo 'checked="checked"';}?>/>
            No</label></td>
          </tr>
        </table>
      </fieldset>
      <table>
        <tr>
          <td><label for="budget">Budget:</label></td>
          <td colspan="2"><input type="text" value="<?php echo $field2['budget'];?>" name="budget" id="budget" /></td>
        </tr>
        <tr>
        	<td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td><input type="submit" name="submit" class="submit" value="Save" /></td>
          <td><input type="submit" name="submit2" class="submit" value="Save and Print" /></td>
          <td><input type="submit" name="submit3" class="submit" value="Save and Print Bill" /></td>
        </tr>
      </table>
    </form>  
  </div>
</div>
<?php 
if(isset($_POST['submit']) || isset($_POST['submit2'])|| isset($_POST['submit3'])){
    $client = protect($_POST['client']);
	$status = protect($_POST['status']);
	$employee = protect($_POST['employee']);
	$initial_date = protect($_POST['initial_date']);
	$final_date = protect($_POST['final_date']);
	$working_hours = protect($_POST['working_hours']);
	$equipment = protect($_POST['equipment']);
	$mark = protect($_POST['mark']);
	$n_serie = protect($_POST['n_serie']);
	$accessories = protect($_POST['accessories']);
	$problem = protect($_POST['problem']);
	$descri_client = protect($_POST['descri_client']);
	$descri_employee = protect($_POST['descri_employee']);
	$service_provided = protect($_POST['service_provided']);
	$material_supplied = protect($_POST['material_supplied']);
	$check = protect($_POST['check']);
	$service = protect($_POST['service']);
	$budget_service = protect($_POST['budget_service']);
	$sending_date = protect($_POST['sending_date']);
	$delivery_date = protect($_POST['delivery_date']);
	$reported_problem = protect($_POST['reported_problem']);
	$radio = protect($_POST['radio']);
	$budget = protect($_POST['budget']);

	if($check==0){
		$budget_service = ' ';
		$sending_date = ' ';
		$delivery_date = ' ';
		$reported_problem = ' ';
		$radio = ' ';
		$servic = ' ';
		$name = protect($_POST['name']);
    	$address = protect($_POST['address']);
    	$phone = protect($_POST['phone']);  
		}

   if($client==0){
		if($field4['private']==0){
		mysql_query("INSERT INTO `client` VALUE('','".$name."','".$address."','','".$phone."','1')");
		$cli = mysql_result(mysql_query("SELECT MAX(`id_client`) FROM `client`"),0,0);	
		} else{
		mysql_query("UPDATE `client` SET `name`='".$name."' , `address`='".$address."' , `phone`='".$phone."' , `private`='1' WHERE `id_client`='".$cli."'")or die(mysql_error());	
		}
    }else{
		if($field4['private']==1){
		mysql_query("DELETE FROM `client` WHERE `id_client`='".$cli."'")or die(mysql_error());
		$cli = $client;	
		}
	}
	
    mysql_query("UPDATE `equipment` SET `id_user`='".$employee."' , `id_client`='".$client."' , `id_service`='".$service."' ,  `budget`='".$budget."' , `equipment`='".$equipment."' , `mark/model`='".$mark."' , `n_serie`='".$n_serie."' , `accessories`='".$accessories."' , `service`='".$service_provided."' , `provided`='".$material_supplied."' WHERE `id`='".$_GET['id']."'")or die(mysql_error());
	
    mysql_query("UPDATE `equip_problem` SET `problem/damage`='".$problem."' , `description(client)`='".$descri_client."' , `description(employee)`='".$descri_employee."'  WHERE `id`='".$id."'")or die(mysql_error());
	
    mysql_query("UPDATE `equip_status` SET `start_date`='".$initial_date."' , `end_date`='".$final_date."' , `final_time`='".$working_hours."' , `status`='".$status."' WHERE `id`='".$id."'")or die(mysql_error());
	
    mysql_query("UPDATE `service_problem` SET `check`='".$check."' , `budget`='".$budget_service."' , `reported_problem`='".$reported_problem."' , `sending_date`='".$sending_date."' , `delivery_date`='".$delivery_date."' , `confirmation`='".$radio."'  WHERE `id`='".$id."'")or die(mysql_error());
	
    
    
       
    if(isset($_POST['submit2'])){
        header('Location:'.check('home.php').'?imp=0&id='.$id.'&idcli='.$cli.'');
    }elseif(isset($_POST['submit3'])){
        header('Location:'.check('home.php').'?imp=1&id='.$id.'&idcli='.$cli.'&empr='.$empr.'');
    }else{
        header('Location:'.check('home.php')); 
    }
}
?>
<?php include("inc/footer.php"); ?>