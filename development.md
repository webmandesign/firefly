# Starter Theme Development Instructions

The starter theme was created by **WebMan Design**. Please read the instructions below for theme development process.


## Additional scripts

This starter theme requires installation of these additional scripts:

* [**WebMan WordPress Theme Framework** (complex)](https://github.com/webmandesign/webman-theme-framework/tree/master/complex) - copy the `library` folder into the theme's root folder.
* [**WordPress CSS starter**](https://github.com/webmandesign/wp-css-starter) - copy the `starter` SASS folder into the `assets/scss` folder.
* [**Post Formats**](https://github.com/webmandesign/wp-post-formats) - copy the `class-post-formats.php` file into the `includes/post-formats` folder.


## Replacements

When developing a new theme, you need to batch replace a predefined set of string variables. Each variable is enclosed in `{%= %}` brackets (i.e. `{%= variable_name %}`).

### Example replacements:

* `theme_name`      => "Theme Name"
* `theme_slug`      => "themeslug"
* `version_since`   => "1.0"
* `version`         => "1.0"
* `prefix_constant` => "THEMESLUG"
* `prefix_var`      => "themeslug"
* `prefix_class`    => "Themeslug"
* `prefix_fn`       => "themeslug"
* `prefix_hook_fn`  => "fn_" + `prefix_fn` => "fn_themeslug"
* `prefix_hook`     => "themeslug"
* `text_domain`     => "themeslug"

### Project replacements:

> Developers, fill this section with the actual values used for replacements for future reference.

* `theme_name`      => "Firefly"
* `theme_slug`      => "firefly"
* `version_since`   => "1.0"
* `version`         => "1.0"
* `prefix_constant` => "FIREFLY"
* `prefix_var`      => "firefly"
* `prefix_class`    => "Firefly"
* `prefix_fn`       => "firefly"
* `prefix_hook_fn`  => "fn_firefly"
* `prefix_hook`     => "firefly"
* `text_domain`     => "firefly"


## Documentation

The theme documentation template can be found in `documentation` subfolder. Documentation uses the `theme_name`, `theme_slug`, `version_since` and `version` from above to be replaced.

For online documentation rename the file to `index.php` and enable GZIP compression by including the `<?php ob_start( 'ob_gzhandler' ); ?>` before the HTML doctype declaration.


## Upgrades

In case you upgrade the library (`library/*.*`) and/or other universal pluggable/external scripts, such as post formats class (`includes/post-formats/class-post-formats.php`) and CSS starter (`assets/scss/starter`), you will need to batch replace certain string variables (see above).

Reference of what variables need to be replaced can be found in the scripts themselves.


## Debugging

For SASS debugging define a `FIREFLY_DEBUG_SASS` constant and set it to `true`.

Or simply use `webman-sass-debug.php` plugin for that.

This will force enqueuing `fallback.css` instead of the customizer-generated stylesheet.


*(C) WebMan Design, Oliver Juhas, [http://www.webmandesign.eu]*