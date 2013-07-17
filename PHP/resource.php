<?php

// include our OAuth2 Server object
require_once __DIR__.'/server.php';

// Handle a request for an OAuth2.0 Access Token and send the response to the client
$request = OAuth2\Request::createFromGlobals();
if (!$server->verifyResourceRequest($request)) {
    echo 'Invalue resource request!';
    $server->getResponse()->send();
    die;
}
  
$access_token = isset($_GET["access_token"]) ? $_GET["access_token"] : NULL;
if (!$access_token) {
   echo '{error: "Missing access token"}';
   die;
}
$stmt = $dbconnection->prepare(sprintf('SELECT username, first_name, last_name, email FROM oauth_users AS U JOIN oauth_access_tokens AS T ON U.username=T.user_id WHERE T.access_token = :access_token'));
$stmt->execute(array( 'access_token' => $access_token));
if ($row = $stmt->fetch()) {
    echo json_encode(array('email' => $row['email'],
                           'id' => $row['username'],
                           'given_name' => $row['first_name'],
                           'family_name' => $row['last_name']));
} else {
    echo '{error: "No user found for this access token"}';
    die;
}
