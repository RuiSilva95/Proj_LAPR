<?php require "../inc/head.php";

if(!isset($_SESSION['id'])) {
    echo "Não tens acesso a esta pagina";
    header("refresh:1;url=../login.php");
    die();
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
                            Profile
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="../home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-user"></i> Profile
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <br>
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-1">
                        <div class="form-group">
                            <label for="ChangeName">Name:</label>
                            <p class="form-control-static"><?php echo access('name'); ?></p>
                        </div>
                        <div class="form-group">
                            <label for="ChangeEmail">Email:</label>
                            <p class="form-control-static"><?php echo access('email'); ?></p>
                        </div>
                        <div class="form-group">
                            <label for="ChangeEmail">Status:</label>
                            <p class="form-control-static"><?php echo (access('status')==1)? 'Administrator': 'Employee'; ?></p>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                        <label for="File_input">Picture:</label><br><br>
                        <?php
                        $pinc = access('data');
                        if($pinc!=null) {
                            echo '<i class="fa-border" style="font-size:118px"><img src="data:image/jpg;base64,' . base64_encode($pinc) . '"  width="108" width="518"></i>';
                        }else{
                            echo '<i class="fa fa-user fa-border" style="font-size:118px"> </i>';
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require "../inc/footer.php"; ?>
