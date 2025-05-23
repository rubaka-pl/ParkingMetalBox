<footer class="footer">
    <div class="footer-container">
        <div class="footer-left">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/logo.svg" alt="logo.svg">
            </a>
        </div>
        <nav class="footer-nav">

            <li><a href="<?php echo home_url('/about-us'); ?>">O nas</a></li>
            <li><a href="<?php echo home_url('/contacts'); ?>">Kontakt</a></li>
            <li><a href="<?php echo home_url('/wp-content/uploads/2025/05/REGULAMIN.pdf'); ?>" target="_blank" class="regulamin-link yellow-text">regulamin</a></li>
        </nav>
        <div class="footer-social">
            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/facebook-icon.svg" alt="Facebook"></a>
            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/instagram-icon.svg" alt="Instagram"></a>
            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/linkedIn-icon.svg" alt="LinkedIn"></a>
        </div>
    </div>
    <div class="footer-bottom">
        <hr>
        <p class="footer-rights">© 2017-<?php echo date('Y'); ?> Metal Box. Wszelkie prawa zastrzeżone. <a href="<?php echo home_url('/wp-content/uploads/2025/05/REGULAMIN.pdf'); ?>"
                target="_blank"
                class="regulamin-link yellow-text"
                onclick="event.stopPropagation()">
                Regulamin
            </a></p>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js"></script>


</html>