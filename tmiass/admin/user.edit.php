<?php include("../inc/head.php"); 

if(!isset($_SESSION['id']) && $_SESSION['id']==2){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<?php include("../inc/header.php"); ?>
<?php include("../inc/menu.php"); ?>
<div id="content">
  <div class="titlecontent">
    <p><a href="<?php echo check('home.php'); ?>">Home</a> <span> >> </span> Administrador <span> >> </span><a href="<?php echo check('user.php'); ?>">User Management</a><span> >> </span><a href="#">Change User</a></p>
  </div>
  <div class="bodycontent">
  <?php
   $id = protect($_GET['id']);
   $apg = protect($_GET['apg']);
        
   if(!empty($apg)){
     mysql_query("DELETE FROM `users` WHERE `id_user`='".$apg."'")or die(mysql_error());
     header('Location:'.check('user.php'));
   }elseif(!empty($id)){
     $SQL = mysql_query("SELECT * FROM `users` WHERE `id_user`='".$id."'")or die(mysql_error());
     $field = mysql_fetch_assoc($SQL);
     if($_POST['submit']){
		$name = protect($_POST['name']);
		$username = protect($_POST['username']);
		$password = protect($_POST['password']);
		$email = protect($_POST['email']);
		$status = protect($_POST['status']);
		if(empty($password)){
			$password = $field['password'];
		}else{
			$password = md5($password);
			}
		$SQL1 = mysql_query("SELECT * FROM `users` WHERE `username`='".$username."' AND `id_user`!='".$id."'")or die(mysql_error());
		$SQL2 = mysql_query("SELECT * FROM `users` WHERE `email`='".$email."' AND `id_user`!='".$id."'")or die(mysql_error());
		$SQL3 = mysql_query("SELECT * FROM `users` WHERE `name`='".$name."' AND `id_user`!='".$id."'")or die(mysql_error());
				if(mysql_num_rows($SQL1)==1){
				  echo 'Username '.$username.' exist';
				}elseif(mysql_num_rows($SQL2)==1){
				  echo 'Email '.$email.' exist'; 
				}elseif(mysql_num_rows($SQL3)==1){
				  echo 'Name '.$name.' exist'; 	
				}else{
		            mysql_query("UPDATE `users` SET `username`='".$username."',`password`='".$password."',`email`='".$email."',`status`='".$status."' WHERE `id_user`='".$id."'")or die(mysql_Error()); 
		            header('Location:'.check('user.php'));
				}
        }
    }
  ?>
  <form action="" method="POST">
      <table>
        <tr>
          <td><label for="username">Username*:</label></td>
          <td><input type="text" name="username" id="username" value="<?php echo $field['username']; ?>"/></td>
        </tr>
        <tr>
          <td><label for="name">Name*:</label></td>
          <td><input type="text" name="name" id="name" value="<?php echo $field['name']; ?>"/></td>
        </tr>
        <tr>
          <td><label for="password">Password*:</label></td>
          <td><input type="text" name="password" id="password" /></td>
        </tr>
        <tr>
          <td><label for="email">Email*:</label></td>
          <td><input type="text" name="email" id="email" value="<?php echo $field['email']; ?>"/></td>
        </tr>
        <tr>
          <td><label for="status">Status</label></td>
          <td>
            <select name="status" id="status" onchange="verificaOpcao(this.value)">
               <option <?php active($field['status'],'0')?> value='0'>Employee</option>
               <option <?php active($field['status'],'2')?> value='2'>Administrator</option>
            </select>
          </td>
        </tr>
        <tr>
         <td></td>
         <td><input type="submit" value="Change" name="submit"/></td>
       </tr>
     </table>     
   </form>
  </div>
</div>
<?php include("../inc/footer.php"); ?>