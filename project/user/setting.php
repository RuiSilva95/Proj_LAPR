<?php require "../inc/head.php";

if(!isset($_SESSION['id'])) {
    echo "Não tes acesso a esta pagina";
    die();
}
$wrongpass=0;

if(isset($_POST['submit1'])) {
    $changename= protect($_POST['change_name']);
    $changeemail= protect($_POST['change_email']);
    mysqli_query($conn, 'UPDATE users SET name="'.$changename.'" , email="'.$changeemail.'" WHERE id_user="'.$_SESSION['id'].'";')or die("Error:".mysqli_error($conn));
}else if(isset($_POST['submit2'])) {
    $old_password = protect($_POST['old_password']);
    $new_password = protect($_POST['new_password']);
    $again_password = protect($_POST['again_password']);

    if(hash_equals(access('password'), crypt($old_password, access('password')))) {
        if($new_password == $again_password) {
            $query = 'UPDATE users SET password="'.crypt($new_password).'" WHERE `id_user`="'.access('id_user').'";';
            mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
            $wrongpass = 3;
        }else{
            $wrongpass = 2;
        }

    }else{
        $wrongpass = 1;
    }
}else if(isset($_POST['submit3'])) {

    $data = file_get_contents($_FILES['pic']['tmp_name']);
    $data = mysqli_real_escape_string($conn, $data);

    $query='UPDATE users SET data="'.$data.'" WHERE id_user='.$_SESSION['id'].';';
    mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
}

?>

<div id="wrapper">
        <?php require "../inc/menu.php"; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Setting
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="../home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-gear"></i> Setting
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <br>
                <div class="row">
                    <div class="col-lg-2 col-lg-offset-1">
                        <form method="POST" name="formchangename" action="<?php echo current_file(); ?>">

                            <div class="form-group">
                                <label for="ChangeName">Change Name:</label>
                                <input type="text" name="change_name" class="form-control" id="ChangeName" value="<?php echo access('name'); ?>"/>
                            </div>

                            <div class="form-group">
                                <label for="ChangeEmail">Change Email:</label>
                                <input type="text" name="change_email" class="form-control" id="ChangeEmail" value="<?php echo access('email'); ?>"/>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit1" class="btn btn-default" value="Change" />
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-2 col-lg-offset-1">
                        <form method="POST" name="formchangepassword" action="<?php echo current_file(); ?>">

                            <div class="form-group <?php echo($wrongpass==1)? 'has-error': ''; ?>">
                                <label for="Old_Password">Old Password:</label>
                                <input type="password" name="old_password" class="form-control" id="Old_Password" required="required"/>
                                <p class="help-block"><?php echo($wrongpass==1)? 'Old password is not the Same': ''; ?></p>
                            </div>

                            <div class="form-group">
                                <label for="New_Password">New Password:</label>
                                <input type="password" name="new_password" class="form-control" id="New_Password" required="required"/>
                            </div>

                            <div class="form-group <?php echo($wrongpass==2)? 'has-error': ''; ?>">
                                <label for="Again_Password" class="control-label">Insert Again password:</label>
                                <input type="password" name="again_password" class="form-control" id="Again_Password" required="required"/>
                                <p class="help-block"><?php echo($wrongpass==2)? 'Repeat Password is Wrong': ''; ?></p>
                            </div>
                            <p class="help-block"><?php echo($wrongpass==3)? 'Password Change': ''; ?></p>
                            <div class="form-group">
                                <input type="submit" name="submit2" class="btn btn-default" value="Change password" />
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-3 col-lg-offset-1">
                        <form method="POST" name="formchangepassword" action="<?php echo current_file(); ?>" enctype="multipart/form-data">

                            <div class="form-group">
                            <label for="File_input">File input:</label><br><br>
                            <?php
                            $pinc = access('data');
                            if($pinc!=null) {
                                echo '<i class="fa-border" style="font-size:118px"><img src="data:image/jpg;base64,' . base64_encode($pinc) . '"  width="108" width="518"></i>';
                            }else{
                                echo '<i class="fa fa-user fa-border" style="font-size:118px"> </i>';
                            }
                            ?>
                            </div>

                            <div class="form-group">
                                <input type="file" name="pic" id="File_input">
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit3" class="btn btn-default" value="Change picture" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require "../inc/footer.php"; ?>
