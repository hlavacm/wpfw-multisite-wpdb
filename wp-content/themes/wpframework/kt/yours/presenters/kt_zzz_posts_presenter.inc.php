<?php

class KT_ZZZ_Posts_Presenter extends KT_Presenter_Base
{
    const DEFAULT_COUNT = 3;

    private $posts;
    private $postsCount;
    private $offset;
    private $categorySlugs;
    private $siteIds;

    public function __construct($withInitParams = true)
    {
        parent::__construct();
        if ($withInitParams) {
            $this->initParams();
        }
    }

    // --- getry & setry ------------------------------

    /** @return array */
    public function getPosts()
    {
        if (KT::issetAndNotEmpty($this->posts)) {
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

    /** @return int */
    public function getMaxCount()
    {
        return self::DEFAULT_COUNT;
    }

    /** @return int */
    public function getOffset()
    {
        return $this->offset;
    }

    /** @return int */
    public function getInitialOffset()
    {
        return $this->getOffset() ?: self::DEFAULT_COUNT;
    }

    private function setOffset($value)
    {
        $this->offset = KT::tryGetInt($value);
        return $this;
    }

    /** @return int */
    public function getCategorySlugs()
    {
        return $this->categorySlugs;
    }

    private function setCategorySlugs(array $values = null)
    {
        $categorySlugs = [];
        if (KT::arrayIssetAndNotEmpty($values)) {
            foreach (array_unique($values) as $value) {
                $categorySlugs[] = sanitize_title($value);
            }
        }
        $this->categorySlugs = $categorySlugs;
        return $this;
    }

    /** @return int */
    public function getSiteIds()
    {
        return $this->siteIds;
    }

    private function setSiteIds(array $values = null)
    {
        $this->siteIds = array_filter(array_unique($values), function ($value) {
            return KT::isIdFormat($value);
        });
        return $this;
    }

    // --- veřejné metody ------------------------------

    /** @return boolean */
    public function hasPosts()
    {
        return $this->getPostsCount() > 0;
    }

    /** @return boolean */
    public function isOffset()
    {
        return KT::isIdFormat($this->getOffset());
    }

    /** @return boolean */
    public function hasCategorySlugs()
    {
        return KT::arrayIssetAndNotEmpty($this->getCategorySlugs());
    }

    /** @return boolean */
    public function hasSiteIds()
    {
        return KT::arrayIssetAndNotEmpty($this->getSiteIds());
    }

    public function thePosts($loopName = KT_WP_POST_KEY)
    {
        global $post;
        if ($this->hasPosts()) {
            $currentSiteId = get_current_blog_id();
            foreach ($this->getPosts() as $item) {
                $post = $item;
                include(locate_template("loops/loop-$loopName.php"));
            }
            switch_to_blog($currentSiteId);
            $post = KT_ZZZ::getPostsPageModel(); // reset "state helper"
            wp_reset_postdata();
        }
    }

    public function getPostsOutput()
    {
        if ($this->hasPosts()) {
            ob_start();
            $this->thePosts();
            $output = ob_get_clean();
            return $output;
        } elseif ($this->getOffset() >= $this->getMaxCount()) {
            return false;
        } else {
            return $this->getNoPostsMessage();
        }
    }

    public function getNoPostsMessage()
    {
        return "<div class=\"alert alert-primary text-center\">" . __("There are no posts ...", "ZZZ_DOMAIN") . "</div>";
    }

    public function renderCategoryButtons()
    {
        $currentSiteId = get_current_blog_id();

        $categories = [];
        $categoriesSlugs = [];
        foreach (array_keys(KT_ZZZ::getSiteOptions()) as $siteId) {
            switch_to_blog($siteId);
            $siteCategories = get_categories(["hide_empty" => true]);
            $categories[$siteId] = array_filter($siteCategories, function (WP_Term $category) use (&$categoriesSlugs) {
                if (in_array($category->slug, $categoriesSlugs)) {
                    return false;
                }
                $categoriesSlugs[] = $category->slug;
                return true;
            });
        }
        switch_to_blog($currentSiteId);

        if (KT::arrayIssetAndNotEmpty($categories)) {
            $label = __("Categories:", "ZZZ_DOMAIN");
            echo "<div id=\"category-filters\"><label>$label</label> ";
            foreach ($categories as $siteId => $siteCategories) {
                switch_to_blog($siteId);
                foreach ($siteCategories as $category) {
                    $class = ($this->hasCategorySlugs() && in_array($category->slug, $this->getCategorySlugs())) ? "btn-primary" : "btn-outline-primary";
                    echo "<button class=\"btn $class\" data-slug=\"{$category->slug}\">{$category->name}</button> ";
                }
            }
            switch_to_blog($currentSiteId);
            echo "</div>";
        }
    }

    public function renderSiteButtons()
    {
        $sites = KT_ZZZ::getSiteOptions();
        if (KT::arrayIssetAndNotEmpty($sites)) {
            $label = __("Sites:", "ZZZ_DOMAIN");
            echo "<div id=\"site-filters\"><label>$label</label> ";
            foreach ($sites as $siteId => $siteName) {
                $class = ($this->hasSiteIds() && in_array($siteId, $this->getSiteIds())) ? "btn-primary" : "btn-outline-primary";
                echo "<button class=\"btn $class\" data-id=\"{$siteId}\">{$siteName}</button> ";
            }
            echo "</div>";
        }
    }

    // --- neveřejné metody ------------------------------

    private function initParams()
    {
        $this->setOffset(KT::arrayTryGetValue($_REQUEST, "kt_offset"));
        $this->setCategorySlugs($this->tryGetUrlParamValues("category-slugs", "kt_category_slugs"));
        $this->setSiteIds($this->tryGetUrlParamValues("site-ids", "kt_site_ids"));
    }

    private function tryGetUrlParamValues($getKey, $requestKey)
    {
        $value = $this->tryGetUrlParamValue($getKey, $requestKey);
        if (KT::arrayIssetAndNotEmpty($value)) {
            return $value;
        } elseif (KT::issetAndNotEmpty($value)) {
            return explode(",", $value);
        }
        return [];
    }

    private function tryGetUrlParamValue($getKey, $requestKey)
    {
        $getValue = KT::arrayTryGetValue($_GET, $getKey);
        if (KT::issetAndNotEmpty($getValue)) {
            return $getValue;
        }
        $requestValue = KT::arrayTryGetValue($_REQUEST, $requestKey);
        if (KT::issetAndNotEmpty($requestValue)) {
            return $requestValue;
        }
        return null;
    }

    private function initPosts()
    {
        /** @var WPDB $wpdb ; */
        global $wpdb;
        $params = [];
        $currentSiteId = get_current_blog_id();
        // build SQL query
        $sqls = [];
        foreach ($this->tryGetCurrentSiteIds() as $siteId) {
            switch_to_blog($siteId);
            $sqls[] = $this->initPostsSiteQuery($params, $siteId);
        }
        switch_to_blog($currentSiteId);
        $sql = implode(" UNION ALL ", $sqls);
        // order
        $sql .= " ORDER BY post_date DESC";
        // limit
        $sql .= " LIMIT {$this->getMaxCount()}";
        // offset
        if ($this->isOffset()) {
            $sql .= " OFFSET {$this->getOffset()}";
        }
        $sql .= ";";
        if (count($params) > 0) {
            $postIds = $wpdb->get_results($wpdb->prepare($sql, $params));
        } else {
            $postIds = $wpdb->get_results($sql);
        }
        if (KT::arrayIssetAndNotEmpty($postIds)) {
            $posts = [];
            foreach ($postIds as $postData) {
                $postId = $postData->post_id;
                $siteId = $postData->site_id;
                switch_to_blog($siteId);
                $post = get_post($postId);
                if (KT::issetAndNotEmpty($post)) {
                    $posts[] = $post;
                    $post->site_id = $siteId;
                }
            }
            switch_to_blog($currentSiteId);
            $this->posts = $posts;
            $this->postsCount = count($posts);
        } else {
            $this->posts = [];
            $this->postsCount = 0;
        }
    }

    private function initPostsSiteQuery(array &$params, $id)
    {
        /** @var WPDB $wpdb */
        global $wpdb;
        // select
        $sql = "(SELECT p{$id}.ID AS post_id, $id AS site_id, p{$id}.post_date FROM {$wpdb->posts} AS p{$id}";
        // category
        if ($this->hasCategorySlugs()) {
            $topicKey = KT_WP_CATEGORY_KEY;
            $placeholders = implode(",", array_fill(0, count($this->getCategorySlugs()), "%s"));
            $sql .= " INNER JOIN {$wpdb->term_relationships} AS trt{$id} ON p{$id}.ID = trt{$id}.object_id INNER JOIN {$wpdb->term_taxonomy} AS ttt{$id} ON trt{$id}.term_taxonomy_id = ttt{$id}.term_taxonomy_id AND ttt{$id}.taxonomy = '$topicKey' INNER JOIN {$wpdb->terms} AS tt{$id} ON ttt{$id}.term_id = tt{$id}.term_id AND tt{$id}.slug IN ($placeholders)";
            $params = array_merge($params, $this->getCategorySlugs());
        }
        // where
        $postKey = KT_WP_POST_KEY;
        $sql .= " WHERE p{$id}.post_status = 'publish' AND p{$id}.post_type = '$postKey'";
        $sql .= ")";
        return $sql;
    }

    private function tryGetCurrentSiteIds()
    {
        if ($this->hasSiteIds()) {
            return $this->getSiteIds();
        }
        return array_keys(KT_ZZZ::getSiteOptions());
    }
}
