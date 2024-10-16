=== 404 Site Checker ===
Contributors: tenseg
Tags: 404, errors, redirection
Tested up to: 6.6
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

When you get a 404 this will check the requested path at a site you define and redirect there if found rather than showing the `404.php` template from your theme.

== Description ==

This plugin will look at another site you specify whenever a 404 error occurs and check if the requested path is there. If the path is found, it will redirect there rather than show the WP 404 page.

This is particularly useful to silently redirect over to an archival copy of a website when a major redesign has been done.

More information about this plugin can be found [on its homepage](https://www.tenseg.net/software/404sitechecker).

== Installation ==

Once the plugin is installed and activated follow the on-screen prompt to set the URL of the site to check against. The prompt takes you to the Settings > 404 Site Checker screen in the Dashboard, which has a field for you to enter the URL of the site to check against.

If you are using this on a WordPress Multisite Network install where all sites should share one check site, you may prefer setting the check site in your `wp-config.php` file using the following code:

> define('TG_404_CHECK_SITE', 'https://example.com');

The plugin will always use what is defined in `wp-config.php` if it is found. So if you have a check site set both ways, the one set from the 404 Site Checker screen will be ignored.

== Changelog ==

= 1.2 - 2024-10-16 =

* Move updates to Github

= 1.1.1 - 2022-11-04 =

* Fix for fatal error seen by new users on settings page

= 1.1 - 2022-08-17 =

* Support an array of check sites in the define statement ([#12](https://bitbucket.org/tenseg/tg-404-site-checker/issues/12/support-multiple-check-sites))

= 1.0.5 - 2021-08-11 =

* Made assorted cleanup fixes to the page for this plugin on WordPress.org ([#6](https://bitbucket.org/tenseg/tg-404-site-checker/issues/6/readmetxt-fixes-for-plugins-directory-page))
* Unified plugin name with settings screen title ([#7](https://bitbucket.org/tenseg/tg-404-site-checker/issues/7/remove-tg-from-plugin-name))
* Added an icon for the plugin ([#9](https://bitbucket.org/tenseg/tg-404-site-checker/issues/9/custom-icon))

= 1.0.4 - 2021-08-10 =

* Now using WP HTTP library ([#3](https://bitbucket.org/tenseg/tg-404-site-checker/issues/3/using-curl-instead-of-http-api))
* Properly escaping variables ([#4](https://bitbucket.org/tenseg/tg-404-site-checker/issues/4/variables-and-options-must-be-escaped-when))
* Using a text domain ([#5](https://bitbucket.org/tenseg/tg-404-site-checker/issues/5/plugin-permalink-does-not-match-text))
* Numerous other tweaks to support submission to WordPress.org and to unify reused code

= 1.0.3 - 2021-08-07 =

* Changed the title of the plugin in its settings screen

= 1.0.2 - 2021-08-05 =

* Added an admin notice for when the check site is not configured ([#2](https://bitbucket.org/tenseg/tg-404-site-checker/issues/2/inactive-warning))

= 1.0.1 - 2021-08-05 =

* Added a settings screen ([#1](https://bitbucket.org/tenseg/tg-404-site-checker/issues/1/configuration-page))

= 1.0.0 - 2021-08-05 =

* Initial release
