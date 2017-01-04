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
     <p><a href="<?php echo check('home.php'); ?>">Home</a><span> >> </span><a href="<?php echo check('service.php'); ?>">Service</a><span> >> </span><a href="#">Change Service</a></p>
  </div>
  <div class="bodycontent">
    <?php
    $id = protect($_GET['id']);
    $apg = protect($_GET['apg']);
    if(!empty($apg)){
        mysqli_query($conn,"DELETE FROM `service` WHERE `id_service`='".$apg."'")or die(mysqli_error());
        header('Location:'.check('service.php'));
    }elseif(!empty($id)){
        $SQL = mysqli_query($conn,"SELECT * FROM `service` WHERE `id_service`='".$id."'")or die(mysqli_error());
        $field = mysqli_fetch_assoc($SQL);
        if($_POST['submit']){
            $name = protect($_POST['name']);
            $address = protect($_POST['address']);
            $email = protect($_POST['email']);
            $phone = protect($_POST['phone']); 
			$SQL1 = mysqli_query($conn,"SELECT * FROM `service` WHERE `name`='".$name."' AND `id_service`!='".$id."'")or die(mysqli_error());
		 $SQL2 = mysqli_query($conn,"SELECT * FROM `service` WHERE `email`='".$email."' AND `id_service`!='".$id."'")or die(mysqli_error());
				if(mysqli_num_rows($SQL1)==1){
				  echo 'Name '.$name.' exist';
				}elseif(mysqli_num_rows($SQL2)==1){
				  echo 'Email '.$email.' exist'; 
				}else{	
                    mysqli_query($conn,"UPDATE `service` SET `name`='".$name."',`address`='".$address."',`email`='".$email."',`phone`='".$phone."' WHERE `id_service`='".$id."'")or die(mysqli_error());
                    header('Location:'.check('service.php'));
				}
        }
    }
    ?>
    <form method="POST">
      <table>
        <tr>
          <td><label for="name">Name*:</label></td>
          <td><input type="text" name="name" id="name" value="<?php echo $field['name'] ; ?>"/></td>
        </tr>
        <tr>
          <td><label for="address">Morada*:</label></td>
          <td><input type="text" name="address" id="address" value="<?php echo $field['address'] ; ?>"/></td>
        </tr>
        <tr>
          <td><label for="email">Email:</label></td>
          <td><input type="text" name="email" id="email" value="<?php echo $field['email'] ; ?>"/></td>
        </tr>
        <tr>
          <td><label for="phone">Phone:</label></td>
          <td><input type="text" name="phone" id="phone"  maxlength="9" value="<?php echo $field['phone'] ; ?>"/></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Change" name="submit" class="submit"/></td>
        </tr>
      </table>          
    </form>
  </div>
</div>
<?php include("inc/footer.php"); ?>