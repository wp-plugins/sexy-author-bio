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

	<div style="float:left;width:80%;">

	<form method="post" action="options.php">
		<?php
			settings_fields( 'sexyauthorbio_settings' );
			do_settings_sections( 'sexyauthorbio_settings' );
			submit_button();
		?>
	</form>

	</div>

	<div class="metabox-holder" style="float:left;width:20%;">
			<div class="meta-box-sortables">
				<div class="postbox">
				<h3 class="hndle"><span>Like this plugin?</span></h3>

				<div class="inside">
					<p>Why not do any or all of the following:</p><ul style="list-style: inherit;padding-left: 21px;"><li><a href="https://wordpress.org/plugins/sexy-author-bio/" target="_blank">Link to it so other folks can find out about it</a></li><li><a href="https://wordpress.org/support/view/plugin-reviews/sexy-author-bio" target="_blank">Give it a 5 star rating on WordPress.org</a></li><li><a href="https://wordpress.org/plugins/sexy-author-bio/" target="_blank">Let other people know that it works with your WordPress setup</a></li><li><a href="https://wordpress.org/support/plugin/sexy-author-bio" target="_blank">Suggest new features to add to the plugin</a></li></ul>				</div>
			</div>
				<div class="postbox">
				<h3 class="hndle"><span>Need Support?</span></h3>

				<div class="inside">
					<p>If you're in need of support with Sexy Author Bio, please visit the <a href="https://wordpress.org/support/plugin/sexy-author-bio" target="_blank">Sexy Author Bio Support</a> page.</p>				</div>
				</div>

				<div class="postbox">
					<h3 class="hndle"><span>Latest from Penguin Initiatives</span></h3>

				<div class="inside">
					<?php
					/**
					 * Box with latest from Penguin Initiatives for sidebar
					 */
					function pi_news() {
						$rss       = fetch_feed( 'http://penguininitiatives.com/feed/' );
						$rss_items = $rss->get_items( 0, $rss->get_item_quantity( 7 ) );

						$content = '<ul style="list-style: inherit;padding-left: 21px;">';
						if ( ! $rss_items ) {
							$content .= '<li>' . __( 'No news items, feed might be broken...', 'sexyauthorbio' ) . '</li>';
						} else {
							foreach ( $rss_items as $item ) {
								$url = preg_replace( '/#.*/', '', esc_url( $item->get_permalink(), $protocolls = null, 'display' ) );
								$content .= '<li>';
								$content .= '<a target="_blank" href="' . $url . '?utm_source=sexy%20author%20bio&utm_medium=sidebar%20feed&utm_campaign=wordpress%20plugin">' . esc_html( $item->get_title() ) . '</a> ';
								$content .= '</li>';
							}
						}
						$content .= '</ul>';
						echo $content;
					}
					pi_news();
					?>
				</div>

				</div>

				<div class="postbox">
					<h3 class="hndle"><span>WordPress Hosting Deals</span></h3>

					<div class="inside">
						<ul style="list-style: inherit;padding-left: 21px;">
						<li style="list-style-image: url(http://www.siteground.com/img/favicon.ico);"><a target="_blank" href="http://peng.io/sitegroundsab">60% OFF WordPress Hosting at SiteGround!</a></li>
						</ul>
					</div>
				</div>

			</div>
	</div>
</div>

