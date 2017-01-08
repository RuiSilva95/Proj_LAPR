<?php include("inc/head.php"); 

if(!isset($_SESSION['id'])){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<title>Takemore.com - Service</title>
<?php include("inc/header.php"); ?>
<?php include("inc/menu.php"); ?>
<div id="content">
  <div class="titlecontent">
    <p><a href="<?php echo check('home.php'); ?>">Home</a><span> >> </span><a href="<?php echo check('service.php'); ?>">Service</a></p>
  </div>
  <div class="bodycontent">
    <div id="left-column">
     <form id="service_form" name="service_form" method="POST" action="<?php echo $current_file; ?>">
        <table width="261">
          <?php 
			if(isset($_POST['submit'])){
			  $name = protect($_POST['name']);
			  $address = protect($_POST['address']);
			  $email = protect($_POST['email']);
			  $phone = protect($_POST['phone']);
			  if(empty($name)&& empty($address)){
						echo 'The name and address field are required';
			  }else{
				  $SQL1 = mysqli_query($conn,"SELECT * FROM `service` WHERE `name`='".$name."'")or die("Error:".mysqli_error($conn));
				  $SQL2 = mysqli_query($conn,"SELECT * FROM `service` WHERE `address`='".$address."'")or die("Error:".mysqli_error($conn));
				  
				  if(mysqli_num_rows($SQL1)==1){
                    echo 'Name "'.$name.'" exist';
                  }else if(mysqli_num_rows($SQL2)==1){
                    echo 'Address "'.$address.'" exist';
                  }else{
                    mysqli_query($conn,"INSERT INTO `service`(`name`,`address`,`email`,`phone`) VALUE('".$name."','".$address."','".$email."','".$phone."')") or die("Error:".mysqli_error($conn));
                  }
			 }
		}
          ?>
          <tr>
            <td width="84"><label for="name">Name*:</label></td>
            <td width="171"><input name="name" type="text" id="name" maxlength="50" /></td>
          </tr>
          <tr>
            <td><label for="address">Address*:</label></td>
            <td><input name="address" type="text" id="address" maxlength="100" /></td>
          </tr>
          <tr>
            <td><label for="email">Email:</label></td>
            <td><input name="email" type="text" id="email" maxlength="100" /></td>
          </tr>
          <tr>
            <td><label for="phone">Phone:</label></td>
            <td><input name="phone" type="text" id="phone" maxlength="9" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" value="Create" /></td>
          </tr>
       </table>
     </form>
     </div>
     <div id="right-column">
       <table name="list" id="list">
          <tr>
            <th scope="col">Name:</th>
            <th scope="col">Address:</th>
            <th scope="col">Email:</th>
            <th scope="col">Phone:</th>
            <th width="170" scope="col"></th>
          </tr>
		  <?php 
            $SQL= mysqli_query($conn,"SELECT * FROM `service` ORDER BY `name` ASC")or die("Error:".mysqli_error($conn));
            if(mysqli_num_rows($SQL)>0){
              while($field = mysqli_fetch_assoc($SQL)){
                 echo '<tr>';
                 echo '<td> '.$field['name'].' </td>';
                 echo '<td> '.$field['address'].' </td>';
                 echo '<td> '.$field['email'].' </td>';
                 echo '<td> '.$field['phone'].' </td>';
                 echo '<td> <a class="myButton" href="'.check('service.edit.php').'?id='.$field['id_service'].'">Edit</a>
				            <a class="myButton" href="'.check('service.edit.php').'?apg='.$field['id_service'].'">Delete</a> </td>';
                 echo '</tr>';
                 echo '</tr>';
               }
           }else{
              echo '<tr>';
              echo '<td colspan="5"> No field found </td>';
              echo '</tr>';
           }
                    ?>          
        </table>
     </div>
  </div>
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
</div>
<?php include("inc/footer.php"); ?>