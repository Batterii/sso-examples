<!DOCTYPE html>
<html>
<link rel="stylesheet" href="css/bootstrap.min.css" media="all" />
<body class="container">
  
  <h1>Your System's Login Page</h1>

<?php

// include our OAuth2 Server object
require_once __DIR__.'/server.php';

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// let the OAuth library validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}

?>

<?php if (empty($_POST)) { ?>

<div class="row-fluid">

	<div class="span4">
		<form method="post">
			<label>Clicking the "Authorize SSO Client" button will grant the Batterii Server access using the selected user account.</label><br />
			<?php
				// List all of the users we may want to simulate during the OAuth process
				$stmt = $dbconnection->prepare(sprintf('SELECT * from oauth_users'));
				$stmt->execute(compact('client_id'));
				$users_cnt = 0;
				while($row = $stmt->fetch()) {  
					echo '<label class="radio"><input type="radio" name="user_id" value="' . $row['username'] . '">' . $row['first_name'] . ' ' . $row['last_name'] . '</label>';
					$users_cnt++;
				}  
				if ($users_cnt <= 0) {
					echo '<div>No users - create at least one user first</div>';
				}				
			?>
			<input type="submit" name="authorized" value="Authorize SSO Client">
		</form>
	</div>

	<div class="span4 offset2">
		<form method="post" class="form-inline">
			<input type="text" name="username" placeholder="username">
			<input type="text" name="first_name" placeholder="first_name">
			<input type="text" name="last_name" placeholder="last_name">
			<input type="submit" name="new_user" value="New User">
			<input type="submit" name="delete_all" value="Delete All Users">
		</form>
	</div>
	
</div>

<?php 

} else {

	// The authorize form was posted back to us - simulate a login as this user
    $is_authorized = !!$_POST['authorized'];
    if ($is_authorized) {
		$server->handleAuthorizeRequest($request, $response, $is_authorized, $_POST['user_id']);
		$response->send();
		exit();
	} elseif (!!$_POST['new_user']) {
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
		$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
		$data = array( 'username' => $username, 'first_name' => $first_name, 'last_name' => $last_name);
        $stmt = $dbconnection->prepare(sprintf('INSERT INTO oauth_users (username, first_name, last_name) values (:username, :first_name, :last_name)'));
        $stmt->execute($data);
	} elseif (!!$_POST['delete_all']) {
        $stmt = $dbconnection->prepare(sprintf('DELETE from oauth_users'));
        $stmt->execute();
	}
	$response->setRedirect(302, $_SERVER['REQUEST_URI']);
	$response->send();
}

?>

</body>
</html>
