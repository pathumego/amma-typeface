=== Disqus Popular Threads Widget ===
Contributors: rzvagelsky
Tags: disqus, popular posts, comments, most commented, most popular, popular threads, disqus most commented
Donate link: 
Requires at least: 3.2
Tested up to: 3.5.1
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shows your most commented posts from Disqus via widget, shortcode, or template tag.

== Description ==

Integrates with the Disqus API to show your most popular threads (most commented posts). Can be added via sidebar widget, template tag, or shortcode. 

[__For more information or to request additional features, please visit the plugin page__](http://presshive.com/plugins/disqus-popular-threads-widget-for-wordpress/)


== Installation ==

1. Upload the plugin to your 'wp-content/plugins' directory, or download and install automatically through your admin panel.
     
2. Activate the plugin through the 'Plugins' menu in WordPress.

3. Visit the plugin admin page via Settings -> Disqus Settings

4. You'll need to add your Disqus Public API Key, Forum ID (Disqus Site Shortname), and Domain Info. For information on obtaining your Disqus API Key, visit the [plugin homepage](http://presshive.com/plugins/disqus-popular-threads-widget-for-wordpress/). 

= To Display Disqus Popular Threads Via WordPress Widget = 

From your admin console, go to Appeareance > Widgets, drag the Disqus Popular Threads Widget to wherever you want it to be and click on Save.

= To Display Disqus Popular Threads Via Shortcode = 

`[wdp_threads days_back = '7d' show_threads = 5 ]`

= To Display Disqus Popular Threads Via Template Tag = 

<code>
<?php wdp_get_threads( $days_back = '7d', $show_threads = 5, $echo = true ); ?>
</code>

= Parameters =

1. Days Back  - '1h', '6h', '12h', '1d', '3d', '7d', '30d', '90d'

2. Number of Threads - # of posts to return

== Frequently Asked Questions ==

= Where can I get more information about using Disqus Popular Threads Widget? =

See the [plugin homepage](http://presshive.com/plugins/disqus-popular-threads-widget-for-wordpress/).


== Screenshots ==

1. The Disqus Popular Threads Widget.


== Changelog ==

= 1.2 =

Addressed issue with the comment count not matching.

= 1.1 =

API was returning the slug in some cases. Checking for those cases.

= 1.0 =

First public release March 2013