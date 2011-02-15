<?php

function WPJJNGG_IMAGE_LIST_plugin_url( $path = '' )
{
  return plugins_url( $path, WPJJNGG_IMAGE_LIST_PLUGIN_BASENAME );
}

function WPJJNGG_IMAGE_LIST_enqueue_scripts()
{
  if( !is_admin() )
  {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-shuffle', WPJJNGG_IMAGE_LIST_plugin_url( 'script/jquery.jj_ngg_shuffle.js' ), array('jquery'), '', false );
  }
}

function WPJJNGG_IMAGE_LIST_enqueue_styles()
{
  if( !is_admin() )
  {
    wp_enqueue_style( 'image-list-style', WPJJNGG_IMAGE_LIST_plugin_url( 'stylesheets/style.css' ), array(), '', 'all' );
  }
}

function WPJJNGG_IMAGE_LIST_use_default($instance, $key)
{
  return !array_key_exists($key, $instance) || trim($instance[$key]) == '';
}

function jj_ngg_image_list_shortcode_handler($atts)
{
  $instance = array();
  foreach($atts as $att => $val)
  {
    $instance[wp_specialchars($att)] = wp_specialchars($val);
  }

  // Set defaults
  if(WPJJNGG_IMAGE_LIST_use_default($instance, 'html_id')) { $instance['html_id'] = 'image_list'; }
  if(WPJJNGG_IMAGE_LIST_use_default($instance, 'order')) { $instance['order'] = 'random'; }
  $instance['shortcode'] = '1';

  ob_start();
  the_widget("JJ_NGG_Image_List", $instance, array());
  $output = ob_get_contents();
  ob_end_clean();

  return $output;
}

?>