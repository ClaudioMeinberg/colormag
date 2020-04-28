<?php
/**
 * Meta boxes base class.
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 2.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta boxes base class.
 *
 * Class ColorMag_Meta_Boxes
 */
class ColorMag_Meta_Boxes {

	/**
	 * Is meta boxes saved once?
	 *
	 * @var boolean
	 */
	private static $saved_meta_boxes = false;

	/**
	 * Constructor.
	 *
	 * ColorMag_Meta_Boxes constructor.
	 */
	public function __construct() {

		// Adding required meta boxes.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		// Enqueue required meta boxes styles and scripts.
		add_action( 'admin_print_styles-post-new.php', array( $this, 'enqueue' ) );
		add_action( 'admin_print_styles-post.php', array( $this, 'enqueue' ) );

		// Save the meta boxes contents.
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 1, 2 );

		// Save page settings meta boxes.
		add_action( 'colormag_process_page_settings_meta', 'ColorMag_Meta_Box_Page_Settings::save', 10, 2 );

	}

	/**
	 * Adding required meta boxes.
	 */
	public function add_meta_boxes() {

		// Global options for page and posts.
		add_meta_box(
			'colormag-page-setting',
			esc_html__( 'Page Settings', 'colormag' ),
			'ColorMag_Meta_Box_Page_Settings::render',
			array(
				'post',
				'page',
			)
		);

	}

	/**
	 * Enqueue required meta boxes styles and scripts.
	 */
	public function enqueue() {

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Enqueue meta boxes CSS file.
		wp_enqueue_style( 'colormag-meta-boxes', COLORMAG_INCLUDES_URL . '/meta-boxes/assets/css/meta-boxes' . $suffix . '.css', array(), COLORMAG_THEME_VERSION );

		// Enqueue meta boxes JS file.
		wp_enqueue_script( 'colormag-meta-boxes', COLORMAG_INCLUDES_URL . '/meta-boxes/assets/js/meta-boxes' . $suffix . '.js', array( 'jquery-ui-tabs' ), COLORMAG_THEME_VERSION, true );

	}

	/**
	 * Save the meta boxes contents.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 *
	 * @return null|mixed
	 */
	public function save_meta_boxes( $post_id, $post ) {

		$post_id = absint( $post_id );

		// $post_id and $post are required.
		if ( empty( $post_id ) || empty( $post ) || self::$saved_meta_boxes ) {
			return;
		}

		// Dont' save meta boxes for revisions or autosaves.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the nonce.
		if ( empty( $_POST['colormag_meta_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['colormag_meta_nonce'] ), 'colormag_save_data' ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		if ( empty( $_POST['post_ID'] ) || absint( $_POST['post_ID'] ) !== $post_id ) {
			return;
		}

		// Check user has permission to edit.
		if ( isset( $_POST['post_type'] ) && ( 'page' === $_POST['post_type'] ) ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		// We need this save event to run once to avoid potential endless loops.
		self::$saved_meta_boxes = true;

		// Trigger action.
		$process_actions = array( 'page_settings' );
		foreach ( $process_actions as $process_action ) {
			do_action( 'colormag_process_' . $process_action . '_meta', $post_id, $post );
		}

	}

}

return new ColorMag_Meta_Boxes();
