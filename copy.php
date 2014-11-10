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

if($argc < 3)
{
    echo "Files copier\n".
         "Usage:\n".
         "php copy.php <dir_from> <dir_to>";
    return;    
}

recurse_copy($argv[0], $argv[1]);

echo "ok\n";