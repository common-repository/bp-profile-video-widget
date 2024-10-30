=== BP Profile Video Widget ===
Contributors: slushman
Donate link: http://slushman.com/
Tags: buddypress, widget, video, player, YouTube, Vimeo, Facebook, profile, embed
Requires at least: WP 2.9.1 and BuddyPress
Tested up to: 3.4.1
Stable tag: 0.4
License: GPLv2

The BP Profile Video Widget allows users to embed a YouTube, Vimeo, or Facebook video on the sidebar of the user’s profile page using custom profile fields from their profile form.

== Description ==

*** THIS PLUGIN IS NO LONGER UNDER DEVELOPMENT! ***

I haven't discontinued development of this plugin in favor of the newer version - BP Profile Widgets. Please install that plugin instead of this one.

The BP Profile Video Widget allows users to embed a YouTube, Vimeo, or Facebook video on the sidebar of the user’s BuddyPress profile page using custom profile fields from their profile form.  This was originally developed for the Towermix Network for the Mike Curb College of Entertainment and Music Business at Belmont University.

Features

* Embed a YouTube, Vimeo, or Facebook video on the sidebar of the profile page of the user being viewed.
* The video URL is entered on a custom profile field by the user.
* Widget options for width and aspect ratio (normal or HD).
* A description field allows the user to explain their role in the video presented.

== Installation ==

1. Upload the BP Profile Video Widget folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make sure BuddyPress is installed and activated
3. Create the extended profile fields (see FAQ for details)
4. Drag the BP Profile Video Widget to a sidebar on the 'Widgets' page under the 'Appearance' menu

== Frequently Asked Questions ==

= What Custom Profile Fields do I need for this plugin to work properly? =

The following fields are required and must use the EXACT Field Title as below to work properly:

Field Title: Video URL
Field Type: Text Box
Field Description: Enter the URL for the YouTube or Vimeo video you want to show on your profile.

Field Title: Video Player Description
Field Type: Multi-line Text Box
Field Description: What was your role in the video?

= How do I hide these custom profile fields so they don't show on people's profile pages? =

Install the plugin BP Profile Privacy.  For each of the custom profile fields created for this plugin, select User instead of Everyone.

= How do I make this widget only appear on the user's profile page? =

Install the plugin Widget Logic. At the bottom of each widget will have another field, called Widget Logic. Paste in the following:

bp_is_user_profile() && !is_page(array('About', 'News', 'Interviews')) && !is_home()

This code shows this widget only on the BuddyPress user profile page (but nowhere else in BuddyPress), and explicitly not on the WordPress home page or any other WordPress page. You'll need to change the !is_page array to reflect the pages on your site.

== Screenshots ==

1. Widget options
2. YouTube player
3. Vimeo Player
4. Facebook Player
5. Custom profile fields

== Changelog ==

= 0.4 =
Discontinuing development of this plugin.
Notifying users of the new plugin - BP Profile Widgets

= 0.3 =
Added auto-detection for the service, eliminating the need for the "Service" custom profile field
Added support for YouTube short URLs
Added support for Facebook video embedding

= 0.21 = 
Removed bug-testing data from the display.

= 0.2 = 
Added support for shortened Youtube URLs.  Eliminated need for the "Service" xprofile field, the plugin will auto-detect the service being used.

= 0.15 = 
Added BuddyPress 1.5 support.

= 0.1 =
Plugin created.

== Upgrade Notice ==

= 0.4 = 
This plugin is now discontinued, please install BP Profile Widgets instead.

= 0.3 =
Added Facebook and Youtube short URLs support. "Service" custom profile field no longer needed.

= 0.21 = 
Removed bug-testing data from the display.

= 0.2 = 
User can use the shortened Youtube URLs and the "Service" profile field is no longer needed.

= 0.15 = 
Added BuddyPress 1.5 support.

= 0.1 =
Plugin released.