#!/usr/bin/php
<?php

if(PHP_SAPI != "cli") { die(); }

/**
 * Elgg module duplicator.
 * @author Sachik Sergey
 */
ini_set('error_reporting',E_ALL);
ini_set('show_errors', true);

if($argc < 3)
{
    echo "Files renamer\n".
         "Usage:\n".
         "php renamer.php <dir_name> <replace_from> <replace_to>";
    return;    
}

function recurse_copy($src,$dst, $replace_args) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while($file = readdir($dir)) { 
        if($file === false){
            break;
        }
        echo "file:".$file."\n";
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                
                $file1 = $file;
                foreach($replace_args as $key => $value)
                {
                    $file1 = str_replace($key, $value, $file1);
                }
                
                recurse_copy($src . '/' . $file,$dst . '/' . $file1); 
            } 
            else { 
                
                $file1 = $file;
                foreach($replace_args as $key => $value)
                {
                    $file1 = str_replace($key, $value, $file1);
                }                
                
                if(strpos($file1, ".php") !== false)
                {
                    $contents = file_get_contents($src . '/' . $file);
                    foreach($replace_args as $key => $value)
                    {
                        $contents = str_replace($key, $value, $file1);
                    }                    
                    file_put_contents($dst . '/' . $file1, $contents);
                }
                else
                {
                    copy($src . '/' . $file,$dst . '/' . $file1); 
                }
                
                
            } 
        } 
    } 
    closedir($dir); 
} 


var_dump($argv);die();
$module = $argv[1];
$postfix = $argv[2];
$replace_args = array();
$replace_args_arr = explode("-", $argv[3]);
foreach($replace_args_arr as $replace_arg)
{
    $arr = explode($replace_arg, ",");    
    if(count($arr) == 2)
    {
        $replace_args[$arr[0]] = $arr[1];
    }
}
var_dump($replace_args);
$old_module_location = dirname(__FILE__)."/".$module;
$new_module_location = dirname(__FILE__)."/".$module."_".$postfix;

mkdir($new_module_location);

echo "copying files...";
recurse_copy($old_module_location, $new_module_location, $replace_args);
exec ("chmod -R 0777 $new_module_location");
echo "ok\n";