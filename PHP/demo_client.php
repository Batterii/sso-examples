<!DOCTYPE html>
<html>
<link rel="stylesheet" href="css/bootstrap.min.css" media="all" />
<body class="container">
  
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
$profile_endpoint = $http_host . "/resource.php";

// Fetch the "Authentication Code" from the GET params
$auth_code = isset($_GET["code"]) ? $_GET["code"] : null;
$token_form = isset($_GET["token_form"]) ? true : false;
$profile_form = isset($_GET["profile_form"]) ? true : false;

if(!$auth_code && !$token_form && !$profile_form) {
	// No auth token so we just render the first login step
?>
	<h1>Simulated Batterii System</h1>
	<p>This client is meant to simulate the "Batterii SSO Client". It is likely of no use to you unless you want to see the end to end process simulated locally.</p>
	<span>Clicking the "Login w/ SSO" button will send a request to the SSO Provider's Authorize endpoint.</span>
	<form action="<?php echo $authorize_endpoint; ?>" method="GET">
		<input type="hidden" name="response_type" value="code">
		<input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
		<input type="hidden" name="state" value="<?php echo $client_state; ?>">
		<input type="hidden" name="redirect_uri" value="<?php echo $redirect_uri; ?>">
		<input type="submit" name="sso_login" value="Login w/ SSO">
	</form>
  
<?php

} elseif ($auth_code && !$token_form) {
	// We just got redirected to with an auth token so we display it and the next steps
?>
	<h1>Simulated Batterii System</h1>
	<h4>We received an Authentication Token from the SSO provider!</h4>
	<p>
		<strong>Authentication Code:</strong> <?php echo $auth_code; ?> <br>
	</p>
	<p>Our simulated Batterii server received an authentication token so now it can:</p>
	<h4>1. Upgrade authentication token to an "Access Token"</h4>
	<div>(Push the button to request an access token)</div>
	<div class="row-fluid">
		<iframe src="demo_client.php?token_form=1&code=<?php echo $auth_code?>" class="container well well-small span6">
		</iframe>
	</div>
	<h4>2. Use the "access token" to fetch a user profile resource</h4>
	<div>(Copy the token from above and paste it into the form and request the user profile)</div>
	<div class="row-fluid">
		<iframe src="demo_client.php?profile_form=1" class="container well well-small span6">
		</iframe>
	</div
	<div><a href="demo_client.php">Start Over</a></div>
		
<?php
} elseif ($auth_code && $token_form) { 
	// We got the "token_form" flag so we render just the token form for the iframe
?>
	<form action="<?php echo $token_endpoint; ?>" method="POST">
		<input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
		<input type="hidden" name="client_secret" value="<?php echo $client_secret; ?>">
		<input type="hidden" name="grant_type" value="authorization_code">
		<input type="hidden" name="redirect_uri" value="<?php echo $redirect_uri; ?>">
		<input type="hidden" name="code" value="<?php echo $auth_code; ?>">
		<input type="submit" value="Get Access Token">
	</form>	
<?php
} elseif ($profile_form) { 
	// We got the "profile_form" flag so we render just the profile fetch form for the iframe
?>
	<form action="<?php echo $profile_endpoint; ?>" method="POST">
		<input type="text" name="access_token" value="" placeholder="access token">
		<div><input type="submit" value="Get User Profile"></div>
	</form>	
	
<?php	
} else {
	echo '<div>Unknown mode?!?</div>';
}
?>

</body>
</html>