<?php


function copy_groups($elgg_docroot, $index = 1, $replace = false)
{		
	echo "copy groups started for dir $elgg_docroot, index: $index\n";
	$from = $elgg_docroot."/mod/groups";
	$to = $elgg_docroot."/mod/group{$index}s";
	
	if(file_exists($to."/start.php"))
	{
		if($replace == false)
		{
			echo "module already exists...\n";
			return;
		}
		rrmdir($to);
		mkdir($to);
	}
	
	recurse_copy($from, $to);
	
	smart_rename($to, array(
		"group" => "group{$index}",
		"discussion" => "discussion{$index}"
	));		
		
	smart_replace($to, array(
		"group" => "group{$index}",
		"Groups" => "Groups{$index}",
		"discussion" => "discussion{$index}",
		"activity" => "activity{$index}",
		"add_group{$index}_tool_option" => "add_group_tool_option",
		"create_group{$index}_entity" => "create_group_entity",
		"group{$index}_gatekeeper" => "group_gatekeeper",
		"'type' => 'group{$index}'" => "'type' => 'group','subtype' => 'group{$index}'",
		"elgg_register_entity_url_handler('group{$index}', 'all', 'group{$index}s_url');" => "elgg_register_entity_url_handler('group', 'group{$index}', 'group{$index}s_url');"
	));					
		
	mkdir($to."/classes");
	copy($elgg_docroot."/engine/classes/ElggGroup.php",$to."/classes/ElggGroup{$index}.php");
	
	smart_replace($to, array(
		"ElggGroup" => "ElggGroup{$index}",		
		"\$this->attributes['type'] = \"group\";" => "\$this->attributes['type'] = \"group\"; \$this->attributes['subtype'] = \"group{$index}\";",		
		"get_group{$index}_members" => "get_group_members",
		"\$handler != 'group{$index}s'" => "\$handler != 'groups'",
		//"group{$index}_tool_options" => "group_tool_options"
	));	
		
	smart_preg_replace($to, array(
		"/elgg_instanceof\\(([^,]*), 'group{$index}'\\)/" => "elgg_instanceof(\$1, 'group','group{$index}')",				
		"/elgg_instanceof\\(([^,]*), 'group{$index}'\\, ''/" => "elgg_instanceof(\$1, 'group','group{$index}'",
				
		//elgg_instanceof($group1, 'group1', ''
				
	));
		
	$manifest = $to."/manifest.xml";
	$manifest_contents = str_replace("Groups", "Groups copy {$index}", file_get_contents($manifest));
	file_put_contents($manifest, $manifest_contents);
	
	$activate_contents = file_get_contents(dirname(dirname(__FILE__))."/copy/groups_activate.php");
	$activate_contents = str_replace("groupx", "group{$index}", $activate_contents);
	$activate_contents = str_replace("ElggGroup", "ElggGroup{$index}", $activate_contents);
	file_put_contents($to."/activate.php", $activate_contents);
	
	
}

function copy_blogs($elgg_docroot, $index = 1, $replace = false)
{
	echo "copy blogs started for dir $elgg_docroot, index: $index\n";
	$from = $elgg_docroot."/mod/blog";
	$to = $elgg_docroot."/mod/blog{$index}";
	$module_name = "Blogs copy {$index}";
	
	if(file_exists($to."/start.php"))
	{
		if($replace == false)
		{
			echo "module '$module_name' already exists.\n";
			return;
		}
		rrmdir($to);
		mkdir($to);
	}
	
	recurse_copy($from, $to);
	
	smart_rename($to, array(
		"blog" => "blog{$index}",
		"Blog" => "Blog{$index}"
	));		
		
	smart_replace($to, array(
		"blog" => "blog{$index}",
		"Blog" => "Blog{$index}"		
	));			
		
	$manifest = $to."/manifest.xml";
	$manifest_contents = str_replace("Blog", $module_name, file_get_contents($manifest));
	file_put_contents($manifest, $manifest_contents);	
}

function copy_thewire($elgg_docroot, $index = 1, $replace = false)
{
	echo "copy thewire started for dir $elgg_docroot, index: $index\n";
	$from = $elgg_docroot."/mod/thewire";
	$to = $elgg_docroot."/mod/thewire{$index}";
	$module_name = "The Wire copy {$index}";
	
	if(file_exists($to."/start.php"))
	{
		if($replace == false)
		{
			echo "module '$module_name' already exists.\n";
			return;
		}
		rrmdir($to);
		mkdir($to);
	}
	
	recurse_copy($from, $to);
	
	smart_rename($to, array(
		"wire" => "wire{$index}",
		"Wire" => "Wire{$index}"
	));		
		
	smart_replace($to, array(
		"wire" => "wire{$index}",
		"Wire" => "Wire{$index}"		
	));			
		
	$manifest = $to."/manifest.xml";
	$manifest_contents = str_replace("The Wire", $module_name, file_get_contents($manifest));
	file_put_contents($manifest, $manifest_contents);	
}

function copy_chili($elgg_docroot, $index = 1)
{
	echo "copy chili started for dir $elgg_docroot, index: $index\n";
	$from = $elgg_docroot."/mod/chili";
	$to = $elgg_docroot."/mod/chili{$index}";
	$module_name = "Chili copy {$index}";
	
	if(file_exists($to."/start.php"))
	{
		if($replace == false)
		{
			echo "module '$module_name' already exists.\n";
			return;
		}
		rrmdir($to);
		mkdir($to);
	}
	
	recurse_copy($from, $to);
	
	smart_rename($to, array(
		"chili" => "chili{$index}",
	));		
		
	smart_replace($to, array(
		"chili" => "chili{$index}"
	));			
		
	$manifest = $to."/manifest.xml";
	$manifest_contents = str_replace("Chili", $module_name, file_get_contents($manifest));
	file_put_contents($manifest, $manifest_contents);	
}

function copy_webinar($elgg_docroot, $index = 1)
{
	echo "copy webinar started for dir $elgg_docroot, index: $index\n";
	$from = $elgg_docroot."/mod/webinar";
	$to = $elgg_docroot."/mod/webinar{$index}";
	$module_name = "Webinar copy {$index}";
	
	if(file_exists($to."/start.php"))
	{
		if($replace == false)
		{
			echo "module '$module_name' already exists.\n";
			return;
		}
		rrmdir($to);
		mkdir($to);
	}
	
	recurse_copy($from, $to);
	
	smart_rename($to, array(
		"webinar" => "webinar{$index}",
		"Webinar" => "Webinar{$index}",
	),array('bbb-api-php'));		
		
	smart_replace($to, array(
		"webinar" => "webinar{$index}",
		"ElggWebinar" => "ElggWebinar{$index}"
	),array('bbb-api-php'));			
		
	$manifest = $to."/manifest.xml";
	$manifest_contents = str_replace("Webinar", $module_name, file_get_contents($manifest));
	file_put_contents($manifest, $manifest_contents);	
}
