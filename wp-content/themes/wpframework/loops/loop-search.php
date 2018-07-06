<?php $postPresenter = new KT_ZZZ_Post_Presenter($postModel = new KT_ZZZ_Post_Model($post)); ?>
<div class="card">
    <div class="card-body">
        <h3 class="card-title"><a href="<?php echo $postModel->getPermalink(); ?>" title="<?php echo $postModel->getTitleAttribute(); ?>"><?php echo $postModel->getTitle(); ?></a></h3>
        <p class="card-text"><?php echo $postModel->getExcerpt(false, 10); ?></p>
        <a <a href="<?php echo $postModel->getPermalink(); ?>" title="<?php echo $postModel->getTitleAttribute(); ?>" class="btn btn-primary"><?php _e("Detail", "ZZZ_DOMAIN"); ?></a>
    </div>
</div>
<br>