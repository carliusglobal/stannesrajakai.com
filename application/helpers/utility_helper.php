<?php
function asset_url(){
   return str_replace('http:', 'https:', base_url().'assets/');
}