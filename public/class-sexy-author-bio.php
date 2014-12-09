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

		add_action('wp_head', array( $this, 'hook_css' ) );
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
			'author_name_font_size' => 32,
			'author_name_font' => '',
			'author_name_capitalization' => 'uppercase',
			'author_name_decoration' => 'none',
			'separator' => 'at',
			'background_color' => '#333333',
			'highlight_color' => '#0088cc',
			'text_color' => '#ffffff',
			'title_color' => '#777777',
			'border_top_size' => 20,
			'border_right_size' => 0,
			'border_bottom_size' => 20,
			'border_left_size' => 0,
			'border_style' => 'solid',
			'border_color' => '#444444',
			'pick_icon_set' => 'flat-square',
			'icon_size' => 64,
			'icon_spacing' => 2
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
			'behance'    => get_the_author_meta( 'behance' ),
			'blogger'    => get_the_author_meta( 'blogger' ),
			'delicious'    => get_the_author_meta( 'delicious' ),
			'deviantart'    => get_the_author_meta( 'deviantart' ),
			'dribbble'    => get_the_author_meta( 'dribbble' ),
			'facebook'    => get_the_author_meta( 'facebook' ),
			'flickr'    => get_the_author_meta( 'flickr' ),
			'github'    => get_the_author_meta( 'github' ),
			'google'    => get_the_author_meta( 'google' ),
			'instagram'    => get_the_author_meta( 'instagram' ),
			'linkedin'    => get_the_author_meta( 'linkedin' ),
			'myspace'    => get_the_author_meta( 'myspace' ),
			'pinterest'    => get_the_author_meta( 'pinterest' ),
			'rss'    => get_the_author_meta( 'rss' ),
			'stumbleupon'    => get_the_author_meta( 'stumbleupon' ),
			'tumblr'    => get_the_author_meta( 'tumblr' ),
			'twitter'    => get_the_author_meta( 'twitter' ),
			'vimeo'    => get_the_author_meta( 'vimeo' ),
			'wordpress'    => get_the_author_meta( 'wordpress' ),
			'yahoo'    => get_the_author_meta( 'yahoo' ),
			'youtube'    => get_the_author_meta( 'youtube' )
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

		$html = '<div id="sexy-author-bio" class="';
		$html .= preg_replace("/[\s_]/", "-", strtolower(get_the_author()));
		$html .= '">';

		$iconset = $settings['pick_icon_set'];

		if ( get_the_author_meta('job-title') && get_the_author_meta('company') && get_the_author_meta('company-website-url') ) {
			$titleline = '<div id="sab-title-company"><span id="sab-jobtitle">' . get_the_author_meta('job-title') . '</span><span id="sab-separator"> ' . $settings['separator'] . ' </span><span id="sab-company"><a href="' . get_the_author_meta('company-website-url') . '" target="' . $settings['link_target'] . '" style="color:' . $settings['highlight_color'] . ';">' . get_the_author_meta('company') . '</a></span></div>';
		}

		$html .= '<div id="sab-social-wrapper">';

		foreach ( array_reverse($social) as $network => $url ) {
			if ( $url ){
				$html .= '<a id="sab-'.$network.'" href="' . $url . '" target="' . $settings['link_target'] . '"><img id="sig-'.$network.'" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/'.$iconset.'/'.$network.'.png"></a>';
			}
		}

		$html .= '</div><div id="sab-author"><a rel="author" href="' . $author_name_link . '" title="' . esc_attr( __( '', self::get_plugin_slug() ) . '' . get_the_author() ) .'" target="' . $settings['link_target'] . '">' . get_the_author() . '</a></div><div id="sab-gravatar"><a href="' . $author_avatar_link . '" target="' . $settings['link_target'] . '">';
		if( !get_the_author_meta('avatar-url') ){
			$html .= get_avatar( get_the_author_meta('ID'), $gravatar );
		}else{
			$html .= '<img src="'.get_the_author_meta('avatar-url').'" />';
		}
		$html .= '</a></div>'.$titleline.'<div id="sab-description">' . apply_filters( 'sexyauthorbio_author_description', get_the_author_meta( 'description' ) ) . '</div>';
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

	public function hook_css() {
		// Get the settings.
		$settings = get_option( 'sexyauthorbio_settings' );

			// Set the styes.
			$styles = sprintf(
				'background: %1$s; border-style: %2$s; border-color: %3$s; color: %4$s; border-top-width: %5$spx; border-right-width: %6$spx; border-bottom-width: %7$spx; border-left-width: %8$spx;',
				$settings['background_color'],
				$settings['border_style'],
				$settings['border_color'],
				$settings['text_color'],
				$settings['border_top_size'],
				$settings['border_right_size'],
				$settings['border_bottom_size'],
				$settings['border_left_size']
			);

			$customcss = $settings['custom_css_default'];
			$customcssdesktop = $settings['custom_css_desktop'];
			$customcssipadlandscape = $settings['custom_css_ipad_landscape'];
			$customcssipadportrait = $settings['custom_css_ipad_portrait'];
			$customcsssmartphones = $settings['custom_css_smartphones'];
			if($settings['author_name_font']){
				$authorfont = 'font-family:'.$settings['author_name_font'].';';
			}
			$output = '<style id="sexy-author-bio-css" type="text/css" media="screen">
					  #sexy-author-bio { ' . $styles . $hidden . ' }
					  #sab-author { ' . $authorfont . ' font-size: ' . $settings['author_name_font_size'] . 'px; line-height: ' . $settings['author_name_font_size'] . 'px; }
					  #sab-gravatar { width: ' . $settings['gravatar'] . 'px; margin: 0 10px 0 0; }
					  #sab-gravatar a { color: ' . $settings['highlight_color'] . '; }
					  #sab-author a { margin-right:10px; text-decoration:' . $settings['author_name_decoration'] . '; text-transform:' . $settings['author_name_capitalization'] . '; color: ' . $settings['highlight_color'] . '; }
					  #sig-twitter, #sig-google, #sig-facebook, #sig-linkedin { margin-bottom: 10px; }
					  [id^=sig-] { height:' . $settings['icon_size'] . 'px; width:' . $settings['icon_size'] . 'px; margin-left:' . $settings['icon_spacing'] . 'px; }
					  #sab-title-company { color:' . $settings['title_color'] . '; }
					  '.$customcss.'
					  @media (min-width: 1200px) {
					  '.$customcssdesktop.'
					  }
					  @media (min-width: 1019px) and (max-width: 1199px) {
					  '.$customcssipadlandscape.'
					  }
					  @media (min-width: 768px) and (max-width: 1018px) {
					  '.$customcssipadportrait.'
					  }
					  @media (max-width: 767px) {
					  [id^=sig-] { margin-left: 0; margin-right:' . $settings['icon_spacing'] . 'px; }
					  '.$customcsssmartphones.'
					  }
					  </style>';

	echo $output;

	}

}
