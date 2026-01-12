<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * The template for displaying the footer.
 */
$footerBgID = get_field('footer_background_image', 'gpw_settings');
?>

<?php get_template_part( 'gpw-templates/footer/partners-section' ) ?>

<?php get_template_part( 'gpw-templates/footer/consultant-section' ) ?>

</main>

<footer id="footer" class="footer" 
	<?php if ($footerBgID) : ?> style="background-image: url('<?php echo esc_url(wp_get_attachment_url($footerBgID), 'full'); ?>');" <?php endif; ?>
>


	<?php // get_template_part( 'gpw-templates/footer/subscribe-form-block' ) ?>

	<?php get_template_part( 'gpw-templates/footer/main-section' ) ?>

	<?php get_template_part( 'gpw-templates/footer/bottom-section' ) ?>

	<?php
	if (get_theme_mod('back_to_top', 1)) {
		get_template_part('template-parts/footer/back-to-top');
	}
	?>

</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>