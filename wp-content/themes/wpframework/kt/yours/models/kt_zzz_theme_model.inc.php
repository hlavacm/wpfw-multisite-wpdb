<?php

class KT_ZZZ_Theme_Model extends KT_WP_Options_Base_Model
{
    private $categoryNewsPermalink;
    private $categoryNewsTitle;

    public function __construct()
    {
        parent::__construct(KT_ZZZ_Theme_Config::FORM_PREFIX);
    }

    // --- getry & setry ------------------------

    public function getCategoryNewsId()
    {
        return $this->getOption(KT_ZZZ_Theme_Config::CATEGORY_NEWS_ID);
    }

    public function getCategoryNewsPermalink()
    {
        if (isset($this->categoryNewsPermalink)) {
            return $this->categoryNewsPermalink;
        }
        if ($this->isCategoryNewsId()) {
            return $this->categoryNewsPermalink = get_category_link($this->getCategoryNewsId());
        }
        return $this->categoryNewsPermalink = "";
    }

    public function getCategoryNewsTitle()
    {
        if (isset($this->categoryNewsTitle)) {
            return $this->categoryNewsTitle;
        }
        if ($this->isCategoryNewsId()) {
            return $this->categoryNewsTitle = get_cat_name($this->getCategoryNewsId());
        }
        return $this->categoryNewsTitle = "";
    }

    public function getSocialLinkedIn()
    {
        return $this->getOption(KT_ZZZ_Theme_Config::SOCIAL_LINKEDIN);
    }

    public function getSocialTwitter()
    {
        return $this->getOption(KT_ZZZ_Theme_Config::SOCIAL_TWITTER);
    }

    public function getSocialFacebook()
    {
        return $this->getOption(KT_ZZZ_Theme_Config::SOCIAL_FACEBOOK);
    }

    public function getAnalyticsTrackingCode()
    {
        return $this->getOption(KT_ZZZ_Theme_Config::ANALYTICS_TRACKING_CODE);
    }

    public function getAnalyticsPixelCode()
    {
        return $this->getOption(KT_ZZZ_Theme_Config::ANALYTICS_PIXEL_CODE);
    }

    // --- veřejné metody ---------------------------

    public function isCategoryNews()
    {
        return KT::isIdFormat($this->getCategoryNewsId());
    }

    public function isCategoryNewsPermalink()
    {
        return KT::issetAndNotEmpty($this->getCategoryNewsId());
    }

    public function isCategoryNewsTitle()
    {
        return KT::issetAndNotEmpty($this->getCategoryNewsId());
    }

    public function theSocialLinkedIn()
    {
        $this->theSocialListItem($this->getSocialLinkedIn(), __("LinkedIn", "ZZZ_DOMAIN"), "linkedin");
    }

    public function theSocialTwitter()
    {
        $this->theSocialListItem($this->getSocialTwitter(), __("Twitter", "ZZZ_DOMAIN"), "twitter");
    }

    public function theSocialFacebook()
    {
        $this->theSocialListItem($this->getSocialFacebook(), __("Facebook", "ZZZ_DOMAIN"), "facebook");
    }

    public function isAnalyticsTrackingCode()
    {
        return KT::issetAndNotEmpty($this->getAnalyticsTrackingCode());
    }

    public function isAnalyticsPixelCode()
    {
        return KT::issetAndNotEmpty($this->getAnalyticsPixelCode());
    }

    // --- neveřejné metody ------------------------

    private function theSocialListItem($url, $title, $class)
    {
        if (KT::issetAndNotEmpty($url) && KT::issetAndNotEmpty($title) && KT::issetAndNotEmpty($class)) {
            echo "<li class=\"list-inline-item\"><a href=\"{$url}\" title=\"{$title}\" target=\"_blank\" class=\"{$class}\">{$title}</a></li>";
        }
    }
}
