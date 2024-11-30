<?php 
// includes/shortcodes.php

function my_connect_shortcode() {
   

    return '<div id="root"></div>';
}

// Enregistrer le shortcode
add_shortcode('my_connect', 'my_connect_shortcode');


