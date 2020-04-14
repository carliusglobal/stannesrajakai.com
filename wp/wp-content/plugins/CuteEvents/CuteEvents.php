<?php
/*
  Plugin Name: Cute Events
  Plugin URI: Plugin URI: http://themeforest.net/user/torbara/
  Description: Display Future Events
  Author: ovvod
  Version: 1.0.0
  Author URI: 
 */

class CuteEvents extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CuteEvents', 'description' => 'Display Future Events');
        parent::__construct('CuteEvents', 'Cute Events', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Events";
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
                    'taxonomy'                 => 'tribe_events_cat',
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

        <?php $viewanimation = isset( $instance['viewanimation'] ) ? $instance['viewanimation'] : "1"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'viewanimation' )); ?>">
                Show animation:
            </label> 
            <br>
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('viewanimation')."_1"); ?>" name="<?php echo esc_attr($this->get_field_name('viewanimation')); ?>" value="1" <?php if($viewanimation=="1"){ echo "checked"; }?>>Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('viewanimation')."_2"); ?>" name="<?php echo esc_attr($this->get_field_name('viewanimation')); ?>" value="2" <?php if($viewanimation=="2"){ echo "checked"; }?>>No
        </p>
        
        <?php
        
    }
    
    function update($new_instance, $old_instance) { 
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['toptext'] = $new_instance['toptext'];
        $instance['PostsCount'] = $new_instance['PostsCount'];
        $instance['CatID'] = $new_instance['CatID'];
        $instance['viewanimation'] = $new_instance['viewanimation'];
        
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
        $posts = tribe_get_events( $args );
        
        ?>
        <div class="tm-widget-top-text"><?php echo $instance['toptext'];?></div>
        <div class="uk-grid uk-grid-collapse">
            <ul class="tm-category-posts-block">
                <?php
                $count = 0;
                foreach ( $posts as $post ) : $count++; ?>
                <?php  ?>
                        <li class="uk-width-small-1-1 uk-width-medium-1-2 tribe-events-list-widget-events <?php tribe_events_event_classes(); ?>"
                            <?php if($instance['viewanimation']=="1") : ?> 
                                <?php if($count%2==0) { echo 'data-uk-scrollspy="{cls:\'uk-animation-slide-right\', repeat: true}" '; } else { echo 'data-uk-scrollspy="{cls:\'uk-animation-slide-left\', repeat: true}" '; } ?> 
                            <?php endif; ?>
                        >

                            <?php echo tribe_event_featured_image($post->ID, $size = 'thumbnail'); ?>
                            
                            <div class="post-date">
                                <div class="day">
                                    <span><?php echo tribe_get_start_date( $post->ID, false, 'd' ) ?></span>
                                    <p><?php echo tribe_get_start_date( $post->ID, false, 'M' ) ?></p>
                                </div>
                                <div class="time">
                                    <p><?php echo tribe_get_start_date( $post->ID, false, 'g:i a' ) ?></p>
                                    <p class="tm-event-venue"><?php echo tribe_get_venue($post->ID); ?></p>
                                </div>
                            </div>
                            <div style="padding: 20px;">
                                <h3 class="uk-panel-header">
                                    <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
                                </h3>
                                <?php echo wp_trim_words($post->post_content, 15); ?>
                                <a href="<?php echo esc_url( tribe_get_event_link($post->ID) ); ?>" class="read-more" rel="bookmark"><?php _e( 'Read more', 'tribe-events-calendar' ) ?></a>
                            </div>
                            
                            
                            <?php do_action( 'tribe_events_list_widget_after_the_meta' ) ?>


                        </li>
                
                <?php    
                endforeach;
                ?>
            </ul>
            
        </div>
        <a href="<?php echo esc_url( tribe_get_events_link() ); ?>" rel="bookmark" class="tm-event-widget-button">
            <?php _e( 'All Events', 'tribe-events-calendar' ); ?>
        </a>

        <?php
        
        
        

        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CuteEvents");')); ?>