<?php 
if(is_file("core/init.php")){
	include("core/init.php");
}else{
	include("../core/init.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
echo '<link href="'.check('style/default/css/layout.css').'" rel="stylesheet" type="text/css" />';
echo '<script type="text/javascript" src="'.check('ajax/ajax.js').'"></script>';
?>
