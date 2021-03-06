<?php

namespace adapt\menus{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class view_justified_tabs extends \bootstrap\views\view_nav{
        
        public function __construct($items = array(), $selected_item = null){
            parent::__construct('tabs', null, $selected_item);
            $this->add_class('menus');
            $this->justified = true;
            
            foreach($items as $menu_item){
                if ($menu_item instanceof model_menu_item){
                    if (!isset($menu_item->permission_id) || $this->session->user->has_permission($menu_item->permission_id)){
                        switch($menu_item->menu_item_type){
                        case "Link":
                            $this->add($menu_item->label, $menu_item->link);
                            break;
                        case "Dropdown menu":
                            $items = $menu_item->get();
                            $menu = new \bootstrap\views\view_dropdown($menu_item->label);
                            $this->add($menu);
                            foreach($items as $item){
                                if (is_object($item) && $item instanceof model_menu_item_item){
                                    if (!isset($item->permission_id) || $this->session->user->has_permission($item->permission_id)){
                                        switch($item->menu_item_item_type){
                                        case "Link":
                                            $menu->add(new \bootstrap\views\view_dropdown_menu_item($item->label, $item->link));
                                            break;
                                        case "Divider":
                                            $menu->add(new \bootstrap\views\view_dropdown_divider());
                                            break;
                                        case "Heading":
                                            $menu->add(new \bootstrap\views\view_dropdown_header($item->label));
                                            break;
                                        case "Custom view":
                                            //TODO:
                                            break;
                                        }
                                    }
                                }
                            }
                            break;
                        case "Custom view":
                            //TODO:
                            break;
                        }
                    }
                }
            }
            
            $this->selected_item = $selected_item;
        }
        
    }

}

?>