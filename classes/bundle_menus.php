<?php

namespace adapt\menus{
    
    /* Prevent Direct Access */
    defined('ADAPT_STARTED') or die;
    
    class bundle_menus extends \adapt\bundle{
        
        protected $_menus;
        
        public function __construct($data){
            parent::__construct('menus', $data);
            
            $this->_menus = array();
            
            $this->register_config_handler('menus', 'menus', 'process_menus_tag');
        }
        
        public function install_menus($bundle){
            if ($bundle instanceof \adapt\bundle){
                foreach($this->_menus as $menu){
                    if ($menu['bundle_name'] == $bundle->name){
                        
                        
                        $model_menu = new model_menu();
                        $model_menu->bundle_name = $menu['bundle_name'];
                        $model_menu->menu_type = $menu['menu_item'];
                        $model_menu->name = $menu['name'];
                        $model_menu->label = $menu['label'];
                        $model_menu->description = $menu['description'];
                        
                        
                        if ($menu['permission_id'] != ""){
                            $permission = new model_permission();
                            
                            if ($permission->load_by_php_key($menu['permission_id'])){
                                $model_menu->permission_id = $permission->permission_id;
                            }
                        }
                        
                        foreach($menu['menu_items'] as $item){
                            
                            $model_item = new model_menu_item();
                            $model_item->bundle_name = $item['bundle_name'];
                            $model_item->menu_item_type = $item['menu_item_type'];
                            $model_item->priority = $item['priority'];
                            $model_item->permission_id = $permission->permission_id;
                            $model_item->custom_view = $item['custom_view'];
                            $model_item->link = $item['link'];
                            $model_item->name = $item['name'];
                            $model_item->label = $item['label'];
                            $model_item->description = $item['description'];
                            
                            if ($item['permission_id'] != ""){
                                $permission = new model_permission();
                                
                                if ($permission->load_by_php_key($item['permission_id'])){
                                    $model_item->permission_id = $permission->permission_id;
                                }
                            }
                            
                            foreach($item['menu_item_items'] as $sub){
                                $model_sub = new model_menu_item_item();
                                $model_sub->bundle_name = $sub['bundle_name'];
                                $model_sub->menu_item_item_type = $sub['menu_item_item_type'];
                                $model_sub->custom_view = $sub['custom_view'];
                                $model_sub->link = $sub['link'];
                                $model_sub->priority = $sub['priority'];
                                $model_sub->label = $sub['label'];
                                $model_sub->description = $sub['description'];
                                
                                if ($sub['permission_id'] != ""){
                                    $permission = new model_permission();
                                    if ($permission->load_by_php_key($sub['permission_id'])){
                                        $model_sub->permission_id = $permission->permission_id;
                                    }
                                }
                                
                                $model_item->add($model_sub);
                            }
                            
                            $model_menu->add($model_item);
                        }
                        
                        $model_menu->save();
                    }
                }
            }
        }
        
        
        public function process_menus_tag($bundle, $tag_data){
            if ($bundle instanceof \adapt\bundle && $tag_data instanceof \adapt\xml){
                
                $this->register_install_handler($this->name, $bundle->name, 'install_menus');
                
                $menu_nodess = $tag_data->get();
                
                foreach($menu_nodes as $menu_node){
                    if ($menu_node instanceof \adapt\xml && $menu_node->tag == "menu"){
                        $menu = array(
                            'bundle_name' => $bundle->name,
                            'menu_type' => $menu_node->attr('type'),
                            'permission_id' => $menu_node->attr('permission'),
                            'name' => $menu_node->attr('name'),
                            'label' => $menu_node->attr('label'),
                            'description' => $menu_node->attr('description'),
                            'menu_items' => array()
                        );
                        
                        $item_nodes = $menu_node->get();
                        
                        foreach($item_nodes as $item_node){
                            if ($item_node instanceof \adapt\xml && $item_node->tag == 'item'){
                                $item = array(
                                    'bundle_name' => $bundle->name,
                                    'menu_item_type' => $item_node->attr('type'),
                                    'priority' => count($menu['menu_items']) + 1,
                                    'permission_id' => $item_node->attr('permission'),
                                    'custom_view' => $item_node->attr('custom-view'),
                                    'link' => $item_node->attr('link'),
                                    'name' => $item_node->attr('name'),
                                    'label' => $item_node->attr('label'),
                                    'description' => $item_node->attr('description'),
                                    'menu_item_items' => array()
                                );
                                
                                $sub_nodes = $item_node->get();
                                
                                foreach($sub_nodes as $sub_node){
                                    if ($sub_node instanceof \adapt\xml && $sub_node->tag == 'sub_item'){
                                        $sub = array(
                                            'bundle_name' => $bundle->name,
                                            'menu_item_item_type' => $sub_node->attr('type'),
                                            'permission_id' => $sub_node->attr('permission'),
                                            'custom_view' => $sub_node->attr('custom-view'),
                                            'link' => $sub_node->attr('link'),
                                            'priority' => count($item['menu_item_items']) + 1,
                                            'label' => $sub_node->attr('label'),
                                            'description' => $sub_node->attr('description')
                                        );
                                        
                                        $item['menu_item_items'][] = $sub;
                                    }
                                }
                                
                                $menu['menu_items'][] = $item;
                            }
                        }
                        
                        $this->_menus[] = $menu;
                    }
                }
            }
        }
        
        
        
    }
    
    
}

?>