=== JH Portfolio ===
Contributors: joehoyle
Tags: portfolio, jh-portfolio, jh
Requires at least: 2.9
Tested up to: 2.9.2
Stable tag: 0.9.5

JH Portfolio adds a Portfolio section to the WP-Admin and provides portfolio templating either via widgets or template files.

== Description ==

Add a fully functionality integrated Portfolio to your WordPress site. JH Portfolio comes with a set of widgets for visually creating your portfolio layout, or custom page templates can be used if you want that extra level control over your portfolio design.


Report any issues/feature requests here: http://github.com/joehoyle/JH-Portfolio/issues or you can twitter #jhportfolio for feedback etc.

= Features =

* Assign entries to their own categories and tags
* Ability to add additional image gallery for each entry
* Whole new admin section for managing your portfolio
* Pretty permalinks
* Automatic server-side thumbnail generation for all image sizes

== Upgrade Notice ==

= 0.9.6 =
Fixes images breaking on sites with WordPress in stalled in subdir, adds some more template functions, does not break any backwards compatibility.

= 0.9.5 =
Some of your old data will be lost: Main Images, Additional Images and your Portfolio Widgets will need setting up. Not compatible with pre 0.9.5 custom templates. See: http://wiki.github.com/joehoyle/JH-Portfolio/0901-and-under-upgrade-to-095 for details.

== Changelog ==

= 0.9.6 =
* Fixed bug with images not showing with WordPress installed in a subdir
* Added functions: jhp_get_the_category, jhp_get_category_link, jhp_in_category, jhp_the_category, jhp_get_the_tags, jhp_get_the_tag_list, jhp_the_tags
* Fixed bug with images uploaded on new entry not being attached to the post
* Fixed bug with single entries returning a 404 header
* Fixed bug with an empty single base permalink structure breaking templates
* Improved Adding Gallery Images so Thickbox does not need to reload on every addition
* Fixed bug with Portfolio link not getting "current_page_item" class
* Added option to select Portfolio Menu Order in JH Portfolio settings page

= 0.9.5 =
* Removed need for Portfolio page
* Separated into "Portfolio Home" and "Portfolio Single" the same as WordPress (no more problematic ajax failing in IE!).
* Rewrote the whole admin side of the plugin using the CWP Framework, so there is now Bulk Edit, cleaner admin pages / less buggy. New Main Image and Gallery meta boxes.
* Added Portfolio Tags and JHP Tags Widget
* Also added Manage Tags admin page to JH Portfolio menu.
* Removed ShrinkTheWeb - This wasn't a very streamlined process, and I don't think many people were using it.
* Added Options to remove the default CSS and Javascript if you want to use the Portfolio's widgets but your own styles.
* Added Options to change the url of your portfolio
* Rewrote Images to be less buggy
* Replaced "Additional Images" for "Gallery"
* Added the ability to edit Entry slugs
* Added option to change the Portfolio title (in page menu etc)

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

== Screenshots ==

1. The Manage Entries admin page
2. The Add New/Edit Entry page - adding Main Image, Gallery, Brief data etc.
3. The JH Portfolio Settings page

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

