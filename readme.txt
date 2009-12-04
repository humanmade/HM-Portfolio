=== JH Portfolio ===
Contributors: joehoyle
Tags: portfolio, jh-portfolio, jh
Requires at least: 2.8
Tested up to: 2.8.6
Stable tag: 0.9.0.1

JH Portfolio adds a Portfolio section to the WP-Admin and provides default template style

== Description ==

Add a fully functionality integrated Portfolio to your WordPress site. JH Portfolio comes with a set of widgets for visually creating your portfolio layout, or custom page templates can be used if you want that extra level control over your portfolio design.

The plugin has Ajax built in for faster switching between portfolio entries, but also caters for user with javascript disabled and search engines using a "HiJax" method.


Report any issues/feature requests here: http://code.google.com/p/jh-portfolio/ or you can twitter #jhportfolio for feedback etc.

= Features =

* Assign entries to categories
* Integration with ShrinkTheWeb for automatic thumbnail generation
* Ability to add additional image gallery for each entry
* Built in Ajax switching of entries (still works with Javascript disabled)
* Template functions for creating completely custom portfolio design themes
* Pretty permalinks


== Changelog ==

= 0.9.0.1 =
* Fixed action of settings page

= 0.9 =
* Removed phpThumb altogether - now uses inbuilt WordPress resize functions
* Added option to set portfolio template filename
* Support for custom permalink structure
* Added content filters to jh_portfolio_get_content()
* Fixed WP paths for WordPress in a sub directory
* Changed all URLs to pass through esc_url()
* Added char encoding to all fields such as brief etc
* Added JH icon to admin menu page
* Renamed menu item to "Portfolio" and moved to below Comments
* Added new Extra Taxonomy functionality and theme widget (can be used for extra lists such as "Responsible For")
* Added ability to hide certain categories in JH Portfolio Selector widget
* Added template functions: jh_portfolio_the_date(), jh_portfoio_category_is_hidden( $cat_obj ), get_extra_taxonomy_tags( return = 'array' )
* Fixed editing Publish Date bug
* Added Hire Me teaser to Settings page

= 0.8 =
* Fixed problem with main query class returning wrong categories

= 0.7.9 =
* Fixed SQL JOIN Error for single pages
* Fixed commas at end of Javascript arrays for IE

= 0.7.8 =
* Fixed PHP error on Manage Categories page

= 0.7.7 =
* Fixed issue with the filter the_content being disrupted by echoing the portfolio entry

= 0.7.6 =
* Fixed issue with overwriting existing sidebars
* Fixed issue with installations that use a DB prefix other than wp_

= 0.7.5 =
* Added debug page for error reports
* Fixed an error in the SQL for querying

= 0.7.4 =
* Added sorting options to the JH Portfolio Selector Widget
* Added integration with ShrinkTheWeb for automatic thumbnail generation

= 0.7.3 =
* Modifications to rewrite rules /portfolio/$cat_name/ no longer 404's 
* Added manage Categories page, fixed some issues showing categories 
* Added Main Image widget with options for width and height 
* Added options to show main image and main image size for the portfolio selector widget 
* Minor CSS fixes


== Installation ==

Check the Install and general usage video here:
http://www.vimeo.com/5509134

1. Upload the `jh-portfolio` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You must enable "Pretty Permalinks" for the single portfolio pages to work

== Frequently Asked Questions ==

= How do I get automatic thumbnail generation working? =

You must sign up for a free ShrinkTheWeb account here: http://www.shrinktheweb.com/index.php?view=join , once logged in copy your Access Key ID and Secret Key into the JH Portfolio Settings page.

= The plugin doesn't work, what do I do? =

Visit the Issues page of the plugin homepage at: http://code.google.com/p/jh-portfolio/issues/list

