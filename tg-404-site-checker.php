<?php
/*
Plugin Name: TG 404 Site Checker
Plugin URI: https://www.tenseg.net/software/404sitechecker
Description: Check another site for the requested path and redirect there during 404.
Version: 1.0.4
Author: Tenseg LLC
Author URI: https://www.tenseg.net
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: tg-404-site-checker
 */

/**
 * The class that encapsulates all the code of our plugin.
 */
class TG_404_Site_Checker {
	public static function init() {
		static $is_initialized = false;

		if ( $is_initialized ) {
			return; // we only need to do this once
		}

		$is_initialized = true;

		// register actions
		add_action( 'template_redirect', ['TG_404_Site_Checker', 'redirect_404_requests'], 1 );
		add_action( 'admin_init', function () {
			// register our settings
			register_setting( 'tg-404-site-checker-group', 'tg_404_check_site' );
		} );
		add_action( 'admin_menu', function () {
			// add our configuration page
			add_submenu_page(
				'options-general.php',
				__( '404 Site Checker Settings', 'tg-404-site-checker' ),
				__( '404 Site Checker', 'tg-404-site-checker' ),
				'manage_options',
				'tg_404_site_checker_settings',
				['TG_404_Site_Checker', 'settings_page']
			);
		} );
		add_action( 'admin_notices', ['TG_404_Site_Checker', 'admin_notices'] );
	}

	/**
	 * This action checks to see if we're in 404 and redirects as able.
	 *
	 * Called by: template_redirect
	 *
	 * @access public
	 * @return void
	 */
	public static function redirect_404_requests() {
		if ( is_404() ) {
			if ( $check_site = TG_404_Site_Checker::get_check_site() ) {
				$url = $check_site . $_SERVER['REQUEST_URI'];
				if ( TG_404_Site_Checker::does_url_exist( $url ) ) {
					wp_redirect( $url, 301 );
					exit;
				}
			}
		}
	}

	/**
	 * Tells us if we're using the wp-config.php define instead of the DB setting.
	 *
	 * @access private
	 * @return bool true if wp-config, false if not
	 */
	private static function is_using_define() {
		if ( defined( 'TG_404_CHECK_SITE' ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Gets the site to check against.
	 *
	 * @access private
	 * @return string|bool the site to check against or false if none found
	 */
	private static function get_check_site() {
		// first check for the definition in wp-config.php
		if ( TG_404_Site_Checker::is_using_define() && '' != constant( 'TG_404_CHECK_SITE' ) ) {
			$check_site = constant( 'TG_404_CHECK_SITE' );
		}

		// next check for an option
		if ( !isset( $check_site ) && $opt = get_option( 'tg_404_check_site' ) ) {
			if ( '' != $opt ) {
				$check_site = $opt;
			}
		}

		// do some cleanup on the check_site if it was found
		if ( isset( $check_site ) && '' != $check_site ) {
			// check for trailing slash
			// the request uri gives us this
			$check_site = rtrim( $check_site, '/' );

			// check for scheme
			// add http if none found
			$parsed = parse_url( $check_site );
			if ( empty( $parsed['scheme'] ) ) {
				$check_site = 'http://' . ltrim( $check_site, '/' );
			}

			// return the cleaned up check_site
			return $check_site;
		}

		// if no check site was found return false
		return false;
	}

	/**
	 * Check the URL to see if it exists.
	 *
	 * @access private
	 * @param string $url the site to check against
	 * @return bool true if found, false if not or no url given
	 */
	private static function does_url_exist( $url ) {
		// return false if no url was given
		if ( '' == $url ) {
			return false;
		}

		// check the url
		$response = wp_remote_head( $url );
		$httpcode = wp_remote_retrieve_response_code( $response );

		// check the response code
		if ( $httpcode < 400 ) { // below a 400 is presumed to be handled by the check site
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Presents the settings page.
	 *
	 * @access public
	 * @return void
	 */
	public static function settings_page() {
		// get the check site setting
		$check_site = TG_404_Site_Checker::get_check_site();

		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<p><?php _e( "<em>404 Site Checker</em> can check the site you define here whenever a 404 is reached on this site. If it finds the requested page on that site it'll redirect the visitor there, if it does not find the requested page on that site your visitor will see the usual 404 page of this site.", 'tg-404-site-checker' )?></p>
			<hr class="wp-header-end">
			<form method="post" action="options.php">
			<?php settings_fields( 'tg-404-site-checker-group' )?>
			<?php do_settings_sections( 'tg-404-site-checker-group' );?>
			<table class="form-table" role="presentation">
			<tr>
			<th scope="row"><label for="tg_404_check_site"><?php _e( 'Site to Check' );?></label></th>
			<td>
			<?php if ( TG_404_Site_Checker::is_using_define() ) {
			echo '<em>' . esc_url( $check_site ) . '</em>';
			?>
			<p class="description" id="home-description">
				<?php _e( 'The address of the site to check against during 404 errors is defined in <em>wp-config.php</em> using <em>TG_404_CHECK_SITE</em>.', 'tg-404-site-checker' )?>
			</p>
			<?php
} else {
			?>
			<input name="tg_404_check_site" type="text" id="check_site_url" value="<?php echo esc_url( $check_site ) ?>" class="regular-text"/>
			<p class="description" id="home-description">
				<?php _e( 'Enter the address of the site to check against during 404 errors.<br>Alternatively put a define statement for <em>TG_404_CHECK_SITE</em> in your <em>wp-config.php</em> file.', 'tg-404-site-checker' );?>
			</p>
			<?php }?>
			</td>
			</tr>
			</table>
			<?php
if ( !TG_404_Site_Checker::is_using_define() ) {
			submit_button();
		}
		?>
			</form>
		</div>
		<?php
}

	/**
	 * Shows our admin notices as needed.
	 *
	 * Called by: admin_notices
	 *
	 * @access public
	 * @return void
	 */
	public static function admin_notices() {
		// only show a notice if there is no check site and we are not on our settngs screen
		if ( !TG_404_Site_Checker::get_check_site() && 'settings_page_tg_404_site_checker_settings' !== get_current_screen()->id ) {
			$page_url = get_admin_url( null, 'options-general.php?page=tg_404_site_checker_settings' );
			add_settings_error( 'tg-404-site-checker_config_needed', 'tg-404-site-checker_warnings', sprintf( __( "You must configure <a href='%s'>404 Site Checker</a> before it can redirect on 404.", 'tg-404-site-checker' ), $page_url ), 'error' );
			settings_errors( 'tg-404-site-checker_config_needed' );
		}
	}
}

TG_404_Site_Checker::init();