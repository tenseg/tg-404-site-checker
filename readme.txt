=== TG 404 Site Checker ===
Contributors: Tenseg LLC
Tags: 404, errors
Tested up to: 5.8
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

When you get a 404 this will check the requested path at a site you define and redirect there if found rather than showing the `404.php` template from your theme.

== Description ==

This plugin will look at another site you specify whenever a 404 error occurs and check if the requested path is there. If the path is found, it will redirect there rather than show the WP 404 page.

This is particularly useful to silently redirect over to an archival copy of a website when a major redesign has been done.

== Installation ==

Once the plugin is installed and activated follow the on-screen prompt to set the URL of the site to check against. You set this one of two ways:

1. Add the following to `wp-config.php`:

define('TG_404_CHECK_SITE', 'http://example.com');

2. Go to the Settings > 404 Site Checker screen in the Dashboard

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

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
