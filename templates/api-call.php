<?php

// Assigning an API end point
//$url = 'http://localhost/get/committees';
$response = wp_remote_retrieve_body(wp_remote_get('http://localhost/get/committees'));

// Getting content 
//$response = file_get_contents($url);
//$response = file_get_contents($body);

// Decoding the content into an JSON array
$committees = json_decode($response, true);

//if ($response) {
    //print_r($response);
//}