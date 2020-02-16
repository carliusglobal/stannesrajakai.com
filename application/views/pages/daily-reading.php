<div class="tm-default-header-offset-bg"></div>  <!-- Start header offset-->

<div class="uk-container uk-container-center">
    <div class="uk-grid" data-uk-grid-match data-uk-grid-margin>
        <div class="tm-main uk-width-medium-1-1 tm-middle">
            <main class="tm-content">
                <section>
                    
                    <div id="primary" class="site-content post-content">
                        <div class="main-heading">
                            <h1 class="tm-page-title">Nine Day Novena to St. Ann</h1>
                        </div>
                        <div id="content" role="main">
<?php
$file = "http://www.usccb.org/bible/readings/021620.cfm";
$contents = file_get_contents($file);
$first_step = explode( '<div id="contentarea">' , $content );
$second_step = explode("</div>" , $first_step[1] );

echo $second_step[0];
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
