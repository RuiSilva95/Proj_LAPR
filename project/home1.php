<?php require "inc/head.php";
/*
if(!isset($_SESSION['id'])) {
    echo "Não tes acesso a esta pagina";
    die();
}
*/
?>

<div id="wrapper">
        <?php require "inc/menu.php"; ?>
        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            DashBoard
                            <small>Subheading</small>
                        </h1>
                        <ol class="breadcrumb" class="active">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>

                        <p>OLA MUNDO</p>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require "inc/footer.php"; ?>
