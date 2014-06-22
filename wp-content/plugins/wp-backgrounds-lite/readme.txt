=== WP-Backgrounds Lite ===
Contributors: InoPlugs
Donate link: http://inoplugs.com/donate
Tags: background, images, fullsize, post, page, wordpress, photos, photo, image
Requires at least: 3.0
Tested up to: 3.9
Stable tag: 2.2.6

Set clickable fullscreen background images for single posts and pages. Compatible with all major browsers and very easy to install.

== Description ==

Set clickable fullscreen background images for single posts and pages. Compatible with all major browsers and very easy to install. This is the free lite version of <a href="http://inoplugs.com/wpbackgroundsII">WP-Backgrounds II</a>.


*    Set fullscreen background images for posts and pages
*    Apply a link to each background image (only boxed themes where the contentcontainer doesn't cover the whole screen)
*    You can deactivate WP-Backgrounds Lite for certain pages and posts
*    Compatible with all major browsers like IE7, IE8, IE9, Firefox, Opera, Safari, Chrome and other modern browsers.
*    Can be used with nearly every theme (premium and free ones). For the most themes it works out of the box (i.e. for TwentyTen or boxed themes). A z-index and a background color option helps you to adjust the background/content layer z-index and the body background color.
*    Vertical & horizontal image centering
*    Small fingerprint, only a few kb filesize
*	 Translatable - supports mo/po files
*    Easy installation, works out of the box
*    User friendly ajax option page
*    Option to adjust the background image layer z-index, the content container layer z-index, the body background color, the content container id/class and the content container position.

**The newest versions of this plugin can be found here: <a href="http://inoplugs.com/projects/wp-backgrounds-lite-version/">WP-Backgrounds Lite</a>. I'll try to keep the repository up to date but it's easier to host updates on my site. You'll get support there too (just leave a comment).**

Live demo of WP-Backgrounds II can be found here: <a href="http://demo.inoplugs.com">InoPlugs Demo Website</a>.

This plugin is the free lite version of WP-Backgrounds II which you can download here: <a href="http://inoplugs.com/projects/wp-backgrounds-ii-add-wordpress-backgrounds-website/">WP-Backgrounds II</a> - it offers a lot more features:


*	Add fullscreen background image slideshows, html5 video slideshows and youtube video backgrounds to your posts, pages & custom post types.
*	Image sliders support various effects/transitions (KenBurns, Reveal, Split Reveal, etc.).
*	You can a different background for each post, page and custom post type.
*	Set background images/videos for categories and taxonomies/terms.
*   	Apply a category, term/taxonomy background to post, page and custom post types.
*	Set background images for the home, front, search, author, 404, archive, login page and a fallback background option.
*	Each author can use/set an individual background on the author page.
*	Backgrounds are stored as custom post type and you can reuse them as often as you like.
*	Set as many images/videos as you like, they will be displayed as a background slideshow.
*	Compatible with all modern browsers like IE7, IE8, IE9, Firefox, Opera, Safari, Chrome and other modern browsers.
*	Can be used with nearly every theme, premium and free ones. For the most themes it works out of the box (i.e. for TwentyTen or boxed themes). We can assist you with css changes if the are required. Some z-index, container and background color options help you to adjust the background layer and color via admin panel.
*	Fully translatable; the plugin uses PO/MO files for the translation. German translation already included, more to come.


== Installation ==

How to install the plugin and get it working.

1. Upload `wp-backgrounds-lite` to the `/wp-content/plugins/` directory or use the WordPress plugin installer to install the plugin.
2. Activate the plugin through the 'Plugins' menu in WordPress

We do our best to make WP-Backgrounds Lite/WP-Backgrounds II compatible with all available wordpress themes. Unfortunately not all theme authors take care of coding standards and some of them even use weird html structures to build their themes.
WP-Backgrounds Lite/WP-Backgrounds II adds two new layer to your website which will take care of the background slider/image and the pattern/link which covers this background. 
Thus you need to make sure that our plugin can add these two layers to your website without breaking the content area (where all your text paragraphs, images, etc. can be found).
Actually there're two worst case scenarios:


a) The background and pattern layers cover your text/content area und you see the background but you can't see any text. This happens when the background layer overlaps the content area.

b) You can't see the background and/or pattern layer but the text/content layer. This happens when the background layer is overlapped by all other layers including the body layer.


We've added 4 options which will help you to get our plugin running with any well coded theme. However, some features (i.e. the fullsize background link) will not work with all themes. It depends on their structure and layout. The best themes for WP-Backgrounds II are boxed themes. When you're using a boxed theme the content area does not cover the entire screen but just a specfic area of the screen. 
You can see the background layer on the left/right/bottom/top and i.e. your user can see the video and click on the link which is overlaps the background layer. 

