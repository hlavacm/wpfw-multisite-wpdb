<?php

class KT_ZZZ_Post_Model extends KT_WP_Post_Base_Model
{
    function __construct(WP_Post $post)
    {
        parent::__construct($post, KT_ZZZ_Post_Config::FORM_PREFIX);
    }
}
