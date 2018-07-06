<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Martin Hlaváč">
    <link rel="icon" href="<?php echo KT::imageGetUrlFromTheme("favicon.ico"); ?>">
    <title><?php bloginfo("name"); ?></title>
    <?php
    wp_head();
    KT_ZZZ::renderAnalyticsPixelCode();
    KT_ZZZ::renderCompatibilityScript();
    ?>
</head>
<body>
<?php KT_ZZZ::renderAnalyticsTrackingCode(); ?>
<div id="top" class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo get_home_url(); ?>"><?php echo get_bloginfo("name"); ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <?php KT::theWpNavMenu(KT_ZZZ_NAVIGATION_MAIN_MENU, 1, new KT_ZZZ_WP_Bootstrap_Navwalker()); ?>
            </ul>
        </div>
        <?php get_search_form(); ?>
    </nav>