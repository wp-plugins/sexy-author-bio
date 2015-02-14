=== Sexy Author Bio ===
Contributors: penguininitiatives
Tags: author bio, author bio plugin, authors plugin, plugin author, author biography, about the author plugin, signature, signature plugin, plugin author bio, author box, author description, author profile, author profile fields, author social icons, post author, profile fields, responsive author box, user profile, rel author, behance, blogger, delicious, deviantart, dribbble, facebook, flickr, github, google+, google plus, instagram, linkedin, myspace, pinterest, RSS, stumbleupon, tumblr, twitter, vimeo, wordpress, yahoo, youtube
Requires at least: 3.8
Tested up to: 4.1
Stable tag: 1.3.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress author bio plugin that adds a sexy, custom about the author box below your posts for single and multiple authors.

== Description ==

A WordPress author bio plugin that supports single and multiple authors. It offers tons of options to customize the box after WordPress posts about the author and most importantly makes it sexy lookin', rather than dull and bland.

The author bio box is responsive and includes five sexy social icon sets to choose from, with support for all the following social networks: Behance, Blogger, Delicious, DeviantArt, Dribbble, Facebook, Flickr, GitHub, Google+, Instagram, LinkedIn, MySpace, Pinterest, RSS, StumbleUpon, Tumblr, Twitter, Vimeo, WordPress, Yahoo! & YouTube.

= Credits =

* Plugin built and maintained by [@AndyForsberg](https://twitter.com/andyforsberg) of [Penguin Initiatives](http://penguininitiatives.com/).
* The included [Geekly](https://www.behance.net/gallery/Geekly-40-Flat-Icons/10357351) circular social icons are complements of [@Abdo_Ba](https://twitter.com/Abdo_Ba).
* This is a derivative work of the [Author Bio Box WordPress Plugin](http://wordpress.org/plugins/author-bio-box/), which was authored by [Claudio Sanches](http://profiles.wordpress.org/claudiosanches/).

= Latest from Penguin Initiatives =

* [Best WordPress Hosting](http://penguininitiatives.com/best-wordpress-hosting/)
* [Best Free & Premium WordPress Plugins by Category in 2014](http://penguininitiatives.com/best-wordpress-plugins/)
* [Fastest & Best WordPress Themes in 2014](http://penguininitiatives.com/fastest-wordpress-themes-2014/)

== Installation ==

* Upload plugin files to your plugins folder, or install using WordPress built-in Add New Plugin installer;
* Activate the plugin;
* Navigate to Settings -> Sexy Author Bio in order to customize any settings.
* Navigate to Users -> Your Profile and fill in the Contact Info, About Yourself & Author Signature Info fields. Do this for all authors on your website that have made posts (if you want this information to show up in their Sexy Author Bio).

= Add the box directly =

Use this shortcode:

	[sexy_author_bio]

...or this function:

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

= How do I allow the use of HTML in the user profile description field? =

* You can tell WordPress to allow HTML in user profile description fields by adding the following line of code to your active WordPress theme's function.php file:

	remove_filter('pre_user_description', 'wp_filter_kses');

== Screenshots ==

1. Example Sexy Author Bio Front-End Display #1
2. Example Sexy Author Bio User Settings
3. Example Sexy Author Bio Display & Design Settings

= How do I disable Gravatar Hovercards? =

* In the WordPress Admin Dashboard go to Settings > Discussion and then under the Avatars section uncheck Gravatar Hovercards "View people’s profiles when you mouse over their Gravatars" and then save your changes.

= What is the plugin license? =

* This plugin is released under a GPL license.

== Changelog ==

= 1.3.5 2/14/2015 =
* Added "Remove links from author avatar and name" option in Sexy Author Bio settings
* Adjusted company name so it still displays with or without the entry of a company URL
* Added "Allow Access For" option for setting Sexy Author Bio user fields access by WordPress User Roles

= 1.3.4 1/5/2015 =
* Added support for carriage returns in the user profile bio description field to accommodate paragraphs

= 1.3.3 1/4/2015 =
* Fixed Hide Signature option bug and replaced with a checkbox
* Added Hide Job Title checkbox option in user profile settings

= 1.3.2 12/24/2014 =
* Added link to GitHub repo.

= 1.3.1 12/24/2014 =
* Added email icon and email field to user profiles.
* Optimized all social icon images.

= 1.3 12/9/2014 =
* [Co-Authors Plus](https://wordpress.org/plugins/co-authors-plus/) Compatibility so long as the co-authors are standard WordPress Users (does not fully support Guest Authors)
* Added the following new customization options: Author Name Line Height, Author Name Font Weight, Author Byline Font Size, Author Byline Line Height, Author Byline Font, Author Byline Font Weight, Author Byline Capitalization, Author Byline Decoration, Author Biography Font Size, Author Biography Line Height, Author Biography Font, Author Biography Font Weight, Byline color & Icon Hover Effect
* Minor security tweaks

= 1.2 11/24/2014 =
* Added five new social icon sets to choose from, all with icons for all the following social networks: Behance, Blogger, Delicious, DeviantArt, Dribbble, Facebook, Flickr, GitHub, Google+, Instagram, LinkedIn, MySpace, Pinterest, RSS, StumbleUpon, Tumblr, Twitter, Vimeo, WordPress, Yahoo! & YouTube
* Added options to set icon size and icon spacing for social icons
* Added option to set border size for top, right, bottom and left separately
* Added option for users to set a custom Avatar URL
* Added Author's name as CSS Class to make it easy to use CSS to customize Sexy Author Bio for specific authors

= 1.1.1 11/24/2014 =
* Margin CSS Fix

= 1.1 11/23/2014 =
* Tons of CSS & HTML cleanup
* Added option to customize "Job Title Company Separator"
* Added fields to easily customize CSS in the plugin: Global Custom CSS, Desktop 1,200px +, IPAD LANDSCAPE 1019 - 1199px, IPAD PORTRAIT 768 - 1018px & SMARTPHONES
0 - 767px.
* Fixed issue with shortcode not working in widgets & listed shortcode in admin settings page
* Added basic Sexy Author Bio widget

= 1.0.4.1 11/15/2014 =
* Added help sidebar in Sexy Author Bio Admin Settings page

= 1.0.4 11/15/2014 =
* Added Author Links options: "Users set the link" or "Author avatar and name link to author page"
* Added Circle Social Icons Set
* Added rel="author"
* Added Settings link in the WordPress Installed Plugins page
* Updated Screenshots
* Updated Plugin Description and Tags

= 1.0.31 9/29/2014 =
* Added Shortcode
* Added Screenshots

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
