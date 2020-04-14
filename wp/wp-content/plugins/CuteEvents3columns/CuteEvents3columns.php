<?php
/*
  Plugin Name: Cute Events 3 columns
  Plugin URI: http://themeforest.net/user/torbara/
  Description: Display Future Events at 3 columns.
  Author: ovvod
  Version: 1.0.0
  Author URI: 
 */

class CuteEvents3columns extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CuteEvents3columns', 'description' => 'Display Future Events at 3 columns');
        parent::__construct('CuteEvents3columns', 'Cute Events 3 columns', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Events 3 columns";
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
        $posts = tribe_get_events( $args );
        ?>
        <div class="tm-widget-top-text"><?php echo $instance['toptext'];?></div>
            <ul class="tm-events-widget-3-colomn uk-grid">
                <?php
                    $count = 0;
                    foreach ( $posts as $post ) : $count++; ?>
                    <li class="uk-width-small-1-1 uk-width-medium-1-3 tribe-events-list-widget-events <?php tribe_events_event_classes(); ?>">
                        <div class="event-block">
                            <div class="event-image-block">
                                <?php echo tribe_event_featured_image($post->ID, $size = ''); ?>
                            </div>
                            <div class="day">
                                <span><?php echo tribe_get_start_date( $post->ID, false, 'd' ) ?></span>
                                <p><?php echo tribe_get_start_date( $post->ID, false, 'M' ) ?></p>
                            </div>
                            <h3>
                                <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
                            </h3>
                                <div class="tm-p-10">
                                    <?php echo wp_trim_words($post->post_content, 17); ?>&nbsp;<a href="<?php echo esc_url( tribe_get_event_link($post->ID) ); ?>" class="read-more" rel="bookmark" style="display:inline-block;"><?php _e( 'Read more', 'tribe-events-calendar' ) ?></a>
                                </div>
                            <?php do_action( 'tribe_events_list_widget_after_the_meta' ) ?>
                        </div>
                    </li>
                <?php    
                    endforeach;
                ?>
            </ul>
        <a href="<?php echo esc_url( tribe_get_events_link() ); ?>" rel="bookmark" class="tm-button-center">
            <?php _e( 'All Events', 'tribe-events-calendar' ); ?>
        </a>
        <?php
        
        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CuteEvents3columns");')); ?>