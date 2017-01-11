<?php require "inc/head.php";

if(!isset($_SESSION['id'])) {
    echo "Não tens acesso a esta pagina";
    die();
}

if(!empty($_GET['apg'])) {

      $id_external = protect($_GET['id_external']);
      $id_equipment_status = protect($_GET['id_equipment_status']);
      $id_client = protect($_GET['id_client']);

      mysqli_query($conn, "DELETE FROM external WHERE id_external=$id_external ")or die("Error:".mysqli_error($conn));
      mysqli_query($conn, "DELETE FROM equipment_status WHERE id_equipment_status=$id_equipment_status ")or die("Error:".mysqli_error($conn));
      $result = mysqli_query($conn, "SELECT * FROM client WHERE id_client = $id_client AND private = 1");
    if(mysqli_num_rows($result) == 1) {
        mysqli_query($conn, "DELETE FROM client WHERE id_client=$id_client ")or die("Error:".mysqli_error($conn));
    }


    header('Location:'.'home.php');
}elseif(!empty($_GET['edit'])) {

    $id_external = protect($_GET['id_external']);
    $id_status2 = protect($_GET['id_equipment_status']);
    $id_client = protect($_GET['id_client']);
    $id_employee = protect($_GET['id_user']);

    $result1 = mysqli_query($conn, "SELECT * FROM external WHERE id_external=$id_external ")or die("Error:".mysqli_error($conn));
    $result2 = mysqli_query($conn, "SELECT * FROM equipment_status WHERE id_equipment_status=$id_status2 ")or die("Error:".mysqli_error($conn));
    $result3 = mysqli_query($conn, "SELECT * FROM client WHERE id_client=$id_client ")or die("Error:".mysqli_error($conn));
    $result4 = mysqli_query($conn, "SELECT * FROM users WHERE id_user=$id_employee ")or die("Error:".mysqli_error($conn));


    $row1 = mysqli_fetch_assoc($result1);
    $row2 = mysqli_fetch_assoc($result2);
    $row3 = mysqli_fetch_assoc($result3);
    $row4 = mysqli_fetch_assoc($result4);

    $name = protect($row3['name']);
    $address = protect($row3['address']);
    $email = protect($row3['email']);
    $phone = protect($row3['phone']);

    $initial_date = protect($row2['start_date']);
    $final_date = protect($row2['end_date']);
    $working_hours = protect($row2['working_hours']);
    $id_status = protect($row2['status']);

    $description = protect($row1['description']);
    $service_provided = protect($row1['service_provided']);
    $budget = protect($row1['budget']);


}else if(isset($_POST['submit1']) || isset($_POST['submit2'])) {

    $id_client = protect($_POST['client']);
    $id_status = protect($_POST['status']);
    $id_employee = protect($_POST['employee']);

    $name = protect($_POST['name']);
    $address = protect($_POST['address']);
    $email = protect($_POST['email']);
    $phone = protect($_POST['phone']);

    $initial_date = protect($_POST['initial_date']);
    $final_date = protect($_POST['final_date']);
    $working_hours = protect($_POST['working_hours']);

    $description = protect($_POST['description']);
    $service_provided = protect($_POST['service_provided']);
    $budget = protect($_POST['budget']);

    if($id_status=='0') {
        $message = '<div class="alert alert-danger">
                    <strong>Oh snap!</strong> Need Select Status.
                    </div>';
    }else{
        if($id_employee==0) {
            $message = '<div class="alert alert-danger">
                        <strong>Oh snap!</strong> Need Select Employee.
                        </div>';
        }else{
            $verf = 1;
            if($id_client==0) {
                $query = 'SELECT * FROM client WHERE name="'.$name.'"';
                $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
                if(mysqli_num_rows($result)==0) {
                    $query = 'SELECT * FROM client WHERE email="'.$email.'"';
                    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));

                    if(mysqli_num_rows($result)==0) {
                        $query = 'INSERT INTO client(name, address, email, phone, private) VALUE("'.$name.'","'.$address.'","'.$email.'",'.$phone.', 1);';
                        mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
                        $id_client = mysqli_insert_id($conn);
                    }else{
                        echo 'Email client exist';
                        $verf = 0;
                    }
                }else{
                    echo 'Name client exist';
                    $verf = 0;
                }
            }

            if($verf==1) {
                $query = 'INSERT INTO equipment_status(status, start_date, end_date, work_hours) VALUE("'.$id_status.'","'. $initial_date.'","'.$final_date.'","'.$working_hours.'")';
                mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
                $id_eqip = mysqli_insert_id($conn);

                echo $query = 'INSERT INTO external(id_client, id_user, id_equipment_status, description, service_provided, budget) VALUE('.$id_client.','.$id_employee.', '.$id_eqip.', "'.$description.'","'.$service_provided.'","'.$budget.'")';
                mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
                $id_extend = mysqli_insert_id($conn);

                if(isset($_POST['submit2'])) {
                     header('Location: '.check('home.php').'?imp=1&id='.$id_extend.'&entity=external');
                }else{
                    header('Location: '.check('home.php'));
                }
            }else{
            }
        }
    }
}
?>


