<?php

$config = new KT_WP_Configurator();

$config->setDisplayLogo()
    ->setPostArchiveMenu()
    ->setAllowCookieStatement()
    ->setAllowSession();

$config->addThemeSupport(KT_WP_THEME_SUPPORT_POST_THUMBNAILS_KEY);

$config->addPostTypeSupport(KT_WP_POST_TYPE_SUPPORT_EXCERPT_KEY, [KT_WP_PAGE_KEY]);

$config->removePostTypeSupport(KT_WP_POST_TYPE_SUPPORT_THUMBNAIL_KEY, [KT_WP_PAGE_KEY]);

$config->setExcerptText("...");

$config->pageRemover()
    ->removeComments()
    ->removeSubPage("edit.php", "edit-tags.php")
    ->removeSubPage("edit.php", "edit-tags.php?taxonomy=post_tag")
    ->removeSubPage("themes.php", "theme-editor.php");

$config->metaboxRemover()
    ->removePostTagMetabox()
    ->removeMetabox("tagsdiv-news-type", KT_WP_POST_KEY, "normal")
    ->removeRevisionsMetabox();

// --- styly ---------------------------

$config->assetsConfigurator()->addStyle("kt-zzz-bootstrap-style", KT_ZZZ_CSS_URL . "/bootstrap.css")->setVersion("4.1")->setEnqueue();
$config->assetsConfigurator()->addStyle("kt-zzz-style", get_template_directory_uri() . "/style.css")
    ->setDeps(["kt-zzz-bootstrap-style"])
    ->setVersion("20180706")
    ->setEnqueue();

$config->assetsConfigurator()->addStyle("kt-zzz-playfair-font", "https://fonts.googleapis.com/css?family=Playfair+Display:700,900")->setEnqueue();

// --- scripty ------------------------------

$config->assetsConfigurator()->addScript("kt-zzz-jquery-script", KT_ZZZ_JS_URL . "/jquery.js")->setInFooter(true)->setVersion("3.3.1")->setEnqueue();
$config->assetsConfigurator()->addScript("kt-zzz-popper-script", KT_ZZZ_JS_URL . "/popper.js")->setInFooter(true)->setVersion("1.14.3")->setEnqueue();
$config->assetsConfigurator()->addScript("kt-zzz-bootstrap-script", KT_ZZZ_JS_URL . "/bootstrap.js")->setInFooter(true)->setVersion("4.1")->setEnqueue();
$config->assetsConfigurator()
    ->addScript("kt-zzz-functions-script", KT_ZZZ_JS_URL . "/kt-zzz-functions.js")
    ->setDeps(["kt-zzz-jquery-script","kt-zzz-popper-script","kt-zzz-bootstrap-script"])
    ->addLocalizationData("myAjax", ["ajaxurl" => admin_url("admin-ajax.php")])
    ->setInFooter(true)
    ->setVersion("20180706")
    ->setEnqueue();

// --- menu ---------------------------

$config->addWpMenu(KT_ZZZ_NAVIGATION_MAIN_MENU, __("Header Menu", "ZZZ_ADMIN_DOMAIN"));

// --- dashboard ------------------------------

$config->metaboxRemover()->clearWordpressDashboard(true)
    ->removeDashboardMetabox("icl_dashboard_widget")
    ->removeDashboardMetabox("wpseo-dashboard-overview");

// --- widgety ------------------------------

$config->widgetRemover()->removeAllSystemWidgets()
    ->removeWidget("bcn_widget");

// --- head ------------------------------

$config->headRemover()->removeRecommendSystemHeads();

// --- Stránka s theme options ------------------------------

$config->setThemeSettingsPage();

// --- incializace ------------------------------

$config->initialize();

// --- umístění jQuery pluginu do patičky ------------------------------

add_action("wp_enqueue_scripts", "kt_zzz_enqueue_jquery_in_footer");

function kt_zzz_enqueue_jquery_in_footer()
{
    wp_deregister_script("wp-embed");
    wp_deregister_script(KT_WP_JQUERY_SCRIPT);
}
