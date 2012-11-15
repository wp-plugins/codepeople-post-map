=== Google Post Map ===
Contributors: codepeople
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GZX2Y9BBJKWN2
Tags: google maps, shortcode, map, maps, categories, post map, point, marker, list, location, address, images, geocoder, google maps	
Requires at least: 3.0.5
Tested up to: 3.3.4
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

CodePeople Post Map allows to associate geolocation information to your posts and to integrate your blog with Google Maps in an easy and natural way.

== Description ==

**CodePeople Post Map** allows to insert a Google Map in a post or in any of the WordPress templates that display multiple posts.

The map inserted in a single post displays a marker at the position indicated by the geolocation information pertaining to the post, but also shows markers of the last posts published in related categories. The number of markers to display can be set in the plugin's settings.

The map inserted into a template displaying multiple posts will contain as many markers as posts making up the page with the associated geolocation info. When the mouse is hovered over the marker, the post to which it belongs gets highlighted.  

**CodePeople Post Map** has a wide range of settings to make your maps more versatile and adaptable.

**Features:**

*   The plugin is capable of dealing with **large volumes of dots or markers**.
*   Another way for users to discover **additional entries related** to the post.
*   The **location information** can be defined by physical address or point coordinates.
*   The location information and description may be used in posts search (**only for advanced plugin version**).
*   Allows addresses in **different languages**.
*   Allows to **insert a map** in the best position within your blog or simply **associate the geolocation information** to the post but without displaying the map.
*   Markers **customization**.
*   Based on **Google Maps Javascript API Version 3**.
*   Allows to embed maps in **multiple languages**.
*   Displays **markers** belonging to posts of the same categories.
*   **Several customization options** are available: initial zoom, width, height, margins, alignment, map type, map language, the way the map is displayed in a single post (either fully deployed or icon to display map), enable or disable map controls, the number of points plotted on a map, as well as the class that will be assigned to the post when the mouse hovers over the marker associated with the post.

If you want more information about this plugin or another one don't doubt to visit my website:

[http://wordpress.dwbooster.com](http://wordpress.dwbooster.com "CodePeople WordPress Repository")

== Installation ==

**To install CodePeople Post Map, follow these steps:**

1.	Download and unzip the plugin
2.	Upload the entire codepeople-post-map/ directory to the /wp-content/plugins/ directory
3.	Activate the plugin through the Plugins menu in WordPress

== Interface ==

**CodePeople Post Map** offers several setting options and is highly flexible. Options can be set up in the Settings page (and will become the **default setup** for all maps added to posts in the future), or may be **specific to each post** to be associated with the map (in this case the values are entered in the editing screen of the post in question.)

The settings are divided into two main groups, those belonging to the map and those belonging to the geolocation point.

**Map configuration options:**

*   Map zoom: initial map zoom.
*   Map width: Width of the map.
*   Map height: Height of the map.
*   Map margin: Margin of the map.
*   Map type: Select one of the possible types of maps to load (roadmap, satellite, terrain, hybrid).
*   Map language: a large number of languages is available to be used on maps, select the one that matches your blog's language.
*   Display map in post / page: When the map is inserted in a post you can select whether to display the map or display an icon, which displays the map, when pressed (if the map is inserted into a template that allows multiple posts, this option does not apply)
*   Options: This setting allows you to select which map controls should be available.
*   Enter the number of points on the post / page map: When the map is inserted into a post, points that belong to the same categories will be shown on the same map. This option allows you to set the number of points to be shown. When the map is inserted into a template that allows multiple posts this option does not apply.
*   Highlight post when mouse hovers over related point on map:  When the map is inserted into a template that allows multiple posts,  hovering the mouse over one of the points will highlight the associated post through assignment of a class in the next setup option. 
*   Highlight class: Name of the class to be assigned to a post to highlight when the mouse is hovered over the point associated with that post on the map.

**Configuration options related to the location points**

*   Location name: Name of the place you are indicating on the map, alternatively, the name of the post can be used.
*   Location description: Description of the place you are showing on the map. If left blank, the post summary will be used.
*   Select the thumbnail by clicking on the images: Select the thumbnail to associate with the localization point. The thumbnails are selected from the images in the gallery associated with the post.
*   Address: Physical address of the geolocation point.
*   Latitude: Latitude of the geolocation point.
*   Longitude: Longitude of the geolocation point.
*   Verify: This button allows you to check the accuracy of the geolocation point address by updating the latitude and longitude where necessary.
*   Select the marker by clicking on the images: Select the bookmark icon to show on the map.
*   Insert the map tag: Inserts a shortcode in the content of the post where the map is displayed with the features selected in the setup. You can attach geolocation information to a post but choose not to show a map in the content of the post. In case you do want to display a map in the post content, use this button.

== Frequently Asked Questions ==

= Q: How many maps I can insert into a post? =

A: Only one, because only one point location can be associated with a single post.

= Q: How to insert a map into a template? =

A: Load the template in which you want to place the map in the text editor of your choice and place the following code in the position where you want to display the map:
<? Php echo do_shortcode ('[post-map CodePeople]');?>

= Q: If I link geolocation information to a post but do not insert a map in it, will the geolocation information be available? =

A: If you have inserted a map into a template where multiple posts are displayed, then the geolocation information associated with posts is displayed on the map.

== Screenshots ==

1. Global maps settings
2. Point insertion's form 
3. Maps in action