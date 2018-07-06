<?php
if (KT_ZZZ::getThemeModel()->isCategoryNews()) {
    $newsPresenter = new KT_ZZZ_News_Presenter();
    ?>
    <section id="news">
        <header>
            <h2><?php echo KT_ZZZ::getThemeModel()->getCategoryNewsTitle(); ?></h2>
        </header>
    </section>
    <div class="row">
        <?php $newsPresenter->thePosts(); ?>
    </div>
    <div class="text-center">
        <a href="<?php echo get_post_type_archive_link(KT_WP_POST_KEY); ?>" class="btn btn-primary"><?php _e("All Posts", "ZZZ_DOMAIN"); ?></a>
    </div>
    <?php
}
