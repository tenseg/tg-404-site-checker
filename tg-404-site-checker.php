<?php
/*
Plugin Name: TG 404 Site Checker
Plugin URI: https://tenseg.net
Description: Check another site for the requested path and redirect there during 404.
Version: 1.0
Author: Tenseg LLC
Author URI: https://tenseg.net
License: MIT License
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
	}

	/**
	 * This action checks to see if we're in 404 and redirects as able.
	 *
	 * Called by: template_redirect
	 *
	 * @return void
	 */
	public static function redirect_404_requests() {
		if ( is_404() ) {
			if ( $base = TG_404_Site_Checker::get_check_site() ) {
				$url = $base . $_SERVER['REQUEST_URI'];
				if ( TG_404_Site_Checker::does_url_exist( $url ) ) {
					wp_redirect( $url, 301 );
					exit;
				}
			}
		}
	}

	/**
	 * Gets the site to check against.
	 *
	 * @return string|bool the site to check against or false if none found
	 */
	private static function get_check_site() {
		// first check for the definition in wp-config.php
		if ( defined( 'TG_404_CHECK_SITE' ) && '' != constant( 'TG_404_CHECK_SITE' ) ) {
			$base = constant( 'TG_404_CHECK_SITE' );
		}

		// next check for an option
		if ( !isset( $base ) && $opt = get_option( 'tg_404_check_site' ) ) {
			if ( '' != $opt ) {
				$base = $opt;
			}
		}

		// do some cleanup on the base if it was found
		if ( isset( $base ) && '' != $base ) {
			// check for trailing slash
			// the request uri gives us this
			$base = rtrim( $base, '/' );

			// check for scheme
			// add http if none found
			$parsed = parse_url( $base );
			if ( empty( $parsed['scheme'] ) ) {
				$base = 'http://' . ltrim( $base, '/' );
			}

			// return the cleaned up base
			return $base;
		}

		// if no base was found return false
		return false;
	}

	/**
	 * Check the URL to see if it exists.
	 *
	 * @param string $url the site to check against
	 * @return bool true if found, false if not or no url given
	 */
	private static function does_url_exist( $url ) {
		// return false if no url was given
		if ( '' == $url ) {
			return false;
		}

		// run a curl to check the url
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HEADER, true );
		curl_setopt( $ch, CURLOPT_NOBODY, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_exec( $ch );
		$httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		curl_close( $ch );

		// check the response code from the curl
		if ( $httpcode < 400 ) { // anything below a 400 is presumed to be handled by the check site
			return true;
		} else {
			return false;
		}
	}
}

TG_404_Site_Checker::init();