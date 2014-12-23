<?php

$builder_config = array(
    'modules' => array(
        'remove' => array('tinymce'),
        'install' => array(
            'bottom_bar' => array(
                'type' => 'git',
                'url' => 'https://github.com/notwall/bottom_bar'
            ),
            'etherpad' => array(
                'type' => 'git',
                'url' => 'https://github.com/caedesvvv/elgg-etherpad'
            ),
            'event_calendar' => array(
                'type' => 'git',
                'url' => 'https://github.com/kevinjardine/Elgg-Event-Calendar'
            ),
            'event_manager' => array(
                'type' => 'git',
                'url' => 'https://github.com/ColdTrick/event_manager'
            ),
            'extended_tinymce' => array(
                'type' => 'git_subfolder',
                'url' => 'https://github.com/iionly/Elgg_1.8_1.9_extended_tinymce',
                'path' => 'extended_tinymce'
            ),                        
            'hypeFramework' => array(
                'type' => 'git',
                'url' => 'https://github.com/hypeJunction/hypeFramework'
            ),                        
            'hypeGallery' => array(
                'type' => 'git',
                'url' => 'https://github.com/hypeJunction/hypeGallery'
            ),                        
            'hypeForum' => array(
                'type' => 'git',
                'url' => 'https://github.com/hypeJunction/hypeForum'
            ),                        
            'hypeStyler' => array(
                'type' => 'git',
                'url' => 'https://github.com/hypeJunction/hypeStyler'
            ),                        
            'hypeInbox' => array(
                'type' => 'git',
                'url' => 'https://github.com/hypeJunction/hypeInbox'
            ),                     
            'kms' => array(
                'type' => 'svn',
                'url' => 'https://github.com/digecon/kms'
            ),
            'chili' => array(
                'type' => 'git',
                'url' => 'https://github.com/digecon/chiliproject_module'
            ),
            /*'polls' => array(
                'type' => 'git',
                'url' => 'https://github.com/kevinjardine/polls',
                //'path' => 'source/mod/polls'
            ),
            /*'tabbed_profile' => array(
                'type' => 'git',
                'url' => 'https://github.com/Elgg/tabbed_profile'
            ),*/
            'webinar' => array(
                'type' => 'git',
                'url' => 'https://github.com/bouland/webinar'
            ),
            'widget_manager' => array(
                'type' => 'git',
                'url' => 'https://github.com/ColdTrick/widget_manager'
            ),
            'dokuwiki' => array(
                'type' => 'git',
                'url' => 'https://github.com/lorea/dokuwiki'
            ),
			'group1s' => array(
				'type' => 'copy_groups',
				'index' => 1
			),
			'group2s' => array(
				'type' => 'copy_groups',
				'index' => 2
			),
			'group3s' => array(
				'type' => 'copy_groups',
				'index' => 3
			),
			'blog1' => array(
				'type' => 'copy_blogs',
				'index' => 1
			),
			'thewire1' => array(
				'type' => 'copy_thewire',
				'index' => 1
			),
			'webinar1' => array(
				'type' => 'copy_webinar',
				'index' => 1
			),
			'webinar2' => array(
				'type' => 'copy_webinar',
				'index' => 2
			)
        )
    )
);