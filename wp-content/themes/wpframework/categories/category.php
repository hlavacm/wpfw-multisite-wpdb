<?php
wp_redirect(add_query_arg("category-slugs", get_queried_object()->slug, get_post_type_archive_link(KT_WP_POST_KEY)));
exit;
