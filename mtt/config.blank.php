<?php

// default receiver address prefilled in UI
define('DEFAULT_MAIL_RECEIVER', 'info@example.com');

// mail sending method: 'php' for PHP mail() or 'smtp' for SMTP
define('MAIL_METHOD', 'php');

// if using SMTP, define server settings
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_AUTH', true);
define('SMTP_USERNAME', 'user@example.com');
define('SMTP_PASSWORD', 'secret');
define('SMTP_TLS', false);
define('SMTP_PORT', 465);





/*
 * NOTE: The config.php is copied from mtt/config.blank.php
 * on the first run of index.php (if not already exists).
 * So make sure available settings are in sync on both files.
 * */