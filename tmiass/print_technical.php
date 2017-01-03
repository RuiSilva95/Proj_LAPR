 <?php 
require ('core/init.php');
if(!isset($_SESSION['id'])){
    echo "Não tes acesso a esta pagina";
    die();
}
?>

<html>
    <head>
        <link rel="stylesheet" href="css/imprimir.css" type="text/css" />
    </head>
    <body>
        <?php
        $id = protect($_GET['id']);
        $idcli = protect($_GET['idcli']);
        
        $SQL1 = mysql_query("SELECT * FROM `equip_status` WHERE `id`='".$id."'");
        $SQL2 = mysql_query("SELECT * FROM `client` WHERE `idclient`='".$idcli."'");
        $SQL3 = mysql_query("SELECT * FROM `equipment` WHERE `id`='".$id."'");
        $SQL4 = mysql_query("SELECT * FROM `equip_problem` WHERE `id`='".$id."'");
        
        $field1 = mysql_fetch_assoc($SQL1);
        $field2 = mysql_fetch_assoc($SQL2);
        $field3 = mysql_fetch_assoc($SQL3);
        $field4 = mysql_fetch_assoc($SQL4);
        ?>
        <div id="content">
            <h1>Ficha reparação <span class="n">Nº<?php echo $id; ?></span></h1>
            Data entrada:
            <?php 
            if(!empty($field1['start_date'])){echo $field1['start_date'];}?>
            <br /><br /><br />
            <span class="na">nome:
                <?php if(!empty($field2['name'])){echo $field2['name'];}else{echo '_____________________________________________';}?>
            </span>
            <span class="n">telf:
                <?php if(!empty($field3['phone'])){echo $field2['phone'];}else{echo '________________';}?>
            </span>
            <br /><br /><br />
            <table>
                <tr>
                    <td>Equipamento</td>
                    <td>Marca/Modelo</td>
                    <td>NºSerie</td>
                    <td>Acessorios Extras</td>
                </tr>
                <tr>
                    <?php
                    if(!empty($field3['equipment'])){echo '<td>'.$field3['equipment'].'</td>'; }else{ echo '<td>______________</td>';}
                    if(!empty($field3['mark/model'])){echo '<td>'.$field3['mark/model'].'</td>'; }else{ echo '<td>________________</td>';}
                    if(!empty($field3['n_serie'])){echo '<td>'.$field3['n_serie'].'</td>'; }else{ echo '<td>_____________</td>';}
                    if(!empty($field3['accessories'])){echo '<td>'.$field3['accessories'].'</td>'; }else{ echo '<td>______________________</td>';}
                    ?>
                </tr>
            </table>
            <p>
                Problema Avaria:<br />
                <?php 
                if(!empty($field4['problem/damage'])){
                    echo '<td>'.$field4['problem/damage'].'</td>'; 
                }else{ 
                    echo '<td>______________________________________________________________________
                              ______________________________________________________________________</td>';
                }
                ?>
            </p>
            <p>
                observação:<br />
                <?php 
                if(!empty($field4['description(client)'])){
                    echo '<td>'.$field4['description(client)'].'</td>'; 
                }else{ 
                    echo '<td>______________________________________________________________________
                              ______________________________________________________________________
                              ______________________________________________________________________
                              ______________________________________________________________________</td>';
                }
                ?>
            </p>
            <p>
                Serviço Efetuado:<br />
                <?php 
                if(!empty($field4['description(employee)'])){
                    echo '<td>'.$field4['description(employee)'].'</td>';
                }else{ 
                    echo '<td>______________________________________________________________________
                              ______________________________________________________________________
                              ______________________________________________________________________
                              ______________________________________________________________________</td>';
                }
                ?>
            </p>
            <br />Envio para entidade externa:<input type="checkbox"/>Sim <input type="checkbox"/>Não
            <p>
                <br />Material Fornecido:<br />
                <?php 
                if(!empty($field3['provided'])){
                    echo '<td>'.$field3['provided'].'</td>';
                }else{ 
                    echo '<td>______________________________________________________________________
                              ______________________________________________________________________
                              ______________________________________________________________________</td>';
                }
                ?>
            </p>
            <br />
            <table>
                <tr>
                    <td>Orçamento:</td>
                    <td>Aceite:</td>
                </tr>
                <tr>
                    <?php 
                    if(!empty($field3['budget'])){
                        echo '<td>'.$field3['budget'].'</td>'; 
                    }else{ 
                        echo '<td>_________________</td>';
                    } 
                    ?>
                    <td><input type="checkbox"/>Sim</td>
                    <td><input type="checkbox"/>Não</td>
                </tr>
            </table>
        </div>
    </body>
</html>
<script>
    window.print();return;
</script>