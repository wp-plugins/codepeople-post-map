=== CP Google Maps ===
Contributors: codepeople
Donate link: http://wordpress.dwbooster.com/content-tools/codepeople-post-map
Tags:google maps,shortcode,map,maps,categories,post map,point,marker,list,location,address,images,geocoder,google,shape,panoramio,grouping,cluster,exif tag,pin,place,streetview,post,posts,pages,widget,image,plugin,sidebar,stylize,admin
Requires at least: 3.0.5
Tested up to: 4.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

CP Google Maps allows to associate geolocation information to your posts and to integrate your blog with Google Maps in an easy and natural way.

== Description ==

Google Map features:

	► Insert a Google map in the best position within your blog
	► Deal with large volumes of dots or markers on the Google Maps
	► Uses Google Maps to discover additional entries related to the post
	► The location can be defined by physical address and point coordinates
	► Map markers customization
	► Allows to embed Google Maps in multiple languages
	► Allows several Google Maps controls and configuration options

**CP Google Maps** allows to insert a Google Maps in a post or in any of the WordPress templates that display multiple posts.

The Google Maps inserted in a single post displays a marker at the position indicated by the geolocation information pertaining to the post, but also shows markers of the last posts published in related categories. The number of markers to display on the Google Maps can be set in the plugin's settings.

The Google Maps inserted into a template displaying multiple posts will contain as many markers as posts making up the page with the associated geolocation info. When the mouse is hovered over the marker, the post to which it belongs gets highlighted.  

**Google Maps** has a wide range of settings to make your maps more versatile and adaptable.

**More about the Main Features:**

*   The plugin is capable of dealing with **large volumes of dots or markers**.
*   Another way for users to discover **additional entries related** to the post.
*   The **location information** can be defined by physical address and point coordinates.
*   Allows to **insert the Google maps** in the best position within your blog or simply **associate the geolocation information** to the post but without displaying the Google maps.
*   Markers **customization**.
*   Allows to display or hide the bubbles with markers information.
*   Allows to display a bubble opened by default.
*   Based on **Google Maps Javascript API Version 3**.
*   Allows to embed Google maps in **multiple languages**.
*   Displays **markers** belonging to posts of the same categories.
*   **Several customization options** are available: initial zoom, width, height, margins, alignment, map type, map language, the way the map is displayed in a single post (either fully deployed or icon to display the Google maps), enable or disable map controls, the number of points plotted on a Google map, as well as the class that will be assigned to the post when the mouse hovers over the marker associated with the post.

**Premium Features:**

*   Allows to load all points that belong to a specific category.
*   Allows to load the points associated to all posts.
*   Allows to display the points that belong to the posts with a specific tag.
*   The location information and description may be used in posts search.
*   Allows to associate multiple Google maps points to each post/page.
*   Allows to draw routes through points in the same post.
*   Allows to draw shapes on map.
*   Allows to create a legend with categories, tags, or custom taxonomies, and display or hide the points, checking or unchecking legend items.
*   Allows to display a link to get directions to the point.
*   Allows to display a link to open the point directly on Google Maps.
*   Allows to display a link to display directly the street view in the specific point.
*   Allows to display multiple maps in the same post/page (but displays the same points in all maps on page). 
*   Allows to insert the map as widget on sidebars.
*   Allows to styling the map.
*   Allows to display the Panoramio layer on map.
*   Allows grouping multiple markers in a cluster.
*   Allows to display the user location on map.
*	Generates dynamic points from the geolocation information, stored in the image's metadata when it is uploaded to WordPress.
*	Generates dynamic points on map, relative to the geolocation information, assigned to the posts from WordPress App.
*   Allows to associate the Google maps with any public post_type in WordPress.
*   In non singular webpages, Google Maps display a map for each post.

The third, and most extended version of the plugin is the "Developer Version". The Developer version of the plugin includes all features of the Premium version, and the features listed below:
  
**Developer Features**

*   Allows design a Contact Form, and associate it with the points
*   Allows send notification emails with the information included in the form by the users
*   Allows associate an email address to the points, to contact a different person by each point, or a global email address to be notified from all points
*   Allows to use the image associated with the point as the point's icon on map
*   Allows to export all points defined in the website to a CSV file
*   Allows to import the points from a CSV file

