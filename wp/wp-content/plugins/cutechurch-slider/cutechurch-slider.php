<?php
/*
  Plugin Name: Cute Church Slider
  Plugin URI: Plugin URI: http://themeforest.net/user/torbara/
  Description: Post slider for WP
  Author: ovvod
  Version: 1
  Author URI: 
 */

class CuteChurch extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'CuteChurch', 'description' => 'Displays a random post with thumbnail');
        parent::__construct('CuteChurch', 'Cute Church Slider', $widget_ops);
    }

    function form($instance) { ?>

        <?php $title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : "CuteChurch Slider WP"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                Title: 
                <input class="widefat" 
                        id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                        name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                        type="text" 
                        value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        
        <?php $CatID = isset( $instance['CatID'] ) ? $instance['CatID'] : ""; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('CatID')); ?>">
                Category ID:
                <input class="widefat" 
                        id="<?php echo esc_attr($this->get_field_id('CatID')); ?>" 
                        name="<?php echo esc_attr($this->get_field_name('CatID')); ?>" 
                        type="text" 
                        value="<?php echo esc_attr($CatID); ?>" />
            </label>
        </p>
        
        <?php $ItemCount = isset( $instance['ItemCount'] ) ? $instance['ItemCount'] : "7"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('ItemCount')); ?>">
                Number of items:
                <input class="widefat" 
                        id="<?php echo esc_attr($this->get_field_id('ItemCount')); ?>" 
                        name="<?php echo esc_attr($this->get_field_name('ItemCount')); ?>" 
                        type="text" 
                        value="<?php echo esc_attr($ItemCount); ?>" />
            </label>
        </p>
        
        <?php $height = isset( $instance['height'] ) ? $instance['height'] : "auto"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('height')); ?>">
                Slider height:
                <input class="widefat"
                        id="<?php echo esc_attr($this->get_field_id('height')); ?>" 
                        name="<?php echo esc_attr($this->get_field_name('height')); ?>" 
                        type="text"
                        value="<?php echo esc_attr($height); ?>" />
            </label>
        </p>        
        
        <?php $slidenav_btn = isset( $instance['slidenav_btn'] ) ? $instance['slidenav_btn'] : "1"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'slidenav_btn' )); ?>">
                Show navigation:
            </label> 
            <br>
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('slidenav_btn')."_1"); ?>" name="<?php echo esc_attr($this->get_field_name('slidenav_btn')); ?>" value="1" <?php if($slidenav_btn=="1"){ echo "checked"; }?>>Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('slidenav_btn')."_2"); ?>" name="<?php echo esc_attr($this->get_field_name('slidenav_btn')); ?>" value="2" <?php if($slidenav_btn=="2"){ echo "checked"; }?>>No
        </p>
        
        <?php $slidenav = isset( $instance['slidenav'] ) ? $instance['slidenav'] : "1"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'slidenav' )); ?>">
                Show next and previous:
            </label> 
            <br>
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('slidenav')."_1"); ?>" name="<?php echo esc_attr($this->get_field_name('slidenav')); ?>" value="1" <?php if($slidenav=="1"){ echo "checked"; }?>>Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('slidenav')."_2"); ?>" name="<?php echo esc_attr($this->get_field_name('slidenav')); ?>" value="2" <?php if($slidenav=="2"){ echo "checked"; }?>>No
		</p>
        
        <?php $animation = isset( $instance['animation'] ) ? $instance['animation'] : "fade"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'animation' )); ?>">
                Animation:
            </label> 
            <br>
            <select id="<?php echo esc_attr($this->get_field_id('animation')); ?>" name="<?php echo esc_attr($this->get_field_name('animation')); ?>">
                <option value="fade" <?php echo ($animation=='fade')?'selected':''; ?>>Fade</option>
                <option value="scroll" <?php echo ($animation=='scroll')?'selected':''; ?>>Scroll</option>
                <option value="scale" <?php echo ($animation=='scale')?'selected':''; ?>>Scale</option>
                <option value="swipe" <?php echo ($animation=='swipe')?'selected':''; ?>>Swipe</option>
                <option value="fold" <?php echo ($animation=='fold')?'selected':''; ?>>Fold</option>
                <option value="puzzle" <?php echo ($animation=='puzzle')?'selected':''; ?>>Puzzle</option>
                <option value="boxes" <?php echo ($animation=='boxes')?'selected':''; ?>>Boxes</option>
                <option value="boxes-reverse" <?php echo ($animation=='boxes-reverse')?'selected':''; ?>>Boxes-reverse</option>
            </select>
        </p>
        
        <?php $duration = isset( $instance['duration'] ) ? $instance['duration'] : "500"; ?>
        <p>
            <label for="<?php echo esc_attr ($this->get_field_id('duration')); ?>">
                Duration of animation:
                <input class="widefat" 
                        id="<?php echo esc_attr($this->get_field_id('duration')); ?>" 
                        name="<?php echo esc_attr($this->get_field_name('duration')); ?>" 
                        type="text" 
                        value="<?php echo esc_attr($duration); ?>" />
            </label>
        </p>
        
        <?php $autoplay = isset( $instance['autoplay'] ) ? $instance['autoplay'] : "1"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'autoplay')); ?>">
                Autoplay:
            </label> 
            <br>
            <input type="radio" id="<?php echo esc_attr ($this->get_field_id('autoplay')."_1"); ?>" name="<?php echo esc_attr ($this->get_field_name('autoplay')); ?>" value="1" <?php if($autoplay=="1"){ echo "checked"; }?>>Yes 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="<?php echo esc_attr ($this->get_field_id('autoplay')."_2"); ?>" name="<?php echo esc_attr ($this->get_field_name('autoplay')); ?>" value="2" <?php if($autoplay=="2"){ echo "checked"; }?>>No
        </p>
        
        <?php $autoplayInterval = isset( $instance['autoplayInterval'] ) ? $instance['autoplayInterval'] : "5000"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('autoplayInterval')); ?>">
                Autoplay Interval:
                <input class="widefat" 
                        id="<?php echo esc_attr ($this->get_field_id('autoplayInterval')); ?>" 
                        name="<?php echo esc_attr ($this->get_field_name('autoplayInterval')); ?>" 
                        type="text" 
                        value="<?php echo esc_attr ($autoplayInterval); ?>" />
            </label>
        </p>
        
        <?php $videoautoplay = isset( $instance['videoautoplay'] ) ? $instance['videoautoplay'] : "1"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'videoautoplay' )); ?>">
                Video autoplay:
            </label>
            <br>
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('videoautoplay')."_1"); ?>" name="<?php echo esc_attr($this->get_field_name('videoautoplay')); ?>" value="1" <?php if($videoautoplay=="1"){ echo "checked"; }?>>Yes 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('videoautoplay')."_2"); ?>" name="<?php echo esc_attr($this->get_field_name('videoautoplay')); ?>" value="2" <?php if($videoautoplay=="2"){ echo "checked"; }?>>No
        </p>
        
        <?php $videomute = isset( $instance['videomute'] ) ? $instance['videomute'] : "1"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'videomute' )); ?>">
                Video mute:
            </label>
            <br>
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('videomute')."_1"); ?>" name="<?php echo esc_attr($this->get_field_name('videomute')); ?>" value="1" <?php if($videomute=="1"){ echo "checked"; }?>>Yes 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('videomute')."_2"); ?>" name="<?php echo esc_attr($this->get_field_name('videomute')); ?>" value="2" <?php if($videomute=="2"){ echo "checked"; }?>>No
        </p>
        
        <?php $kenburns = isset( $instance['kenburns'] ) ? $instance['kenburns'] : "2"; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'kenburns' )); ?>">
                Kenburns:
            </label>
            <br>
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('kenburns')."_1"); ?>" name="<?php echo esc_attr($this->get_field_name('kenburns')); ?>" value="1" <?php if($kenburns=="1"){ echo "checked"; }?>>Yes 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="<?php echo esc_attr($this->get_field_id('kenburns')."_2"); ?>" name="<?php echo esc_attr($this->get_field_name('kenburns')); ?>" value="2" <?php if($kenburns=="2"){ echo "checked"; }?>>No
		</p>
        
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['ItemCount'] = $new_instance['ItemCount'];
        $instance['CatID'] = $new_instance['CatID'];
        $instance['height'] = $new_instance['height'];
        $instance['slidenav_btn'] = $new_instance['slidenav_btn'];
        $instance['slidenav'] = $new_instance['slidenav'];
        $instance['animation'] = $new_instance['animation'];
        $instance['duration'] = $new_instance['duration'];
        $instance['autoplay'] = $new_instance['autoplay'];
        $instance['autoplayInterval'] = $new_instance['autoplayInterval'];
        $instance['videoautoplay'] = $new_instance['videoautoplay'];
        $instance['videomute'] = $new_instance['videomute'];
        $instance['kenburns'] = $new_instance['kenburns'];
            
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);

        echo $before_widget;
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        
        // UIkit Slideshow configuration
        $slideshow_cfg = array ();
        $slideshow_cfg[] = "height: '".$instance['height']."'";
        $slideshow_cfg[] = "animation: '".$instance['animation']."'";
        $slideshow_cfg[] = "duration: '".$instance['duration']."'";
        if($instance['autoplay']=="1"){$slideshow_cfg[] = "autoplay: true";}else{$slideshow_cfg[] = "autoplay: false";}
        $slideshow_cfg[] = "autoplayInterval: '".$instance['autoplayInterval']."'";
        if($instance['videoautoplay']=="1"){$slideshow_cfg[] = "videoautoplay: true";}else{$slideshow_cfg[] = "videoautoplay: false";}
        if($instance['videomute']=="1"){$slideshow_cfg[] = "videomute: true";}else{$slideshow_cfg[] = "videomute: false";}
        if($instance['kenburns']=="1"){$slideshow_cfg[] = "kenburns: true";}else{$slideshow_cfg[] = "kenburns: false";} 
        
        $args = array(
            'posts_per_page'   => $instance['ItemCount'],
            'offset'           => 0,
            'category'         => $instance['CatID'],
            'orderby'          => 'post_date',
            'order'            => 'ASC',
            'post_status'      => 'publish',
            'suppress_filters' => true 
        );
        $list = get_posts( $args );?>
        
        
        <div class="slider-module">
            <div class="uk-slidenav-position" data-uk-slideshow="{<?php echo esc_attr(implode(", ", $slideshow_cfg)); ?>}">
                <ul class="uk-slideshow uk-overlay-active">
                    <?php foreach ($list as $item) : ?>
                        <li class="uk-cover uk-height-viewport  tm-wrap"><?php echo do_shortcode($item->post_content) ; ?></li>
                    <?php endforeach; ?>
                </ul>
                
                <?php if($instance['slidenav_btn']=="1") : ?>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
                <?php endif; ?>
                <?php if($instance['slidenav']=="1") : ?>
                    <ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center">
                        <?php $counter = 0; ?>
                        <?php foreach ($list as $item) : ?>
                            <li data-uk-slideshow-item="<?php echo esc_attr($counter); ?>"><a href=""><?php echo esc_attr($counter); $counter++; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

    <?php
        
        echo $after_widget;
    }

}

function wp_load_cutechurch_slider_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style('css-cutechurch-slider', $plugin_url . 'css/cutechurch-slider.css' );
}
add_action('wp_enqueue_scripts', 'wp_load_cutechurch_slider_css' );

add_action('widgets_init', create_function('', 'return register_widget("CuteChurch");')); ?>