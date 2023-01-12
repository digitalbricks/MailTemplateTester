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
define('SMTP_PORL', 465);
