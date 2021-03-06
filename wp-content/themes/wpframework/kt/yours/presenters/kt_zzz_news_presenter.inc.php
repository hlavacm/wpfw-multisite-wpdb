<?php

class KT_ZZZ_News_Presenter extends KT_Presenter_Base
{
    const DEFAULT_COUNT = 3;

    private $posts;
    private $postsCount;

    public function __construct()
    {
        parent::__construct();
    }

    // --- getry & setry ------------------------------

    /** @return array */
    public function getPosts()
    {
        if (isset($this->posts)) {
            return $this->posts;
        }
        $this->initPosts();
        return $this->posts;
    }

    /** @return int */
    public function getPostsCount()
    {
        if (isset($this->postsCount)) {
            return $this->postsCount;
        }
        $this->initPosts();
        return $this->postsCount;
    }

    // --- veřejné metody ------------------------------

    /** @return boolean */
    public function hasPosts()
    {
        return $this->getPostsCount() > 0;
    }

    public function thePosts()
    {
        if ($this->hasPosts()) {
            self::theItemsLoops($this->getPosts(), KT_WP_POST_KEY);
        }
    }

    // --- neveřejné metody ------------------------------

    private function initPosts()
    {
        $args = [
            "post_type" => KT_WP_POST_KEY,
            "post_status" => "publish",
            "posts_per_page" => self::DEFAULT_COUNT,
            "orderby" => "date",
            "order" => KT_Repository::ORDER_DESC,
            "cat" => KT_ZZZ::getThemeModel()->getCategoryNewsId(),
        ];
        $query = new WP_Query();
        $posts = $query->query($args);
        if (KT::arrayIssetAndNotEmpty($posts)) {
            $this->posts = $posts;
            $this->postsCount = count($posts);
        } else {
            $this->posts = [];
            $this->postsCount = 0;
        }
    }
}
