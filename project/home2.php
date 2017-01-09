<form id="filter" name="filter" method="POST" action="<?php echo $current_file; ?>">

          <tr>
              <td><label for="number">Number ID</label></td>
            <td><input size="4" type="text" name="number" id="NºID" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" class="myButton" id="submit" value="Filter" /></td>
          </tr>
        </table>
      </fieldset>













      <p>&nbsp;</p>
      <table align="center" name="list" id="list">
        <tr>
          <th  width="42" scope="col">Id:</th>
          <th  scope="col">Client:</th>
          <th  scope="col">Description:</th>
          <th  scope="col">Status:</th>
          <th  scope="col">Employee:</th>
          <th  scope="col">Entity:</th>
          <th  width="170" scope="col">Edit:</th>
        </tr>
        <?php
        if($_POST['client']!=0) {
            $ext1 ="`client`.`id_client`='".$_POST['client']."' AND ";
        }elseif($_POST['client']=='priv') {
            $ext1 ="`client`.`private`=1 AND";
        }else{
            $ext1 = ' ';
        }
        //*************************************************************
        if($_POST['status']) {
            $ext2 = "`equip_status`.`status` LIKE '".$_POST['status']."' AND ";
        }else{
            $ext2 = ' ';
        }
        //*************************************************************
        if(!empty($_POST['entity'])) {
            $ext3 =  "`equipment`.`entity`='".$_POST['entity']."' AND " ;
        }else{
            $ext3 = ' ';
        }
        //*************************************************************
        if(!empty($_POST['number'])) {
                    $ext4 =  "`equipment`.`id`='".$_POST['number']."'AND " ;
        }else{
            $ext4 = ' ';
        }

        //*************************************************************
        if($_POST['employee']!=0) {
            $ext5 =  "`users`.`id_user`='".$_POST['employee']."'" ;
        }else{
            $ext5 = " `users`.`id_user`=`users`.`id_user` ";
        }
            //*************************************************************
        $campos_query = "`client`.`name` AS 'client_name' ,`equipment`.`entity` AS 'enty' , `equip_status`.`status` AS 'stats' , `equipment`.`id_client` AS 'id_cli' , `users`.`name` AS 'user_name' ,`equip_problem`.`description(employee)` AS 'descript' , `equipment`.`id` AS 'idd'";

            $final_query  = "FROM `equipment`
                             INNER JOIN `equip_status` ON `equip_status`.`id` = `equipment`.`id`
                             INNER JOIN `client` ON `client`.`id_client` = `equipment`.`id_client`
                             INNER JOIN `users` ON `users`.`id_user` = `equipment`.`id_user`
							 INNER JOIN `equip_problem` ON `equip_problem`.`id` = `equipment`.`id`
                             WHERE ".$ext1." ".$ext2." ".$ext3." ".$ext4." ".$ext5." ORDER BY `equipment`.`id`";
        $maximo = 5;
                $pagina = $_GET["pagina"];
        if($pagina == "") {
            $pagina = "1";
        }
                $inicio = $pagina - 1;
                $inicio = $maximo * $inicio;

                $strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
                $query = mysqli_query($conn, $strCount);
                $row = mysqli_fetch_array($query);
                $total = $row["num_registros"];
                $sql = mysqli_query($conn, "SELECT $campos_query $final_query LIMIT $inicio,$maximo") or die("Error:".mysqli_error($conn));
        while ($result_SQL = mysqli_fetch_assoc($sql)) {
            echo '<tr>';
            echo '<td >'.$result_SQL['idd'].'</td>';
            echo '<td>'.$result_SQL['client_name'].'</td>';
            echo '<td>'.$result_SQL['descript'].'</td>';
            echo '<td '; echo ''.tint($result_SQL['stats']).'>'.$result_SQL['stats'].'</td>';
            echo '<td>'.$result_SQL['user_name'].'</td>';
            if($result_SQL['enty']=='2') {
                echo '<td>Internal</td>';
                echo '<td>
				<a class="myButton" href="'.check('internal.edit.php').'?id='.$result_SQL['idd'].'&cli='.$result_SQL['id_cli'].'&empr='.$result_SQL['user_name'].'">Edit</a>
				<a class="myButton" href="'.check('internal.edit.php').'?apg='.$result_SQL['idd'].'&cli='.$result_SQL['id_cli'].'">Delete</a> </td>';
            }else{
                echo '<td>External</td>';
                echo '<td>
				<a class="myButton" href="'.check('external.edit.php').'?id='.$result_SQL['idd'].'&cli='.$result_SQL['id_cli'].'&empr='.$result_SQL['user_name'].'">Edit</a>
				<a class="myButton" href="'.check('external.edit.php').'?apg='.$result_SQL['idd'].'&cli='.$result_SQL['id_cli'].'">Delete</a> </td>';
            }
            echo '</tr>';
        }

        $menos = $pagina - 1;
                $mais = $pagina + 1;
                $pgs = ceil($total / $maximo);
        if($pgs > 1 ) {
            echo "<br /><span>";
            if($menos > 0) {
                echo "<a href=".$_SERVER['PHP_SELF']."?pagina=$menos>anterior</a>&nbsp; ";
            }
            for($i=1;$i <= $pgs;$i++) {
                if($i != $pagina) {
                    echo " <a href=".$_SERVER['PHP_SELF']."?pagina=".($i).">$i</a> | ";
                }else{
                    echo " <strong>".$i."</strong> | ";
                }
            }
            if($mais <= $pgs) {
                echo " <a href=".$_SERVER['PHP_SELF']."?pagina=$mais>próxima</a>";
            }
            echo '</span>';
        }
    ?>
        </tr>
      </table>
      <p>&nbsp;</p>
    </form>
  </div>
</div>
<?php require "inc/footer.php"; ?>
