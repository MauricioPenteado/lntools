<?php

$config = array();

$config['username_domain'] = 'lnmail.com';

// Database connection string (DSN) for read+write operations
// Format: db_provider://user:password@host/database
// Currently supported db_providers: mysql, pgsql, sqlite, mssql or sqlsrv
// For examples see http://pear.php.net/manual/en/package.database.mdb2.intro-dsn.php
// NOTE: for SQLite use absolute path: 'sqlite:////full/path/to/sqlite.db?mode=0646'
$config['db_dsnw'] = 'mysql://roundcube:password@localhost/roundcube';

// ----------------------------------
// PLUGINS
// ----------------------------------
// List of active plugins (in plugins/ directory)
$config['plugins'] = array();

// the mail host chosen to perform the log-in
// leave blank to show a textbox at login, give a list of hosts
// to display a pulldown menu or set one host as string.
// To use SSL/TLS connection, enter hostname with prefix ssl:// or tls://
//$config['default_host'] = '';
//$config['default_host'] = array('ssl://imap.example.com', 'ssl://mail.example.com', );
//$config['default_host'] = 'tls://imap.example.com';

// TCP port used for IMAP connections
$config['default_port'] = 143;

// Automatically create a new Roundcube user when log-in the first time.
// A new user will be created once the IMAP login succeeds.
// Set to false if only registered users can use this service
$config['auto_create_user'] = true;

// ----------------------------------
// IMAP
// ----------------------------------
// The mail host chosen to perform the log-in.
// Leave blank to show a textbox at login, give a list of hosts
// to display a pulldown menu or set one host as string.
// To use SSL connection, enter hostname with prefix ssl://
//$config['default_host'] = '';
//$config['default_host'] = array('ssl://imap.example.com', 'ssl://mail.example.com', );
//$config['default_host'] = 'tls://imap.example.com';

// TCP port used for IMAP connections
$config['default_port'] = 143;

// ----------------------------------
// SMTP
// ----------------------------------
// SMTP server host (for sending mails).
// To use SSL/TLS connection, enter hostname with prefix ssl:// or tls://
// If left blank, the PHP mail() function is used
// Supported replacement variables:
// %h - user's IMAP hostname
// %n - hostname ($_SERVER['SERVER_NAME'])
// %t - hostname without the first part
// %d - domain (http hostname $_SERVER['HTTP_HOST'] without the first part)
// %z - IMAP domain (IMAP hostname without the first part)
// For example %n = mail.domain.tld, %t = domain.tld
//$config['smtp_server'] = '';
//$config['smtp_server'] = 'tls://smtp.example.com';
$config['smtp_server'] = 'localhost';

// SMTP port (default is 25; use 587 for STARTTLS or 465 for the
// deprecated SSL over SMTP (aka SMTPS))
$config['smtp_port'] = 25;

// SMTP username (if required) if you use %u as the username Roundcube
// will use the current username for login
$config['smtp_user'] = '%u';

// SMTP password (if required) if you use %p as the password Roundcube
// will use the current user's password for login
$config['smtp_pass'] = '%p';

// ----------------------------------
// SYSTEM
// ----------------------------------
// use this folder to store log files (must be writeable for apache user)
// This is used when log_driver = 'file'.
$config['log_dir'] = '/var/log/roundcube/';

// use this folder to store temp files (must be writeable for apache user)
$config['temp_dir'] = '/var/temp/';

// List of active plugins (in plugins/ directory)
$config['plugins'] = array();

// skin name: folder from skins/
$config['skin'] = 'elastic';

?>
