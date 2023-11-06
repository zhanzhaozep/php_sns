<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $tweetId = $_POST['tweet_id'];
    

    $response = ['message' => 'いいね'];
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    
    http_response_code(405); 
    echo "Method Not Allowed";
}