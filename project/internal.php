<?php include("inc/head.php"); 

if(!isset($_SESSION['id'])){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<title>Takemore.com - Internal</title>
<?php include("inc/header.php"); ?>
<?php include("inc/menu.php"); ?>
<div id="content">
  <div class="titlecontent">
 <p><a href="<?php echo check('home.php'); ?>">Home</a> <span> >> </span><a href="#">Sheet Repair</a><span> >> </span><a href="<?php echo check('internal.php'); ?>">Internal</a></p>
  </div>
  <div class="bodycontent">
    <form id="repair_form" name="repair_form" method="POST" action="<?php echo $current_file; ?>">
      <?php
	  if(isset($_POST['submit']) || isset($_POST['submit2'])){
		  $client = protect($_POST['client']);
		  $status = protect($_POST['status']);
		  $employee = protect($_POST['employee']);
		  $name = protect($_POST['name']);
		  $address = protect($_POST['address']);
		  $phone = protect($_POST['phone']);
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
		  $cod = rand();
		  
		  
		  if($check==0){
			$budget_service = ' ';
			$sending_date = ' ';
			$delivery_date = ' ';
			$reported_problem = ' ';
			$radio = ' ';
			$service = ' ';
			}
		  
		  if($status==0 && $employee==0){
			  echo 'Fill required fields';
		  }else{
			  if($client==0 ){ 
			  	 if(empty($name)){	
                	echo 'If not selected Client. Write at least name';
					$verf = 1;
				 }else{ 
					 mysqli_query($conn,"INSERT INTO `client` VALUE('','".$name."','".$address."','','".$phone."','1')");
					 $client = mysqli_result(mysqli_query($conn,"SELECT MAX(`id_client`) FROM `client`"),0,0);
				 }
				if(empty($verf)) {
			  mysqli_query($conn,"INSERT INTO `equipment` VALUE('','".$employee."','".$client."','".$service."','2','".$cod."','".$budget."','".$equipment."','".$mark."','".$n_serie."','".$accessories."','".$service_provided."','".$material_supplied."')")or die("Error:".mysqli_error($conn));
              mysqli_query($conn,"INSERT INTO `equip_problem` VALUE('','".$problem."','".$descri_client."','".$descri_employee."')")or die("Error:".mysqli_error($conn));
              mysqli_query($conn,"INSERT INTO `equip_status` VALUE('','".$status."','".$initial_date."','".$final_date."','".$working_hours."')")or die("Error:".mysqli_error($conn));
			  mysqli_query($conn,"INSERT INTO `service_problem` VALUE('','".$check."','".$budget_service."','".$radio."','".$reported_problem."','".$sending_date."','".$delivery_date."')")or die("Error:".mysqli_error($conn));
              if(isset($_POST['submit2'])){
                $SQL = mysqli_query($conn,"Select * FROM `equipment` WHERE `cod`='$cod'");
                $SQL = mysqli_fetch_assoc($SQL);
                $id = $SQL['id'];
                $idcli = $SQL['id_client'];
                header('Location:'.check('home.php').'?imp=0&id='.$id.'&idcli='.$idcli.'');
              }else{
                header('Location:'.check('home.php'));
              }
			  }
		  	}
		  }
	  }
	  ?>
      <table>
        <tr>
          <td><label for="client">Client:</label></td>
          <td>
              <select name="client" onchange="verificaOpcao(this.value)">
                <?php 
				echo '<option value="0">Select Client</option>';
                $SQL = mysqli_query($conn,"SELECT * FROM `client` WHERE `private`='0' ORDER BY `name` ASC");
                  if(mysqli_num_rows($SQL)>=1){
                     while($field = mysqli_fetch_assoc($SQL)){
                       echo '<option value='.$field['id_client'].'>'.$field['name'].'</option>'; 
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
               <option value='0'>Select Status</option>
               <option value="Waits">Waits</option>
               <option value="Budgeted">Budgeted</option>
               <option value="Under Repair">Under Repair</option>
               <option value="Closed Billing">Closed Billing</option>
               <option value="Closed guarantee">Closed guarantee</option>
               <option value="Closed Contract">Closed Contract</option>
               <option value="Archive">Archive</option>
              </select>
          </td>
          <td><label for="employee">Employee*:</label></td>
          <td>
              <select name="employee" id="employee">
              <?php
              echo '<option value="0">Select Employee</option>';
                $SQL = mysqli_query($conn,"SELECT * FROM `users`  ORDER BY `username` ASC");
                  if(mysqli_num_rows($SQL)>=1){
                     while($field = mysqli_fetch_assoc($SQL)){
                       echo '<option value='.$field['id_user'].'>'.$field['name'].'</option>'; 
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
          <td><input type="text" name="name" id="client" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><label for="address">Address:</label></td>
          <td><input type="text" name="address" id="client1" /></td>
          <td><label for="phone">Phone:</label></td>
          <td><input type="text" name="phone" id="client2" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><label for="initial_date">Initial Date:</label></td>
          <td><input type="text" placeholder="0000-00-00 00:00:00" name="initial_date" id="initial_date" onchange="javascript('1')"/></td>
          <td><label for="final_date">Final Date:</label></td>
          <td><input type="text" placeholder="0000-00-00 00:00:00" name="final_date" id="final_date" onchange="javascript('1')"/></td>
          <td><label for="working_hours">Working Hours:</label></td>
          <td><input type="text" name="working_hours" id="working_hours" readonly/></td>
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
          <td><input type="text" name="equipment" id="equipment" /></td>
          <td><input type="text" name="mark" id="mark" /></td>
          <td><input type="text" name="n_serie" id="n_serie" /></td>
          <td><input type="text" name="accessories" id="accessories" /></td>
        </tr>
      </table>
      <table>
        <tr>
          <td><label for="problem">Problem/Damage:</label></td>
          <td><textarea name="problem" id="problem" cols="45" rows="2"></textarea></td>
        </tr>
        <tr>
          <td><label for="descri_client">Description(Client):</label></td>
          <td><textarea name="descri_client" id="descri_client" cols="45" rows="2"></textarea></td>
        </tr>
        <tr>
          <td><label for="descri_employee">Description(Employee):</label></td>
          <td><textarea name="descri_employee" id="descri_employee" cols="45" rows="2"></textarea></td>
        </tr>
        <tr>
          <td><label for="service_provided">Service Provided:</label></td>
          <td><textarea name="service_provided" id="service_provided" cols="45" rows="2"></textarea></td>
        </tr>
        <tr>
          <td><label for="material_supplied">Material Supplied:</label></td>
          <td><textarea name="material_supplied" id="material_supplied" cols="45" rows="2"></textarea></td>
        </tr>
      </table>
      <fieldset id="fieldset" disabled>
        <legend>Service<input name="check" type="checkbox" onclick="document.getElementById('fieldset').disabled = !this.checked;" /></legend>
        <table>
          <tr>
            <td><label for="service">Service:</label></td>
            <td>
                <select name="service" id="service">
                	<?php
					  echo '<option value="0">Select Employee</option>';
						$SQL = mysqli_query($conn,"SELECT * FROM `service` ORDER BY `name` ASC");
						  if(mysqli_num_rows($SQL)>=1){
							 while($field = mysqli_fetch_assoc($SQL)){
							   echo '<option value='.$field['id_service'].'>'.$field['name'].'</option>'; 
							 }
						  }else{
							   echo '<option value="0">No value found</option>'; 
						  }
					  ?>
                </select>
            </td>
            <td><label for="budget_service">Budget Service:</label></td>
            <td><input type="text" name="budget_service" id="budget_service" /></td>
          </tr>
          <tr>
            <td><label for="sending_date">Sending Date:</label></td>
            <td colspan="3"><input type="text" placeholder="0000-00-00 00:00:00" name="sending_date" id="sending_date" /></td>

          </tr>
          <tr>
            <td><label for="delivery_date">Delivery Date:</label></td>
            <td colspan="3"><input type="text" placeholder="0000-00-00 00:00:00" name="delivery_date" id="delivery_date" /></td>

          </tr>
          <tr>
            <td colspan="4"><label for="reported_problem">Reported Problem:</label></td>

          </tr>
          <tr>
            <td colspan="4"><textarea name="reported_problem" id="reported_problem" cols="45" rows="2"></textarea></td>
          </tr>
          <tr>
            <td colspan="2">Equipment has been Repaired:</td>
            <td colspan="2"><input type="radio" name="radio" id="radio" value="1" />
            <label for="radio">Yes</label>
              <input type="radio" name="radio" id="radio" value="0" />
            No</label></td>
          </tr>
        </table>
      </fieldset>
      <table>
        <tr>
          <td><label for="budget">Budget:</label></td>
          <td colspan="2"><input type="text" name="budget" id="budget" /></td>
        </tr>
        <tr>
        	<td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td><input type="submit" name="submit" class="submit" value="Save" /></td>
          <td><input type="reset" name="clean" class="submit" value="Clean" /></td>
          <td><input type="submit" name="submit2" class="submit" value="Save and Print" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include("inc/footer.php"); ?>