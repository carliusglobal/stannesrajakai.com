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
$url = "http://www.usccb.org/bible/readings/".date("mdy").".cfm";
$page = file_get_contents($url);
$doc = new DOMDocument();
$doc->loadHTML($page);
$divs = $doc->getElementsByTagName('div');
foreach($divs as $div) {
    echo $book->nodeValue, PHP_EOL;
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
