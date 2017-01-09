<?php require "../inc/head.php";

if(!isset($_SESSION['id'])) {
    echo "Não tes acesso a esta pagina";
    die();
}


if(isset($_POST['submit1'])) {
    $name = protect($_POST['name']);
    $username = protect($_POST['username']);
    $password = protect($_POST['password']);
    $email = protect($_POST['email']);
    $status = protect($_POST['status']);
    $data = file_get_contents($_FILES['pic']['tmp_name']);
    $data = mysqli_real_escape_string($conn, $data);


    $query = 'SELECT * FROM users WHERE username="'.$username.'";';
    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));

    if(mysqli_num_rows($result)==0) {
        $query = 'SELECT * FROM users WHERE email="'.$email.'";';
        $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
        if(mysqli_num_rows($result)==0) {

            $query = 'INSERT INTO users(name, username, password, email, status, data) VALUE("'.$name.'","'.$username.'","'.crypt($password).'","'.$email.'","'.$status.'","'.$data.'");';
            mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
        }else{
            $wrongpass = 2;
            echo 'Email '.$email.' exist';

        }
    }else{
        $wrongpass = 1;
        echo 'Name '.$name.' exist';
    }
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
                            User Management
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="../home.php">Dashboard</a>
                            </li>
                            <li>
                                <a href="#">Administration</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-user"> </i> User Management
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <br>
                <div class="row">
                    <div class="col-lg-4">
                        <form name="user_form" method="POST" action="<?php echo current_file(); ?> enctype="multipart/form-data"">
                            <div class="form-group">
                                <label for="Name">Name*:</label>
                                <input type="text" name="name" class="form-control" id="Name" required="required"/>
                            </div>

                            <div class="form-group">
                                <label for="Username">username*:</label>
                                <input type="text" name="username" class="form-control" id="Username" required="required"/>
                            </div>

                            <div class="form-group">
                                <label for="Password">Password*:</label>
                                <input type="password" name="password" class="form-control" id="Password" required="required"/>
                            </div>

                            <div class="form-group">
                                <label for="Email">Email*:</label>
                                <input type="email" name="email" class="form-control" id="Email" required="required"/>
                            </div>

                            <div class="form-group">
                                <label for="Status">Status:</label>
                                <select name="status" class="form-control" id="Status">
                                    <option value="0">Employee</option>
                                    <option value="1">Administrator</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="File_input" class="col-sm-3">Picture:</label>
                                <input type="file" name="pic" id="File_input">
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit1" class="btn btn-default" id="submit" value="Create" />
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-7 col-lg-offset-1">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped ">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Picture</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = 'SELECT * FROM users ORDER BY name ASC;';
                                    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
                                    if(mysqli_num_rows($result)>0) {
                                        while($row = mysqli_fetch_assoc($result)){
                                            switch ($row['status']){
                                            case 0:
                                                $stat = 'Employee';
                                                break;
                                            case 1:
                                                $stat = 'Administrador';
                                                break;
                                            }

                                            echo '<tr>';
                                            echo '<td> '.$row['name'].' </td>';
                                            echo '<td> '.$row['username'].' </td>';
                                            echo '<td> '.$row['email'].' </td>';
                                            echo '<td> '. $stat .' </td>';
                                            if($row['data']!=null) {
                                                echo '<td style="text-align:center;vertical-align:middle"><img src="data:image/jpg;base64,' . base64_encode($pinc) . '"  width="38" height="38"></td>';
                                            }else{
                                                echo '<td style="text-align:center;vertical-align:middle"><i class="fa fa-user" style="font-size:38px"> </i></td>';
                                            }

                                            echo '<td>
                            			          <a class="btn btn-default" href="'.current_file().'?edit='.$row['$row'].'">Edit</a>
                            			          <a class="btn btn-default" href="'.current_file().'?apg='.$row['$row'].'">Delete</a>
                            				  </td>';
                                            echo '</tr>';
                                        }
                                    }else{
                                        echo '<tr>';
                                        echo '<td colspan="6"> <center>No field found</center></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require "../inc/footer.php"; ?>
