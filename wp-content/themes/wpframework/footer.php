</main>
<footer class="text-muted">
    <div class="container">
        <hr>
        <p class="float-right">
            <a href="#top"><?php _e("TOP", "ZZZ_DOMAIN"); ?></a>
        </p>
        <p>Copyright &copy; <?php echo date("Y"); ?> <a href="http://hlavacm.net/" target="_blank"><b>Martin Hlaváč</b></a></p>
        <ul class="list-inline text-center">
            <?php
            KT_ZZZ::getThemeModel()->theSocialLinkedIn();
            KT_ZZZ::getThemeModel()->theSocialTwitter();
            KT_ZZZ::getThemeModel()->theSocialFacebook();
            ?>
        </ul>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>