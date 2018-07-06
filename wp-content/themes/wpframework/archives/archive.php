<?php
$postsPresenter = new KT_ZZZ_Posts_Presenter();
get_header();
?>
    <br>
    <div class="jumbotron">
        <h1 class="display-4"><?php post_type_archive_title(); ?></h1>
    </div>
<?php if ($postsPresenter->hasPosts()) { ?>
    <hr>
    <div class="row">
        <div class="col">
            <?php $postsPresenter->renderCategoryButtons(); ?>
        </div>
        <div class="col">
            <?php $postsPresenter->renderSiteButtons(); ?>
        </div>
    </div>
    <hr>
    <div id="posts-container" class="row" data-offset="<?php echo $postsPresenter->getInitialOffset(); ?>">
        <?php $postsPresenter->thePosts(); ?>
    </div>
    <?php if ($postsPresenter->getPostsCount() == $postsPresenter->getMaxCount()) { ?>
        <div class="text-center">
            <span id="load-more-posts" class="btn btn-primary"><?php _e("Load More", "ZZZ_DOMAIN"); ?></span>
        </div>
    <?php } ?>
<?php } else { ?>
    <?php echo $postsPresenter->getNoPostsMessage(); ?>
<?php } ?>
<?php
get_footer();

