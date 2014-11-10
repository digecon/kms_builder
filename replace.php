#!/usr/bin/php
<?php

if(PHP_SAPI != "cli") { die(); }

/**
 * Elgg module duplicator.
 * @author Sachik Sergey
 */
ini_set('error_reporting',E_ALL);
ini_set('show_errors', true);

require_once dirname(__FILE__).'/builder/functions.php';

if($argc < 4)
{
    echo "Files replaces\n".
         "Usage:\n".
         "php replace.php <dir_name> <replace_from> <replace_to>";
    return;    
}

smart_replace($argv[1], array($argv[2] => $argv[3]));

echo "ok\n";