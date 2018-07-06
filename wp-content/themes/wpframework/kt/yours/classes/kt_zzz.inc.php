<?php

/**
 * Základní statická třída s persitentími daty per request
 */
class KT_ZZZ
{
    private static $themeModel = null;
    private static $frontPageModel;
    private static $postsPageModel;
    private static $siteOptions;

    /** @return KT_ZZZ_Theme_Model */
    public static function getThemeModel()
    {
        if (isset(self::$themeModel)) {
            return self::$themeModel;
        }
        $themeModel = new KT_ZZZ_Theme_Model();
        return self::$themeModel = $themeModel;
    }

    /** @return KT_WP_Post_Base_Model */
    public static function getFrontPageModel()
    {
        if (isset(self::$frontPageModel)) {
            return self::$frontPageModel;
        }
        global $post;
        $frontPageId = get_option(KT_WP_OPTION_KEY_FRONT_PAGE);
        if (isset($post) && $post->ID == $frontPageId) {
            $frontPageModel = new KT_WP_Post_Base_Model($post);
        } else {
            $frontPageModel = new KT_WP_Post_Base_Model(get_post($frontPageId));
        }
        return self::$frontPageModel = $frontPageModel;
    }

    /** @return KT_WP_Post_Base_Model */
    public static function getPostsPageModel()
    {
        if (isset(self::$postsPageModel)) {
            return self::$postsPageModel;
        }
        global $post;
        $postsPageId = get_option(KT_WP_OPTION_KEY_POSTS_PAGE);
        if (isset($post) && $post->ID == $postsPageId) {
            $postsPageModel = new KT_WP_Post_Base_Model($post);
        } else {
            $postsPageModel = new KT_WP_Post_Base_Model(get_post($postsPageId));
        }
        return self::$postsPageModel = $postsPageModel;
    }

    public static function getSiteOptions()
    {
        if (isset(self::$siteOptions)) {
            return self::$siteOptions;
        }
        /** @var WPDB $wpdb */
        global $wpdb;
        $options = [];
        $siteIds = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs};");
        if (KT::arrayIssetAndNotEmpty($siteIds)) {
            $currentSiteId = get_current_blog_id();
            foreach ($siteIds as $siteId) {
                switch_to_blog($siteId);
                $name = get_option("blogname");
                $options[$siteId] = $name;
            }
            asort($options);
            switch_to_blog($currentSiteId);
        }
        return self::$siteOptions = $options;
    }

    public static function renderAnalyticsTrackingCode()
    {
        if (self::getThemeModel()->isAnalyticsTrackingCode()) {
            echo self::getThemeModel()->getAnalyticsTrackingCode();
        }
    }

    public static function renderAnalyticsPixelCode()
    {
        if (self::getThemeModel()->isAnalyticsPixelCode()) {
            echo self::getThemeModel()->getAnalyticsPixelCode();
        }
    }

    public static function renderCompatibilityScript()
    {
        echo "<!--[if lt IE 9]><script src=\"https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js\"></script><script src=\"https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js\"></script><![endif]-->";
    }
}
