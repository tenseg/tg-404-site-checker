# TG 404 Site Checker

* Version: 1.0
* Author: Tenseg LLC
* Author URI: http://www.tenseg.net

When you get a 404 this will check the requested path at a site you define and redirect there if found rather than showing the `404.php` template from your theme.

## Configuration

The basic configuration is in the `wp-config.php` file:

```php
define('TG_404_CHECK_SITE', 'http://example.com');
```

If this is installed on a multisite network where each subsite needs a separate check site, you can use the option method, setting it via the WP-CLI:

```bash
wp --url=http://subsite.com option add tg_404_check_site http://example.com
```

If the define is in the config file that will override any setting, but if the define is not found a setting will be looked for. One of these is required for this plugin to function properly.