<?php
/**
 * Sexy Author Bio
 *
 * @package   Sexy_Author_Bio
 * @author    Andy Forsberg <andyforsberg@gmail.com>
 * @license   GPL-2.0+
 * @copyright 2013 Penguin Initiatives
 *
 * @wordpress-plugin
 * Plugin Name:       Sexy Author Bio
 * Description:       Adds a sexy, customizable author bio section below your posts.
 * Version:           1.0.2
 * Author:            penguininitiatives
 * Author URI:        http://penguininitiatives.com/
 * Text Domain:       sexy-author-bio
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Include plugin main class.
 */
require_once plugin_dir_path( __FILE__ ) . 'public/class-sexy-author-bio.php';

/**
 * Perform installation.
 */
register_activation_hook( __FILE__, array( 'Sexy_Author_Bio', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Sexy_Author_Bio', 'deactivate' ) );

/**
 * Initialize the plugin instance.
 */
add_action( 'plugins_loaded', array( 'Sexy_Author_Bio', 'get_instance' ) );

/**
 * Plugin admin.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/class-sexy-author-bio-admin.php';

	add_action( 'plugins_loaded', array( 'Sexy_Author_Bio_Admin', 'get_instance' ) );
}

/**
 * Shows the Sexy Author Bio.
 *
 * @return string Sexy Author Bio HTML.
 */
function get_Sexy_Author_Bio() {
	return Sexy_Author_Bio::view( get_option( 'sexyauthorbio_settings' ) );
}

/**
 * Shows the Sexy Author Bio legacy.
 *
 * @return string Sexy Author Bio HTML.
 */
function authorbbio_add_authorbox() {
	echo get_Sexy_Author_Bio();
}

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

/**
 * Adds custom user profile fields shown in Sexy Author Bio
 *
 */
function extra_user_profile_fields( $user ) { ?>
<h3><?php _e("Author Signature Info", "blank"); ?></h3>

<table class="form-table">
<tr>
<th><label for="job-title"><?php _e("Job Title"); ?></label></th>
<td>
<input type="text" name="job-title" id="job-title" value="<?php echo esc_attr( get_the_author_meta( 'job-title', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter your job title."); ?></span>
</td>
</tr>
<tr>
<th><label for="company"><?php _e("Company"); ?></label></th>
<td>
<input type="text" name="company" id="company" value="<?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter your company."); ?></span>
</td>
</tr>
<tr>
<th><label for="company-website-url"><?php _e("Company Website URL"); ?></label></th>
<td>
<input type="text" name="company-website-url" id="company-website-url" value="<?php echo esc_attr( get_the_author_meta( 'company-website-url', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter your company's website URL."); ?></span>
</td>
</tr>
<tr>
<th><label for="name-link"><?php _e("Name Link"); ?></label></th>
<td>
<input type="text" name="name-link" id="name-link" value="<?php echo esc_attr( get_the_author_meta( 'name-link', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter the URL you want your name to link to."); ?></span>
</td>
</tr>
<tr>
<th><label for="avatar-link"><?php _e("Avatar Link"); ?></label></th>
<td>
<input type="text" name="avatar-link" id="avatar-link" value="<?php echo esc_attr( get_the_author_meta( 'avatar-link', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter the URL you want your avatar to link to."); ?></span>
</td>
</tr>
</table>
<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {

if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

update_user_meta( $user_id, 'job-title', $_POST['job-title'] );
update_user_meta( $user_id, 'company', $_POST['company'] );
update_user_meta( $user_id, 'company-website-url', $_POST['company-website-url'] );
update_user_meta( $user_id, 'name-link', $_POST['name-link'] );
update_user_meta( $user_id, 'avatar-link', $_POST['avatar-link'] );
}