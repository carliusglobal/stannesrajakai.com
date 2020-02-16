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
$doc = new DOMDocument();
$doc->loadHTML($contents);
$path=new DOMXpath($doc);
$dom=$path->query("*/div[@id='contentarea']");
if (!$dom==0) {
       foreach ($dom as $dom) {
          print "
    The Type of the element is: ". $dom->nodeName. "
    <b><pre><code>";
          $getContent = $dom->childNodes;
          foreach ($getContent as $attr) {
             print $attr->nodeValue. "</code></pre></b>";
          }
       }
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
