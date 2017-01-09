<?php
require "core/init.php";

if(isset($_SESSION['id'])) {
    header('Location:'.'home.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Takemore.com</title>

        <!-- Latest compiled and minified CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- Optional theme -->
        <link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />

        <!-- Manuel change -->
        <link href="css/login_logout.css" rel="stylesheet" type="text/css" />
    </head>

    <body>

    <div class="login">

    <img src="img/takemore_lg.png"/>
        <form method="POST" <?php echo current_file(); ?>>
            <input type="text" name="user" placeholder="Username" required="required" value="<?php echo $_POST['user'];?>">
            <input type="password" name="pass" placeholder="Password" required="required" value="<?php echo $_POST['pass'];?>">

            <?php

            if (isset($_POST['submit'])) {
                $username=protect($_POST['user']);
                $password=protect($_POST['pass']);

                $query =  'SELECT * FROM users WHERE username="'.$username.'"';
                $result = mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
                if(mysqli_num_rows($result)==1) {
                    $row = mysqli_fetch_assoc($result);

                    if(hash_equals($row['password'], crypt($password, $row['password']))) {
                        $_SESSION['id'] = $row['id_user'];
                        mysqli_close($conn);
                        header('Location:'.'home.php');

                    }else{
                        echo '<p style="color:#fff">password invalid try again</p>';

                    }
                }else{
                    echo '<p style="color:#fff">Username invalid try again</p>';

                }
                mysqli_close($conn);
            }
            ?>
            <button type="submit" name="submit" class="btn btn-primary btn-block btn-large">Login</button>
        </form>
    </div>
</body>

<!-- Jquery  CDN -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap.min.js"></script>
</html>
