<?php
// Toggle this to change the setting
define('DEBUG', false);

// You want all errors to be triggered
error_reporting(E_ALL);

if (DEBUG)
{
    ini_set('display_errors', 'On');
}
else
{
    ini_set('display_errors', 'Off');
}