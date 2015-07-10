<?php

/* Prevent Direct Access */
defined('ADAPT_STARTED') or die;

$adapt = $GLOBALS['adapt'];
$sql = $adapt->data_source->sql;

$sql->on('adapt.error', function($e){
    print "<h3>SQL error</h3>";
    print "<pre>" . $e['event_data']['error'] . "</pre>";
});

$sql->create_table('menu_type')
    ->add('menu_type_id', 'bigint')
    ->add('bundle_name', 'varchar(128)', false)
    ->add('view', 'varchar(256)', false)
    ->add('name', 'varchar(64)', false)
    ->add('label', 'varchar(64)', false)
    ->add('description', 'text')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('menu_type_id')
    ->execute();

    

$sql->create_table('menu')
    ->add('menu_id', 'bigint')
    ->add('menu_type_id', 'bigint')
    ->add('bundle_name', 'varchar(128)', false)
    ->add('permission_id', 'bigint')
    ->add('name', 'varchar(64)', false)
    ->add('label', 'varchar(64)', false)
    ->add('description', 'text')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('menu_id')
    ->foreign_key('menu_type_id', 'menu_type', 'menu_type_id')
    ->foreign_key('permission_id', 'permission', 'permission_id', \frameworks\adapt\sql::ON_DELETE_SET_NULL)
    ->execute();


$sql->create_table('menu_item')
    ->add('menu_item_id', 'bigint')
    ->add('bundle_name', 'varchar(128)')
    ->add('menu_id', 'bigint')
    ->add('menu_item_type', "enum('Link', 'Dropdown menu', 'Custom view')", false, 'Link')
    ->add('permission_id', 'bigint')
    ->add('custom_view', 'varchar(256)')
    ->add('priority', 'int')
    ->add('name', 'varchar(64)')
    ->add('label', 'html', false)
    ->add('link', 'varchar(256)')
    ->add('description', 'text')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('menu_item_id')
    ->foreign_key('menu_id', 'menu', 'menu_id')
    ->foreign_key('permission_id', 'permission', 'permission_id', \frameworks\adapt\sql::ON_DELETE_SET_NULL)
    ->execute();

$sql->create_table('menu_item_item')
    ->add('menu_item_item_id', 'bigint')
    ->add('bundle_name', 'varchar(128)')
    ->add('menu_item_id', 'bigint')
    ->add('menu_item_item_type', "enum('Link', 'Divider', 'Heading', 'Custom view')", false, 'Link')
    ->add('permission_id', 'bigint')
    ->add('custom_view', 'varchar(256)')
    ->add('priority', 'int')
    ->add('label', 'html', false)
    ->add('link', 'varchar(256)')
    ->add('description', 'text')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('menu_item_item_id')
    ->foreign_key('menu_item_id', 'menu_item', 'menu_item_id')
    ->foreign_key('permission_id', 'permission', 'permission_id', \frameworks\adapt\sql::ON_DELETE_SET_NULL)
    ->execute();

$type = new model_menu_type();
$type->bundle_name = 'menus';
$type->view = '\\extensions\\menus\\view_tabs';
$type->label = 'Tabs';
$type->name = 'bs_tabs';
$type->description = 'Tabs using Bootstrap';
$type->save();

$type = new model_menu_type();
$type->bundle_name = 'menus';
$type->view = '\\extensions\\menus\\view_justified_tabs';
$type->label = 'Justified tabs';
$type->name = 'bs_justified_tabs';
$type->description = 'Justified tabs using Bootstrap';
$type->save();

$type = new model_menu_type();
$type->bundle_name = 'menus';
$type->view = '\\extensions\\menus\\view_pills';
$type->label = 'Pills';
$type->name = 'bs_pills';
$type->description = 'Pills using Bootstrap';
$type->save();

$type = new model_menu_type();
$type->bundle_name = 'menus';
$type->view = '\\extensions\\menus\\view_stacked_pills';
$type->label = 'Stacked Pills';
$type->name = 'bs_stacked_pills';
$type->description = 'Stacked pills using Bootstrap';
$type->save();

$type = new model_menu_type();
$type->bundle_name = 'menus';
$type->view = '\\extensions\\menus\\view_justified_pills';
$type->label = 'Justified pills';
$type->name = 'bs_justified_pills';
$type->description = 'Justified pills using Bootstrap';
$type->save();

$type = new model_menu_type();
$type->bundle_name = 'menus';
$type->view = '\\extensions\\menus\\view_navbar';
$type->label = 'Navigation bar';
$type->name = 'bs_navbar';
$type->description = 'Bootstrap navigation bar';
$type->save();

$type = new model_menu_type();
$type->bundle_name = 'menus';
$type->view = '\\extensions\\menus\\view_nav';
$type->label = 'Navigation bar (inner nav)';
$type->name = 'bs_navbar_nav';
$type->description = 'Bootstrap navigation bar (Inner nav)';
$type->save();

$type = new model_menu_type();
$type->bundle_name = 'menus';
$type->view = '\\extensions\\menus\\view_pipe';
$type->label = 'Pipe seperatred menu';
$type->name = 'pipe';
$type->description = 'Simple pipe seperated menu';
$type->save();


?>