<div id="wrapper">
        <?php require "inc/menu.php"; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <form name="external_form" method="POST" action="<?php echo current_file(); ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Sheet Repair External eit
                            </h1>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="../home.php">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#">Sheet Repair</a>
                                </li>
                                <li >
                                     <a href="#">External</a>
                                </li>
                                <li class="active">
                                     External Edit
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- /.row -->
                    <br>

                    <div class="row">
                        <div class="col-lg-12 form-inline">
                            <?php
                            if(!empty($message)) {
                                echo $message;
                            }?>
                            <div class="form-group col-lg-3">
                                <label for="Client">Client</label>
                                <select name="client" class="form-control" id="client" onchange="verificaOpcao(this.value)">
                                    <?php
                                    echo '<option value="0"> -- Select Client -- </option>';
                                    $query = 'SELECT * FROM client WHERE private=0 ORDER BY name ASC;';
                                    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
                                    if(mysqli_num_rows($result)>=1) {
                                        while($row = mysqli_fetch_assoc($result)){
                                            echo '<option value="'.$row['id_client'].'" '.active($row['id_client'], $id_client).' >'.$row['name'].'</option>';
                                        }
                                    }else{
                                        echo '<option value="0">No value found</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Status">Status *</label>
                                <select name="status" class="form-control" id="Status">
                                    <option value="0"> -- Select Status -- </option>
                                    <option value="Waits" <?php echo active('Waits', $id_status); ?>>Waits</option>
                                    <option value="Budgeted" <?php echo active('Budgeted', $id_status); ?>>Budgeted</option>
                                    <option value="Under Repair" <?php echo active('Under Repair', $id_status); ?>>Under Repair</option>
                                    <option value="Closed Billing" <?php echo active('Closed Billing', $id_status); ?>>Closed Billing</option>
                                    <option value="Closed Guaranty" <?php echo active('Closed Guaranty', $id_status); ?>>Closed Guaranty</option>
                                    <option value="Closed Contract" <?php echo active('Closed Contract', $id_status); ?>>Closed Contract</option>
                                    <option value="Archive" <?php echo active('Archive', $id_status); ?> >Archive</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="Employee">Employee *</label>
                                    <select name="employee" class="form-control" id="employee">
                                        <?php
                                        echo '<option value="0"> -- Select Employee -- </option>';
                                        $query = 'SELECT * FROM users ORDER BY name ASC;';
                                        $result = mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
                                        if(mysqli_num_rows($result)>=1) {
                                            while($row = mysqli_fetch_assoc($result)){
                                                echo '<option value='.$row['id_user'].' '.active($row['id_user'], $id_employee).'>'.$row['name'].'</option>';
                                            }
                                        }else{
                                            echo '<option value="0">No value found</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-lg-12 form-inline">
                            <div class="form-group col-lg-3">
                                <label for="Name">Name*:</label>
                                <input type="text" name="name" class="form-control" id="Name"  value="<?php echo $name; ?>" required="required"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Address">Address:</label>
                                <input type="text" name="address" class="form-control" id="Address" value="<?php echo $address; ?>"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Email">Email*:</label>
                                <input type="email" name="email" class="form-control" id="Email" value="<?php echo $email; ?>" required="required"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Phone">Phone:</label>
                                <input type="number" name="phone" class="form-control" id="Phone" value="<?php echo $phone; ?>" maxlength="9"/>
                            </div>
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-lg-12 form-inline">
                            <div class="form-group col-lg-3">
                              <label for="initial_date">Initial Date:</label></td>
                              <input type="datetime-local" name="initial_date" class="form-control" value="<?php echo $initial_date; ?>" id="initial_date" onchange="javascript('1')"/></td>
                            </div>

                            <div class="form-group col-lg-3">
                              <label for="final_date">Final Date:</label></td>
                              <input type="datetime-local" name="final_date" class="form-control" value="<?php echo $final_date; ?>" id="final_date" onchange="javascript('1')"/></td>
                          </div>

                            <div class="form-group col-lg-3">
                              <label for="working_hours">Working Hours:</label></td>
                              <input type="text" name="working_hours" class="form-control" value="<?php echo $working_hours; ?>" id="working_hours" readonly/></td>
                            </div>
                          </table>
                        </div>
                    </div>

                    <br><br>

                    <div class="row col-lg-12">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Description">Description:</label>
                                <textarea  name="description" class="form-control" id="Description"  rows="3"><?php echo $description; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Service_Provided">Service Provided:</label>
                                <textarea  name="service_provided" class="form-control" id="Service_Provided"  rows="3"><?php echo $service_provided; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Budget">Budget:</label>
                                <input type="text" name="budget" value="<?php echo $budget; ?>" class="form-control" id="Budget"/>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit1" class="btn btn-default" value="Save" />
                                <input type="submit" name="submit2" class="btn btn-default" value="Save and Print Bill" />
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        <!-- /.container-fluid -->
    </div>
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php require "inc/footer.php"; ?>
