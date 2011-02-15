<?php

require_once WPJJNGG_IMAGE_LIST_PLUGIN_DIR . '/includes/functions.php';
require_once WPJJNGG_IMAGE_LIST_PLUGIN_DIR . '/includes/jj_ngg_image_list.php';

add_action( 'widgets_init', create_function('', 'return register_widget("JJ_NGG_Image_List");') );
add_shortcode( 'jj-ngg-image-list', 'jj_ngg_image_list_shortcode_handler' );

if( !is_admin() )
{
  add_action( 'init', 'WPJJNGG_IMAGE_LIST_enqueue_scripts' );
  add_action( 'init', 'WPJJNGG_IMAGE_LIST_enqueue_styles' );
}

?>