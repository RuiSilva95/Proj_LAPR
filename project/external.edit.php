<?php require "inc/head.php"; 

if(!isset($_SESSION['id'])) {
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<?php require "inc/header.php"; ?>
<?php require "inc/menu.php"; ?>
<div id="content">
  <div class="titlecontent">
    <p><a href="<?php echo check('home.php'); ?>">Home</a> <span> >> </span><a href="#">Sheet Repair</a><span> >> </span><a href="#">External</a><span> >> </span><a href="#">External Edit</a></p>
  </div>
  <div class="bodycontent">
    <?php
        $id = protect($_GET['id']);
        $apg = protect($_GET['apg']);
        $cli = protect($_GET['cli']);
        $empr = protect($_GET['empr']);

    if(!empty($apg)) {
        mysqli_query($conn, "DELETE FROM `equip_problem` WHERE `id`='$apg'")or die("Error:".mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM `equipment` WHERE `id`='$apg'")or die("Error:".mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM `equip_status` WHERE `id`='$apg'")or die("Error:".mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM `service_problem` WHERE `id`='$apg'")or die("Error:".mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM `client` WHERE `id_client`='$cli' AND `private`='1'")or die("Error:".mysqli_error($conn));

        header('Location:'.'home.php');
    }elseif(!empty($id)) {
        $SQL1 = mysqli_query($conn, "SELECT * FROM `equip_problem` WHERE `id`='$id'")or die("Error:".mysqli_error($conn));
        $SQL2 = mysqli_query($conn, "SELECT * FROM `equipment` WHERE `id`='$id'")or die("Error:".mysqli_error($conn));
        $SQL3 = mysqli_query($conn, "SELECT * FROM `equip_status` WHERE `id`='$id'")or die("Error:".mysqli_error($conn));
        $SQL4 = mysqli_query($conn, "SELECT * FROM `client` WHERE `id_client`='$cli'")or die("Error:".mysqli_error($conn));

        $field1 = mysqli_fetch_assoc($SQL1);
        $field2 = mysqli_fetch_assoc($SQL2);
        $field3 = mysqli_fetch_assoc($SQL3);
        $field4 = mysqli_fetch_assoc($SQL4);
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
                $SQL = mysqli_query($conn, "SELECT * FROM `client` WHERE `private`='0' ORDER BY `name` ASC");
                if(mysqli_num_rows($SQL)>=1) {
                    while($field = mysqli_fetch_assoc($SQL)){
                        echo '<option ';?><?php active($field['id_client'], $cli)?><?php echo' value="'.$field['id_client'].'">'.$field['name'].'</option>';
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
               <option <?php active('0', $field3['status'])?> value='0'>Select Status</option>
               <option <?php active('Waits', $field3['status'])?> value="Waits">Waits</option>
               <option <?php active('Budgeted', $field3['status'])?> value="Budgeted">Budgeted</option>
               <option <?php active('Under Repair', $field3['status'])?> value="Under Repair">Under Repair</option>
               <option <?php active('Closed Billing', $field3['status'])?> value="Closed Billing">Closed Billing</option>
               <option <?php active('Closed Guaranty', $field3['status'])?> value="Closed Guaranty">Closed Guaranty</option>
               <option <?php active('Closed Contract', $field3['status'])?> value="Closed Contract">Closed Contract</option>
               <option <?php active('Archive', $_POST['status'])?> value="Archive">Archive</option>
              </select>
          </td>
          <td><label for="employee">Employee*:</label></td>
          <td>
             <select name="employee" id="employee">
                <?php
                echo '<option value="">Select Status</option>';
                $SQL = mysqli_query($conn, "SELECT * FROM `users` ORDER BY `name` ASC");
                if(mysqli_num_rows($SQL)>=1) {
                    while($field = mysqli_fetch_assoc($SQL)){
                        echo '<option ';?><?php active($field['name'], $empr)?><?php echo ' value="'.$field['id_user'].'">'.$field['name'].'</option>';
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
          <td colspan="5"><input <?php if($field4['private']!=1) {echo 'disabled="true"';
         }else{$var = $field4['name'];
}?> type="text" name="name" id="client" value="<?php echo $var; ?>"/></td>
        </tr>
        <tr>
          <td><label for="address">Address:</label></td>
          <td><input <?php if($field4['private']!=1) {echo 'disabled="true"';
         }else{$var = $field4['address'];
}?> type="text" name="address" id="client1" value="<?php echo $var; ?>"/></td>
          <td><label for="phone">Phone:</label></td>
          <td colspan="3"><input <?php if($field4['private']!=1) {echo 'disabled="true"';
         }else{$var = $field4['phone'];
}?> type="text" name="phone" id="client2" value="<?php echo $var; ?>"/></td>
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
            <td><label for="description">Description:</label></td>
            <td><textarea name="description" id="description" cols="45" rows="2"><?php echo $field1['description(employee)']; ?></textarea></td>
          </tr>
          <tr>
            <td><label for="service_provided">Service Provided:</label></td>
            <td><textarea name="service_provided" id="service_provided" cols="45" rows="2"><?php echo $field2['service']; ?></textarea></td>
          </tr>
        </table>
        <table>
          <tr>
            <td><label for="budget">Budget:</label></td>
            <td colspan="2"><input type="text" value="<?php echo $field2['budget']; ?>" name="budget" id="budget" /></td>
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
<?php
if(isset($_POST['submit']) || isset($_POST['submit2'])) {
    $client = protect($_POST['client']);
    $status = protect($_POST['status']);
    $employee = protect($_POST['employee']);
    $initial_date = protect($_POST['initial_date']);
    $final_date = protect($_POST['final_date']);
    $working_hours = protect($_POST['working_hours']);
    $description = protect($_POST['description']);
    $service_provided = protect($_POST['service_provided']);
    $budget = protect($_POST['budget']);
    $name = protect($_POST['name']);
    $address = protect($_POST['address']);
    $phone = protect($_POST['phone']);

    if($client==0) {
        if($field4['private']==0) {
              mysqli_query($conn, "INSERT INTO `client` VALUE('','".$name."','".$address."','','".$phone."','1')");
              $cli = mysqli_result(mysqli_query($conn, "SELECT MAX(`id_client`) FROM `client`"), 0, 0);
        } else{
              mysqli_query($conn, "UPDATE `client` SET `name`='".$name."' , `address`='".$address."' , `phone`='".$phone."' , `private`='1' WHERE `id_client`='".$cli."'")or die("Error:".mysqli_error($conn));
        }
    }else{
        if($field4['private']==1) {
              mysqli_query($conn, "DELETE FROM `client` WHERE `id_client`='".$cli."'")or die("Error:".mysqli_error($conn));
              $cli = $client;
        }
    }

    mysqli_query($conn, "UPDATE `equipment` SET `id_user`='$employee' , `id_client`='".$cli."' ,  `service`='".$service_provided."' , `budget`='".$budget."' WHERE `id`='".$id."'")or die("Error:".mysqli_error($conn));
    mysqli_query($conn, "UPDATE `equip_problem` SET  `description(employee)`='".$description."'  WHERE `id`='".$id."'")or die("Error:".mysqli_error($conn));
    mysqli_query($conn, "UPDATE `equip_status` SET `status`='".$status."' , `start_date`='".$initial_date."' , `end_date`='".$final_date."' , `final_time`='".$working_hours."'  WHERE `id`='".$id."'")or die("Error:".mysqli_error($conn));

    if(isset($_POST['submit2'])) {
        header('Location:'.check('home.php').'?imp=1&id='.$id.'&idcli='.$cli.'&empr='.$empr.'');
    }else{
        header('Location:'.check('home.php'));
    }
}
?>

<?php require "inc/footer.php"; ?>
