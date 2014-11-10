<?php

function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }
 
 function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' ) && ( $file != '.svn' ) && ( $file != '.git' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
} 


function tempdir($dir=false,$prefix='php') {
    $tempfile=tempnam('','');
    if (file_exists($tempfile)) { unlink($tempfile); }
    mkdir($tempfile);
    if (is_dir($tempfile)) { return $tempfile; }
}

function install_elgg($docroot)
{
    if(!file_exists($docroot))
    {
        mkdir($docroot, 0777);
    }
    passthru("/usr/bin/git clone https://github.com/Elgg/Elgg $docroot/");    
    chdir("$docroot/");
    passthru("git checkout -t -b 1.8 remotes/origin/1.8");
    
    $settings_contents = file_get_contents($docroot."/engine/settings.example.php");
    echo "please enter configuration settings:\n";
    if(preg_match_all("#'{{([a-z]+)}}'#", $settings_contents, $results))
    {
        foreach($results[1] as $key)
        {
            $value = readline("$key:");
            if(strlen($value) == 0)
            {
                $value = 'null';
            }
            else
            {
                $value = "'$value'";
            }
            $settings_contents = str_replace("'{{{$key}}}'", $value, $settings_contents);
        }
    }
    file_put_contents($docroot."/engine/settings.php", $settings_contents);        
}

function smart_rename($directory, $replace_args, $ignore_names = array())
{
    $dir = opendir($directory); 
	
    while($file = readdir($dir)) { 
        if($file === false){
            break;
        }	
		
		if($file == '.' || $file == '..' || 
				array_search($file, $ignore_names) !== false)
		{
			continue;
		}
		
            if ( is_dir($directory . '/' . $file) ) {                 
				
                $file1 = $file;
                foreach($replace_args as $key => $value)
                {
                    $file1 = str_replace($key, $value, $file1);
                }                
                rename($directory . '/' . $file,$directory . '/' . $file1); 
				smart_rename($directory . '/' . $file1, $replace_args,$ignore_names);				
            } 
            else { 
                
                $file1 = $file;
                foreach($replace_args as $key => $value)
                {
                    $file1 = str_replace($key, $value, $file1);
                }                
				rename($directory . '/' . $file,$directory . '/' . $file1);               
                
            } 
        } 
    closedir($dir); 
}

function smart_replace($src, $replace_args, $ignore_names = array()) { 
    $dir = opendir($src); 
    @mkdir($dst); 
	
    while($file = readdir($dir)) { 
        if($file === false){
            break;
        }
		
		if($file == '.' || $file == '..' || 
				array_search($file, $ignore_names) !== false)
		{
			continue;
		}		
		
		if ( is_dir($src . '/' . $file) ) {                 
			smart_replace($src . '/' . $file, $replace_args,$ignore_names);				
		} 
		else { 

			if(strpos($file, ".php") !== false)
			{
				$contents = file_get_contents($src . '/' . $file);
				foreach($replace_args as $key => $value)
				{
					$contents = str_replace($key, $value, $contents);
				}                    
				file_put_contents($src . '/' . $file, $contents);
			}                  

		} 
       
    } 
    closedir($dir); 
} 

function smart_preg_replace($src, $replace_args, $ignore_names = array())
{
	$dir = opendir($src); 
    @mkdir($dst); 
	
    while($file = readdir($dir)) { 
        if($file === false){
            break;
        }
		
		if($file == '.' || $file == '..' || 
				array_search($file, $ignore_names) !== false)
		{
			continue;
		}		
		
		if ( is_dir($src . '/' . $file) ) {                 
			smart_preg_replace($src . '/' . $file, $replace_args,$ignore_names);				
		} 
		else { 

			if(strpos($file, ".php") !== false)
			{
				$contents = file_get_contents($src . '/' . $file);
				foreach($replace_args as $key => $value)
				{
					$contents = preg_replace($key, $value, $contents);
				}                    
				file_put_contents($src . '/' . $file, $contents);
			}                  

		} 
       
    } 
    closedir($dir);
}

