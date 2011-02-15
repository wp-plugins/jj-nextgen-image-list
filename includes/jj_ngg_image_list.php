<?php

class JJ_NGG_Image_List extends WP_Widget
{
  
  function JJ_NGG_Image_List()
  {
    $widget_ops = array('classname' => 'jj-nexgen-image-list', 'description' => "Allows you to pick a gallery from the 'NextGen Gallery' plugin to use with as an Image List. You can list images vertically or horizontally.");
    $this->WP_Widget('jj-nexgen-image_list', 'JJ NextGEN Image List', $widget_ops);
  }
  
  function widget($args, $instance)
  {
    global $wpdb;
    extract($args);

    // Set params
    $title = apply_filters('widget_title', $instance['title']);
    $html_id = $this->get_val($instance, 'html_id', 'image_list');
    $order = $this->get_val($instance, 'order', 'asc', false);
    $shuffle = $this->get_val($instance, 'shuffle');
    $orientation = $this->get_val($instance, 'orientation');
    $limit = $this->get_val_numeric($instance, 'max_pictures');
    $gallery = $this->get_val_numeric($instance, 'gallery');
    $width = $this->get_val_numeric($instance, 'width');
    $height = $this->get_val_numeric($instance, 'height'); 
    $gap = $this->get_val_numeric($instance, 'gap');
    $center = $this->get_val($instance, 'center');    
    $shortcode = $this->get_val($instance, 'shortcode');  

    // Set defaults
    $vertical = true;
    if($orientation == 'horizontal')
    {
      $vertical = false;
    }
    if($gap == "0")
    {
      $gap == '';
    }    
    
    // SQL defaults
    $sql_order = '';
    $sql_where = ' WHERE exclude = 0';
    $sql_limit = '';
    
    // Set SQL order
    if($order == 'random')
    {
      $sql_order = 'RAND()';
    }
    elseif($order == 'asc') 
    {
       $sql_order = 'galleryid ASC';
    }        
    elseif($order == 'desc') 
    {
      $sql_order = 'galleryid DESC';
    }
    elseif($order == 'sortorder')
    {
      $sql_order = 'sortorder ASC';
    }
    else
    {
      $sql_order = 'galleryid ASC';
    }

    if($gallery != '')
    {
      $sql_where .= ' AND galleryid = ' . $gallery;
    }
    
    // Set limit defaults
    if(is_numeric($limit)) 
    {
      $sql_limit = ' LIMIT 0, ' . $limit;
    }        

    $results = $wpdb->get_results("SELECT * FROM $wpdb->nggpictures" . $sql_where . " ORDER BY " . $sql_order . $sql_limit);
    $p_size = 0;
    if(is_array($results))
    {
       $p_size = count($results);
    }
    
    $output = '';                
    if($p_size > 0) 
    {         
      if($title != '')
      {      
        if($shortcode != '1')
        {      
          $output .= "\n" . $before_title . $title . $after_title;
        }
        else
        {
          $output .= "\n<h3>" . $title . "</h3>";
        }
      }
           
      $container_class = " image_list_vertical";
      if(!$vertical)
      {
        $container_class = " image_list_horizontal";
      }
                       
      $wrapper_class = '';
      if($center == '1')
      {
        $wrapper_class = " image_list_center";
      }
      
      $gap_style = '';
      if($gap != '') {
        if($vertical)
        {
          $gap_style = "margin-bottom: " . $gap . "px;";
        }
        else
        {
          $gap_style = "margin-right: " . $gap . "px;";
          if($center == '1')
          {
            $gap_style .= " margin-left: " . $gap . "px;";
          }          
        }
        if($gap_style != '')
        {
          $gap_style = " style=\"" . $gap_style . "\"";
        }
      }      
      $gap_style_item = '';
                          
      $output .= "\n<div id=\"" . $html_id . "_container\" class=\"image_list_container" . $container_class . "\">";      
      $output .= "\n  <div id=\"" . $html_id . "\" class=\"image_list_wrapper" . $wrapper_class . "\">";
      if($vertical)
      {
        $output .= "\n    <ul class=\"image_list\">";
      }      
      $image_alt = null;
      $image_description = null;
      foreach($results as $result) 
      {
        $gallery = $wpdb->get_row("SELECT * FROM $wpdb->nggallery WHERE gid = '" . $result->galleryid . "'");
        foreach($gallery as $key => $value) 
        {
            $result->$key = $value;
        }        
        $image = new nggImage($result);    
        $image_alt = trim($image->alttext);   
        $image_description = trim($image->description);                   
                
        // check that alt is url with a simple validation
        $use_url = false;        
        if($image_alt != '' && (substr($image_alt, 0, 1) == '/' || substr($image_alt, 0, 4) == 'http' || substr($image_alt, 0, 3) == 'ftp'))
        {
          $use_url = true;
        }
        // if alt isn't a url make it the alt text to backwards support nextgen galleries
        elseif($image_alt != '') 
        {
          $image_description = $image_alt;
        }
        
        if($gap_style != '') 
        {
          $gap_style_item = $gap_style;
        }
        else
        {
          $gap_style_item = '';
        }
          
        if($vertical)
        {    
          $output .= "      \n<li class=\"image_list_item\">";
        }
        if($use_url != '')
        {
          $output .= "<a href=\"" . esc_attr($image_alt) . "\">";
        }
        
        if($image_description != '')
        {
          $image_description = "alt=\"" . esc_attr($image_description) . "\" ";
        }
        else
        {
          $image_description = '';
        }
                  
        $width_d = '';
        $height_d = '';
        if($width != '' && $height != '')
        {        
          $width_d = " width=\"" . $width . "\"";
          $height_d = " height=\"" . $height . "\"";  
        }     
        $output .= "<img src=\"" . $image->imageURL . "\" " . $image_description . $width_d . $height_d . " border=\"0\"" . $gap_style_item . " />";
        
        if($use_url != '')
        {
          $output .= "</a>";
        } 
        if($vertical)
        {  
          $output .= "</li>"; 
        }
      }
      if($vertical)
      {
        $output .= "\n    </ul>";
      }
      $output .= "\n  </div>";
      $output .= "\n</div>";

      // Add javascript
      if($order == 'random' && $shuffle == 'true')
      {
        $output .= "\n<script type=\"text/javascript\">";   
        if($vertical)
        {
          $output .= "\n  jQuery('div#" . $html_id . " ul.image_list').jj_ngg_shuffle();";       
        }
        else
        {
          $output .= "\n  jQuery('div#" . $html_id . "').jj_ngg_shuffle();";
        }
        $output .= "\n</script>\n";
      }
          
    }    
 
    if($shortcode != '1')
    {      
      echo $before_widget . "\n<ul class=\"ul_jj_image_list\">\n    <li class=\"li_jj_image_list\">" . $output . "\n    </li>\n  </ul>\n" . $after_widget;
    }
    else
    {
      echo $output;
    }
  }

