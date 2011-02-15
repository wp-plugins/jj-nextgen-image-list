<?php
/*
Plugin Name: JJ NextGen Image List
Description: Allows you to pick a gallery from the 'NextGen Gallery' plugin to use with as an Image List. You can list images vertically or horizontally.
Author: JJ Coder
Version: 1.0.0
*/

if ( ! defined( 'WPJJNGG_IMAGE_LIST_PLUGIN_BASENAME' ) )
	define( 'WPJJNGG_IMAGE_LIST_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'WPJJNGG_IMAGE_LIST_PLUGIN_NAME' ) )
	define( 'WPJJNGG_IMAGE_LIST_PLUGIN_NAME', trim( dirname( WPJJNGG_IMAGE_LIST_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'WPJJNGG_IMAGE_LIST_PLUGIN_DIR' ) )
	define( 'WPJJNGG_IMAGE_LIST_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . WPJJNGG_IMAGE_LIST_PLUGIN_NAME );

function WPJJNGG_IMAGE_LIST_set_plugin_meta($links, $file) 
{
  $plugin = WPJJNGG_IMAGE_LIST_PLUGIN_BASENAME;  
  if ($file == $plugin) 
  {
    $links[] = '<a href="http://wordpress.org/extend/plugins/jj-nextgen-image-list/">' . 'Visit plugin site' . '</a>';    
    $links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=PSCMPVDADYP74&lc=NZ&item_name=JJNextGenImageList&item_number=jjcoder_image_list&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted">' . 'Donate' . '</a>';
  }
  return $links;
}
if( is_admin() )
{
  add_filter( 'plugin_row_meta', 'WPJJNGG_IMAGE_LIST_set_plugin_meta', 10, 2 );
}

require_once WPJJNGG_IMAGE_LIST_PLUGIN_DIR . '/includes/application.php';