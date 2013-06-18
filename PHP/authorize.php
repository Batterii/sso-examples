<html>
<body>
  
  <h1>Simulated SSO Provider</h1>

<?php

// include our OAuth2 Server object
require_once __DIR__.'/server.php';

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}
// display an authorization form
if (empty($_POST)) {
  exit('
<form method="post">
  <label>Clicking the "Authorize SSO Client" button will grant the Batterii Server access. The simulated SSO Provider will respond with a 302 redirect to the redirect_uri along with the authorization code.</label><br />
  <input type="submit" name="authorized" value="Authorize SSO Client">
</form>');
}

$is_authorized = !!$_POST['authorized'];
$server->handleAuthorizeRequest($request, $response, $is_authorized);
$response->send();

?>

</body>
</html>
