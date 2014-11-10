<?php
/**
 * Register the ElggBlog class for the object/blog subtype
 */

if (get_subtype_id('group', 'groupx')) {
        update_subtype('group', 'groupx', 'ElggGroup');
} else {
        add_subtype('group', 'groupx', 'ElggGroup');
}                  