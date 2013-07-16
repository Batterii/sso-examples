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
echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));

