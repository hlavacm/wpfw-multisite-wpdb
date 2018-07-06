<?php

class KT_ZZZ_Theme_Config implements KT_Configable
{
    const FORM_PREFIX = "kt-zzz-theme";

    // --- fieldsety ---------------------------

    public static function getAllGenericFieldsets()
    {
        return self::getAllNormalFieldsets() + self::getAllSideFieldsets();
    }

    public static function getAllNormalFieldsets()
    {
        return [
            self::CATEGORY_FIELDSET => self::getCategoryFieldset(),
            self::SOCIAL_FIELDSET => self::getSocialFieldset(),
        ];
    }

    public static function getAllSideFieldsets()
    {
        return [
            self::ANALYTICS_FIELDSET => self::getAnalyticsFieldset(),
        ];
    }

    // --- KATEGORIE ------------------------

    const CATEGORY_FIELDSET = "kt-zzz-theme-category";
    const CATEGORY_NEWS_ID = "kt-zzz-theme-category-news-id";

    public static function getCategoryFieldset()
    {
        $fieldset = new KT_Form_Fieldset(self::CATEGORY_FIELDSET, __("Categories", "ZZZ_ADMIN_DOMAIN"));
        $fieldset->setPostPrefix(self::CATEGORY_FIELDSET);

        $fieldset->addWpCategory(self::CATEGORY_NEWS_ID, __("News:", "ZZZ_ADMIN_DOMAIN"));

        return $fieldset;
    }


    // --- SOCIÁLNÍ SÍTĚ ------------------------

    const SOCIAL_FIELDSET = "kt-zzz-theme-social";
    const SOCIAL_LINKEDIN = "kt-zzz-theme-social-linkedin";
    const SOCIAL_TWITTER = "kt-zzz-theme-social-twitter";
    const SOCIAL_FACEBOOK = "kt-zzz-theme-social-facebook";

    public static function getSocialFieldset()
    {
        $fieldset = new KT_Form_Fieldset(self::SOCIAL_FIELDSET, __("Social Networks", "ZZZ_ADMIN_DOMAIN"));
        $fieldset->setPostPrefix(self::SOCIAL_FIELDSET);

        $fieldset->addText(self::SOCIAL_LINKEDIN, __("LinkedIn", "ZZZ_ADMIN_DOMAIN"))
            ->setInputType(KT_Text_Field::INPUT_URL);
        $fieldset->addText(self::SOCIAL_TWITTER, __("Twitter", "ZZZ_ADMIN_DOMAIN"))
            ->setInputType(KT_Text_Field::INPUT_URL);
        $fieldset->addText(self::SOCIAL_FACEBOOK, __("Facebook:", "ZZZ_ADMIN_DOMAIN"))
            ->setInputType(KT_Text_Field::INPUT_URL);

        return $fieldset;
    }

    // --- ANALYTIKA ------------------------

    const ANALYTICS_FIELDSET = "kt-zzz-theme-analytics";
    const ANALYTICS_TRACKING_CODE = "kt-zzz-theme-analytics-tracking-code";
    const ANALYTICS_PIXEL_CODE = "kt-zzz-theme-analytics-pixel-code";

    public static function getAnalyticsFieldset()
    {
        $fieldset = new KT_Form_Fieldset(self::ANALYTICS_FIELDSET, __("Analytics", "ZZZ_ADMIN_DOMAIN"));
        $fieldset->setPostPrefix(self::ANALYTICS_FIELDSET);

        $fieldset->addTextarea(self::ANALYTICS_TRACKING_CODE, __("Measure code:", "ZZZ_ADMIN_DOMAIN"))
            ->setToolTip(__("Google Tag Manager or Analytics tracking code", "ZZZ_ADMIN_DOMAIN"))
            ->setFilterSanitize(FILTER_DEFAULT);

        $fieldset->addTextarea(self::ANALYTICS_PIXEL_CODE, __("Pixel code:", "ZZZ_ADMIN_DOMAIN"))
            ->setToolTip(__("Measuring (Facebook) Pixel code into header", "ZZZ_ADMIN_DOMAIN"))
            ->setFilterSanitize(FILTER_DEFAULT);

        return $fieldset;
    }
}
