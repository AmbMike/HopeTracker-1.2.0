<?php
/**
 * File For: HopeTracker.com
 * File Name: head.php.
 * Author: Mike Giammattei
 * Created On: 3/10/2017, 1:38 PM
 */
?>
<?php User::set_session(); ?>
<!DOCTYPE HTML>
<html>
<head>
    <link rel="apple-touch-icon" sizes="57x57" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/<?php echo RELATIVE_PATH; ?>site/public/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo ($page_title) ? : 'Hope Tracker | Ambrosia'; ?></title>
    <meta name="description" content="<?php echo ($page_description) ? : 'The focus of HopeTrack is to build a community that will support you for ever.'; ?>">
    <link rel="stylesheet" href="<?php echo CSS; ?>main-full.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

    <link rel="canonical" href="<?php echo ($canonical_url) ? : BASE_URL . $_SERVER['REQUEST_URI'] ?>" />
    <?php echo ($no_index) == true ? '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">' : ''; ?>
    <?php echo ($custom_stylesheet) ? ' <link rel="stylesheet" href="'.CSS.'/'.$custom_stylesheet.'.css" type="text/css">' : ''; ?>
    <meta property="og:title" content="<?php echo ($og_title)  ? : 'HomeTracker | There is Hope'; ?>" />
    <meta property="og:url" content="<?php echo BASE_URL; echo ($og_url)  ? : $_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:image" content="<?php echo BASE_URL; echo ($og_img) ? :IMAGES .'quotes/quote.cant_shine.jpg'; ?>" />

    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
