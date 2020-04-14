<?php
/*
  Plugin Name: Cute Post Image Gallery
  Plugin URI: Plugin URI: http://themeforest.net/user/torbara/
  Description: Display post image gallery
  Author: ovvod
  Version: 1.0.0
  Author URI: 
 */

class CutePostGallery extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CutePostGallery', 'description' => 'Display posts images');
        parent::__construct('CutePostGallery', 'Cute Post Image Gallery', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Post Image Gallery";
        }
        
        ?>
<p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                Title: 
                <input class="widefat" 
                        id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                        name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                        type="text" 
                        value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('toptext'); ?>">
                Top text: 
                <textarea class="widefat" 
                        id="<?php echo $this->get_field_id('toptext'); ?>" 
                        name="<?php echo $this->get_field_name('toptext'); ?>" 
                        rows="5" 
                        cols="40"><?php echo $instance['toptext']; ?></textarea>
            </label>
        </p>
        
        <?php
        // jQuery
        wp_enqueue_script('jquery');
        // This will enqueue the Media Uploader script
        wp_enqueue_media(); 
        // OpenMediaFrame scripts
        wp_enqueue_script('upload_media_widget', plugin_dir_url(__FILE__) . 'upload-media.js', array('jquery'));
        ?>
        
        <?php $images_id = isset( $instance['images_id'] ) ? $instance['images_id'] : ""; ?>
        
        <div>
            <label for="images_id">Images:</label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('images_id')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('images_id')); ?>" 
                   type="hidden"
                   value="<?php echo esc_attr($images_id); ?>" />
            <a href="#" class="button" onclick="OpenMediaFrame(jQuery(this).prev()); return false;">Select Images</a>
        </div>


        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['toptext'] = $new_instance['toptext'];
        $instance['images_id'] = $new_instance['images_id'];        
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);

        echo $before_widget;
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        
        // If no selected images
        if(empty($instance['images_id'])){
            echo '<div class="uk-alert uk-alert-danger">Please select images in widget settings</div>';
            return ;
        }

        $aoi = array(); // Array with images data
        $imgIDs = explode(",", $instance['images_id']); // Images IDs
        foreach ($imgIDs as $imgID) {
            $imgData = wp_prepare_attachment_for_js ( $imgID );
            if ( $imgData == NULL ) { continue; } //If an ID picture is, and the image is not - skipping, we go to the next element of the array
            if(trim($imgData["caption"])==""){$imgData["caption"]="OTHER";}
            $aoi[$imgData["caption"]][] = $imgData;
        } ?>
        <?php echo $instance['toptext'];?>
        <div class="uk-slidenav-position" data-uk-slider>
            <div class="uk-slider-container">
                <ul class="uk-slider uk-grid uk-grid-collapse uk-grid-width-small-1-2 uk-grid-width-medium-1-4 uk-grid-width-large-1-6 uk-grid-width-xlarge-1-6">
                <?php foreach ($aoi as $group) {
                        foreach ($group as $img ) { ?>
                                <li>
                                    <figure class="uk-overlay uk-overlay-hover">                                    
                                        <img class="uk-overlay-scale" src="<?php echo $img["url"];?>"
                                             height="<?php echo $img["height"];?>"
                                             width="<?php echo $img["width"]; ?>" 
                                             alt="<?php echo $img["alt"]; ?>">
                                    </figure>
                                        <a class="uk-position-cover" 
                                           data-uk-lightbox="{group:'gallery-group'}" 
                                           data-lightbox-type="image" 
                                           href="<?php echo $img["url"]; ?>">
                                        </a>
                                    
                                </li>
                        <?php } ?>
                <?php } ?>

                </ul>
            </div>
            <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
            <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
        </div>


        <?php        
            echo $after_widget;
        }
    
    
    /**
     * Upload the Javascripts for the media uploader
     */
    public function upload_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        
        wp_enqueue_style('thickbox');
    }

}

add_action('widgets_init', create_function('', 'return register_widget("CutePostGallery");')); ?>