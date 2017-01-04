<?php require "core/init.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/default/css/login_logout.css" rel="stylesheet" type="text/css" />
<title>Takemore.com</title>
</head>
<body>
<div id="box">
  <div id="logo">
    <img src="style/default/img/logo2.png" width="400" height="73" />
  </div>
    <form id="login" name="login" method="POST" action="<?php echo $current_file; ?>">
    <div class="field">
    <?php
    if(isset($_SESSION['id'])) {
        header('Location:'.'home.php');
    }else{
        if (isset($_POST['submit'])) {
             $username=protect($_POST['username']);
             $password=protect($_POST['password']);
            if($username == '' || $password == '') {
                echo 'Missing fields<br />';
            }else{
                echo "ENTROU";
                $query = "SELECT * FROM `users` WHERE `username`='".$username."' and `password`='".md5($password)."'";
                echo $query;
                $SQL = mysqli_query($conn, "SELECT * FROM `users` WHERE `username`='".$username."' and `password`='".md5($password)."'") or die(mysqli_error());
                if(mysqli_num_rows($SQL)) {
                    header('Location:'.'home.php');
                    $get_id = mysqli_fetch_assoc($SQL);
                    $_SESSION['id'] = $get_id['id_user'];
                }else{
                    echo 'User / Password wrong turn insert<br />';
                }
            }
        }
    }
    ?>
      <label for="username">Username:</label><br />
      <input type="text" name="username" id="username" maxlength="50" />
    </div>
    <div class="field">
      <label for="password">Password:</label><br />
      <input type="password" name="password" id="password" maxlength="50" />
    </div>
    <div class="field_action">
      <input type="submit" value="Login" name="submit" id="submit" class="submit"/>
    </div>
    </form>
</div>
</body>
</html>
