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
$reading_date = $_REQUEST['readingdate'];
$file = "http://www.usccb.org/bible/readings/".$reading_date.".cfm";
$content = file_get_contents($file);
$first_step = explode( '<div id="contentarea" class="readings">' , $content );
$second_step = explode("</div>" , $first_step[1] );
$reading_date = date_create($reading_date)
$reading_day = date_format($reading_date,"l");

if($reading_day=="Sunday") {
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
