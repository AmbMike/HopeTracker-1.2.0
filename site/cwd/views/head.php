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
<html lang="en">
<head>
	<?php if( ENV != 'dev'): ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WJDDD8');</script>
    <!-- End Google Tag Manager -->
	<?php endif; ?>
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

    <?php
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>
    <link rel="canonical" href="<?php echo ($canonical_url) ? : $actual_link; ?>" />
    <?php echo ($no_index) == true ? '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">' : ''; ?>

    <?php echo ($custom_stylesheet) ? ' <link rel="stylesheet" href="'.CSS.'/'.$custom_stylesheet.'.css" type="text/css">' : ''; ?>

    <meta property="og:title" content="<?php echo ($og_title)  ? : 'HomeTracker | There is Hope'; ?>" />
    <meta property="og:url" content="<?php echo (BASE_URL . $og_url)  ? : $actual_link; ?>" />
    <meta property="og:image" content="<?php echo BASE_URL; echo ($og_img) ? :IMAGES .'quotes/quote.cant_shine.jpg'; ?>" />
    <meta property="og:description" content="<?php echo ($page_title) ? : 'Hope Tracker | Ambrosia'; ?>"/>
    <meta property="fb:app_id" content="169128966857060"/>
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:type" content="Website" />
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body data-page-url="<?php global $p_url; echo $p_url; ?>">
<?php if( ENV != 'dev'): ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WJDDD8"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Start of LiveChat (www.livechatinc.com) code -->
    <script type="text/javascript">
        window.__lc = window.__lc || {};
        window.__lc.license = 9705150;
        window.__lc.ga_version = "gtm";
        window.__lc.params = [
            { name: 'Tracking Code', value: 'NA' },
            { name: 'Campaign Format', value: 'NA' },
            { name: 'Campaign Description', value: 'NA' }
        ];
        (function() {
            var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
            lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
        })();
    </script>
    <!-- End of LiveChat code -->
<?php endif; ?>
<?php if(SHOW_PAGE_LOADER == "Yes"): ?>
    <div id="loader-wrapper" data-show-page-loader="<?php echo SHOW_PAGE_LOADER; ?>">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
<?php endif; ?>

