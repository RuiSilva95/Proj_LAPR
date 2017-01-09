<?php require "inc/head.php";
/*
if(!isset($_SESSION['id'])) {
    echo "Não tes acesso a esta pagina";
    die();
}
*/
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
        var idcli = param_item[1];
        var params = query_string[1].split('&');
        var param_item = params[3].split('=');
        var empr = param_item[1];
        window.open('print_bill.php?id='+id+'&idcli='+idcli+'&empr='+empr,'_blank')
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
                            <small>Subheading</small>
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
                        <form method="POST" class="form-inline" action="">
                            <legend><h2>Filter</h2></legend>

                            <div class="col-lg-2 form-group">
                                <label for="Client">Client</label>
                                <select name="client" class="form-control" id="Client" >
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
                                <select name="status" class="form-control" id="Status">
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
                                    <select name="employee" class="form-control" id="employee">
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

                            <div class="col-lg-2 form-group">
                                <label for="SheetRepair">Sheet Repair</label>
                                <select name="sheetrepair" class="input-medium form-control" id="SheetRepair">
                                  <option value="*">&nbsp&nbsp&nbsp&nbsp- See All -&nbsp&nbsp&nbsp&nbsp</option>
                                  <option value="1" <?php active('1', $_POST['entity'])?> >External</option>
                                  <option value="2" <?php active('2', $_POST['entity'])?> >Internal</option>
                                </select>
                            </div>

                            <div class="col-lg-2 form-group">
                                <label for="NumberId">Number ID</label>
                                <input type="text" name="numberid" class="form-control" id="NumberId" />
                            </div>

                            <div class="col-md-2 form-group"><br>
                                <label for="NumberId">&nbsp&nbsp</label>
                                <input type="submit" name="submit" class="btn btn-default btn-lg" value="Filter" />
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
                                            <th>Client:</th>
                                            <th>Description:</th>
                                            <th>Status:</th>
                                            <th>Employee:</th>
                                            <th>Sheet Repair:</th>
                                            <th>Edit:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>/index.html</td>
                                            <td>1265</td>
                                            <td>32.3%</td>
                                            <td>$321.33</td>
                                        </tr>
                                        <tr>
                                            <td>/about.html</td>
                                            <td>261</td>
                                            <td>33.3%</td>
                                            <td>$234.12</td>
                                        </tr>
                                        <tr>
                                            <td>/sales.html</td>
                                            <td>665</td>
                                            <td>21.3%</td>
                                            <td>$16.34</td>
                                        </tr>
                                        <tr>
                                            <td>/blog.html</td>
                                            <td>9516</td>
                                            <td>89.3%</td>
                                            <td>$1644.43</td>
                                        </tr>
                                        <tr>
                                            <td>/404.html</td>
                                            <td>23</td>
                                            <td>34.3%</td>
                                            <td>$23.52</td>
                                        </tr>
                                        <tr>
                                            <td>/services.html</td>
                                            <td>421</td>
                                            <td>60.3%</td>
                                            <td>$724.32</td>
                                        </tr>
                                        <tr>
                                            <td>/blog/post.html</td>
                                            <td>1233</td>
                                            <td>93.2%</td>
                                            <td>$126.34</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
