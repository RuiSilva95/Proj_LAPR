<?php include("../inc/head.php"); 

if(!isset($_SESSION['id']) && $_SESSION['id']==2){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<title>Takemore.com - User Management</title>
<?php include("../inc/header.php"); ?>
<?php include("../inc/menu.php"); ?>
<div id="content">
  <div class="titlecontent">
    <p><a href="<?php echo check('home.php'); ?>">Home</a> <span> >> </span> Administrador <span> >> </span><a href="<?php echo check('user.php'); ?>">User Management</a></p>
  </div>
  <div class="bodycontent">
	<div id="left-column">
   	  <form id="user_form" name="user_form" method="POST" action="<?php echo $current_file; ?>">
        <table width="261">
          <?php 
            if(isset($_POST['submit'])){
              $name = protect($_POST['name']);
              $password = protect($_POST['password']);
			  $email = protect($_POST['email']);
              $status = protect($_POST['status']);
              if(empty($name)&& empty($password)){
                echo 'The name and address field are required';   
              }else{
                $SQL1 = mysqli_query($conn,"SELECT * FROM `users` WHERE `username`='".$name."'")or die(mysqli_error());
				$SQL2 = mysqli_query($conn,"SELECT * FROM `users` WHERE `email`='".$email."'")or die(mysqli_error());
				if(mysqli_num_rows($SQL1)==1){
				  echo 'Name '.$name.' exist';
				}elseif(mysqli_num_rows($SQL2)==1){
				  echo 'Email '.$email.' exist'; 
				}else{
				  mysqli_query($conn,"INSERT INTO `users`(`username`,`name`,`password`,`email`,`status`) VALUE('".$name."','".$name."','".md5($password)."','".$email."','".$status."')") or die(mysqli_error());
                }
              } 
           }
           ?>
          <tr>
            <td width="84"><label for="name">Name*:</label></td>
            <td width="171"><input name="name" type="text" id="name" maxlength="50" /></td>
          </tr>
          <tr>
            <td><label for="password">Password*:</label></td>
            <td><input name="password" type="text" id="password" maxlength="100" /></td>
          </tr>
          <tr>
            <td><label for="email">Email:</label></td>
            <td><input type="text" name="email" id="email" /></td>
          </tr>
          <tr>
            <td><label for="status">Status:</label></td>
            <td>
              <select name="status" id="status">
                  <option value="0">Employee</option>
                  <option value="2">Administrator</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" id="submit" value="Create" /></td>
          </tr>
        </table>
   	  </form>
    </div>
    <div id="right-column">
      <table name="list" id="list">
        <tr>
          <th scope="col">Username:</th>
          <th scope="col">Name:</th>
          <th scope="col">Email:</th>
          <th scope="col">Status:</th>
          <th width="170" scope="col"></th>
        </tr>
        <?php 
        $SQL = mysqli_query($conn,"SELECT * FROM `users` ORDER BY `username` ASC")or die(mysqli_error());
        if(mysqli_num_rows($SQL)>0){
          while($field = mysqli_fetch_assoc($SQL)){
			switch ($field['status']){
				case 0:
					$echo = 'Employee';
					break;
				case 2:
					$echo = 'Administrador';
					break;
				} 
             echo '<tr>';
             echo '<td> '.$field['username'].' </td>';
			 echo '<td> '.$field['name'].' </td>';
			 echo '<td> '.$field['email'].' </td>';
             echo '<td> '. $echo .' </td>';
             echo '<td> 
			          <a class="myButton" href="'.check('user.edit.php').'?id='.$field['id_user'].'">Edit</a>  
			          <a class="myButton" href="'.check('user.edit.php').'?apg='.$field['id_user'].'">Delete</a>
				  </td>';
             echo '</tr>';
          }
        }else{
          echo '<tr>';
          echo '<td colspan="3"> No field found </td>';
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
<?php include("../inc/footer.php"); ?>