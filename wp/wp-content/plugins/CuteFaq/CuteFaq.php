<?php
/*
  Plugin Name: Cute FAQ
  Plugin URI: http://cute.market/
  Description: Display posts from FAQ Category
  Author: ovvod
  Version: 1.0.0
  Author URI: 
 */

class CuteFaq extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CuteFaq', 'description' => 'Display posts from FAQ Category');
        parent::__construct('CuteFaq', 'Cute FAQ', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute FAQ";
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
        <p><?php echo $instance['toptext'];?></p>
        <div class="uk-grid uk-accordion tm-accordion" data-uk-accordion><?php
        foreach ($list as $post) { ?>
            <div class="uk-width-1-1">
                    <h3 class="uk-panel-header uk-accordion-title tm-accordion-title"><?php echo $post->post_title; ?></h3>
                    <div class="uk-accordion-content">
                        <?php echo wp_trim_words($post->post_content, 30); ?>
                        <a href="<?php echo get_permalink($post->ID); ?>" class="read-more">read more</a>
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

add_action('widgets_init', create_function('', 'return register_widget("CuteFaq");')); ?>