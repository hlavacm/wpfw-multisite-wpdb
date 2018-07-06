<?php
$postPresenter = new KT_ZZZ_Post_Presenter($postModel = new KT_ZZZ_Post_Model($post));
get_header();
?>
    <br>
    <div class="jumbotron">
        <h1 class="display-4"><?php echo $postModel->getTitle(); ?></h1>
        <?php
        if ($postModel->hasExcerpt()) {
            echo $postModel->getExcerpt();
        }
        echo $postModel->getContent();
        $postPresenter->renderCategoryTags();
        ?>
        <hr>
        <small class="text-muted">
            <?php echo $postModel->getPublishDate("j.n.Y H:i"); ?> |
            <?php echo $postModel->getAuthor()->getDisplayName(); ?> |
            <?php echo get_bloginfo("name"); ?>
        </small>
    </div>
<?php
get_footer();
