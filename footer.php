<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="wrap">
				<?php
				get_template_part( 'template-parts/footer/footer', 'widgets' );

				if ( has_nav_menu( 'social' ) ) :
				?>
					<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'social',
									'menu_class'     => 'social-links-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
								)
							);
						?>
					</nav><!-- .social-navigation -->
				<?php
				endif;

				get_template_part( 'template-parts/footer/site', 'info' );
				?>
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

<?php if ( is_front_page() ) { ?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/one-page.js"></script>
<?php } ?>
<script type="text/javascript">
	<?php if ( is_front_page() ) { ?>
		<?php if ( is_user_logged_in() ) { ?>
	jQuery( document ).ready(() => {
		jQuery( "nav#site-navigation" )
			.find("a[href='http://bos.scrapironcity.net/login']")
			.parent()
			.hide();
	});
		<?php } ?>
	<?php } ?>
</script>
<style>
	<?php if ( is_front_page() ) { ?>
	a.anchor {
		display: block;
		position: relative;
		top: <?php echo ( is_admin_bar_showing() ? '-96px' : '-72px' ); ?>;
		visibility: hidden;
	}
	<?php } ?>
</style>
</body>
</html>
