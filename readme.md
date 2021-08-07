# TG 404 Site Checker

* Version: 1.0.3
* Author: Tenseg LLC
* Author URI: http://www.tenseg.net

When you get a 404 this will check the requested path at a site you define and redirect there if found rather than showing the `404.php` template from your theme.

## Configuration

The basic configuration is in the `wp-config.php` file:

```php
define('TG_404_CHECK_SITE', 'http://example.com');
```

If this is installed on a multisite network where each subsite needs a separate check site, you can use the settings method by visiting the *Settings > 404 Site Checker* page in the Dashboard. You can, of course, use the setting even on a single site install, in that configuration it really comes down to personal preference and security.

If the define is in the config file that will override any setting, but if the define is not found a setting will be looked for. One of these is required for this plugin to function properly.

## Changelog

These release notes are based on the issues resolved in our [TG 404 Site Checker issue tracker](https://bitbucket.org/tenseg//tg-404-site-checker/issues?status=resolved&sort=-updated_on). The numbers cited below refer to those issues.

### 20210807 1.0.3

* Changed the title of the plugin in its settings screen
### 20210805 1.0.2

* Added an admin notice for when the check site is not configured ([#2](https://bitbucket.org/tenseg/tg-404-site-checker/issues/2/inactive-warning))
### 20210805 1.0.1

* Added a settings screen ([#1](https://bitbucket.org/tenseg/tg-404-site-checker/issues/1/configuration-page))

### 20210805 1.0

* Initial release

## Notes

### Bumping the version number

Change version and add release notes in this file.

Update the version number in the header of [tg-404-site-checker.php](tg-404-site-checker.php).