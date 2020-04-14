<?php
/*
  Plugin Name: Cute Latest Posts
  Plugin URI: http://themeforest.net/user/torbara/
  Description: Display Latest Posts
  Author: ovvod
  Version: 1
  Author URI:
 */

class CuteLatest extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CuteLatest', 'description' => 'Display Latest posts');
        parent::__construct('CuteLatestPosts', 'Cute Latest Posts', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Latest Posts";
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
        <div class="tm-wrap uk-grid-collapse"><?php
            foreach ($list as $post) { ?>
                <div class="tm-latest-post-widget clearfix">
                    <div class="post-date">
                        <div class="day">
                            <span><?php echo get_the_time( 'd', $post->ID ); ?></span>
                            <p><?php echo get_the_time( 'M', $post->ID ); ?></p>
                        </div>
                    </div>
                    <div class="post-image">
                        <?php echo get_the_post_thumbnail( $post->ID, 'post-small-circular-thumbnails' ); ?>
                    </div>
                    <div class="post-text">
                        <h3 class="uk-panel-header"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo wp_trim_words($post->post_title, 3); ?></a></h3>
                        <div><?php echo wp_trim_words($post->post_content, 16); ?></div>
                        <div class="grey">
                            <?php echo get_comments_number( $post->ID ); ?>&#32;Comments&#32;&#124;&#32;
                            <span>Posted by:&#32;<?php echo get_user_by('id', $post->post_author)->data->user_nicename; ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <a href="<?php echo get_category_link( $instance['CatID'] ); ?>" title="<?php echo get_cat_name($instance['CatID']);  ?>" class="tm-button-left" >Read more</a>
        </div>
        <?php
        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CuteLatest");')); ?>