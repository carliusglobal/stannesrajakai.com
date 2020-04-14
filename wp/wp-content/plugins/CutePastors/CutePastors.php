<?php
/*
  Plugin Name: Cute Pastors
  Plugin URI: Plugin URI: http://themeforest.net/user/torbara/
  Description: Display widget Our Pastors
  Author: ovvod
  Version: 1.0.0
  Author URI:
 */

class CutePastors extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CutePastors', 'description' => 'Display posts as Pastors');
        parent::__construct('CutePastors', 'Cute Pastors', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Pastors";
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
            <div data-uk-slideset="{small: 1, medium: 2, large: 4}" class="tm-slideset">
                <div class="uk-slidenav-position">
                    <ul class="uk-grid uk-slideset ">
                        <?php
                            foreach ($list as $post) { ?>
                                <li >
                                    <div class="uk-panel">
                                        <p><span class="circle-border"><?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?></span></p>
                                        <h4 class="uk-panel-header"><span class="brackets"><a href="<?php echo get_permalink(); ?>"><?php echo $post->post_title; ?></a></span></h4>
                                        <div><?php echo wp_trim_words($post->post_content, 15); ?></div>
                                    </div>
                                </li>
                            <?php    
                            }
                        ?>
                    </ul>
                    <a href="" data-uk-slideset-item="previous" class="tm-slideset-previous"></a>
                    <a href="" data-uk-slideset-item="next" class="tm-slideset-next"></a>
                </div>
                <?php
                    $categories = get_the_category();
                    if(!empty($categories)) :
                    ?>
                        <?php foreach($categories as $category) : ?>
                            <a href="<?php echo get_category_link($category->cat_ID ); ?>" title="<?php echo $category->cat_name;  ?>" class="tm-button-center" >Read more</a>
                        <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php
        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CutePastors");')); ?>