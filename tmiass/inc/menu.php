<div id="menu">
  <div class="nav">
  <ul>
    <li><a href="<?php echo check('home.php');?>">Home</a></li>
    <li><a href="#">Sheet repair</a>
      <ul>
        <li><a href="<?php echo check('external.php');?>">External</a></li>
        <li><a href="<?php echo check('internal.php');?>">Internal</a></li>
      </ul>
    </li>
    <li><a href="<?php echo check('client.php');?>">Client</a></li>
    <li><a href="<?php echo check('service.php');?>">Service</a></li>
    <?php 
	switch(access('status')) {
    case 1:
        echo '<li><a href="#">proj2</a></li>';
        break;
    case 2:
        echo '<li><a href="#">proj2</a></li>
			  <li><a href="#">administration</a>
			  <ul>
			    <li><a href="'.check('admin/mapping.php').'">Mapping</a></li>
				<li><a href="'.check('admin/user.php').'">User Management</a></li>
			  </ul>
			</li>';
        break;
	}
	 ?>
  </ul>
  </div>
</div>