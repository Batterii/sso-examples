<!-- This client is meant to simulate the "Batterii SSO Client". It is likely of no use. -->
<html>
<body>
  
  <h1>Simulated Batterii System</h1>

<?php

/////////////////////////////////////////////////////////////////////////////
// Globals
static $client_state = "100100,34566";
// The `client_id` and `client_secret` which were added to the database. See README.md.
static $client_id = "Batterii SSO";
static $client_secret = "ae033c5653e254aa8a0a53ed3c48e460";
// Construct the redirect_uri and endpoint strings. The `http_host` should match the value added to the database. See README.md.
static $http_host = "http://localhost:8000";
$redirect_uri = $http_host . "/demo_client.php";
$token_endpoint = $http_host . "/token.php";
$authorize_endpoint = $http_host . "/authorize.php";

// Fetch the "Authentication Code" from the GET params
$auth_code = isset($_GET["code"]) ? $_GET["code"] : null;

if(!$auth_code) {
  
?>
  <span>Clicking the "Login w/ SSO" button will send a request to the SSO Provider's Authorize endpoint.</span>
  <form action="<?php echo $authorize_endpoint; ?>" method="GET">
    <input type="hidden" name="response_type" value="code">
    <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
    <input type="hidden" name="state" value="<?php echo $client_state; ?>">
    <input type="hidden" name="redirect_uri" value="<?php echo $redirect_uri; ?>">
    <input type="submit" value="Login w/ SSO">
  </form>
<?php

} else {

?>
  <p>
    <strong>Authentication Code:</strong> <?php echo $auth_code; ?> <br>
    <strong>Note:</strong> The above Authentication Code is sent to Batterii Server, then Batterii Server makes a request to the SSO provide for the Access Token. The secret key is included in the later request. 
  </p>
  <form action="<?php echo $token_endpoint; ?>" method="POST">
    <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
    <input type="hidden" name="client_secret" value="<?php echo $client_secret; ?>">
    <input type="hidden" name="grant_type" value="authorization_code">
    <input type="hidden" name="redirect_uri" value="<?php echo $redirect_uri; ?>">
    <input type="hidden" name="code" value="<?php echo $auth_code; ?>">
    <input type="submit" value="Send via Batterii Server">
  </form>
<?php

}

?>

</body>
</html>