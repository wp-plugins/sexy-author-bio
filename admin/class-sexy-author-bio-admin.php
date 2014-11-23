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
 * Sexy_Author_Bio_Admin class.
 *
 * @package   Sexy_Author_Bio_Admin
 * @author    Andy Forsberg <andyforsberg@gmail.com>
 */
class Sexy_Author_Bio_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @var   object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since 1.0.0
	 *
	 * @var   string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		$this->plugin_slug = Sexy_Author_Bio::get_plugin_slug();

		// Custom contact methods.
		add_filter( 'user_contactmethods', array( $this, 'contact_methods' ), 10, 1 );

		// Load admin JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Init plugin options form.
		add_action( 'admin_init', array( $this, 'plugin_settings' ) );

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
	 * Sets default settings.
	 *
	 * @since  1.0.0
	 *
	 * @return array Plugin default settings.
	 */
	protected function default_settings() {

		$settings = array(
			'settings' => array(
				'title' => __( 'Settings', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'display' => array(
				'title' => __( 'Display in', $this->plugin_slug ),
				'default' => 'posts',
				'type' => 'select',
				'description' => sprintf( __( 'You can display the box directly into your theme using: %s', $this->plugin_slug ), '<br /><code>&lt;?php if ( function_exists( \'get_Sexy_Author_Bio\' ) ) echo get_Sexy_Author_Bio(); ?&gt;</code><br />You can also use this shortcode:<br /><code>[sexy_author_bio]</code>' ),
				'section' => 'settings',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'posts' => __( 'Only in Posts', $this->plugin_slug ),
					'home_posts' => __( 'Homepage and Posts', $this->plugin_slug ),
					'none' => __( 'None', $this->plugin_slug ),
				)
			),
			'author_links' => array(
				'title' => __( 'Author Links', $this->plugin_slug ),
				'default' => 'posts',
				'type' => 'select',
				'description' => sprintf( __( 'Control whether or not users can set avatar and name links.', $this->plugin_slug ) ),
				'section' => 'settings',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'users_set' => __( 'Users set the links', $this->plugin_slug ),
					'link_to_author_page' => __( 'Author avatar and name link to author page', $this->plugin_slug ),
				)
			),
			'link_target' => array(
				'title' => __( 'Link Target', $this->plugin_slug ),
				'default' => '_top',
				'type' => 'select',
				'description' => sprintf( __( 'Set Sexy Author Bio links to open in current window or in a new window.', $this->plugin_slug ) ),
				'section' => 'settings',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'_top' => __( 'Load in the full body of the window', $this->plugin_slug ),
					'_blank' => __( 'Load in a new window', $this->plugin_slug ),
				)
			),
			'design' => array(
				'title' => __( 'Design', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'gravatar' => array(
				'title' => __( 'Gravatar size', $this->plugin_slug ),
				'default' => 100,
				'type' => 'text',
				'description' => sprintf( __( 'Set the Gravatar size (only integers). To configure the profile picture of the author you need to register in %s.', $this->plugin_slug ), '<a href="gravatar.com">gravatar.com</a>' ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_name_font_size' => array(
				'title' => __( 'Author Name Font Size', $this->plugin_slug ),
				'default' => 27,
				'type' => 'text',
				'description' => sprintf( __( 'Set the author name font size', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_name_font' => array(
				'title' => __( 'Author Name Font', $this->plugin_slug ),
				'default' => '',
				'type' => 'text',
				'description' => sprintf( __( 'Set the author name font', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'author_name_capitalization' => array(
				'title' => __( 'Author Name Capitalization', $this->plugin_slug ),
				'default' => 'uppercase',
				'type' => 'select',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'uppercase' => __( 'UPPERCASE', $this->plugin_slug ),
					'capitalize' => __( 'Capitalize', $this->plugin_slug ),
					'lowercase' => __( 'lowercase', $this->plugin_slug ),
					'none' => __( 'As is', $this->plugin_slug )
				)
			),
			'author_name_decoration' => array(
				'title' => __( 'Author Name Decoration', $this->plugin_slug ),
				'default' => 'none',
				'type' => 'select',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'none' => __( 'None', $this->plugin_slug ),
					'underline' => __( 'Underline', $this->plugin_slug )
				)
			),
			'separator' => array(
				'title' => __( 'Job Title Company Separator', $this->plugin_slug ),
				'default' => 'at',
				'type' => 'text',
				'description' => sprintf( __( 'Set the text to separate job title and company', $this->plugin_slug ) ),
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'background_color' => array(
				'title' => __( 'Background color', $this->plugin_slug ),
				'default' => '#333333',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'highlight_color' => array(
				'title' => __( 'Highlight color', $this->plugin_slug ),
				'default' => '#0088cc',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'text_color' => array(
				'title' => __( 'Text color', $this->plugin_slug ),
				'default' => '#ffffff',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'title_color' => array(
				'title' => __( 'Title color', $this->plugin_slug ),
				'default' => '#777777',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'border_size' => array(
				'title' => __( 'Border size', $this->plugin_slug ),
				'default' => 2,
				'type' => 'text',
				'section' => 'design',
				'description' => __( 'Thickness of the top and bottom edge of the box (only integers).', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'border_style' => array(
				'title' => __( 'Border style', $this->plugin_slug ),
				'default' => 'solid',
				'type' => 'select',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'none' => __( 'None', $this->plugin_slug ),
					'solid' => __( 'Solid', $this->plugin_slug ),
					'dotted' => __( 'Dotted', $this->plugin_slug ),
					'dashed' => __( 'Dashed', $this->plugin_slug )
				)
			),
			'border_color' => array(
				'title' => __( 'Border color', $this->plugin_slug ),
				'default' => '#444444',
				'type' => 'color',
				'section' => 'design',
				'menu' => 'sexyauthorbio_settings'
			),
			'icon_set' => array(
				'title' => __( 'Icon Set', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'pick_icon_set' => array(
				'title' => __( 'Pick Icon Set', $this->plugin_slug ),
				'default' => 'squares',
				'type' => 'select',
				'section' => 'icon_set',
				'description' => __( '<h4>Squares</h4><img id="sig-twitter" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/twitter.png" style="width:55px;"> <img id="sig-google" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/google-plus.png" style="width:55px;"> <img id="sig-facebook" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/facebook.png" style="width:55px;"> <img id="sig-linkedin" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/linkedin.png" style="width:55px;"><h4>Circles</h4><img id="sig-twitter" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/twitter2.png" style="width:55px;"> <img id="sig-google" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/google-plus2.png" style="width:55px;"> <img id="sig-facebook" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/facebook2.png" style="width:55px;"> <img id="sig-linkedin" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/linkedin2.png" style="width:55px;">', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings',
				'options' => array(
					'squares' => __( 'Squares', $this->plugin_slug ),
					'circles' => __( 'Circles', $this->plugin_slug )
				)
			),
			'custom_css' => array(
				'title' => __( 'Custom CSS', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_default' => array(
				'title' => __( 'YOUR Custom CSS', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'custom_css',
				'description' => __( 'Paste your custom CSS here.', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'responsive_css' => array(
				'title' => __( 'Responsive CSS', $this->plugin_slug ),
				'type' => 'section',
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_desktop' => array(
				'title' => __( 'DESKTOP<br />1,200px +', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'responsive_css',
				'description' => __( 'Paste your custom CSS for DESKTOP 1,200px + here.', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_ipad_landscape' => array(
				'title' => __( 'IPAD LANDSCAPE<br />1019 - 1199px', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'responsive_css',
				'description' => __( 'Paste your custom CSS for IPAD LANDSCAPE 1019 - 1199px here.', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_ipad_portrait' => array(
				'title' => __( 'IPAD PORTRAIT<br />768 - 1018px', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'responsive_css',
				'description' => __( 'Paste your custom CSS for IPAD PORTRAIT 768 - 1018px here.', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
			'custom_css_smartphones' => array(
				'title' => __( 'SMARTPHONES<br />0 - 767px', $this->plugin_slug ),
				'default' => '',
				'type' => 'textarea',
				'section' => 'responsive_css',
				'description' => __( 'Paste your custom CSS for SMARTPHONES 0 - 767px here.', $this->plugin_slug ),
				'menu' => 'sexyauthorbio_settings'
			),
		);

		return $settings;

	}

	/**
	 * Custom contact methods.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $methods Old contact methods.
	 *
	 * @return array          New contact methods.
	 */
	public function contact_methods( $methods ) {
		// Add new methods.
		$methods['facebook']   = __( 'Facebook', $this->plugin_slug );
		$methods['twitter']    = __( 'Twitter', $this->plugin_slug );
		$methods['googleplus'] = __( 'Google Plus', $this->plugin_slug );
		$methods['linkedin']   = __( 'LinkedIn', $this->plugin_slug );

		// Remove old methods.
		unset( $methods['aim'] );
		unset( $methods['yim'] );
		unset( $methods['jabber'] );

		return $methods;
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since  1.0.0
	 *
	 * @return null Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script(
				$this->plugin_slug . '-admin',
				plugins_url( 'assets/js/admin.min.js', __FILE__ ),
				array( 'jquery', 'wp-color-picker' ),
				null,
				true
			);
		}
	}

	/**
	 * Register the administration menu for this plugin into the
	 * WordPress Dashboard menu.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_plugin_admin_menu() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Sexy Author Bio', $this->plugin_slug ),
			__( 'Sexy Author Bio', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);
	}

	/**
	 * Plugin settings form fields.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function plugin_settings() {
		$settings = 'sexyauthorbio_settings';

		foreach ( $this->default_settings() as $key => $value ) {

			switch ( $value['type'] ) {
				case 'section':
					add_settings_section(
						$key,
						$value['title'],
						'__return_false',
						$value['menu']
					);
					break;
				case 'text':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'text_element_callback' ),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'class' => 'small-text',
							'description' => isset( $value['description'] ) ? $value['description'] : ''
						)
					);
					break;
				case 'textarea':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'textarea_element_callback' ),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'class' => 'large-text',
							'description' => isset( $value['description'] ) ? $value['description'] : ''
						)
					);
					break;
				case 'checkbox':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'checkbox_element_callback' ),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'class' => 'checkbox',
							'description' => isset( $value['description'] ) ? $value['description'] : ''
						)
					);
					break;
				case 'select':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'select_element_callback' ),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'description' => isset( $value['description'] ) ? $value['description'] : '',
							'options' => $value['options']
						)
					);
					break;
				case 'color':
					add_settings_field(
						$key,
						$value['title'],
						array( $this, 'color_element_callback' ),
						$value['menu'],
						$value['section'],
						array(
							'menu' => $value['menu'],
							'id' => $key,
							'description' => isset( $value['description'] ) ? $value['description'] : ''
						)
					);
					break;

				default:
					break;
			}

		}

		// Register settings.
		register_setting( $settings, $settings, array( $this, 'validate_options' ) );
	}

	/**
	 * Text element fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Text field.
	 */
	public function text_element_callback( $args ) {
		$menu  = $args['menu'];
		$id    = $args['id'];
		$class = isset( $args['class'] ) ? $args['class'] : 'small-text';

		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '';
		}

		$html = sprintf( '<input style="width:200px;" type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="%4$s" />', $id, $menu, $current, $class );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Text Area element fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Text field.
	 */
	public function textarea_element_callback( $args ) {
		$menu  = $args['menu'];
		$id    = $args['id'];
		$class = isset( $args['class'] ) ? $args['class'] : 'large-text';

		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '';
		}

		$html = sprintf( '<textarea style="width:550px;height: 175px;" type="text" id="%1$s" name="%2$s[%1$s]" class="%4$s" />%3$s</textarea>', $id, $menu, $current, $class );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Text element fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Text field.
	 */
	public function checkbox_element_callback( $args ) {
		$menu  = $args['menu'];
		$id    = $args['id'];
		$class = isset( $args['class'] ) ? $args['class'] : 'checkbox';

		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '';
		}

		$html = sprintf( '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="%4$s" />', $id, $menu, $current, $class );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Select field fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Select field.
	 */
	public function select_element_callback( $args ) {
		$menu = $args['menu'];
		$id   = $args['id'];

		$options = get_option( $menu );

		// Sets current option.
		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '';
		}

		$html = sprintf( '<select id="%1$s" name="%2$s[%1$s]">', $id, $menu );
		foreach( $args['options'] as $key => $label ) {
			$key = sanitize_title( $key );

			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $label );
		}
		$html .= '</select>';

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Color element fallback.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Color field.
	 */
	public function color_element_callback( $args ) {
		$menu = $args['menu'];
		$id   = $args['id'];

		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '#333333';
		}

		$html = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="sexy-author-bio-color-field" />', $id, $menu, $current );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Valid options.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $input options to valid.
	 *
	 * @return array        validated options.
	 */
	public function validate_options( $input ) {
		// Create our array for storing the validated options.
		$output = array();

		// Loop through each of the incoming options.
		foreach ( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if ( isset( $input[ $key ] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings.
				$output[ $key ] = sanitize_text_field( $input[ $key ] );
			}
		}

		return $output;
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once 'views/admin.php';
	}

}
