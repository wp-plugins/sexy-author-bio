<?php
/**
 * Sexy Author Bio
 *
 * @package   Sexy_Author_Bio
 * @author    Andy Forsberg <andyforsberg@gmail.com>
 * @license   GPL-2.0+
 * @copyright 2014 Penguin Initiatives
 */

/**
 * Sexy_Author_Bio class.
 *
 * @package Sexy_Author_Bio
 * @author  Andy Forsberg <andyforsberg@gmail.com>
 */
class Sexy_Author_Bio {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 1.0.0
	 *
	 * @var   string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since 1.0.0
	 *
	 * @var   string
	 */
	protected static $plugin_slug = 'sexy-author-bio';

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @var   object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Display the box.
		add_filter( 'the_content', array( $this, 'display' ), 9999 );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since  1.0.0
	 *
	 * @return Plugin slug variable.
	 */
	public static function get_plugin_slug() {
		return self::$plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since  1.0.0
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since  1.0.0
	 *
	 * @param  boolean $network_wide True if WPMU superadmin uses
	 *                               "Network Activate" action, false if
	 *                               WPMU is disabled or plugin is
	 *                               activated on an individual blog.
	 *
	 * @return void
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since  1.0.0
	 *
	 * @param  boolean $network_wide True if WPMU superadmin uses
	 *                               "Network Deactivate" action, false if
	 *                               WPMU is disabled or plugin is
	 *                               deactivated on an individual blog.
	 *
	 * @return void
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since  1.0.0
	 *
	 * @param  int  $blog_id ID of the new blog.
	 *
	 * @return void
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since  1.0.0
	 *
	 * @return array|false The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	private static function single_activate() {
		$options = array(
			'display' => 'posts',
			'gravatar' => 100,
			'author_name_font_size' => 62,
			'author_name_font' => '',
			'author_name_capitalization' => 'uppercase',
			'author_name_decoration' => 'none',
			'background_color' => '#333333',
			'highlight_color' => '#0088cc',
			'text_color' => '#ffffff',
			'title_color' => '#777777',
			'border_size' => 20,
			'border_style' => 'solid',
			'border_color' => '#444444',
			'pick_icon_set' => 'squares'
		);

		update_option( 'sexyauthorbio_settings', $options );
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	private static function single_deactivate() {
		delete_option( 'sexyauthorbio_settings' );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$domain = self::get_plugin_slug();
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

        load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
        load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		wp_register_style( self::get_plugin_slug() . '-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION, 'all' );
		/*wp_register_style( 'GoogleFonts', 'http://fonts.googleapis.com/css?family=Oswald:400,300,700'); 
    	wp_enqueue_style( 'GoogleFonts' ); */
	}

	/**
	 * Checks if can display the box.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $settings Sexy Author Bio settings.
	 *
	 * @return bool
	 */
	protected function is_display( $settings ) {
		switch( $settings['display'] ) {
			case 'posts':
				return is_single() && 'post' == get_post_type();
				break;
			case 'home_posts':
				return is_single() && 'post' == get_post_type() || is_home();
				break;

			default:
				return false;
				break;
		}
	}

	/**
	 * HTML of the box.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $settings Sexy Author Bio settings.
	 *
	 * @return string          Sexy Author Bio HTML.
	 */
	public static function view( $settings ) {

		// Load the styles.
		wp_enqueue_style( self::get_plugin_slug() . '-styles' );

		// Set the gravatar size.
		$gravatar = ! empty( $settings['gravatar'] ) ? $settings['gravatar'] : 70;

		// Set the social icons
		$social = array(
			'twitter'    => get_the_author_meta( 'twitter' ),
			'googleplus' => get_the_author_meta( 'googleplus' ),
			'facebook' => get_the_author_meta( 'facebook' ),
			'linkedin' => get_the_author_meta( 'linkedin' )
		);

		// Set the styes.
		$styles = sprintf(
			'background: %1$s; border-top: %2$spx %3$s %4$s; border-bottom: %2$spx %3$s %4$s; color: %5$s',
			$settings['background_color'],
			$settings['border_size'],
			$settings['border_style'],
			$settings['border_color'],
			$settings['text_color']
		);

		$author = get_query_var('author');

		if ( $settings['author_links'] == "link_to_author_page" ){ 
			$author_name_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
			$author_avatar_link = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
		}else{
			$author_name_link = get_the_author_meta('name-link');
			$author_avatar_link = get_the_author_meta('avatar-link');
		}

		if ( get_the_author_meta('hide-signature') ) { $hidden = ";display:none!important;"; }else{ $hidden = ""; }

		$html = '<div id="sexy-author-bio" style="' . $styles . $hidden . '">';

		if ( $settings['pick_icon_set'] == "circles" ){ $iconset = "2"; }else{ $iconset = ""; }

		if ( $social['twitter'] ){
			$twitter = '<a href="' . $social['twitter'] . '" target="' . $settings['link_target'] . '"><img id="sig-twitter" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/twitter'.$iconset.'.png"></a>';
		}

		if ( $social['googleplus'] ){
			$googleplus = '<a href="' . $social['googleplus'] . '" target="' . $settings['link_target'] . '"><img id="sig-google" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/google-plus'.$iconset.'.png"></a>';
		}

		if ( $social['facebook'] ){
			$facebook = '<a href="' . $social['facebook'] . '" target="' . $settings['link_target'] . '"><img id="sig-facebook" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/facebook'.$iconset.'.png"></a>';
		}

		if ( $social['linkedin'] ){
			$linkedin = '<a href="' . $social['linkedin'] . '" target="' . $settings['link_target'] . '"><img id="sig-linkedin" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/linkedin'.$iconset.'.png"></a>';
		}

		if ( get_the_author_meta('job-title') && get_the_author_meta('company') && get_the_author_meta('company-website-url') ) {
			$titleline = '<h4 style="color:' . $settings['title_color'] . ';">' . get_the_author_meta('job-title') . ' at <a href="' . get_the_author_meta('company-website-url') . '" target="' . $settings['link_target'] . '" style="color:' . $settings['highlight_color'] . ';">' . get_the_author_meta('company') . '</a></h4>';
		}

		$html .= '<div>'.$linkedin.''.$facebook.''.$twitter.''.$googleplus.'</div><h3 style="font-family:' . $settings['author_name_font'] . '!important;font-size: ' . $settings['author_name_font_size'] . 'px!important;"><a rel="author" style="text-decoration:' . $settings['author_name_decoration'] . '!important;text-transform:' . $settings['author_name_capitalization'] . '!important;color: ' . $settings['highlight_color'] . ';" href="' . $author_name_link . '" title="' . esc_attr( __( '', self::get_plugin_slug() ) . '' . get_the_author() ) .'" target="' . $settings['link_target'] . '">' . get_the_author() . '</a></h3><a style="color: ' . $settings['highlight_color'] . ';" href="' . $author_avatar_link . '" target="' . $settings['link_target'] . '"><div class="bio-gravatar">' . get_avatar( get_the_author_meta('ID'), $gravatar ) . '</div></a>'.$titleline.'<p class="bio-description">' . apply_filters( 'sexyauthorbio_author_description', get_the_author_meta( 'description' ) ) . '</p>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Insert the box in the content.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $content WP the content.
	 *
	 * @return string          WP the content with Sexy Author Bio.
	 */
	public function display( $content ) {
		// Get the settings.
		$settings = get_option( 'sexyauthorbio_settings' );

		if ( $this->is_display( $settings ) ) {
			return $content . self::view( $settings );
		}

		return $content;
	}

}
