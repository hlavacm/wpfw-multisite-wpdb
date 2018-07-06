<?php
$pagePresenter = new KT_ZZZ_Page_Presenter($pageModel = new KT_ZZZ_Page_Model($post));
get_header();
?>
    <br>
    <div class="jumbotron">
        <h1 class="display-4"><?php echo $pageModel->getTitle(); ?></h1>
        <?php
        if ($pageModel->hasExcerpt()) {
            echo $pageModel->getExcerpt();
        }
        echo $pageModel->getContent();
        ?>
    </div>
<?php
get_footer();
