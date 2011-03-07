=== JJ NextGen Image List ===
Contributors: JJ Coder
Donate link: http://www.redcross.org.nz/donate
Tags: image, picture, photo, widgets, gallery, images, nextgen-gallery
Requires at least: 2.8
Tested up to: 3.1
Stable tag: 1.0.3

Allows you to pick a gallery from the 'NextGen Gallery' plugin to list images from. You can list images vertically or horizontally.

== Description ==

The 'JJ NextGen List' allows you to create an image list as a widget or as a shortcode.
This plugin uses the 'NextGen Gallery' plugin for its images.

Requirements:

- NextGen Gallery Plugin (http://wordpress.org/extend/plugins/nextgen-gallery/)

NextGen Gallery Integration:

- This plugin uses the original width and height of the image uploaded so make sure the images are the correct dimensions when uploaded.
- If a width and height are defined under the configuration all images will be resized to those dimensions=.
- Alt & Title Text Field: Provide a full url here and the image will link to this. Only works if alt field starts with either of these; /, http, or ftp.
- Description Field: Will be used as image alt text. If alt text is present but not a valid url alt text will be used instead for image alt text.

You can specify the following parameters:

NOTE: sc means shortcode:

- Title: Title. Leave blank for no title. (sc: title="My Image List")
- Gallery: Leave blank to use all galleries or choose a gallery to use. (sc: gallery="galleryid")
- Order: Order to display results in. You can choose; Random, Latest First, Oldest First, or NextGen Sortorder. Random will still work when a page is cached. (sc: order="random"|"asc"|"desc"|"sortorder")
- Shuffle: If order is random and this is true will shuffle images with javascript. Useful if your are caching your pages. (sc: shuffle="true"|"false")
- Orientation: Can pick vertical or horizontal defaults to vertical. (sc: orientation="vertical"|"horizontal")
- Max pictures: The maximum amount of pictures to use. (sc: max_pictures="6")
- HTML id: HTML id to use. Defaults to 'image_list'. Needs to be different for multiple instances on same page. (sc: html_id="image_list")
- Image width: All images with be assigned this width. (sc: width="200")
- Image height: All images with be assigned this height. (sc: height="150")
- Image gap: Gap between images. (sc: gap="5")
- Center: Centers content in container. Requires width to be set. (sc: center="1")

Shortcode Examples:

- [jj-ngg-image-list html_id="about-image-list" gallery="1" width="200" height="150"]

Try out my other plugins:

- JJ NextGen JQuery Slider (http://wordpress.org/extend/plugins/jj-nextgen-jquery-slider/)
- JJ NextGen JQuery Carousel (http://wordpress.org/extend/plugins/jj-nextgen-jquery-carousel/)
- JJ NextGen JQuery Cycle (http://wordpress.org/extend/plugins/jj-nextgen-jquery-cycle/)
- JJ NextGen Unload (http://wordpress.org/extend/plugins/jj-nextgen-unload/)
- JJ SwfObject (http://wordpress.org/extend/plugins/jj-swfobject/)

== Installation ==

Please refer to the description for requirements and how to use this plugin.

1. Copy the entire directory from the downloaded zip file into the /wp-content/plugins/ folder.
2. Activate the "JJ NextGen Image List" plugin in the Plugin Management page.
3. Refer to the description to use the plugin as a widget and or a shortcode.

== Frequently Asked Questions ==

Question:

- How can I use plugin inside normal PHP code?

Answer:

- echo do_shortcode('[jj-ngg-image-list html_id="about-image-list" gallery="1" width="200" height="150"]');

Question:

- Doesn't work after upgrade? or Doesn't work with this theme?
  
Answer:

- Please check that you don't have two versions of jQuery loading, this is the problem most of the time. Sometimes a theme puts in <br> tags at the end of newlines aswell.

== Screenshots ==

1. Vertical images.
2. Horizontal images.

== Changelog ==

- 1.0.3: FAQ.
- 1.0.2: Donate to Christchurch Quake.
- 1.0.1: Shuffle should be working now. Gap tweaks.
- 1.0.0: First version.

== Contributors ==

JJ Coder