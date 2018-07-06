<?php get_header(); ?>
    <br>
    <div class="jumbotron">
        <h1 class="display-4"><?php _e("Search Results", "ZZZ_DOMAIN"); ?></h1>
        <h2 class="display-4"><?php _e("for:", "ZZZ_DOMAIN"); ?> <?php echo KT::stringEscape(get_search_query(false)); ?></h2>
    </div>
<?php if (have_posts()) { ?>
    <?php
    global $wp_query;
    KT_Presenter_Base::theQueryLoops($wp_query, "search");
    ?>
    <?php
} else {
    ?>
    <div class="row">
        <p><?php _e("There are no results ...", "ZZZ_DOMAIN"); ?></p>
    </div>
    <?php
}
?>
<?php
get_footer();
