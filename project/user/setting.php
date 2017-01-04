<?php include("../inc/head.php"); 

if(!isset($_SESSION['id']) && $_SESSION['id']==2){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<title>Takemore.com - Setting</title>
<?php include("../inc/header.php"); ?>
<?php include("../inc/menu.php"); ?>
<div id="content">
  <div class="titlecontent">
    <p><a href="<?php echo check('home.php'); ?>">Home</a> <span> >> </span> User <span> >> </span><a href="<?php echo check('setting.php'); ?>">Setting</a></p>
  </div>
  <div class="bodycontent">
    <form id="setting_form" name="setting_form" method="POST" action="<?php echo $current_file; ?>">
    <?php	
	if(isset($_POST['submit'])){
		$name= protect($_POST['name']);
		mysqli_query($conn,"UPDATE `users` SET `name`='".$name."' WHERE `id_user`='".access('id_user')."'")or die(mysqli_error());
	}
	?>
    <table width="305" >
      <tr>
        <td width="129"><label for="name">Change Name:</label></td>
        <td width="160"><input type="text" name="name" id="name" value="<?php echo access('name'); ?>"/></td>
      </tr>
      <tr>
      	<td>&nbsp;</td>
	    <td><input type="submit" name="submit" id="submit" value="Change" /></td>
      </tr>
	</table>
    <?php 
	if(isset($_POST['submit2'])){
		$old_password = protect($_POST['old_password']);
		$new_password = protect($_POST['new_password']);
		$again_password = protect($_POST['again_password']);
		if(!empty($old_password)){
			if(md5($old_password) == access('password')){
				if(!empty($new_password) && !empty($again_password)){
					if($new_password == $again_password){
						mysqli_query($conn,"UPDATE `users` SET `password`='".md5($new_password)."' WHERE `id_user`='".access('id_user')."'")or die(mysqli_error());
						header('Location:'.check('logout.php'));
					}else{
						echo 'Repeat Password is Wrong';
					}
				}else{
					echo 'Insert New Password and Again Password';	
				}
			}else{
				echo 'Old password is not the Same';
			}
		}else{
			echo 'Insert old Password';
		}
	}
	?>
	<table width="305" >
	  <tr>
	    <td><label for="old_password">Old Password:</label></td>
	    <td><input type="password" name="old_password" id="old_password" /></td>
	    </tr>
	  <tr>
	    <td><label for="new_password">New Password:</label></td>
	    <td><input type="password" name="new_password" id="new_password" /></td>
	    </tr>
	  <tr>
	    <td><label for="again_password">Insert Again password:</label></td>
	    <td><input type="password" name="again_password" id="again_password" /></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td><input type="submit" name="submit2" id="submit2" value="Change" /></td>
	    </tr>
	  </table>
    </form>
  </div>
</div>
<?php include("../inc/footer.php"); ?>