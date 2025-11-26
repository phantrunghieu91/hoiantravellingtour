<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * The template for displaying the footer.
 */
?>

</main>

<footer id="footer" class="footer">

	<?php get_template_part( 'gpw-templates/footer/partners-section' ) ?>

	<?php get_template_part( 'gpw-templates/footer/subscribe-form-block' ) ?>

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