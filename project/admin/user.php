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
        }
    }else{
        $wrongpass = 1;
    }
}else if(isset($_GET['sav'])) {
    $id =protect($_GET['edit']);
    $name = protect($_GET['name']);
    $username = protect($_GET['username']);
    $email = protect($_GET['email']);
    $status = protect($_GET['status']);
    if(isset($_FILES['pic'])) {
        echo 'entrou';
        $data = file_get_contents($_FILES['pic']['tmp_name']);
        $data = mysqli_real_escape_string($conn, $data);
        $data = 'data="'.$data.'",';
    }else{
        $data = ' ';
    }
    $query = 'SELECT * FROM users WHERE username="'.$username.'";';
    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result)==0 || (mysqli_num_rows($result)==1 && $id==$row['id_user'])) {
        $query = 'SELECT * FROM users WHERE email="'.$email.'";';
        $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result)==0 || (mysqli_num_rows($result)==1 && $id==$row['id_user'])) {
            $query = 'UPDATE users SET '.$data.' name="'.$name.'", username="'.$username.'",  email="'.$email.'", status='.$status.' WHERE id_user='.$id.';';
            mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
            $_GET['edit']='';
        }else{
            $wrongpass1 = 2;
        }
    }else{
        $wrongpass1 = 1;
    }

}else if(isset($_GET['delet'])) {
    $query = 'DELETE FROM users WHERE id_user='.$_GET['delet'].';';
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
                    <?php
                    if($wrongpass1==1) {
                        echo '
                            <div class="alert alert-danger">
                                <strong>Oh snap!</strong> Username "'.$username.'" on edit already exist.
                            </div>';
                    }else if($wrongpass1==2) {
                        echo '
                            <div class="alert alert-danger">
                                <strong>Oh snap!</strong> Email "'.$email.'" on edit already exist.
                            </div>';
                    }
                    ?>
                    <div class="col-lg-3">
                        <form name="user_form" method="POST" action="<?php echo current_file(); ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="Name">Name*:</label>
                                <input type="text" name="name" class="form-control" id="Name" required="required"/>
                            </div>

                            <div class="form-group <?php echo($wrongpass==1)? 'has-error': ''; ?>">
                                <label for="Username">username*:</label>
                                <input type="text" name="username" class="form-control" id="Username" required="required"/>
                                <p class="help-block"><?php echo($wrongpass==1)? 'Username "'.$username.'" exist': ''; ?></p>
                            </div>

                            <div class="form-group">
                                <label for="Password">Password*:</label>
                                <input type="password" name="password" class="form-control" id="Password" required="required"/>
                            </div>

                            <div class="form-group <?php echo($wrongpass==2)? 'has-error': ''; ?>">
                                <label for="Email">Email*:</label>
                                <input type="email" name="email" class="form-control" id="Email" required="required"/>
                                <p class="help-block"><?php echo($wrongpass==2)? 'Email "'.$email.'" exist': ''; ?></p>
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

                    <div class="col-lg-9">
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
                                    $pageNumber=3;

                                    $offset= (mysqli_real_escape_string($conn, $_GET["page"])-1)*$pageNumber;
                                    if($offset<0) {
                                        $offset=0;
                                    }

                                    $count = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM users;'));
                                    $query = 'SELECT * FROM users ORDER BY name ASC LIMIT '.$pageNumber.' OFFSET '.$offset.';';
                                    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));

                                    if(mysqli_num_rows($result)>0) {
                                        while($row = mysqli_fetch_assoc($result)){
                                            switch ($row['status']){
                                            case 0:
                                                $stat = 'Employee';
                                                break;
                                            case 1:
                                                $stat = 'Administrator';
                                                break;
                                            }

                                            if($row['id_user']==$_GET['edit'] && isset($_GET['edit'])) {
                                                echo '<form name="edit_form" method="GET"';

                                                echo '<tr>';
                                                echo '<td class="col-md-2"> <input type="text" name="name" class="form-control" width="10" value="'.$row['name'].'" required="required"> </td>';
                                                echo '<td class="col-md-2"> <input type="text" name="username" class="form-control" value="'.$row['username'].'" required="required"> </td>';
                                                echo '<td> <input type="email" name="email" class="form-control" value="'.$row['email'].'" required="required"> </td>';
                                                echo '<td>
                                                        <select name="status" class="form-control" id="Status">
                                                            <option value="0" '.active('0', $row['status']).'>Employee</option>
                                                            <option value="1" '.active('1', $row['status']).'>Administrator</option>
                                                        </select>
                                                 </td>';
                                                if($row['data']!=null) {
                                                    echo '<td style="text-align:center;vertical-align:middle"><img src="data:image/jpg;base64,' . base64_encode($pinc) . '"  width="38" height="38"></td>';
                                                }else{
                                                    echo '<td style="text-align:center;vertical-align:middle"><i class="fa fa-user" style="font-size:38px"> </i></td>';
                                                }
                                                echo '<td>
                                			          <button type="submit" name="sav" class="btn btn-default">Save</button>
                                			          <a class="btn btn-default" href="'.current_file().'?page='.$_GET['page'].'">Cancel</a>
                    				                  </td>';
                                                echo '</tr>';
                                                echo '<input type="hidden" name="edit" value="'. $row["id_user"]. '">';
                                                echo '<input type="hidden" name="page" value="'. $_GET['page']. '">';
                                                echo '</form>';
                                            }else{
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
                                			          <a class="btn btn-default" href="'.current_file().'?edit='.$row['id_user'].'">Edit</a>
                                			          <a class="btn btn-default" href="'.current_file().'?delet='.$row['id_user'].'">Delete</a>
                    				                  </td>';
                                                echo '</tr>';
                                            }
                                        }
                                    }else{
                                        echo '<tr>';
                                        echo '<td colspan="6"> <center>No field found</center></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <nav aria-label="...">
                                <center>
                                    <ul class="pagination pagination-sm">
                                        <?php
                                        for($i=0;$i<($count/$pageNumber);$i++){
                                            echo '<li class="page-item"><a class="page-link" href="'.current_file().'?page='.($i+1).'">'.($i+1).'</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </center>
                            </nav>
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
