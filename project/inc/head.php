<?php
if(is_file("core/init.php")) {
    include "core/init.php";
}else{
    include "../core/init.php";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Takemore.com</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo check('css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo check('css/sb-admin.css'); ?>" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo check('css/plugins/morris.css'); ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo check('css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
</head>
<body>
