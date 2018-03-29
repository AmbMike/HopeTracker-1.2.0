<?php
/**
 * File For: HopeTracker.com
 * File Name: head.php.
 * Author: Mike Giammattei
 * Created On: 5/16/2017, 5:00 PM
 */;
 ?>
<?php User::set_session(); ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo ($page_title) ? : 'Hope Tracker | Ambrosia'; ?></title>
    <meta name="description" content="<?php echo ($page_description) ? : 'The focus of HopeTrack is to build a community that will support you for ever.'; ?>">

    <link rel="canonical" href="<?php echo ($canonical_url); ?>" />
    <?php echo ($no_index) == true ? '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">' : ''; ?>
    <?php echo ($custom_stylesheet) ? ' <link rel="stylesheet" href="'.CSS.'/'.$custom_stylesheet.'.css" type="text/css">' : ''; ?>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/<?php echo RELATIVE_PATH ?>HopeAdmin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/<?php echo RELATIVE_PATH ?>HopeAdmin/plugins/iCheck/square/blue.css">


    <link rel="stylesheet" href="/<?php echo RELATIVE_PATH ?>HopeAdmin/plugins/select2/select2.css">

    <link rel="stylesheet" href="/<?php echo RELATIVE_PATH ?>HopeAdmin/dist/css/skins/skin-blue.min.css">

    <link rel="stylesheet" href="/<?php echo RELATIVE_PATH ?>HopeAdmin/site/public/css/main.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/<?php echo RELATIVE_PATH ?>HopeAdmin/dist/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
