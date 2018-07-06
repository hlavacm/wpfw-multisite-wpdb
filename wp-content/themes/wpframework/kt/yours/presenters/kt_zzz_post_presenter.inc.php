<?php

class KT_ZZZ_Post_Presenter extends KT_WP_Post_Base_Presenter
{
    function __construct(KT_ZZZ_Post_Model $model)
    {
        parent::__construct($model);
    }

    // --- getry & setry ------------------------------

    /** @return KT_ZZZ_Post_Model */
    public function getModel()
    {
        return parent::getModel();
    }

    // --- veřejné metody ------------------------------

    public function renderCategoryTags()
    {
        $tags = [];
        $args = ["taxonomy" => KT_WP_CATEGORY_KEY, "hide_empty" => true];
        $categories = wp_get_object_terms($this->getModel()->getPostId(), KT_WP_CATEGORY_KEY, ["taxonomy" => KT_WP_CATEGORY_KEY, "hide_empty => true"]);
        foreach ($categories as $category) {
            $permalink = add_query_arg("category-slugs", $category->slug, get_post_type_archive_link(KT_WP_POST_KEY));
            $tags[] = "<a href=\"$permalink\" class=\"btn btn-outline-primary btn-sm\" title=\"{$category->name}\">{$category->name}</a>";
        }
        echo implode(" ", $tags);
    }
}
