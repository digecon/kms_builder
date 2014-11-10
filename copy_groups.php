#!/usr/bin/php
<?php
if(PHP_SAPI != "cli") { die(); }
define('KMS_BUILDER', 1);


$elgg_docroot_default = "/var/www/elgg";

error_reporting(E_ALL);
ini_set('display_errors', true);

echo "\nWelcome to KMS groups copier.\n\n";

require_once dirname(__FILE__)."/builder/functions.php";

$elgg_docroot = readline("Elgg docroot [$elgg_docroot_default]:");
if(strlen($elgg_docroot) == 0)
{
    $elgg_docroot = $elgg_docroot_default;
}
$index = intval(readline("Group Index [1]:"));
if($index == 0) $index = 1;

copy_groups($elgg_docroot, $index);



echo "Done.\n\n";

/* 
 * Компоновщик ELGG
 */



