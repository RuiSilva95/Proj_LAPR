<?php require "inc/head.php";

if(!isset($_SESSION['id'])) {
    echo "Não tens acesso a esta pagina";
    die();
}


if(isset($_POST['submit1'])) {
    $name = protect($_POST['name']);
    $address = protect($_POST['address']);
    $email = protect($_POST['email']);
    $phone = protect($_POST['phone']);

    $query = 'SELECT * FROM client WHERE name="'.$name.'";';
    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));

    if(mysqli_num_rows($result)==0) {
        $query = 'SELECT * FROM client WHERE email="'.$email.'";';
        $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));

        if(mysqli_num_rows($result)==0) {
            $query = 'INSERT INTO client(name, address, email, phone, private) VALUE("'.$name.'","'.$address.'","'.$email.'",'.$phone.', 0);';
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
    $address = protect($_GET['address']);
    $email = protect($_GET['email']);
    $phone = protect($_GET['phone']);


    $query = 'SELECT * FROM client WHERE name="'.$name.'";';
    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result)==0 || (mysqli_num_rows($result)==1 && $id==$row['id_client'])) {
        $query = 'SELECT * FROM client WHERE email="'.$email.'";';
        $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result)==0 || (mysqli_num_rows($result)==1 && $id==$row['id_client'])) {
            $query = 'UPDATE client SET name="'.$name.'", address="'.$address.'",  email="'.$email.'", phone='.$phone.' WHERE id_client='.$id.';';
            mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
            $_GET['edit']='';
        }else{
            $wrongpass1 = 2;
        }
    }else{
        $wrongpass1 = 1;
    }

}else if(isset($_GET['delet'])) {
    $query = 'DELETE FROM client WHERE id_client='.$_GET['delet'].';';
    mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
}



?>

<div id="wrapper">
        <?php require "inc/menu.php"; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Client
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="../home.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-users"> </i> Client
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
                                <strong>Oh snap!</strong> Name "'.$name.'" on edit already exist.
                            </div>';
                    }else if($wrongpass1==2) {
                        echo '
                            <div class="alert alert-danger">
                                <strong>Oh snap!</strong> Email "'.$email.'" on edit already exist.
                            </div>';
                    }
                    ?>
                    <div class="col-lg-3">
                        <form name="client_form" method="POST" action="<?php echo current_file(); ?>">
                            <div class="form-group <?php echo($wrongpass==1)? 'has-error': ''; ?>">
                                <label for="Name">Name*:</label>
                                <input type="text" name="name" class="form-control" id="Name" required="required"/>
                                <p class="help-block"><?php echo($wrongpass==1)? 'Name "'.$name.'" exist': ''; ?></p>
                            </div>

                            <div class="form-group">
                                <label for="Address">Address:</label>
                                <input type="text" name="address" class="form-control" id="Address"/>
                            </div>

                            <div class="form-group <?php echo($wrongpass==2)? 'has-error': ''; ?>">
                                <label for="Email">Email*:</label>
                                <input type="email" name="email" class="form-control" id="Email" required="required"/>
                                <p class="help-block"><?php echo($wrongpass==2)? 'Email "'.$email.'" exist': ''; ?></p>
                            </div>

                            <div class="form-group">
                                <label for="Phone">Phone:</label>
                                <input type="text" name="phone" class="form-control" id="Phone" maxlength="9"/>
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
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Phone</th>
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

                                $count = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM client WHERE private=0 ;'));

                                $query = 'SELECT * FROM client WHERE private=0 ORDER BY name ASC LIMIT '.$pageNumber.' OFFSET '.$offset.';';
                                $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));

                                if(mysqli_num_rows($result)>0) {
                                    while($row = mysqli_fetch_assoc($result)){

                                        if($row['id_client']==$_GET['edit'] && isset($_GET['edit'])) {
                                            echo '<form name="edit_form" method="GET"';

                                            echo '<tr>';
                                            echo '<td class="col-md-2"> <input type="text" name="name" class="form-control" width="10" value="'.$row['name'].'" required="required"> </td>';
                                            echo '<td class="col-md-2"> <input type="text" name="address" class="form-control" value="'.$row['address'].'" required="required"> </td>';
                                            echo '<td> <input type="email" name="email" class="form-control" value="'.$row['email'].'" required="required"> </td>';
                                            echo '<td> <input type="text" name="phone" class="form-control" value="'.$row['phone'].'" maxlength="9"</td>';
                                            echo '<td>
                                                  <button type="submit" name="sav" class="btn btn-default">Save</button>
                                                  <a class="btn btn-default" href="'.current_file().'?page='.$_GET['page'].'">Cancel</a>
                                                  </td>';
                                            echo '</tr>';
                                            echo '<input type="hidden" name="edit" value="'. $row["id_client"]. '">';
                                            echo '<input type="hidden" name="page" value="'. $_GET['page']. '">';
                                            echo '</form>';
                                        }else{
                                            echo '<tr>';
                                            echo '<td> '.$row['name'].' </td>';
                                            echo '<td> '.$row['address'].' </td>';
                                            echo '<td> '.$row['email'].' </td>';
                                            echo '<td> '.$row['phone'].' </td>';

                                            echo '<td>
                                                  <a class="btn btn-default" href="'.current_file().'?edit='.$row['id_client'].'">Edit</a>
                                                  <a class="btn btn-default" href="'.current_file().'?delet='.$row['id_client'].'">Delete</a>
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
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
<?php require "inc/footer.php"; ?>
