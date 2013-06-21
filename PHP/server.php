<?php 
  $dsn      = 'sqlite:db/oauth2.db';
  $username = '';
  $password = '';

  // error reporting (this is a demo, after all!)
  ini_set('display_errors',1);error_reporting(E_ALL);
  
  // Autoloading (composer is preferred, but for this example let's just do this)
  require_once('lib/oauth2-server-php/src/OAuth2/Autoloader.php');
  OAuth2\Autoloader::register();
  
  // $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
  $storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
  
  // Pass a storage object or array of storage objects to the OAuth2 server class
  $server = new OAuth2\Server($storage);
  
  // Add the "Client Credentials" grant type (it is the simplest of the grant types)
  $server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
  
  // Add the "Authorization Code" grant type (this is where the oauth magic happens)
  $server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

  // configure your available scopes
  $defaultScope = 'basic';
  $supportedScopes = array(
    'basic',
    'postonwall',
    'accessphonenumber' 
  );
  $memory = new OAuth2\Storage\Memory(array(
    'default_scope' => $defaultScope,
    'supported_scopes' => $supportedScopes
  ));
  $scopeUtil = new OAuth2\Scope($memory);

  $server->setScopeUtil($scopeUtil);  
?>
