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
1. Add the demo client as an OAuth Client with the following SQL statement

```sql
INSERT INTO oauth_clients (client_id, client_secret, redirect_uri) VALUES ("Batterii SSO", "ae033c5653e254aa8a0a53ed3c48e460", "http://localhost:8000/client.php");
```

2. Fire up a PHP development server.

``` php -S localhost:8000 ```

3. Point your browser at http://localhost:8000/client.php


Credit
-----------------------
This Batterii SSO Provider demo uses the library "[oauth2-server-php](https://github.com/bshaffer/oauth2-server-php)", written by [Brent Shaffer](https://github.com/bshaffer). Parts of this demo were derived from Brent's [oauth2-demo-php](https://github.com/bshaffer/oauth2-demo-php).