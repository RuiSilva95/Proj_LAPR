<?php require "inc/head.php";

if(!isset($_SESSION['id'])) {
    echo "Não tes acesso a esta pagina";
    die();
}

?>

<script>
    var url = window.location.toString();
    var query_string = url.split('?');
    var params = query_string[1].split('&');
    var param_item = params[0].split('=');
    var imp = param_item[1];

    if(imp == '0'){
        var params = query_string[1].split('&');
        var param_item = params[1].split('=');
        var id = param_item[1];
        var params = query_string[1].split('&');
        var param_item = params[2].split('=');
        var idcli = param_item[1];
        window.open('print_technical.php?id='+id+'&idcli='+idcli,'_blank')
    }
    if(imp == '1'){
        var params = query_string[1].split('&');
        var param_item = params[1].split('=');
        var id = param_item[1];
        var params = query_string[1].split('&');
        var param_item = params[2].split('=');
        var entity = param_item[1];
        window.open('print_bill.php?id='+id+'&entity='+entity,'_blank')
    }
</script>


<div id="wrapper">
        <?php require "inc/menu.php"; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            DashBoard
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <form method="POST" name="filterInternal" class="form-inline" action="<?php echo current_file(); ?>">
                            <legend><h2>Internal</h2></legend>

                            <div class="col-lg-2 form-group">
                                <label for="Client">Client</label>
                                <select name="client1" class="form-control" id="Client" >
                                    <?php
                                    echo '<option value="*" '.active('*', $_POST['status']).'>&nbsp&nbsp&nbsp&nbsp- See All -&nbsp&nbsp&nbsp&nbsp</option>';
                                    echo '<option value="priv" '.active('priv', $_POST['client']).'>Private</option>';
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

                            <div class="col-lg-2 form-group">
                                <label for="Status">Status</label>
                                <select name="status1" class="form-control" id="Status">
                                    <option value="*" <?php active('*', $_POST['status']); ?>>&nbsp&nbsp&nbsp&nbsp- See All -&nbsp&nbsp&nbsp&nbsp</option>
                                    <option value="Waits" <?php echo active('Waits', $_POST['status']); ?>>Waits</option>
                                    <option value="Budgeted" <?php echo active('Budgeted', $_POST['status']); ?>>Budgeted</option>
                                    <option value="Under Repair" <?php echo active('Under Repair', $_POST['status']); ?>>Under Repair</option>
                                    <option value="Closed Billing" <?php echo active('Closed Billing', $_POST['status']); ?>>Closed Billing</option>
                                    <option value="Closed Guaranty" <?php echo active('Closed Guaranty', $_POST['status']); ?>>Closed Guaranty</option>
                                    <option value="Closed Contract" <?php echo active('Closed Contract', $_POST['status']); ?>>Closed Contract</option>
                                    <option value="Archive" <?php echo active('Archive', $_POST['status']); ?> >Archive</option>
                                </select>
                            </div>

                            <div class="col-lg-2 form-group">
                                <label for="Employee">Employee</label>
                                    <select name="employee1" class="form-control" id="employee">
                                        <?php
                                        echo '<option value="*">&nbsp&nbsp&nbsp&nbsp- See All -&nbsp&nbsp&nbsp&nbsp</option>';
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

                            <div class="col-lg-3 form-group">
                                <label for="NumberId">Number ID</label>
                                <input type="text" name="numberid1" class="form-control" id="NumberId"  />
                            </div>

                            <div class="col-md-2 form-group"><br>
                                <label for="NumberId">&nbsp&nbsp</label>
                                <input type="submit" name="submit1" class="btn btn-default btn-lg" value="Filter" />
                            </div>
                        </form>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id:</th>
                                            <th>Employee:</th>
                                            <th>Status:</th>
                                            <th>Client:</th>
                                            <th>Description:</th>
                                            <th>Edit:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if($_POST['client1']!=0) {
                                            $ext1 = 'client.id_client="'.$_POST['client1'].'" AND';
                                        }elseif($_POST['client1']=='priv') {
                                            $ext1 = 'client.private=1 AND';
                                        }else{
                                            $ext1 = ' ';
                                        }
                                        //*************************************************************
                                        if($_POST['status1']!=0) {
                                            $ext2 = 'equipment_status.status LIKE "'.$_POST['status1'].'" AND';
                                        }else{
                                            $ext2 = ' ';
                                        }
                                        //*************************************************************
                                        if(!empty($_POST['numberid1'])) {
                                            $ext3 = 'internal.id_internal='.$_POST['numberid1'].' AND';
                                        }else{
                                            $ext3 = ' ';
                                        }

                                        //*************************************************************
                                        if($_POST['employee1']!=0) {
                                            $ext4 =  'users.id_user="'.$_POST['employee1'].'"';
                                        }else{
                                            $ext4 = ' users.id_user=users.id_user ';
                                        }
                                        //*************************************************************
                                        //*************************************************************
                                        $pageNumber=3;

                                        $offset= (mysqli_real_escape_string($conn, $_GET["page1"])-1)*$pageNumber;
                                        if($offset<0) {
                                            $offset=0;
                                        }

                                        $count = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM internal;'));

                                        $query = 'SELECT internal.id_internal AS int_id,
                                                                users.name AS user_name,
                                                                equipment_status.status AS equip_status,
                                                                client.name AS client_name,
                                                                equip_problem.`description(employee)` AS int_description
                                                        FROM internal
                                                            INNER JOIN client ON internal.id_client = client.id_client
                                                            INNER JOIN users ON internal.id_user = users.id_user
                                                            INNER JOIN equipment_status ON internal.id_equipment_status = equipment_status.id_equipment_status
                                                            INNER JOIN equip_problem ON internal.id_equipment_problem = equip_problem.id_equipment_problem
                                                            WHERE  '.$ext1.' '.$ext2.' '.$ext3.' '.$ext4.'  ORDER BY internal.id_internal DESC';

                                        $result = mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
                                        if(mysqli_num_rows($result)>0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                    echo '<td >'.$row['int_id'].'</td>';
                                                    echo '<td>'.$row['user_name'].'</td>';
                                                    echo '<td '.tint($row['equip_status']).'>'.$row['equip_status'].'</td>';
                                                    echo '<td>'.$row['client_name'].'</td>';
                                                    echo '<td>'.$row['int_description'].'</td>';
                                                    echo '<td>
                                                            <a class="btn btn-default href="'.check('internal.edit.php').'?edit='.$row['int_id'].'">Edit</a>
                                                            <a class="btn btn-default href="'.check('internal.edit.php').'?apg='.$row['int_id'].'">Delete</a>
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
                                <nav aria-label="...">
                                    <center>
                                        <ul class="pagination pagination-sm">
                                            <?php
                                            for($i=0;$i<($count/$pageNumber);$i++){
                                                echo '<li class="page-item"><a class="page-link" href="'.current_file().'?page1='.($i+1).'">'.($i+1).'</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </center>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <form method="POST" name="filterExternal" class="form-inline" action="<?php echo current_file(); ?>">
                            <legend><h2>External</h2></legend>

                            <div class="col-lg-2 form-group">
                                <label for="Client">Client</label>
                                <select name="client2" class="form-control" id="Client" >
                                    <?php
                                    echo '<option value="0" '.active('*', $_POST['status']).'>&nbsp&nbsp&nbsp&nbsp- See All -&nbsp&nbsp&nbsp&nbsp</option>';
                                    echo '<option value="priv" '.active('priv', $_POST['client']).'>Private</option>';
                                    $query = 'SELECT * FROM client WHERE private=0 ORDER BY name ASC;';
                                    $result = mysqli_query($conn, $query)or die("Error:".mysqli_error($conn));
                                    if(mysqli_num_rows($result)>=1) {
                                        while($row = mysqli_fetch_assoc($result)){
                                            echo '<option value="'.$row['id_client'].'" '.active($row['id_client'], $_POST['client2']).' >'.$row['name'].'</option>';
                                        }
                                    }else{
                                        echo '<option value="0">No value found</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-2 form-group">
                                <label for="Status">Status</label>
                                <select name="status2" class="form-control" id="Status">
                                    <option value="0">&nbsp&nbsp&nbsp&nbsp- See All -&nbsp&nbsp&nbsp&nbsp</option>
                                    <option value="Waits" <?php echo active('Waits', $_POST['status2']); ?>>Waits</option>
                                    <option value="Budgeted" <?php echo active('Budgeted', $_POST['status2']); ?>>Budgeted</option>
                                    <option value="Under Repair" <?php echo active('Under Repair', $_POST['status2']); ?>>Under Repair</option>
                                    <option value="Closed Billing" <?php echo active('Closed Billing', $_POST['status2']); ?>>Closed Billing</option>
                                    <option value="Closed Guaranty" <?php echo active('Closed Guaranty', $_POST['status2']); ?>>Closed Guaranty</option>
                                    <option value="Closed Contract" <?php echo active('Closed Contract', $_POST['status2']); ?>>Closed Contract</option>
                                    <option value="Archive" <?php echo active('Archive', $_POST['status2']); ?> >Archive</option>
                                </select>
                            </div>

                            <div class="col-lg-2 form-group">
                                <label for="Employee">Employee</label>
                                    <select name="employee2" class="form-control" id="employee">
                                        <?php
                                        echo '<option value="0">&nbsp&nbsp&nbsp&nbsp- See All -&nbsp&nbsp&nbsp&nbsp</option>';
                                        $query = 'SELECT * FROM users ORDER BY name ASC;';
                                        $result = mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
                                        if(mysqli_num_rows($result)>=1) {
                                            while($row = mysqli_fetch_assoc($result)){
                                                echo '<option value='.$row['id_user'].' '.active($row['id_user'], $_POST['employee2']).'>'.$row['name'].'</option>';
                                            }
                                        }else{
                                            echo '<option value="0">No value found</option>';
                                        }
                                        ?>
                                    </select>
                            </div>

                            <div class="col-lg-3 form-group">
                                <label for="NumberId">Number ID</label>
                                <input type="text" name="numberid2" class="form-control" id="NumberId"  />
                            </div>

                            <div class="col-md-2 form-group"><br>
                                <label for="NumberId">&nbsp&nbsp</label>
                                <input type="submit" name="submit2" class="btn btn-default btn-lg" value="Filter" />
                            </div>
                        </form>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id:</th>
                                            <th>Employee:</th>
                                            <th>Status:</th>
                                            <th>Client:</th>
                                            <th>Description:</th>
                                            <th>Edit:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if($_POST['client2']!=0) {
                                            $ext1 = 'client.id_client="'.$_POST['client2'].'" AND';
                                        }elseif($_POST['client2']=='priv') {
                                            $ext1 = 'client.private=1 AND';
                                        }else{
                                            $ext1 = ' ';
                                        }
                                        //*************************************************************
                                        if($_POST['status2']!=0) {
                                            $ext2 = 'equipment_status.status LIKE "'.$_POST['status2'].'" AND';
                                        }else{
                                            $ext2 = ' ';
                                        }
                                        //*************************************************************
                                        if(!empty($_POST['numberid2'])) {
                                            $ext3 = 'external.id_external='.$_POST['numberid2'].' AND';
                                        }else{
                                            $ext3 = ' ';
                                        }

                                        //*************************************************************
                                        if($_POST['employee2']!=0) {
                                            $ext4 =  'users.id_user="'.$_POST['employee2'].'"';
                                        }else{
                                            $ext4 = ' users.id_user=users.id_user ';
                                        }
                                        //*************************************************************
                                        //*************************************************************
                                        $pageNumber=3;

                                        $offset= (mysqli_real_escape_string($conn, $_GET["page2"])-1)*$pageNumber;
                                        if($offset<0) {
                                            $offset=0;
                                        }

                                        $count = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM external;'));

                                        $query = 'SELECT external.id_external AS ext_id,
                                                                users.name AS user_name,
                                                                equipment_status.status AS equip_status,
                                                                client.name AS client_name,
                                                                external.description AS ext_description
                                                        FROM external
                                                            INNER JOIN client ON external.id_client = client.id_client
                                                            INNER JOIN users ON external.id_user = users.id_user
                                                            INNER JOIN equipment_status ON external.id_equipment_status = equipment_status.id_equipment_status
                                                            WHERE  '.$ext1.' '.$ext2.' '.$ext3.' '.$ext4.'  ORDER BY external.id_external DESC';

                                        $result = mysqli_query($conn, $query) or die("Error:".mysqli_error($conn));
                                        if(mysqli_num_rows($result)>0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                    echo '<td >'.$row['ext_id'].'</td>';
                                                    echo '<td>'.$row['user_name'].'</td>';
                                                    echo '<td '.tint($row['equip_status']).'>'.$row['equip_status'].'</td>';
                                                    echo '<td>'.$row['client_name'].'</td>';
                                                    echo '<td>'.$row['ext_description'].'</td>';
                                                    echo '<td>
                                                            <a class="btn btn-default href="'.check('external.edit.php').'?edit='.$row['ext_id'].'">Edit</a>
                                                            <a class="btn btn-default href="'.check('external.edit.php').'?apg='.$row['ext_id'].'">Delete</a>
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
                                <nav aria-label="...">
                                    <center>
                                        <ul class="pagination pagination-sm">
                                            <?php
                                            for($i=0;$i<($count/$pageNumber);$i++){
                                                echo '<li class="page-item"><a class="page-link" href="'.current_file().'?page2='.($i+1).'">'.($i+1).'</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </center>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /// page-wrapper -->

    </div>
    <!-- /// wrapper -->
<?php require "inc/footer.php"; ?>
