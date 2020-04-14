<?php
/*
  Plugin Name: Cute Events Sidebar
  Plugin URI: http://cute.market/
  Description: Display Latest Events at sidebar
  Author: ovvod
  Version: 1.0.0
  Author URI: 
 */

class CuteEventsSidebar extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CuteEventsSidebar', 'description' => 'Display Latest Events at sidebar');
        parent::__construct('CuteEventsSidebar', 'Cute Events Sidebar', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Events Sidebar";
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

        <div class="uk-grid tm-cat-event-sb-widget">
            <ul>
                <?php
                foreach ( $posts as $post ) :
                    setup_postdata( $post ); ?>
                
                    <li class="">
                        <div class="post-date">
                            <div class="day">
                                <span><?php echo tribe_get_start_date( $post->ID, false, 'd' ) ?></span>
                                <p><?php echo tribe_get_start_date( $post->ID, false, 'M' ) ?></p>
                            </div>
                        </div>
                        <div class="">
                            <h5><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h5>
                            <p class=""><?php echo tribe_get_venue($post->ID); ?></p>
                            <p class=""><?php echo tribe_get_start_date( $post->ID, false, 'd M' ) ?>&#32;<?php echo tribe_get_start_date( $post->ID, false, 'g:i a' ) ?>&#32;-&#32;<?php echo tribe_get_end_date( $post->ID, false, 'g:i a' ) ?></p>
                            <div class="duration"></div>
                        </div>
                        <div class="clr"></div>
                    </li>
                
                <?php    
                endforeach;
                ?>
            </ul>
        </div>
        <?php
        
        
        

        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CuteEventsSidebar");')); ?>