<?php
/*
  Plugin Name: Cute Bible Text
  Plugin URI: Plugin URI: http://themeforest.net/user/torbara/
  Description: Display widget of Bible Text Category posts
  Author: ovvod
  Version: 1.0.0
  Author URI:
 */

class CuteBibleText extends WP_Widget {
    
    function __construct () {
        $widget_ops = array('classname' => 'CuteBibleText', 'description' => 'Display Bible Text Category posts');
        parent::__construct('CuteBibleText', 'Cute Bible Text', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Bible Text";
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
                <div data-uk-slideset="{default: 1}" class="tm-bible-slideset">
                    <div class="slider-bible">
                        <ul class="uk-grid uk-slideset">
                            <?php
                            foreach ($list as $post) { ?>
                            <li class="uk-push-2-5 uk-grid-width-small-1-1 uk-width-medium-3-5  uk-width-large-3-5">
                                <div class="uk-text-center text-shadow"><?php echo wp_trim_words($post->post_content, 20); ?></div>
                                <div class="tm-text-center">
                                    <a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
                                    <h3 class="uk-panel-header uk-text-center"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h3>
                                    <a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
                                </div>
                            </li>
                            <?php    
                            }
                            ?>
                        </ul>
                        
                            
                            
                        
                    </div>
                </div>
                
        <?php
        
        
        

        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CuteBibleText");')); ?>