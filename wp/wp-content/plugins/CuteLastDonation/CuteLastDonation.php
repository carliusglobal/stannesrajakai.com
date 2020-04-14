<?php
/*
  Plugin Name: Cute Last Donation
  Plugin URI: http://cute.market/
  Description: Display widget of Last Donation
  Author: ovvod
  Version: 1.0.0
  Author URI:
 */

class CuteLastDonation extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'CuteLastDonation', 'description' => 'Display Last Donation');
        parent::__construct('CuteLastDonation', 'Cute Last Donation', $widget_ops);
    }
    
    function form($instance) {
        
        if(isset($instance['title'] )){
            $title =  $instance['title'];
        }else{
            $title =  "Cute Last Donation";
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
            <label for="<?php echo $this->get_field_id('toptext'); ?>">
                Top text: 
                <textarea class="widefat" 
                        id="<?php echo $this->get_field_id('toptext'); ?>" 
                        name="<?php echo $this->get_field_name('toptext'); ?>" 
                        rows="5" 
                        cols="40"><?php echo $instance['toptext']; ?></textarea>
            </label>
        </p>
        
        <?php
        //Query Give Forms
        $args       = array(
            'post_type'      => 'give_forms',
            'posts_per_page' => - 1,
            'post_status'    => 'publish',
        );
        $give_forms = get_posts( $args );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php printf( __( 'Give %s', 'give' ), give_get_forms_label_singular() ); ?>
                <span class="dashicons dashicons-tinymce-help" data-tooltip="<?php _e( 'Select a Give Form that you would like to embed in this widget area.', 'give' ); ?>"></span>
            </label>

            <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>">
                <option value="current"><?php _e( 'Please select...', 'give' ); ?></option>
                <?php foreach ( $give_forms as $give_form ) { ?>
                    <option <?php selected( absint( $instance['id'] ), $give_form->ID ); ?> value="<?php echo esc_attr( $give_form->ID ); ?>"><?php echo $give_form->post_title; ?></option>
                <?php } ?>
            </select>
        </p>
    
        
        <?php
        
    }
    
    function update($new_instance, $old_instance) { 
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['PostsCount'] = $new_instance['PostsCount'];
        $instance['toptext'] = $new_instance['toptext'];
        $instance  ["id"] = $new_instance['id'];
        $instance  ["formtoptext"] = $new_instance['formtoptext'];
        
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
        
        $instance  ["formtoptext"]= "";
        
        
        ?>
            <div class="tm-widget-top-text"><?php echo $instance['toptext'];?></div>
            <div class="uk-panel">
                <div class="uk-width-1-1">
                    <div class="uk-grid uk-grid-collapse">
                        <div class="uk-grid-width-small-1-1 uk-width-medium-1-2 tm-widget-lastdonations-image">
                            <?php echo get_the_post_thumbnail( $instance['id'], 'full' ); ?>
                        </div>
                        <div class="uk-grid-width-small-1-1 uk-width-medium-1-2 tm-default-bg">
                            <div class="tm-text-center">
                                <a href="<?php echo get_permalink($instance['id']); ?>" class="inline-block tm-p-top-medium"><h2><?php echo get_the_title($instance['id']); ?></h2></a>
                                <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
                                <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="facebook,twitter,gplus"></div>
                                <?php give_get_donation_form( $instance ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        
        
        

        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CuteLastDonation");')); ?>