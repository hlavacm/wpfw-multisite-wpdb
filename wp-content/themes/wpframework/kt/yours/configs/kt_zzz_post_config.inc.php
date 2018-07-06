<?php

class KT_ZZZ_Post_Config implements KT_Configable
{
    const FORM_PREFIX = "kt-zzz-post";

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
