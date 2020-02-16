<div class="tm-slider-box tm-light-bg">
    <section class="tm-slider uk-grid tm-none-padding" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin>
        <!-- start full width -->
        <div class="uk-width-1-1">
            <div class="uk-panel top-pageslider CuteChurch">
                <div class="slider-module">
                    <div class="uk-slidenav-position" data-uk-slideshow="{height: &#039;300&#039;, animation: &#039;fade&#039;, duration: &#039;&#039;, autoplay: true, autoplayInterval: &#039;5000&#039;, videoautoplay: false, videomute: false, kenburns: false}">
                        <ul class="uk-slideshow uk-overlay-active">
                            <li class="uk-cover uk-height-viewport  tm-wrap"><img src="<?=asset_url();?>/images/bg_page.jpg" alt="bg_page" width="1920" height="360" class="aligncenter size-full" />
                            </li>
                            <li class="uk-cover uk-height-viewport  tm-wrap"><img src="<?=asset_url();?>/images/bg_page-01.jpg" alt="bg_page-01" width="1920" height="300" class="aligncenter size-full" />
                            </li>
                            <li class="uk-cover uk-height-viewport  tm-wrap"><img src="<?=asset_url();?>/images/bg_page-02.jpg" alt="bg_page-02" width="1920" height="300" class="aligncenter size-full" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- end full width -->
    </section>
</div>

<div class="tm-default-header-offset-bg"></div>  <!-- Start header offset-->

<div class="uk-container uk-container-center">
    <div class="uk-grid" data-uk-grid-match data-uk-grid-margin>
        <div class="tm-main uk-width-medium-1-1 tm-middle">
            <main class="tm-content">
                <section>
                    
                    <div id="primary" class="site-content post-content">
                        <div class="main-heading">
                            <h1 class="tm-page-title">Daily Readings</h1>
                        </div>
                        <div id="content" role="main">
<?php
ini_set( 'error_reporting', E_ALL );
$reading_date = $_REQUEST['readingdate'];
$file = "http://www.usccb.org/bible/readings/".$reading_date.".cfm";
$content = file_get_contents($file);
$first_step = explode( '<div id="contentarea" class="readings">' , $content );
$second_step = explode("</div>" , $first_step[1] );
$reading_time_input = strtotime("20".$reading_date[4].$reading_date[5]."/".$reading_date[0].$reading_date[1]."/".$reading_date[2].$reading_date[3]);  
$reading_date_input = getDate($reading_time_input);  

if($reading_date_input["weekday"]=="Sunday") {
    echo $second_step[3];
    echo $second_step[7];
    echo $second_step[9];
    echo $second_step[13];
    echo $second_step[17];
    echo $second_step[19];
    echo $second_step[23];
}
else {
    echo $second_step[3];
    echo $second_step[7];
    echo $second_step[9];
    echo $second_step[13];
    echo $second_step[17];
    echo $second_step[21];   
}




?>
                    </div>
                        <!-- #content -->
                    </div>
                    <!-- #primary -->
                </section>
            </main>
        </div>
    </div>
</div>
