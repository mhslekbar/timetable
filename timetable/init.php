<?php 

    include 'connect.php';

    // Root
     
    $tpl    = 'includes/templates/';
    $func   = 'includes/functions/';


    // Layout 

    $css    = 'layout/css/';
    $js     = 'layout/js/';
    $fonts  = 'layout/fonts/';
    
    
    // Includes

    include $tpl . 'header.php';
    include $func . 'functions.php'; 
    
    // Queries
    include $func . 'queries_func.php'; 
    
    if(!isset($noNavbar)){
        include $tpl . 'navbar.php';
    }

?>