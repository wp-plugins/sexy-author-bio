<?php
/**
 * Plugin options view.
 *
 * @package   Sexy_Author_Bio
 * @author    Andy Forsberg <andyforsberg@gmail.com>
 * @license   GPL-2.0+
 * @copyright 2014 Penguin Initiatives
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<form method="post" action="options.php">
		<?php
			settings_fields( 'sexyauthorbio_settings' );
			do_settings_sections( 'sexyauthorbio_settings' );
			submit_button();
		?>
	</form>
</div>
