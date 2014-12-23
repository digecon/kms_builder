#!/usr/bin/php
<?php
if(PHP_SAPI != "cli") { die(); }
define('KMS_BUILDER', 1);


$elgg_docroot_default = "/var/www/elgg";

error_reporting(E_ALL);
ini_set('display_errors', true);

echo "\nWelcome to KMS project builder.\n\n";

require_once dirname(__FILE__)."/builder/config.php";
require_once dirname(__FILE__)."/builder/functions.php";
require_once dirname(__FILE__)."/builder/copiers.php";

$elgg_docroot = readline("Elgg docroot [$elgg_docroot_default]:");
if(strlen($elgg_docroot) == 0)
{
    $elgg_docroot = $elgg_docroot_default;
}

if(!file_exists($elgg_docroot) || !file_exists($elgg_docroot."/index.php"))
{
    while(true)
    {
        $answer = trim(readline("Elgg not found in $elgg_docroot. Install it?[y/n]:"));
        if($answer == 'y')
        {
            install_elgg($elgg_docroot);
            break;           
        }
        if($answer == 'n')
        {
            echo "nothing to do.\n";
            exit;
        }
    }
    
}

$mod_root = realpath($elgg_docroot)."/mod/";

foreach($builder_config['modules']['remove'] as $remove_module)
{
    $remove_module_path = $mod_root.$remove_module;
    if(file_exists($remove_module_path))
    {
        echo "removing module $remove_module...";
        rrmdir($remove_module_path);
        echo "ok\n";
    }
}

echo "\nInstalling modules:\n";

$copiyng_modules = array();

foreach($builder_config['modules']['install'] as $module => $module_config)
{
	echo "checking $module\n";
    $mod_path = $mod_root.$module;
    if(file_exists($mod_path) && file_exists($mod_path."/start.php"))
    {
        
        switch($module_config['type'])
        {
            case 'git':
                chdir($mod_path);
                passthru("/usr/bin/git checkout");
                break;
            case 'git_subfolder':       
                $repo_path = $mod_path."/rep/";
                chdir($repo_path);
                passthru("/usr/bin/git checkout");            

                $objects = scandir($mod_path);
                foreach ($objects as $object) {
                  if ($object != "." && $object != "..") {
                    if (filetype($mod_path."/".$object) == "dir")
                    {
                        if($object != 'rep')
                        {
                            rrmdir($mod_path."/".$object);
                        }
                    }
                    else
                    {
                        unlink($mod_path."/".$object);
                    }
                  }
                }
                reset($objects);
                recurse_copy($repo_path.$module_config['path'], $mod_path);       
                break;
            case 'svn':
                chdir($mod_path);
                passthru("/usr/bin/svn up");
                break;
			case 'copy':
				if($module_config['source'] == 'groups')
				{
					copy_groups(realpath($elgg_docroot), $module_config['index']);
				}				
        }                
                     
    }
    else
    {
        echo "installing $module to $mod_path...\n";

        if(file_exists($mod_path))
        {
            rrmdir($mod_path);
        }
        
        mkdir($mod_path);

        switch($module_config['type'])
        {
            case 'git':
				$branchtext = isset($module_config['branch']) ? "--branch {$module_config['branch']} " : "";								
                passthru("/usr/bin/git clone {$branchtext}{$module_config['url']} $mod_path");
                break;
            case 'git_subfolder':       
                $repo_path = $mod_path."/rep/";
                mkdir($repo_path);
                passthru("/usr/bin/git clone {$module_config['url']} $repo_path");
                recurse_copy($repo_path.$module_config['path'], $mod_path);        
                break;
            case 'svn':
                passthru("/usr/bin/svn co {$module_config['params']} {$module_config['url']} $mod_path");
                break;
			case 'copy_groups':				
			case 'copy_blogs':
			case 'copy_thewire':
			case 'copy_chili':
			case 'copy_webinar':
				$copiyng_modules[] = array($module_config['type'], array($elgg_docroot, $module_config['index']));
				break;
			default:
				throw new Exception("bad type: {$module_config['type']}");
        }        
        
        echo "module $module installed.\n";
    }
        
}

exec("chown -R apache:apache $elgg_docroot");

/**
 * updating language
 */
$temp_dir = tempdir();
echo "updating language...\n";
exec("git clone https://github.com/digecon/elgg_rus $temp_dir");
recurse_copy($temp_dir, realpath($elgg_docroot));
rrmdir($temp_dir);
echo "language updated\n";

foreach(glob($mod_root."*") as $module_dir)
{
	if(strpos($module_dir,".") === false && is_dir($module_dir))
	{
		if(file_exists($module_dir."/languages") && !file_exists($module_dir."/start.php"))
		{
			echo "rrmdir $module_dir\n";
			rrmdir($module_dir);
		}
	}
}

echo "copying modules...\n";

foreach($copiyng_modules as $data)
{
	call_user_func_array($data[0], $data[1]);
}

copy(dirname(__FILE__)."/copy/.htaccess", $elgg_docroot."/.htaccess");



echo "Done.\n\n";

/* 
 * Компоновщик ELGG
 */



