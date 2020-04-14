<?php
/*
  Plugin Name: Cute Location
  Plugin URI: Plugin URI: http://themeforest.net/user/torbara/
  Description: Display widget of Location Category  future posts
  Author: ovvod
  Version: 1.0.0
  Author URI:
 */

class CuteLocation extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CuteLocation', 'description' => 'Display Location');
        parent::__construct('CuteLocation', 'Cute Location', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Location";
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
        $list = get_posts( $args );
        ?>
        <?php echo $instance['toptext']; ?>
        <div class=""><?php
        $count = 0;
        foreach ($list as $post) { $count++; ?> 
            <div class="uk-panel tm-location-widget" 
                <?php if($instance['viewanimation']=="1") : ?> 
                    <?php if($count%2==0) { echo 'data-uk-scrollspy="{cls:\'uk-animation-slide-left\', repeat: true}" '; } else { echo 'data-uk-scrollspy="{cls:\'uk-animation-slide-right\', repeat: true}" '; } ?> 
                <?php endif; ?>
            >
                <div class="uk-grid tm-location-box uk-grid-collapse">
                    <div class="uk-width-small-1-1 uk-width-medium-1-2 <?php if($count%2==0) { echo "uk-push-1-2 "; } ?> tm-location-infoblock">
                        <h3 class="tm-location-title"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h3>
                        <div class="tm-location-info"><?php echo $content = $post->post_content; ?></div>
                    </div>
                    <div class="uk-width-small-1-1 uk-width-medium-1-2 <?php if($count%2==0){ echo "uk-pull-1-2 "; } ?>"><a href="<?php echo get_permalink($post->ID); ?>" class=""><?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?></a></div>
                </div>
            </div>
        <?php    
        }
        ?>
        </div>
        <?php
        
        
        

        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CuteLocation");')); ?>