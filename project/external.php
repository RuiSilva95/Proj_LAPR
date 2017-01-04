<?php require "inc/head.php"; 

if(!isset($_SESSION['id'])) {
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<title>Takemore.com - External</title>
<?php require "inc/header.php"; ?>
<?php require "inc/menu.php"; ?>
<div id="content">
  <div class="titlecontent">
 <p><a href="<?php echo check('home.php'); ?>">Home</a> <span> >> </span><a href="#">Sheet Repair</a><span> >> </span><a href="<?php echo check('external.php'); ?>">External</a></p>
  </div>
  <div class="bodycontent">
    <form id="repair_form" name="repair_form" method="POST" action="<?php echo $current_file; ?>">
        <?php
        if(isset($_POST['submit']) || isset($_POST['submit2'])) {
              $client = protect($_POST['client']);
              $status = protect($_POST['status']);
              $employee = protect($_POST['employee']);
              $name = protect($_POST['name']);
              $address = protect($_POST['address']);
              $phone = protect($_POST['phone']);
              $initial_date = protect($_POST['initial_date']);
              $final_date = protect($_POST['final_date']);
              $working_hours = protect($_POST['working_hours']);
              $description = protect($_POST['description']);
              $service_provided = protect($_POST['service_provided']);
              $budget = protect($_POST['budget']);
              $cod = rand();
            if($status==0 && $employee==0) {
                echo 'Fill required fields';
            }else{
                if($client==0) {
                    if(empty($name)) {
                         echo 'If not selected Client. Write at least name';
                        $verf = 1;
                    }else{
                        mysqli_query($conn, "INSERT INTO `client` VALUE('','".$name."','".$address."','','".$phone."','1')");
                        $client = mysqli_result(mysqli_query($conn, "SELECT MAX(`id_client`) FROM `client`"), 0, 0);
                    }
                }
                if(empty($verf)) {
                    mysqli_query($conn, "INSERT INTO `equipment` VALUE('','".$employee."','".$client."','','1','".$cod."','".$budget."','','','','','".$service_provided."','')")or die(mysqli_error());
                    mysqli_query($conn, "INSERT INTO `equip_problem` VALUE('','','','".$description."')")or die(mysqli_error());
                    mysqli_query($conn, "INSERT INTO `equip_status` VALUE('','".$status."','". $initial_date."','".$final_date."','".$working_hours."')")or die(mysqli_error());
                    mysqli_query($conn, "INSERT INTO `service_problem` VALUE('','','','','','','')")or die(mysqli_error());
                    if(isset($_POST['submit2'])) {
                         $SQL = mysqli_query($conn, "Select * FROM `equipment` WHERE `cod`='$cod'");
                         $SQL = mysqli_fetch_assoc($SQL);
                         $id = $SQL['id'];
                         $idcli = $SQL['id_client'];
                         header('Location:'.check('home.php').'?imp=1&id='.$id.'&idcli='.$idcli.'&empr='.$employee.'');
                    }else{
                         header('Location:'.check('home.php'));
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
                $SQL = mysqli_query($conn, "SELECT * FROM `client` WHERE `private`='0' ORDER BY `name` ASC");
                if(mysqli_num_rows($SQL)>=1) {
                    while($field = mysqli_fetch_assoc($SQL)){
                        echo '<option';?><?php active($field['id_client'], $client)?><?php echo' value='.$field['id_client'].'>'.$field['name'].'</option>';
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
                $SQL = mysqli_query($conn, "SELECT * FROM `users`  ORDER BY `username` ASC");
                if(mysqli_num_rows($SQL)>=1) {
                    while($field = mysqli_fetch_assoc($SQL)){
                        echo '<option';?><?php active($field['id_user'], $employee)?><?php echo'  value='.$field['id_user'].'>'.$field['name'].'</option>';
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
          <td colspan="5"><input type="text" name="name" id="client" /></td>
        </tr>
        <tr>
          <td><label for="address">Address:</label></td>
          <td><input type="text" name="address" id="client1" /></td>
          <td><label for="phone">Phone:</label></td>
          <td colspan="3"><input type="text" name="phone" id="client2" /></td>
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
            <td><label for="description">Description:</label></td>
            <td><textarea name="description" id="description" cols="45" rows="2"></textarea></td>
          </tr>
          <tr>
            <td><label for="service_provided">Service Provided:</label></td>
            <td><textarea name="service_provided" id="service_provided" cols="45" rows="2"></textarea></td>
          </tr>
        </table>
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
            <td><input type="submit" name="submit2" class="submit" value="Save and Print Bill" /></td>
          </tr>
        </table>
    </form>
  </div>
</div>
<?php require "inc/footer.php"; ?>