  function get_val($instance, $key, $default = '', $escape = true)
  {
    $val = '';
    if(isset($instance[$key]))
    {
      $val = trim($instance[$key]);
    }
    if($val == '')
    {
      $val = $default;
    }
    if($escape)
    {
      $val = esc_attr($val);
    }
    return $val;
  }
  
  function get_val_numeric($instance, $key, $default = '')
  {
    $val = $this->get_val($instance, $key, $default, false);
    if($val != '' && !is_numeric($val))
    {
      $val = '';
    }
    return $val;
  }

  function form($instance)
  {
    global $wpdb;
    $instance = wp_parse_args((array) $instance, array(
      'title' => '',
      'gallery' => '',
      'html_id' => 'image_list',
      'order' => 'random',
      'shuffle' => 'false',
      'orientation' => 'vertical',
      'max_pictures' => '',
      'width' => '',
      'height' => '',
      'gap' => '5',
      'center' => ''
    ));
    $order_values = array('random' => 'Random', 'asc' => 'Latest First', 'desc' => 'Oldest First', 'sortorder' => 'NextGen Sortorder');
    $galleries = $wpdb->get_results("SELECT * FROM $wpdb->nggallery ORDER BY name ASC");
?>
  <p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><strong>Widget title:</strong></label><br />
    <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
  </p>
  <p>
    <label><strong>Select a gallery to use:</strong></label><br />
    <?php if(is_array($galleries) && count($galleries) > 0) { ?>
      <select id="<?php echo $this->get_field_id('gallery'); ?>" name="<?php echo $this->get_field_name('gallery'); ?>" class="widefat">
        <option value="">All images</option>
        <?php 
          $gallery_selected = '';        
          foreach($galleries as $gallery)
          {       
            if($gallery->gid == $instance['gallery'])
            {
              $gallery_selected = " selected=\"selected\"";
            }
            else
            {
              $gallery_selected = "";
            }
            echo "<option value=\"" . $gallery->gid . "\"" . $gallery_selected . ">" . $gallery->name . "</option>";
        } ?>
      </select>
    <?php }else{ ?>
      No galleries found
    <?php } ?>
  </p>  
  <p>
    <label for="<?php echo $this->get_field_id('order'); ?>"><strong>Order:</strong></label><br />
    <select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" class="widefat">
      <?php 
        $order_selected = '';        
        foreach($order_values as $key => $value) 
        {       
          if($key == $instance['order'])
          {
            $order_selected = " selected=\"selected\"";
          }
          else
          {
            $order_selected = "";
          }
          echo "<option value=\"" . $key . "\"" . $order_selected . ">" . $value . "</option>";
      } ?>
    </select>
  </p>
  <p>
    <label><strong>Shuffle:</strong> <small>(Only for random order)</small></label><br />
    <input type="radio" id="<?php echo $this->get_field_id('shuffle'); ?>_true" name="<?php echo $this->get_field_name('shuffle'); ?>" value="true" style="vertical-align: middle;"<?php if($instance['shuffle'] == 'true') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('shuffle'); ?>_true" style="vertical-align: middle;">true</label>
    <input type="radio" id="<?php echo $this->get_field_id('shuffle'); ?>_false" name="<?php echo $this->get_field_name('shuffle'); ?>" value="false" style="vertical-align: middle;"<?php if($instance['shuffle'] == 'false') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('shuffle'); ?>_false" style="vertical-align: middle;">false</label>          
  </p> 
    <p>
      <label><strong>Orientation:</strong></label><br />
      <input type="radio" id="<?php echo $this->get_field_id('orientation'); ?>_vertical" name="<?php echo $this->get_field_name('orientation'); ?>" value="vertical" style="vertical-align: middle;"<?php if($instance['orientation'] == 'vertical') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('orientation'); ?>_vertical" style="vertical-align: middle;">Vertical</label>
      <input type="radio" id="<?php echo $this->get_field_id('orientation'); ?>_horizontal" name="<?php echo $this->get_field_name('orientation'); ?>" value="horizontal" style="vertical-align: middle;"<?php if($instance['orientation'] == 'horizontal') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('orientation'); ?>_horizontal" style="vertical-align: middle;">Horizontal</label>          
    </p>    
  <p>
    <label for="<?php echo $this->get_field_id('max_pictures'); ?>"><strong>Max pictures:</strong> (Leave blank for all)</label><br />
    <input type="text" id="<?php echo $this->get_field_id('max_pictures'); ?>" name="<?php echo $this->get_field_name('max_pictures'); ?>" value="<?php echo $instance['max_pictures']; ?>" size="3" />
  </p>
  <p>
    <label for="<?php echo $this->get_field_id('html_id'); ?>"><strong>HTML id:</strong></label><br />
    <input type="text" id="<?php echo $this->get_field_id('html_id'); ?>" name="<?php echo $this->get_field_name('html_id'); ?>" value="<?php echo $instance['html_id']; ?>" class="widefat" />
  </p>  
  <p>
    <label for="<?php echo $this->get_field_id('width'); ?>"><strong>Image width:</strong></label><br />
    <input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" size="3" />
  </p>
  <p>
    <label for="<?php echo $this->get_field_id('height'); ?>"><strong>Image height:</strong></label><br />
    <input type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $instance['height']; ?>" size="3" />
  </p> 
  <p>
    <label for="<?php echo $this->get_field_id('gap'); ?>"><strong>Image gap:</strong></label><br />
    <input type="text" id="<?php echo $this->get_field_id('gap'); ?>" name="<?php echo $this->get_field_name('gap'); ?>" value="<?php echo $instance['gap']; ?>" size="3" />
  </p>      
  <p>
    <input type="checkbox" id="<?php echo $this->get_field_id('center'); ?>" style="vertical-align: middle;" name="<?php echo $this->get_field_name('center'); ?>" value="1"<?php if($instance['center'] == '1') { echo " checked=\"checked\""; } ?> />
    <label for="<?php echo $this->get_field_id('center'); ?>" style="vertical-align: middle;"><strong>Center content</strong></label><br />
  </p>  
<?php
  }

  function update($new_instance, $old_instance)
  {
    $new_instance['title'] = esc_attr($new_instance['title']);
    return $new_instance;
  }
}