**Demo of the Developer Version of Plugin**

[http://demos.net-factor.com/cp-google-maps/wp-login.php](http://demos.net-factor.com/cp-google-maps/wp-login.php "Click to access the administration area demo")

[http://demos.net-factor.com/cp-google-maps/](http://demos.net-factor.com/cp-google-maps/ "Click to access the Public Page")


Note 1: To display all points that belong to a specific category, it is required to insert the following shortcode [codepeople-post-map cat="3"]. The number 3 represent the category ID, replace this number by the corresponding category's ID. To insert the code directly in a template, the snippet of code is:

            <?php echo do_shortcode('[codepeople-post-map cat="3"]'); ?>
			
Note 2:	To display all points that belong to more than one category, separate the categories IDs with the comma symbol [codepeople-post-map cat="3,5"]. The numbers 3 y 5 are the categories IDs, replace these numbers by the corresponding categories IDs. To insert the code directly in a template, the snippet of code is:

            <?php echo do_shortcode('[codepeople-post-map cat="3,5"]'); ?>
            
Note 3: To display all points in the website, use -1 as the category's ID: [codepeople-post-map cat="-1"] or  <?php echo do_shortcode('[codepeople-post-map cat="-1"]'); ?> for template.

Note 4:	To display all points that belong to the posts with a specific tag assigned, for example the tag name "mytag", use the shortcode's attribute "tag", like follows: [codepeople-post-map tag="mytag"]. To insert the code directly in a template, the snippet of code is:

            <?php echo do_shortcode('[codepeople-post-map tag="mytag"]'); ?>
			
If you prefer configure your map directly from the shortcode, then you must enter an attribute for each map feature to specify. For example:
            
            [codepeople-post-map width="500" height="500"]

The complete list of allowed attributes are:

Very Important. Some of attributes are available only in the premium version of the plugin.
            
width:  Values allowed, number or percentage. Defines the map's width. [codepeople-post-map width="300"] or [codepeople-post-map width="100%"]

height:  Values allowed, number or percentage (In the web's development, the height in percentage is effective only if the parent element has a height defined). Defines the map's height. [codepeople-post-map height="300"]

align:  Values allowed, left, right, center. Aligns the map's container to the left, right or center. [codepeople-post-map align="center"]

dynamic_zoom:  Values allowed, 1 or 0. Adjust the zoom of map dynamically to display all points on map at the same time. [codepeople-post-map dynamic_zoom="1"]

zoom:  Accepts a number to define the map's zoom. To apply a zoom to the map, the dynamic zoom should be 0. [codepeople-post-map dynamic_zoom="0" zoom="5"]

type:  Values allowed, SATELLITE, ROADMAP, TERRAIN and HYBRID. Select the type of map to display. [codepeople-post-map type="ROADMAP"] 

language:  Values allowed, en for English, es for Spanish, pt for Portuguese, etc. (for the complete list, check the Google Maps documentation). Select a language to display on map. [codepeople-post-map language="en"]

route:  Values allowed, 0 or 1. Draw or not the route between points in a same post or page. [codepeople-post-map route="1"]

mode:  Values allowed, DRIVING, BICYCLING and WALKING. Define the type of route. [codepeople-post-map route="1" mode="DRIVING"]

show_window:  Values allowed, 0 or 1. To enable or disable the infowindows. [codepeople-post-map show_window="1" ]

show_default:  Values allowed, 0 or 1. Display or not an infowindow expanded by default. [codepeople-post-map show_window="1" show_default="1"]

panoramiolayer:  Values allowed, 0 or 1. Displays a layer with pictures of places. [codepeople-post-map panoramiolayer="1"]

markerclusterer:  Values allowed, 0 or 1. Displays a cluster with the number of points in an area. [codepeople-post-map markerclusterer="1"]

mousewheel:  Values allowed, 0 or 1. Enables the map's zoom with the mouse wheel. [codepeople-post-map mousewheel="1"]

zoompancontrol:  Values allowed, 0 or 1. Displays or hide the zoom and pan controls. [codepeople-post-map zoompancontrol="1"]

typecontrol:  Values allowed, 0 or 1. Displays or hide the type control. [codepeople-post-map typecontrol="1"]

streetviewcontrol:  Values allowed, 0 or 1. Displays or hide the street-view control. [codepeople-post-map streetviewcontrol="1"]

defaultpost: Defines the post ID, for centring the map, and display by default the infowindow corresponding to the first point associated to this post. [codepeople-post-map defaultpost="396"]

legend:  Accepts a taxonomy name as value. Some common taxonomies names are:  category and post_tag, for the categories and tags, respectively. Displays the legend with the list of elements that belong to the taxonomy and are assigned to the posts associated with the points. [codepeople-post-map legend="category"]

legend_title:  Text to be used as legend title. [codepeople-post-map legend="category" legend_title="Select the categories to display on map"]

legend_class:  Class name to be assigned to the legend. The legend design may be modified through CSS styles. Creates a class name, with the styles definition, and associates the new class name to the legend through the legend_class attribute. [codepeople-post-map legend="category" legend_class="my-legend-class"]

tag:  Tags slugs separated by ",". Displays on map the points whose posts have assigned the tags.[codepeople-post-map tag="tag1,tag2,tag3"]

cat:  Categories IDs separated by "," or -1. Displays on map the points whose posts belong to the categories. The special value -1, allows display on map all points defined in the website.[codepeople-post-map cat="2,4,56"] [codepeople-post-map cat="-1"]

excludecat:  Categories IDs to exclude, separated by ",". From points to be displayed on map, the plugin excludes the points whose posts belong to the categories to exclude. [codepeople-post-map tag="tag1,tag2" excludecat="4"]

excludepost:  Posts IDs to exclude separated by ",". [codepeople-post-map cat="-1" excludepost="235,260"]

excludetag:  Tags IDs to exclude separated by ",". [codepeople-post-map excludetag="2,13"]

taxonomy:  The taxonomy is a special attribute that should be combined with other attributes, depending of taxonomies to use for points filtering. Suppose the website includes two new taxonomies:  taxonomyA and taxonomyB, and the map should display all points that belong to the posts with the value T1 for taxonomyA, and T3,T4 for taxonomyB, the shortcode would be:  [codepeople-post-map taxonomy="taxonomyA,taxonomyB" taxonomyA="T1" taxonomyB="t2,t3"]

Note 5: The geolocation information is stored in image's metadata from mobiles or cameras with GPS devices.

Note 6: Some plugins interfere with the shortcodes replacements, and provokes that maps don't be loaded correctly, in this case should be passed a new parameter through the shortcode print=1

Passing the parameter print=1, displays the map at beginning of page/post content.

Note 7: To display all points in posts with a specific taxonomy assigned, or multiple taxonomies, should be used the "taxonomy" attribute in the shortcode, with the list of all taxonomies separated by the comma symbol, for example: taxonomy="taxonomy1,taxonomy2", and a new attribute for each taxonomy with the values corresponding. For example if you want select the points that belong to the posts with the values: "value1" for "taxonomy1", the shortcode would be: [codepeople-post-map taxonomy="taxonomy1" taxonomy1="value1"], for multiple taxonomies: [codepeople-post-map taxonomy="taxonomy1,taxonomy2" taxonomy1="value1" taxonomy2="value2,value3"].

If you want more information about this plugin or another one don't doubt to visit my website:

[http://wordpress.dwbooster.com](http://wordpress.dwbooster.com "CodePeople WordPress Repository")

== Installation ==

**To install CP Google Maps, follow these steps:**

1.	Download and unzip the plugin
2.	Upload the entire codepeople-post-map/ directory to the /wp-content/plugins/ directory



3.	Activate the plugin through the Plugins menu in WordPress

== Interface ==

**Google Maps** offers several setting options and is highly flexible. Options can be set up in the Settings page (and will become the **default setup** for all maps added to posts in the future), or may be **specific to each post** to be associated with the Google maps (in this case the values are entered in the editing screen of the post in question.)

The settings are divided into two main groups, those belonging to the Google maps and those belonging to the geolocation point.

**Google Maps configuration options:**

*   Map zoom: Initial map zoom.
*   Dynamic zoom: Allows to adjust the map's zoom dynamically to display all points at the same time.
*   Map width: Width of the map.
*   Map height: Height of the map.
*   Map margin: Margin of the map.
*   Map align: Aligns the map at left, center or right of area.
*   Map type: Select one of the possible types of maps to load (roadmap, satellite, terrain, hybrid).
*   Map language: a large number of languages is available to be used on maps, select the one that matches your blog's language.
*   Allow drag the map: allows drag the map to see other places.
*   Map route: Draws the route through the points that belong to the same post (available only in the premium version of plugin)
*   Travel Mode: Travel mode used in route drawing (available only in the premium version of plugin) 
*   Show info bubbles: display or hide the bubbles with the information associated to the points.
*   Display a bubble by default: display  a bubble opened by default.
*   Display map in post / page: When the Google maps are inserted in a post you can select whether to display the Google maps or display an icon, which displays the map, when pressed (if the Google maps are inserted into a template that allows multiple posts, this option does not apply)
*   Options: This setting allows you to select which map controls should be available.
*	Display the Panoramio layer: Displays a new layer on map with images published in Panoramio (available only in the premium version of plugin)
*	Display a bundle of points in the same area, like a cluster: Allows grouping multiple points in a cluster (available only in the premium version of plugin)
*	Display the user's location: Displays a marker with the location of user that is visiting the webpage (available only in the premium version of plugin)
*	Title of user's location: Enter the title of infowindow belonging to the user's marker (available only in the premium version of plugin)
*	Display the get directions link: Displays a link in the infowindow to get the directions to the point (available only in the premium version of plugin)
*	Display a link to Google Maps: Displays a link in the infowindow to load the point directly on Google Maps.
*	Display a link to Street View: Displays a link in the infowindow to display the street view in the specific point.
*   Enter the number of points on the post / page map: When the Google maps are inserted into a post, points that belong to the same categories will be shown on the same Google map. This option allows you to set the number of points to be shown. When the Google maps are inserted into a template that allows multiple posts this option does not apply.
*   Generate points dynamically from geolocation information included on images, when images are uploaded to WordPress: If the image uploaded to WordPress includes geolocation information is generated a point with related to the geolocation information.
*   Generate points dynamically from geolocation information included on posts: Displays new points on maps, if the post includes geolocation information, generated by WordPress App.
*   Allow stylize the maps: Allows to define a JSON object to stylize the maps.
*   Display maps legends: Check the option to display a legend with categories, tags, or custom taxonomies, to display or hide the points on map dynamically.
*   Select the taxonomy to display on legend: Select the taxonomies to display on legend.
*   Enter a title for legend: Enter the title to display in the legend.
*   Enter a classname to be applied to the legend: To customize the legend appearance, associate to it a classname, and set the class definition in any of style files in your website.
*   Highlight post when mouse hovers over related point on map:  When the Google maps are inserted into a template that allows multiple posts,  hovering the mouse over one of the points will highlight the associated post through assignment of a class in the next setup option. 
*   Highlight class: Name of the class to be assigned to a post to highlight when the mouse is hovered over the point associated with that post on the Google map.
*   Use points information in search results: Allows search in the points information ( Available only in the premium version of plugin )
*	Allow to associate a map to the post types: Allows to associate points to custom post types in website ( Available only in the premium version of plugin )

**Configuration options related to the location points**

*   Location name: Name of the place you are indicating on the Google maps, alternatively, the name of the post can be used.
*   Location description: Description of the place you are showing on the Google maps. If left blank, the post summary will be used.
*   Select an image from media library: Select an image to associate with the localization point.
*   Address: Physical address of the geolocation point.
*   Latitude: Latitude of the geolocation point.
*   Longitude: Longitude of the geolocation point.
*   Verify: This button allows you to check the accuracy of the geolocation point address by updating the latitude and longitude where necessary.
*   Select the marker by clicking on the images: Select the bookmark icon to show on the Google maps.
*   Insert the map tag: Inserts a shortcode in the content of the post where the Google map is displayed with the features selected in the setup. You can attach geolocation information to a post but choose not to show the Google maps in the content of the post. In case you do want to display a map in the post content, use this button.

**Configure Shapes**

*   Check the box over the "Insert the map tag" button.
*   Enter the stroke weight of shape.
*   Enter the color of shape.
*   Enter the opacity of shape.
*   Press with the mouse on map at right to draw the shape.

**Inserting maps as widgets on sidebars** (Available only in the premium version of plugin)

To insert the maps as widget on sidebars, go to the menu option "Appearance / Widgets", and drag the "CP Google Maps" widget to the sidebar. 

It is possible define, for each map on sidebar, all attributes available with the format attr="value". The map's width is set to the 100% of sidebar by default.

**Translations**

The CP Google Maps uses the English language by default, but includes the following language packages:

* Spanish
* French

Note: The languages packages are generated dynamically. If detects any errors in the translation, please, contact us to correct it.

== Frequently Asked Questions ==

= Q: Why the map's tag is not inserted on page content? =

A: There are some content editors, available as WordPress plugins, that provoke some compatibility issues with WordPress, in this case you should type the shortcode manually:
[codepeople-post-map]

= Q: How many maps I can insert into a post? =

A: In the free version of plugin only one map with only one point associated in each post/page. In the premium version of plugin it is possible associate multiple points to the post and insert multiple shortcodes ( if there are multiple maps included in the same post/page, all of them will display the same points)

= Q: How to insert Google maps into a template? =

A: Load the template in which you want to place the map in the text editor of your choice and place the following code in the position where you want to display the Google maps:

        <?php echo do_shortcode ('[codepeople-post-map]'); ?>    

= Q: Is possible to load all points that belong to the posts with  a tag assigned? =

A:	To display all points that belong to the posts with a specific tag assigned, for example the tag name "mytag", use the shortcode's attribute "tag", like follows: [codepeople-post-map tag="mytag"]. To insert the code directly in a template, the snippet of code is:

        <?php echo do_shortcode('[codepeople-post-map tag="mytag"]'); ?>    

= Q: Is possible to load all points in a category? =

A: To display all points that belong to a specific category, it is required to insert the following shortcode [codepeople-post-map cat="3"]. The number 3 represent the category ID, replace this number by the corresponding category's ID. To insert the code directly in a template, the snippet of code is: 

        <?php echo do_shortcode ('[codepeople-post-map cat="3"]'); ?>    

= Q: How to exclude the points in a category? =

A: To exclude the points that belong to a specific category, or various categories, inserts the attribute excludecat in the shortcode [codepeople-post-map excludecat="3,4"]. The number 3 and 4 represent the categories IDs.

= Q: How to exclude the points in a post? =

A: To exclude the points that belong to a post, or various posts, inserts the attribute excludepos in the shortcode [codepeople-post-map excludepost="3,4"]. The number 3 and 4 represent the posts IDs.

= Q: How to exclude the points in posts with tag? =

A: To exclude the points that belong to the post with a specific tag, or various tags, inserts the attribute excludetag in the shortcode [codepeople-post-map excludetag="3,4"]. The number 3 and 4 represent the tags IDs.

= Q: Is possible to load all points in more than one category? =

A: To display all points that belong to multiple categories, it is required separate the categories IDs with comma "," [codepeople-post-map cat="3,5"]. The numbers 3 and 5 are the categories IDs, replace these numbers with the corresponding categories IDs. To insert the code directly in a template, the snippet of code is: 

        <?php echo do_shortcode ('[codepeople-post-map cat="3,5"]'); ?>    

= Q: Is possible to load all points in the website? =

A: To display all points in the website use -1 as the category ID: [codepeople-post-map cat="-1"] or &lt;?php echo do_shortcode ('[codepeople-post-map cat="-1"]'); ?&gt; for template.

= Q: If I link geolocation information to a post but do not insert a Google map in it, will the geolocation information be available? =

A: If you have inserted a Google map into a template where multiple posts are displayed, then the geolocation information associated with posts is displayed on the map.

= Q: How can I disable the information window of point opened by default? =

A: Go to the settings of map (the settings page of plugin for settings of all maps, or the settings of a particular map), and uncheck the option "Display a bubble by default"

= Q: How can I disable all information windows of points? =

A: Go to the settings of map (the settings page of plugin for settings of all maps, or the settings of a particular map), and uncheck the option "Show info bubbles"

= Q: How can I stylize the maps? =

A: In the premium version of plugin is possible define a JSON object to stylize the maps: the maps' colors, labels, etc.

= Q: How can I use different icons, in the points markers?  =

A: To use your own icons, you only should to upload the icons images to the following location: "/wp-content/plugins/codepeople-post-map/images/icons/", and then select the image from the list in the point's definition.

= Q: How can I use particular settings in a map? =

A: You may use a particular settings in a map, defining the options directly as attributes of shortcode: [codepeople-post-map width="100%"]

If you are inserting the map in a particular page/post, you may check the field named "Use particular settings for this map", and then entering the particular values in the settings options.

= Q: Is possible to display the map as responsive design? =

A: Yes, that is possible, you only should to define the width of map with values in percent. For example: 100%
Pay attention the height definition with percent is not recommended, because it is only possible if the map's container has a fixed height.

= Q: How to get the directions to the point? =

A: Go to the settings page of plugin and check the box to display the "Get directions" link in the infowindow. The "Get directions" link will be displayed in the infowindow.

= Q: How to open the point on Google Maps? =

A: If you want to display a link to open the point directly on Google Maps, go to the settings page of plugin, and checks the box to display the link in the infowindow.

= Q: Could I insert the map as widget? =

A: Yes, you can. Go to the menu option: "Appearance / Widgets" and insert the "CP Google Maps" widget on side bar.

= Q: My images include geolocation information. Is possible use the geolocaion information stored in the image to generate points on map? =

A: Go to the settings page of plugin and select the corresponding option to allow processing the information stored on image's metadata, and then if an image uploaded to WordPress, includes geolocation information, will be generated a point with this information dynamically, that will be displayed on map.

= Q: Why the maps are not showing on website? =

A: Some plugins interfere with the shortcodes replacements, and provokes that maps don't be loaded correctly, in this case should be passed a new parameter through the shortcode print=1
Passing the parameter print=1, displays the map at beginning of page/post content.

= Q: How can I change the route between address? =

A: The route depends on the order of the points. If you want change the route, you should change the order of point. Takes the point by the handle's icon, and drag it to its correct position in the points list.

= Q: How can I centring the map in a point defined a specific post, and display its infowindow? =

A: Use the "defaultpost" attribute, in the map's shortcode, like follow:

[codepeople-post-map defaultpost="231"]

The number is the post's ID

= Q: I've configured the sizes of the map to be displayed with a responsive design, but the map is not showing =

A: To display the maps with a responsive design, you should define the map's width with percentages (for example 100% if you want that the map width be the same that its container), but PAY ATTENTION, in web development the treatment of the width and height is different. The page width is limited by the browser's width, but with the height it is not apply. So, you should enter a fixed height(for example 320px). 

The only way to define the map's height in percentages, is if the element that contain the map has defined a fixed height.

= Q: Can be inserted a link in the infowindow? =

A: It is possible insert links, and any other HTML element in the infowindow. You only should insert HTML tags directly in the point description. For example, to insert a link to our web page: &lt;a href="http://wordpress.dwbooster.com"&gt;Click Here&lt;/a&gt;

= Q: After entering an address, and to press the verify button, the address is modified, and the pin is displayed in a different location =

A: If after pressing the "verify" button, the address is modified dynamically, and the pin is displayed in another location, the cause is simple. If Google does not recognize an address, it uses the nearest known address, and displays the pin on this location. 

To solve the issue, you simply should drag and drop the pin in the correct location, and type the address again, but this time "DON'T PRESS AGAIN THE VERIFY BUTTON".

= Q: Can be hidden the local listings from Google Maps API? = 

A: Yes of course, if you want hide the local listings from Google Maps API, open the settings page of plugin, select the "Allow stylize the maps" attribute, and finally, paste the following code in the textarea:

        [       
            {       
                featureType: "poi",     
                stylers: [      
                  { visibility: "off" }     
                ]           
            }       
        ]       
        
= Q: I've inserted an image in the page, but have not been generated a new point in the map =

A: First, be sure you have checked the option "Generate points dynamically from geolocation information included on images, when images are uploaded to WordPress", from the settings page of the plugin.

Second, be sure the image includes the Exif tags with the geolocation information (latitude and longitude)

Finally, you should upload the image from the "Add Media" button of the page or post, and not from the media library.

= Q: Can be generated a point from the page publication, with the location of the author? =

A: Yes, that is possible but only from the WordPress App, available for iPhone, iPad and Android, with the option for sharing the location enabled in the application. Furthermore, from the settings page of the plugin, should be checked the option: "Generate points dynamically from geolocation information included on posts"

= Q: Can be searched in the website by the points information? =

A: If was checked the option "Use points information in search results", from the settings page of the plugin. The searching process will consider the points information too, and the posts and pages resulting could be selected by its points.

Pay attention, the results of search will be the posts and pages that include the points, not the point directly.

= Q: What styles are used in the infowindows? = 

A: The design of infowindows is defined through styles in the cpm-styles.css file, located in "/wp-content/plugins/codepeople-post-map/styles/cpm-styles.css", specifically with the styles:

        .cpm-infowindow {margin:0; padding:0px; min-height:80px; font-size:11px; clear:both;}       
        .cpm-infowindow .cpm-content {float:left;width:100%; color:black;}      
        .cpm-infowindow .cpm-content .title {font-size:12px; line-height: 18px; font-weight:bold; color:black;}     
        .cpm-infowindow .cpm-content .address {font-weight:bold; font-size:9px;}        
        .cpm-infowindow .cpm-content .description {font-size:10px;}     

= Q: Can be highlighted the post or page related with the point on map? =        

A: From the settings page of the plugin, there are two options:

* Highlight post when mouse move over related point on map
* Highlight class

If you check the option: "Highlight post when mouse move over related point on map", and enter a class name in the "Highlight class" attribute, in the maps inserted on pages with multiple entries, the class name will be applied to the post, or page, when the mouse is moved over a point associated in the corresponding page or post.

== Screenshots ==

01. Maps in action
02. Styling the maps
03. Map with Panoramio layer
04. Map with user's location
05. Map with shape
06. Global maps settings
07. Point insertion's form 
08. Inserting map on sidebars
09. Generates points, from the geolocation information stored on image's metadata
10. Contact Form Builder (only available in the Developer version of the plugin)
11. Associate the contact form with the point, and define an email address between the point's data (only available in the Developer version of the plugin)
12. Export/Import section (only available in the Developer version of the plugin)

== Changelog ==

= 1.0.1 =

* Allows to get the latitude and longitude of points from the point definition
* Corrects some conflicts with styles defined in some themes that interfere  with the map styles.
* Allows display the map, in themes that use AJAX to load the posts and pages.
* Corrects some issues related with the update in the version of jQuery Framework, and force the inclusion of jQuery if it is not loaded by the website.
* Improves the plugin interface to allow modify the maps settings easily.
* Allows controlling the maps settings directly through attributes in the shortcode.
* Corrects an issue with the insertion of maps with a responsive design.
* Allows insert links in the points description.
* Include online demos.
* Change the icons URL to preserve the references with domain changes.
* Allows display and hide map when is inserted like an icon in page.
* Allows the selection of point images as thumbnail to optimize the page load.
* Changes the HTML generated to meet the W3C validation
* Include the use of nonce fields to protect the maps settings form.
* The Google Api is loaded with the same schema of webpage, and use https if it is required.

= 1.0 =

* Insert a Google Map in template files page with multiple entries.
* Improves of meta-boxes calling.
* Correct some bugs in Internet Explorer 8.
* Integrate the Google Map with non-standard WordPress themes.
* Allows the use of language files in the plugin
* Allows set an icon by default in the points of map.
* Uses Google Maps to discover additional entries related to the post
* The location can be defined by physical address and point coordinates
* Allows the map markers customization
* Allows to embed Google Maps in multiple languages
* Allows several Google Maps controls and configuration options

= 0.9b =

* First stable version released