If you're using a fullwidth layout/theme instead then it will be a bit harder to use WP-Backgrounds Lite/WP-Backgrounds II with this theme because you need to change the background of the content area to a semi-transparent background (eg use a rgba color as background color or use semi-transparent png or gif images) and you can't apply a fullscreen link to the images. WP-Backgrounds Lite/WP-Backgrounds II  offers an option to display the links as small icons though which allows you to use the link features with these themes too though.

= Let's explain the 4 options: = 

1) Custom z-index of the background layer: This option allows you to adjust the z-index value of the background layer. The z-index value tells the browser which priority the layer has compared to other layers. Higher priority means that the layer will overlap other layers, lower means that other layers will overlap this layer. The z-index value can be negative and positive - i.e. -999 and 999 are valid values. During our tests we found out that -1 for the background layer is a sensible value and that it will work in most cases. Values under -1 (like -2, -3, etc.) will probably break the pattern/link layer because WP-Backgrounds Lite/WP-Backgrounds II  calculates the z-index of this layer automatically by adding +1 to the background layer. Therefore i.e. the value -2 for the background layer will result in -1 for the pattern/link layer. However -1 is lower than 0 and this is the standard z-index value of all elements without a specific z-index value. Thus the risk is high that one or more elements will overlap the pattern layer and that the background won't be clickable. I'd suggest to keep the value for the background layer with -1 or use any hihger value but do not use a lower value unless you know what you're doing or if you don't want to use the fullscreen background link feature.

2) Content container id or class: This option allows you to specify the content container element. It's important for WP-Backgrounds Lite/WP-Backgrounds II  to know it because if the pattern and/or the background overlaps your content WP-Backgrounds Lite/WP-Backgrounds II  gives you an option to increase the z-index value of the content container. The result will be that the content container gets a higher priority and it will overlap the background again. The layer structure will be "Content Container/Area" > "Pattern" > "Background". It's hard to say how this container element is called in your case because there're no standards. Most theme authors use a div with the id "wrapper" or class "wrapper" - in this case you'd need to enter "#wrapper" (for the id) or ".wrapper" (without "") for the class. If you need any help to locate the id/class of the container element just contact us and we'll help you asap or ask the theme author for help. If you're an advanced user or web designer you can also use FireBug or any other web developer console to locate the right element.

3) Custom z-index of the content container layer: This option is pretty self explaining - you need it if the background and/or the pattern layer overlap the content area. I'd insert a value between 1-5 which should give you good results. If it doesn't work try to increase it to a high value like 999 or even 9999.

4) Custom position of the content container: During our tests we noticed that some theme developers do not add a position to their container element which can cause troubles because i.e. the z-index value for the content container won't work. Basically you'll notice this issue if the z-index values don't have any effect - so i.e. if the patterns always overlap the content area even if the background layer is set to -999 and the content container layer to 999. In this case you probably need to define a position for your content container. In most cases (probably 98%+) the right position value will be "relative" (enter it into the field without the "" signs) but maybe you need to use "absolute" or "fixed" in your case (enter it without "").	


== Frequently Asked Questions ==

= The background doesn't show up =

First check if your theme has a boxed layout (like TwentyTen, the default WP theme) or if your theme has a fullwidth layout. If it has a fullwidth layout you may want to use semi-transparent background images for the content area so that the vistors can see the fullwidth background images.
You can use the z-index option in inoplugs_background_plugin.php to adjust the background layer. If the background image doesn't show up increase the value from -999 to -1. If that doesn't help try 0 or a positive value like 1.


== Changelog ==

= 1.0 =
* Initial release - some features coming, stay tuned.

= 1.1 =
* Fixed meta box bug on pages & posts.

= 1.2 =
* Improved meta box code for pages & posts.

= 1.3 =
* Fixed some php warning messages and decreased background image js/css file size. Fixed meta box caption typo. Compatible with WordPress 3.2 beta2.

= 1.4 =
* Fixed bug with rtl direction websites.

= 1.5 =
* Updated background image javascript function - solves various display errors with IE7+ and mobile devices.

= 2.0 =
* Major update. New option panel (Settings > WP-Backgrounds Lite) and clickable backgrounds (you can enter a custom url for each background). Some configuration may be required. Clickable backgrounds may not work with all themes (only boxed themes are supported).

= 2.1 =
* Fixed "Cheatin, uh" bug with WP 3.4.1

= 2.2 =
* Fixed meta box issue with some themes

= 2.2.5 =
* Fixed php warnings


= 2.2.6 =
* Fixed php warning on search page


== Upgrade Notice ==

Just upload the new plugin files and delete the old plugin files.
