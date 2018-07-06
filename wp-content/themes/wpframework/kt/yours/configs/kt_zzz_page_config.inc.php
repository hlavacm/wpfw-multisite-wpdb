<?php

class KT_ZZZ_Page_Config implements KT_Configable
{
    const FORM_PREFIX = "kt-zzz-page";

    // --- fieldsety ---------------------------

    public static function getAllGenericFieldsets()
    {
        return self::getAllNormalFieldsets() + self::getAllSideFieldsets();
    }

    public static function getAllNormalFieldsets()
    {
        return [];
    }

    public static function getAllSideFieldsets()
    {
        return [];
    }
}
