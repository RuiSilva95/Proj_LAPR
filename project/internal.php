<?php require "inc/head.php";

if(!isset($_SESSION['id'])) {
    echo "Não tes acesso a esta pagina";
    die();
}

if(isset($_POST['submit']) || isset($_POST['submit2'])) {
      $client = protect($_POST['client']);
      $status = protect($_POST['status']);
      $employee = protect($_POST['employee']);
      $name = protect($_POST['name']);
      $address = protect($_POST['address']);
      $phone = protect($_POST['phone']);
      $initial_date = protect($_POST['initial_date']);
      $final_date = protect($_POST['final_date']);
      $working_hours = protect($_POST['working_hours']);
      $equipment = protect($_POST['equipment']);
      $mark = protect($_POST['mark']);
      $n_serie = protect($_POST['n_serie']);
      $accessories = protect($_POST['accessories']);
      $problem = protect($_POST['problem']);
      $descri_client = protect($_POST['descri_client']);
      $descri_employee = protect($_POST['descri_employee']);
      $service_provided = protect($_POST['service_provided']);
      $material_supplied = protect($_POST['material_supplied']);
      $check = protect($_POST['check']);
      $service = protect($_POST['service']);
      $budget_service = protect($_POST['budget_service']);
      $sending_date = protect($_POST['sending_date']);
      $delivery_date = protect($_POST['delivery_date']);
      $reported_problem = protect($_POST['reported_problem']);
      $radio = protect($_POST['radio']);

      $budget = protect($_POST['budget']);
      $cod = rand();


    if($check==0) {
        $budget_service = ' ';
        $sending_date = ' ';
        $delivery_date = ' ';
        $reported_problem = ' ';
        $radio = ' ';
        $service = ' ';
    }

    if($status==0 && $employee==0) {
        echo 'Fill required fields';
    }else{
        if($client==0 ) {
            if(empty($name)) {
                   echo 'If not selected Client. Write at least name';
                $verf = 1;
            }else{
                 mysqli_query($conn, "INSERT INTO `client` VALUE('','".$name."','".$address."','','".$phone."','1')");
                 $client = mysqli_result(mysqli_query($conn, "SELECT MAX(`id_client`) FROM `client`"), 0, 0);
            }
            if(empty($verf)) {
                  mysqli_query($conn, "INSERT INTO `equipment` VALUE('','".$employee."','".$client."','".$service."','2','".$cod."','".$budget."','".$equipment."','".$mark."','".$n_serie."','".$accessories."','".$service_provided."','".$material_supplied."')")or die("Error:".mysqli_error($conn));
                  mysqli_query($conn, "INSERT INTO `equip_problem` VALUE('','".$problem."','".$descri_client."','".$descri_employee."')")or die("Error:".mysqli_error($conn));
                  mysqli_query($conn, "INSERT INTO `equip_status` VALUE('','".$status."','".$initial_date."','".$final_date."','".$working_hours."')")or die("Error:".mysqli_error($conn));
                  mysqli_query($conn, "INSERT INTO `service_problem` VALUE('','".$check."','".$budget_service."','".$radio."','".$reported_problem."','".$sending_date."','".$delivery_date."')")or die("Error:".mysqli_error($conn));
                if(isset($_POST['submit2'])) {
                    $SQL = mysqli_query($conn, "Select * FROM `equipment` WHERE `cod`='$cod'");
                    $SQL = mysqli_fetch_assoc($SQL);
                    $id = $SQL['id'];
                    $idcli = $SQL['id_client'];
                    header('Location:'.check('home.php').'?imp=0&id='.$id.'&idcli='.$idcli.'');
                }else{
                    header('Location:'.check('home.php'));
                }
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
                                Sheet Repair Internal
                            </h1>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="../home.php">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#">Sheet Repair</a>
                                </li>
                                <li class="active">
                                     Internal
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- /.row -->
                    <br>

                    <div class="row">
                        <div class="col-lg-12 form-inline">
                            <div class="form-group col-lg-3">
                                <label for="Client">Client</label>
                                <select name="client" class="form-control" id="client" onchange="verificaOpcao(this.value)">
                                    <?php
                                    echo '<option value="NULL"> -- Select Client -- </option>';
                                    $query = 'SELECT * FROM client WHERE private=0 ORDER BY name ASC;';
                                    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
                                    if(mysqli_num_rows($result)>=1) {
                                        while($row = mysqli_fetch_assoc($result)){
                                            echo '<option value="'.$row['id_client'].'" '.active($row['id_client'], $_POST['client']).' >'.$row['name'].'</option>';
                                        }
                                    }else{
                                        echo '<option value="NULL">No value found</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Status">Status</label>
                                <select name="status" class="form-control" id="Status">
                                    <option value='NULL'> -- Select Status -- </option>
                                    <option value="Waits" <?php echo active('Waits', $_POST['status']); ?>>Waits</option>
                                    <option value="Budgeted" <?php echo active('Budgeted', $_POST['status']); ?>>Budgeted</option>
                                    <option value="Under Repair" <?php echo active('Under Repair', $_POST['status']); ?>>Under Repair</option>
                                    <option value="Closed Billing" <?php echo active('Closed Billing', $_POST['status']); ?>>Closed Billing</option>
                                    <option value="Closed Guaranty" <?php echo active('Closed Guaranty', $_POST['status']); ?>>Closed Guaranty</option>
                                    <option value="Closed Contract" <?php echo active('Closed Contract', $_POST['status']); ?>>Closed Contract</option>
                                    <option value="Archive" <?php echo active('Archive', $_POST['status']); ?> >Archive</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="Employee">Employee</label>
                                <select name="employee" class="form-control" id="employee">
                                    <?php
                                    echo '<option value="NULL"> -- Select Employee -- </option>';
                                    $query = 'SELECT * FROM users ORDER BY name ASC;';
                                    $result = mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
                                    if(mysqli_num_rows($result)>=1) {
                                        while($row = mysqli_fetch_assoc($result)){
                                            echo '<option value='.$row['id_user'].' '.active($row['id_user'], $_POST['employee']).'>'.$row['name'].'</option>';
                                        }
                                    }else{
                                        echo '<option value="NULL">No value found</option>';
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
                                <input type="text" name="name" class="form-control" id="Name"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Address">Address*:</label>
                                <input type="text" name="address" class="form-control" id="Address"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Email">Email*:</label>
                                <input type="email" name="email" class="form-control" id="Email"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Phone">Phone:</label>
                                <input type="text" name="phone" class="form-control" id="Phone" maxlength="9"/>
                            </div>
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-lg-12 form-inline">
                            <div class="form-group col-lg-3">
                              <label for="initial_date">Initial Date:</label></td>
                              <input type="datetime-local" name="initial_date" class="form-control" id="initial_date" onchange="javascript('1')"/></td>
                            </div>

                            <div class="form-group col-lg-3">
                              <label for="final_date">Final Date:</label></td>
                              <input type="datetime-local" name="final_date" class="form-control" id="final_date" onchange="javascript('1')"/></td>
                          </div>

                            <div class="form-group col-lg-3">
                              <label for="working_hours">Working Hours:</label></td>
                              <input type="text" name="working_hours" class="form-control" id="working_hours" readonly/></td>
                            </div>
                          </table>
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-lg-12 form-inline">
                            <div class="form-group col-lg-3">
                                <label for="Equipment">Equipment*:</label>
                                <input type="text" name="equipment" class="form-control" id="Equipment"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Mark">Mark/Model*:</label>
                                <input type="text" name="mark" class="form-control" id="Mark"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="n_Serie">NºSerie*:</label>
                                <input type="email" name="n_serie" class="form-control" id="n_Serie"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="Accessories">Extra Accessories:</label>
                                <input type="text" name="accessories" class="form-control" id="Accessories" maxlength="9"/>
                            </div>
                        </div>
                    </div>

                    <br><br><br>

                    <div class="row col-lg-12">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Problem/Damage">Problem/Damage:</label>
                                <textarea  name="problem" class="form-control" id="Problem/Damage" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Descri_Client">Description(Client):</label>
                                <textarea  name="descri_client" class="form-control" id="Descri_Client" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Descri_Employee">Description(Employee):</label>
                                <textarea  name="descri_employee" class="form-control" id="Descri_Employee" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Service_Provided">Service Provided:</label>
                                <textarea  name="service_provided" class="form-control" id="Service_Provided" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Material_Supplied">Material Supplied:</label>
                                <textarea  name="material_supplied" class="form-control" id="Material_Supplied" rows="3"></textarea>
                            </div>

                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12">
                            <br><br>
                            <fieldset id="fieldset" disabled>
                                <legend>Service <input name="check" type="checkbox" onclick="document.getElementById('fieldset').disabled = !this.checked;" /></legend>

                                <div class="form-group col-lg-6">
                                    <label for="Service">Service:</label>

                                    <select name="service" class="form-control" id="Service">
                                        <?php
                                        echo '<option value="NULL"> -- Select Service -- </option>';
                                        $query = 'SELECT * FROM service ORDER BY name ASC;';
                                        $result = mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
                                        if(mysqli_num_rows($result)>=1) {
                                            while($row = mysqli_fetch_assoc($result)){
                                                echo '<option value='.$row['id_user'].' '.active($row['id_user'], $_POST['employee']).'>'.$row['name'].'</option>';
                                            }
                                        }else{
                                            echo '<option value="NULL">No value found</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="budget_service">Budget Service:</label>
                                    <input type="text" name="budget_service" class="form-control" id="budget_service" />
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="sending_date">Sending Date:</label>
                                    <input type="datetime-local" name="sending_date" class="form-control" id="sending_date" />
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="delivery_date">Delivery Date:</label>
                                    <input type="datetime-local" name="delivery_date" class="form-control" id="delivery_date" />
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="reported_problem">Reported Problem:</label>
                                    <textarea name="reported_problem" id="reported_problem" class="form-control" cols="45" rows="2"></textarea>
                                </div>

                                <div class="form-group col-lg-6">
                                    <br>
                                    <label for="reported_problem">Equipment has been Repaired:</label>
                                    <br>
                                    <input type="radio" name="radio" id="radio" value="1" />
                                    <label for="radio">Yes</label>
                                    <input type="radio" name="radio" id="radio" value="0" />
                                    <label for="radio">No</label>

                                </div>
                            </fieldset>
                            <hr />
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="Budget">Budget:</label>
                                <input type="text" name="budget" class="form-control" id="Budget"/>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit1" class="btn btn-default" value="Create" />
                                <input type="reset" name="clean" class="btn btn-default" value="Clean" />
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
