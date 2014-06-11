=== Sexy Author Bio ===
Contributors: penguininitiatives
Tags: author, bio, biography, social, google plus, twitter
Requires at least: 3.8
Tested up to: 3.8
Stable tag: 1.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a sexy, customizable author bio section below your posts.

== Description ==

Adds a sexy, customizable author bio section below your posts.

= Credits =

* Initial idea by [Gustavo Freitas](http://gfsolucoes.net/).
* This is a derivative work of the [Author Bio Box WordPress Plugin](http://wordpress.org/plugins/author-bio-box/), which was authored by [Claudio Sanches](http://profiles.wordpress.org/claudiosanches/).

= Further Reading =

* Get the [best WordPress Hosting](http://penguininitiatives.com/best-wordpress-hosting-2014/).
* Get the [best free WordPress plugins](http://penguininitiatives.com/best-wordpress-plugins-free-2014/).
* Get the [best premium WordPress plugins](http://penguininitiatives.com/best-premium-wordpress-plugins-2014/).
* Get the [best WordPress themes](http://penguininitiatives.com/fastest-wordpress-themes-2014/).

== Installation ==

* Upload plugin files to your plugins folder, or install using WordPress built-in Add New Plugin installer;
* Activate the plugin;
* Navigate to Settings -> Sexy Author Bio in order to customize any settings.
* Navigate to Users -> Your Profile and fill in the Author Signature Info fields, Facebook, Twitter, Google Plus, LinkedIn and Biographical Info fields. Do this for all authors on your website that have made posts (if you want this information to show up in their Sexy Author Bio).

= Add the box directly =

Use this function:

	<?php 
		if ( function_exists( 'get_Sexy_Author_Bio' ) ) {
			echo get_Sexy_Author_Bio();
		}
	?>

== Frequently Asked Questions ==

= How do I customize the look and feel of Sexy Author Bio? =

* Once you've installed it simply go to your WordPress Admin Dashboard and then go to Settings > Sexy Author Bio

= How do I customize a user's Sexy Author Bio? =

* Once you've installed it simply go to your WordPress Admin Dashboard and then edit the user for which you want to customize the Sexy Author Bio. You'll see a section called "Author Signature Info" that contains Sexy Author Bio's customization options for the user.

= How do I disable Gravatar Hovercards? =

* In the WordPress Admin Dashboard go to Settings > Discussion and then under the Avatars section uncheck Gravatar Hovercards "View people’s profiles when you mouse over their Gravatars" and then save your changes.

= What is the plugin license? =

* This plugin is released under a GPL license.

== Changelog ==

= 1.0.3 6/11/2014 =

* Added Author Name Font Size options
* Added Author Name Font options
* Added Author Name Capitalization options
* Added Author Name Decoration options
* Added option to hide display of Sexy Author Bio for specific users
* Added a couple of FAQ's to make it more clear how to use the plugin

= 1.0.2 1/31/2014 =

* Cleaned up the styles.

= 1.0.1 12/26/2013 =

* Made it so Sexy Author Bio only shows up on posts of type post & adjusted margin above author names.

= 1.0.0 12/22/2013 =

* Initial version.

== License ==

Sexy Author Bio is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

Sexy Author Bio is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Sexy Author Bio. If not, see <http://www.gnu.org/licenses/>.
