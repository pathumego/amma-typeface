=== Disqus Recent Comments Widget ===
Contributors: DeusMachineLLC,aaron.white,Andrew Bartel
Tags: disqus, comments, widget, sidebar
Requires at least: 3.4.1
Tested up to: 3.5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Disqus has dropped support for their recent comments widget for WordPress.  This plugin will create a configurable widget that will display the latest Disqus comments from your site in any widgetized area.

== Installation ==

1. Unzip the ZIP file and drop the 'disqus-recent-comments' folder into your 'wp-content/plugins/' folder.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Enter your short name and api key in the settings page.
4. If you're having trouble configuring the settings, please see http://deusmachine.com/disqus-instructions.php

== Frequently Asked Questions ==

= The widget is saying, "No Recent Comments Found," but there are comments, why aren't they appearing? =

Disqus caps the number of requests you can make to their api at 1000 an hour for free accounts.  Comments will start appearing again next hour.

= I blocked a user, but their comments are still appearing, what gives? =

Make sure you entered the exact author name.  The plugin does its best to account for spaces, capitalization, etc but it can't read your mind.  If all else fails, copy/paste their name into the filtered users field.

= I can't figure out this API key stuff, help? =

Please see this guide: http://deusmachine.com/disqus-instructions.php

== Screenshots ==

1. The Settings Page

2. Adding the widget to a sidebar

== Changelog ==
= 1.0 =
* Initial build