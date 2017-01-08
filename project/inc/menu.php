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
                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                <img class="media-object" src="http://placehold.it/50x50" alt="">
                            </span>
                            <div class="media-body">
                                <h5 class="media-heading">
                                    <strong>John Smith</strong>
                                </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet, consectetur...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                <img class="media-object" src="http://placehold.it/50x50" alt="">
                            </span>
                            <div class="media-body">
                                <h5 class="media-heading">
                                    <strong>John Smith</strong>
                                </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet, consectetur...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="message-preview">
                    <a href="#">
                        <div class="media">
                            <span class="pull-left">
                                <img class="media-object" src="http://placehold.it/50x50" alt="">
                            </span>
                            <div class="media-body">
                                <h5 class="media-heading">
                                    <strong>John Smith</strong>
                                </h5>
                                <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                <p>Lorem ipsum dolor sit amet, consectetur...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="message-footer">
                    <a href="#">Read All New Messages</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu alert-dropdown">
                <li>
                    <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">View All</a>
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
                &nbsp&nbsp<?php echo access('name'); ?>&nbsp&nbsp
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
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
            <li>
                <a href="<?php echo check('home.php');?>"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#drop1"><i class="fa fa-fw fa-file"></i> Sheet Repair <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="drop1" class="collapse">
                    <li>
                        <a href="<?php echo check('external.php');?>">External</a>
                    </li>
                    <li>
                        <a href="<?php echo check('internal.php');?>">Internal</a>
                    </li>
                </ul>
            </li>
            <li class="active">
                <a href="<?php echo check('client.php');?>"><i class="fa fa-fw fa-users"></i> Client </a>
            </li>
            <li>
                <a href="<?php echo check('service.php');?>"><i class="fa fa-fw fa-wrench"></i> Service </a>
            </li>
            <?php
            if(access('status')=='1') {
                echo '<li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#drop2"><i class="fa fa-fw fa-unlock-alt"></i> administration <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="drop2" class="collapse">
                        <li>
                            <a href="'.check('admin/mapping.php').'">Mapping</a>
                        </li>
                        <li>
                            <a href="'.check('admin/user.php').'">User Management</a>
                        </li>
                    </ul>
                </li>';
            }
            ?>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>
