<?php 
require ('core/init.php');
if(!isset($_SESSION['id'])){
    echo "Não tes acesso a esta pagina";
    die();
}
?>
<html>
    <head>
        <link rel="stylesheet" href="style/default/css/print.css" type="text/css" />
    </head>
    <body>
    <?php
    $id = protect($_GET['id']);
    $idcli = protect($_GET['idcli']);
    $empr = protect($_GET['empr']);
    
    $SQL1 = mysql_query("SELECT * FROM `equip_status` WHERE `id`='".$id."'");
    $SQL2 = mysql_query("SELECT * FROM `client` WHERE `id_client`='".$idcli."'");
    $SQL3 = mysql_query("SELECT * FROM `equipment` WHERE `id`='".$id."'");
    $SQL4 = mysql_query("SELECT * FROM `equip_problem` WHERE `id`='".$id."'");
    
    $field1 = mysql_fetch_assoc($SQL1);
    $field2 = mysql_fetch_assoc($SQL2);
    $field3 = mysql_fetch_assoc($SQL3);
    $field4 = mysql_fetch_assoc($SQL4);
    ?>
        <div id="A4">
            <div class="center">
                <img class="logo" src="style/default/img/partner/logo.png"/>
                <p class="long">
                    <span class="left">
                        Av. Bombeiros Voluntários, 700, 1-D<br />
                        Apartado 25<br />
                        4585-907 Rebordosa<br />
                    </span>
                    <span class="right">
                        t. 00351 220992008<br />
                        e. info@takemore.pt<br />
                        w. www.takemore.pt<br />
                    </span>
                </p>
                <h2>Ficha de Reparação</h2>
                <div class="box">
                    <table>
                        <tr>
                            <td>
                                <span>Cliente</span>
                                <br /><?php echo $field2['name']; ?>
                            </td>
                            <td>
                                <span>Morada</span>
                                <br /><?php echo $field2['address']; ?>
                            </td>
                            <td>
                                <span>Contacto</span>
                                <br />
                                <?php 
                                if($field2['phone']!=0){
                                    echo $field2['phone'];}
                                elseif(empty($field2['email'])){
                                    echo $field2['email'];
                                } 
                                ?>
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span>Consultor / Técnico</span>
                                <br />
                                <?php echo $empr; ?>
                                <br />
                            </td>
                            <td>
                                <span>Local</span>
                                <br />Fabrica de Rebordosa
                            </td>
                            <td>
                                <span>Data</span>
                                <br />
                                <?php echo date("d/m/Y h:i:s");?>
                                <br />
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>Tempo Total de Intervenção: <?php echo $field1['final_time'];  ?> </h2>
                <table>
                    <tr>
                        <td><span>Inicio da Assistência</span><br />
                            <?php echo $field1['start_date'];?>
                        </td>
                        <td><span>Conclusão da Assistência</span><br />
                            <?php echo $field1['end_date']; ;?>
                        </td>
                    </tr>
                </table>
                <?php 
                if(!empty($field4['problem/damage'])){
                    echo '<h2>Problema da Avaria</h2>';
                    echo '<p>'.$field4['problem/damage'].'</p>';
                }
                ?>
                <?php
                if(!empty($field4['description(employee)'])){ 
                    echo '<h2>Diagnostico tecnico</h2>';
                    echo '<p>'.$field4['description(employee)'].'</p>';
                }
                ?>
                <?php
                if(!empty($field3['service'])){ 
                    echo '<h2>Serviço efetuado</h2>';
                    echo '<p>'.$field3['service'].'</p>';
                }
                ?>
                <?php
                if(!empty($field3['provided'])){ 
                    echo '<h2>Material fornecido</h2>';
                    echo '<p>'.$field3['provided'].'</p>';
                }
                ?>
                 <?php
                if(!empty($field3['budget'])){ 
                    echo '<h2>Price:</h2>';
                    echo '<p>'.$field3['budget'].'€</p>';
                }else{echo '<h2>Price:</h2> <br> _______________€';}
                ?>
            </div>
            <p class="long"><span class="left1">O Cliente <br /><br /><br /> ________________________________________</span><span class="right1">O Técnico/Consultor <br /><br /><br />________________________________________</span></p>
            <hr />
            <p><span>*Os serviços de assistência terão sempre o custo da primeira hora nos serviços presenciais.</span></p>
            <p><span>*Os serviços de assistência serão contabilizados em periodos de 15 minutos.</span></p>
            <table>
                <tr>
                    <td><img src="style/default/img/partner/microsoft.jpg"/></td>
                    <td><img src="style/default/img/partner/hppartner.png"/></td>
                    <td><img src="style/default/img/partner/sagepartner.png"/></td>
                    <td><img src="style/default/img/partner/google.png"/></td>
                    <td><img src="style/default/img/partner/tmi_avat.jpg"/></td>
                </tr>
            </table>
        </div>
    </body>
</html>
<script>
    window.print();return;
</script>