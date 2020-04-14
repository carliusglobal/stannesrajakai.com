<?php
/*
  Plugin Name: Cute Testimonials
  Plugin URI: http://themeforest.net/user/torbara/
  Description: Display posts as Testimonials
  Author: ovvod
  Version: 1
  Author URI: 
 */

class CuteTestimonials extends WP_Widget {
    
    function __construct () {
        $widget_ops = array('classname' => 'CuteTestimonials', 'description' => 'Display posts as Testimonials');
        parent::__construct('CuteTestimonials', 'Cute Testimonials', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Testimonials";
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
            'posts_per_page'   => 10,
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
            <div data-uk-slideset="{small: 1, medium: 2, large: 2}" class="tm-slideset">
                <div class="uk-slidenav-position">
                    <ul class="uk-grid uk-slideset">
                        <?php
                            foreach ($list as $post) { ?>
                                <li>
                                    <div class="uk-panel">
                                        <p><span class="circle-border"><?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?></span></p>
                                        <h3 class="uk-panel-header"><span class="brackets"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></span></h3>
                                        <div class="tm-text-center"><?php echo wp_trim_words($post->post_content, 15); ?></div>
                                    </div>
                                </li>
                            <?php    
                            }
                        ?>
                    </ul>
                    <a href="" data-uk-slideset-item="previous" class="tm-slideset-previous"></a>
                    <a href="" data-uk-slideset-item="next" class="tm-slideset-next"></a>
                </div>
                    <a href="<?php echo get_category_link( $instance['CatID'] ); ?>" title="<?php echo get_cat_name($instance['CatID']);  ?>" class="tm-button-center" >All testimonials</a>

            </div>
        <?php

        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CuteTestimonials");')); ?>