Batterii SSO Provider - PHP Demo
=======================

Database
-----------------------
A default SQLite database is provided at "db/oauth2.db". You can also create one from scratch with the following SQL statements.

```sql
CREATE TABLE oauth_clients ( client_id VARCHAR(80) NOT NULL, client_secret VARCHAR(80) NOT NULL, redirect_uri VARCHAR(2000)  NOT NULL, CONSTRAINT client_id_pk PRIMARY KEY (client_id));
CREATE TABLE oauth_access_tokens (access_token VARCHAR(40) NOT NULL, client_id VARCHAR(80) NOT NULL, user_id VARCHAR(255), expires TIMESTAMP NOT NULL,scope VARCHAR(2000), CONSTRAINT access_token_pk PRIMARY KEY (access_token));
CREATE TABLE oauth_authorization_codes (authorization_code VARCHAR(40) NOT NULL, client_id VARCHAR(80) NOT NULL, user_id VARCHAR(255), redirect_uri VARCHAR(2000) NOT NULL, expires TIMESTAMP NOT NULL, scope VARCHAR(2000), CONSTRAINT auth_code_pk PRIMARY KEY (authorization_code));
CREATE TABLE oauth_refresh_tokens ( refresh_token VARCHAR(40) NOT NULL, client_id VARCHAR(80) NOT NULL, user_id VARCHAR(255), expires TIMESTAMP NOT NULL, scope VARCHAR(2000), CONSTRAINT refresh_token_pk PRIMARY KEY (refresh_token));
CREATE TABLE oauth_users (username VARCHAR(255) NOT NULL, password VARCHAR(2000), first_name VARCHAR(255), last_name VARCHAR(255), CONSTRAINT username_pk PRIMARY KEY (username));
```

Setup
-----------------------
1) Add the demo client as an OAuth Client with the following SQL statement

```sql
INSERT INTO oauth_clients (client_id, client_secret, redirect_uri) VALUES ("Batterii SSO", "ae033c5653e254aa8a0a53ed3c48e460", "http://localhost:8000/demo_client.php");
```

2) Fire up a PHP development server.

``` php -S localhost:8000 -d date.timezone=UTC ```

3) Point your browser at http://localhost:8000/demo_client.php


Overview
-----------------------
This project is meant to assist a developer who is writing an OAuth2 "server" that can integrate with the Batterii system.  The Batterii SSO (single sign-on) feature allows your system to authenticate users and authorize them to use your Batterii account.  During the login process the Batterii system will redirect users to your system for athenticating and authorizing access as well as obtaining user profile details.  The main endpoints in this example project are the same type of endpoints you would implement in your system.

This project is not meant as a drop-in component to an existing PHP-based system.  The files contained in this example project are described below.

#### authorize.php
Example endpoint for the initial OAuth2 redirect.  Your system would implement an endpoint like this to handle the login process for end users.  After the user is authenticated by your system you would redirect the user back to the Batterii endpoint with the "authorization token" information in the redirect.

Note: In our example we don't require a login for expediency during testing.

#### token.php
Example, endpoint to handle the token request.  This endpoint allows the Batterii service to request a long term token(s) based on the initial authorization token passed back in the authorize endpoint.  This endpoint is called directly by the Batterii servers.  The response is the actual access token that can then be used by Batterii to make the resource call.

#### resource.php
Example, endpoint for the user profile resource.  This is an example endpoint that returns user profile information for the user that is logged into Batterii.  This endpoint is called directly by the Batterii servers to obtain user profile information (eg, last name, first name).  The response would be the profile information formatted per the Batterii user profile specification.

#### demo_client.php
This is a simple OAuth2 "client" that can be used to test your OAuth2 server implementation.  This is simulating the same interactions that the Batterii system would use to integrate with your own OAuth2 services.

#### index.php

#### server.php
This is included by the other services.  It supplies the basic OAuth2 functionality used in this OAuth2 example.


Credit
-----------------------
This Batterii SSO Provider demo uses the library "[oauth2-server-php](https://github.com/bshaffer/oauth2-server-php)", written by [Brent Shaffer](https://github.com/bshaffer). Parts of this demo were derived from Brent's [oauth2-demo-php](https://github.com/bshaffer/oauth2-demo-php).
