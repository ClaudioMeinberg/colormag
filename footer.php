<?php
/**
 * Theme Footer Section for our theme.
 *
 * Displays all of the footer section and closing of the #main div.
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Functions hooked into colormag_action_after_inner_content action.
 *
 * @hooked colormag_main_section_inner_end - 10
 */
do_action( 'colormag_action_after_inner_content' );


/**
 * Functions hooked into colormag_action_after_content action.
 *
 * @hooked colormag_main_section_end - 10
 * @hooked colormag_advertisement_above_footer_sidebar - 15
 */
do_action( 'colormag_action_after_content' );


/**
 * Hook: colormag_before_footer.
 */
do_action( 'colormag_before_footer' );


/**
 * Functions hooked into colormag_action_before_footer action.
 *
 * @hooked colormag_footer_start - 10
 * @hooked colormag_footer_sidebar - 15
 */
do_action( 'colormag_action_before_footer' );


/**
 * Functions hooked into colormag_action_before_inner_footer action.
 *
 * @hooked colormag_footer_socket_inner_wrapper_start - 10
 */
do_action( 'colormag_action_before_inner_footer' );


/**
 * Functions hooked into colormag_action_footer action.
 *
 * @hooked colormag_footer_socket_area_start - 10
 * @hooked colormag_footer_socket_area_end - 25
 */
do_action( 'colormag_action_footer' );


/**
 * Functions hooked into colormag_action_after_inner_footer action.
 *
 * @hooked colormag_footer_socket_inner_wrapper_end - 10
 */
do_action( 'colormag_action_after_inner_footer' );


/**
 * Functions hooked into colormag_action_after_footer action.
 *
 * @hooked colormag_footer_end - 10
 */
do_action( 'colormag_action_after_footer' );
?>




				<div class="footer-socket-right-section">
					<?php
					if ( ( get_theme_mod( 'colormag_social_link_activate', 0 ) == 1 ) && ( ( get_theme_mod( 'colormag_social_link_location_option', 'both' ) == 'both' ) || ( get_theme_mod( 'colormag_social_link_location_option', 'both' ) == 'footer' ) ) ) {
						colormag_social_links();
					}
					?>
				</div>

				<div class="footer-socket-left-section">
					<?php do_action( 'colormag_footer_copyright' ); ?>
				</div>



<a href="#masthead" id="scroll-up"><i class="fa fa-chevron-up"></i></a>

<?php
/**
 * Functions hooked into colormag_action_after action.
 *
 * @hooked colormag_page_end - 10
 */
do_action( 'colormag_action_after' );

wp_footer();
?>

</body>
</html>
