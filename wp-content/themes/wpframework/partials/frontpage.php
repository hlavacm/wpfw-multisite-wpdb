<?php
if (KT::issetAndNotEmpty($post)) {
    $frontPagePresenter = new KT_WP_Post_Base_Presenter($post);
    $frontPageModel = $frontPagePresenter->getModel();
    ?>
    <br>
    <div class="jumbotron">
        <h1 class="display-4"><?php echo $frontPageModel->getTitle(); ?></h1>
        <?php
        if ($frontPageModel->hasExcerpt()) {
            echo $frontPageModel->getExcerpt();
        }
        echo $frontPageModel->getContent();
        ?>
    </div>
    <?php
}