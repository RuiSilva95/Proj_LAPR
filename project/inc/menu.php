<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo check('home.php');?>"><img style="max-width:180px; margin-top: -7px;"
             src="<?php echo check('img/takemore_lg.png');?>"></a>
    </div>

    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu message-dropdown">
                <?php
                $query = 'SELECT * FROM message WHERE para = "'.$_SESSION['id'].'" ORDER BY para DESC LIMIT 3';
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $querypic = 'SELECT * FROM users WHERE id_user = "'.$row["de"].'"';
                    $uid = mysqli_fetch_assoc(mysqli_query($conn, $querypic));
                ?>

                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                <?php
                                $pinc = $uid['data'];
                                if($pinc!=null) {
                                    echo '<img src="data:image/jpg;base64,' . base64_encode($pinc) . '"  width="50" height="50">';
                                }else{
                                    echo '<i class="fa fa-user" style="font-size:50px"> </i>';
                                }
                                ?>
                            </span>
                            <div class="media-body">
                                <h5 class="media-heading">
                                    <strong><?php echo $uid["name"]; ?></strong>
                                </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i><?php echo $row["date"]; ?></p>
                                <p><?php echo $row["title"]; ?></p>
                            </div>
                        </div>
                    </a>
                </li>
                <?php
                }
                ?>
                <li class="message-footer">
                    <a href="<?php echo check('inbox.php'); ?>">Read All New Messages</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php
                $pinc = access('data');
                if($pinc!=null) {
                    echo '<img src="data:image/jpg;base64,' . base64_encode($pinc) . '"  width="18" height="18">';
                }else{
                    echo '<i class="fa fa-user"> </i>';
                }
                ?>
                &nbsp&nbspWelcome <?php echo access('name'); ?>&nbsp&nbsp
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="<?php echo check('user/profile.php'); ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li>
                    <a href="<?php echo check('user/inbox.php'); ?>"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                </li>
                <li>
                    <a href="<?php echo check('user/setting.php'); ?>"><i class="fa fa-fw fa-gear"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo check('logout.php'); ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>





    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li <?php echo (current_file()=='home.php')? 'class="active"':'';?>>
                <a href="<?php echo check('home.php');?>"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#drop1"><i class="fa fa-fw fa-file"></i> Sheet Repair <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="drop1" class="collapse">
                    <li <?php echo (current_file()=='external.php')? 'class="active"':'';?>>
                        <a href="<?php echo check('external.php');?>">External</a>
                    </li>
                    <li <?php echo (current_file()=='internal.php')? 'class="active"':'';?>>
                        <a href="<?php echo check('internal.php');?>">Internal</a>
                    </li>
                </ul>
            </li>
            <li <?php echo (current_file()=='client.php')? 'class="active"':'';?>>
                <a href="<?php echo check('client.php');?>"><i class="fa fa-fw fa-users"></i> Client </a>
            </li>
            <li <?php echo (current_file()=='service.php')? 'class="active"':'';?>>
                <a href="<?php echo check('service.php');?>"><i class="fa fa-fw fa-wrench"></i> Service </a>
            </li>
            <?php
            if(access('status')=='1') {
                echo '<li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#drop2"><i class="fa fa-fw fa-unlock-alt"></i> Administration <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="drop2" class="collapse">
                        <li>
                            <a href="'.check('admin/mapping.php').'"><i class="fa fa-fw fa-calendar-plus-o"> </i> Mapping</a>
                        </li>
                        <li>
                            <a href="'.check('admin/user.php').'"><i class="fa fa-fw fa-user"> </i> User Management</a>
                        </li>
                    </ul>
                </li>';
            }
            ?>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>
