<?php
/*
  Plugin Name: Cute Sermons
  Plugin URI: Plugin URI: http://themeforest.net/user/torbara/
  Description: Display widget of Sermons Category  future posts
  Author: ovvod
  Version: 1.0.0
  Author URI:
 */

class CuteSermons extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CuteSermons', 'description' => 'Display Sermons Category future posts');
        parent::__construct('CuteSermons', 'Cute Sermons', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Sermons";
        }
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Title: 
                <input class="widefat" 
                        id="<?php echo $this->get_field_id('title'); ?>" 
                        name="<?php echo $this->get_field_name('title'); ?>" 
                        type="text" 
                        value="<?php echo $title; ?>" />
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
        <p>
            <label for="<?php echo $this->get_field_id('PostsCount'); ?>">
                Posts Count: 
                <input class="widefat" 
                        id="<?php echo $this->get_field_id('PostsCount'); ?>" 
                        name="<?php echo $this->get_field_name('PostsCount'); ?>" 
                        type="number"
                        min="1"
                        max="6"
                        step="1"
                        value="<?php echo $instance['PostsCount']; ?>" />
            </label>
        </p>
        
        
        <p>
            <label for="<?php echo $this->get_field_id('CatID'); ?>">
                Select Category:<?php
  
                $args = array(
                    'type'                     => 'post',
                    'child_of'                 => 0,
                    'parent'                   => '',
                    'orderby'                  => 'name',
                    'order'                    => 'ASC',
                    'hide_empty'               => 1,
                    'hierarchical'             => 1,
                    'exclude'                  => '',
                    'include'                  => '',
                    'number'                   => '',
                    'taxonomy'                 => 'category',
                    'pad_counts'               => false 
                );
                
                $cats = get_categories( $args );
                
                ?><select class="widefat" 
                          id="<?php echo esc_attr($this->get_field_id('CatID')); ?>" 
                          name="<?php echo esc_attr($this->get_field_name('CatID')); ?>" ><?php
                foreach ($cats as $cat){
                    ?><option value="<?php echo esc_attr($cat->term_id); ?>" <?php if($cat->term_id==$instance['CatID']){echo 'selected=""';} ?>><?php echo $cat->name; ?></option><?php
                }
                ?>
                </select>
        </p>
        
        <?php
        
    }
    
    function update($new_instance, $old_instance) { 
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['toptext'] = $new_instance['toptext'];
        $instance['PostsCount'] = $new_instance['PostsCount'];
        $instance['CatID'] = $new_instance['CatID'];
        
        return $instance;
    }
    
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);

        echo $before_widget;

        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        
        if(isset($instance['PostsCount'])){
            $PostsCount = $instance['PostsCount'];
        }else{
            $PostsCount = 3;
        }
        
        $args = array(
            'posts_per_page'   => $PostsCount,
            'offset'           => 0,
            'category'         => $instance['CatID'],
            'orderby'          => 'post_date',
            'order'            => 'ASC',
            'post_status'      => 'publish',
            'suppress_filters' => true 
        );
        $list = get_posts( $args );
        ?>
        <div class="tm-widget-top-text"><?php echo $instance['toptext'];?></div>
        <div class="uk-grid"><?php
            foreach ($list as $post) { ?>
                <div class="uk-width-1-1">
                    <div class="uk-panel tm-category-widget-box">
                        <?php echo get_the_post_thumbnail( $post->ID, 'post-small-thumbnails' ); ?>
                        <div class="tm-post-text-block">
                            <h5><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h5>
                            <p class="post-authore">Posted by: <em><?php the_author(); ?></em></p>
                            <div class="tm-post-button-block uk-container-center">
                                <a class="" href="https://www.youtube.com/watch?v=yZHWTNvYpcU" data-uk-lightbox ><i class="uk-icon-video-camera"></i></a>
                                <a href="#modal" data-uk-modal=""><i class="uk-icon-headphones"></i></a>
                                <a class="" href="/wp-content/uploads/test.pdf" target="_blank"><i class="uk-icon-file-pdf-o"></i></a>
                                <a class="" href="/wp-content/uploads/test.txt" target="_blank"><i class="uk-icon-file-text"></i></a>
                                <div class="clr"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            <?php    
            }
            ?>
        </div>
        <div id="modal" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll;">
            <div class="uk-modal-dialog">
                <a href="" class="uk-modal-close uk-close"></a>
                <audio controls>
                    <source src="/wp-content/uploads/audio-sermons.mp3" type="audio/mpeg">
                </audio>
            </div>
        </div>
        <?php
        
        
        

        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CuteSermons");')); ?>