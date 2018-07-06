<?php
if (property_exists($post, "site_id")) {
    switch_to_blog($post->site_id);
}
$postPresenter = new KT_ZZZ_Post_Presenter($postModel = new KT_ZZZ_Post_Model($post));
?>
<div class="col-md-4">
    <div class="card mb-4 box-shadow">
        <?php if ($postModel->hasThumbnail()) { ?>
            <a href="<?php echo $postModel->getPermalink(); ?>" title="<?php echo $postModel->getTitleAttribute(); ?>">
                <?php echo $postPresenter->getThumbnailImage(KT_WP_IMAGE_SIZE_MEDIUM, ["class" => "card-img-top", "alt" => $postModel->getTitleAttribute()], "", false); ?>
            </a>
        <?php } ?>
        <div class="card-body">
            <h3 class="card-title"><a href="<?php echo $postModel->getPermalink(); ?>" title="<?php echo $postModel->getTitleAttribute(); ?>"><?php echo $postModel->getTitle(); ?></a></h3>
            <p class="card-text"><?php echo $postModel->getExcerpt(false, 10); ?></p>
            <?php $postPresenter->renderCategoryTags(); ?>
        </div>
        <div class="card-footer">
            <small class="text-muted">
                <?php echo $postModel->getPublishDate("j.n.Y H:i"); ?> |
                <?php _e("Site:", "ZZZ_DOMAIN"); ?> <?php echo get_bloginfo("name"); ?>
            </small>
        </div>
    </div>
</div>