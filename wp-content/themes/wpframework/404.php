<?php get_header(); ?>
    <br>
    <div class="jumbotron">
        <h1 class="display-4"><?php _e("Error - 404", "ZZZ_DOMAIN"); ?></h1>
        <p><?php _e("We're sorry, but the requested web address does not exist. It was either deleted or moved to a different address.", "ZZZ_DOMAIN"); ?></p>
        <hr class="my-4">
        <p><?php _e("Did not find what you were looking for? Continue to the home page.", "ZZZ_DOMAIN"); ?></p>
        <a href="<?php echo get_home_url(); ?>" title="<?php _e("Home", "ZZZ_DOMAIN"); ?>" class="btn btn-primary btn-lg"><?php _e("Home", "ZZZ_DOMAIN"); ?></a>
    </div>
<?php
get_footer();
