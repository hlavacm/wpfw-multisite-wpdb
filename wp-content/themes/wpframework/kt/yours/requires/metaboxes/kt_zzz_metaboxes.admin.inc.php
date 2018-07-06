<?php

// --- theme ------------------------

KT_MetaBox::createMultiple(KT_ZZZ_Theme_Config::getAllNormalFieldsets(), KT_WP_Configurator::getThemeSettingSlug(), KT_MetaBox_Data_Type_Enum::OPTIONS);

$themeSideMetaboxes = KT_MetaBox::createMultiple(KT_ZZZ_Theme_Config::getAllSideFieldsets(), KT_WP_Configurator::getThemeSettingSlug(), KT_MetaBox_Data_Type_Enum::OPTIONS, false);
foreach ($themeSideMetaboxes as $themeSideMetabox) {
    $themeSideMetabox->setContext(KT_MetaBox::CONTEXT_SIDE);
    $themeSideMetabox->register();
}

// --- post ------------------------

KT_MetaBox::createMultiple(KT_ZZZ_Post_Config::getAllGenericFieldsets(), KT_WP_POST_KEY, KT_MetaBox_Data_Type_Enum::POST_META);

// --- page ------------------------

KT_MetaBox::createMultiple(KT_ZZZ_Page_Config::getAllGenericFieldsets(), KT_WP_PAGE_KEY, KT_MetaBox_Data_Type_Enum::POST_META);
