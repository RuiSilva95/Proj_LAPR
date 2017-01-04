</head>
<body>
<div id="header">
  <div class="logo"><a href="<?php echo check('home.php'); ?>"><img src="<?php echo check('style/default/img/logo2.png'); ?>" width="400" height="73" /></a></div>
  <div class="user">
  <?php 
	echo 'Welcome '.access('name').'<br />';
  ?>
  <a class="myButton" href="<?php echo check('user/setting.php'); ?>">Setting</a> <a class="myButton" href="<?php echo check('logout.php'); ?>">Exit</a>
  </div>
</div>