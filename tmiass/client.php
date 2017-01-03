<?php include("inc/head.php"); 

if(!isset($_SESSION['id'])){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<title>Takemore.com - Client</title>
<?php include("inc/header.php"); ?>
<?php include("inc/menu.php"); ?>
<div id="content">
  <div class="titlecontent">
    <p><a href="<?php echo check('home.php'); ?>">Home</a><span> >> </span><a href="<?php echo check('client.php'); ?>">Client</a></p>
  </div>
  <div class="bodycontent">
    <div id="left-column">
      <form id="client_form" name="client_form" method="POST" action="<?php echo $current_file; ?>">
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
			  $SQL1 = mysql_query("SELECT * FROM `client` WHERE `name`='".$name."' AND `private`='0'")or die(mysql_error());
              $SQL2 = mysql_query("SELECT * FROM `client` WHERE `address`='".$address."'  AND `private`='0'")or die(mysql_error());
			  
			  if(mysql_num_rows($SQL1)==1){
                 echo 'Name "'.$name.'" exists';
              }else if(mysql_num_rows($SQL2)==1){
                 echo 'Address "'.$address.'" exists';
              }else{
                 mysql_query("INSERT INTO `client`(`name`,`address`,`email`,`phone`,`private`) VALUE('".$name."','".$address."','".$email."','".$phone."','0')") or die(mysql_error());
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
            $SQL= mysql_query("SELECT * FROM `client` WHERE `private`='0' ORDER BY `name` ASC")or die(mysql_error());
            if(mysql_num_rows($SQL)>0){
              while($field = mysql_fetch_assoc($SQL)){
                 echo '<tr>';
                 echo '<td> '.$field['name'].' </td>';
                 echo '<td> '.$field['address'].' </td>';
                 echo '<td> '.$field['email'].' </td>';
                 echo '<td> '.$field['phone'].' </td>';
                 echo '<td> 
				         <a class="myButton" href="'.check('client.edit.php').'?id='.$field['id_client'].'">Edit</a> 
						 <a class="myButton" href="'.check('client.editar.php').'?apg='.$field['id_client'].'">Delete</a> 
					   </td>';
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