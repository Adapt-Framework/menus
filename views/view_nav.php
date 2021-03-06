<?php

namespace adapt\menus{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class view_nav extends \bootstrap\views\view_nav{
        
        public function __construct($items = array(), $selected_item = null){
            parent::__construct('navbar', null, $selected_item);
            $this->add_class('menus');
            
            foreach($items as $menu_item){
                if ($menu_item instanceof model_menu_item){
                    if (!$menu_item->permission_id || $this->session->user->has_permission($menu_item->permission_id)){
                        $label = $menu_item->label;
                        if ($menu_item->icon_class && $menu_item->icon_name && class_exists($menu_item->icon_class)){
                            $class = $menu_item->icon_class;
                            $icon = new $class($menu_item->icon_name);
                            if ($icon && $icon instanceof \adapt\html){
                                $label = trim($icon . " " . $label);
                            }
                        }
                        switch($menu_item->menu_item_type){
                        case "Link":
                            $this->add($label, $menu_item->link);
                            break;
                        case "Dropdown menu":
                            $items = $menu_item->get();
                            $menu = new \bootstrap\views\view_dropdown($label);
                            $this->add($menu);
                            foreach($items as $item){
                                if (is_object($item) && $item instanceof model_menu_item_item){
                                    if (!$item->permission_id || $this->session->user->has_permission($item->permission_id)){
                                        $label = $item->label;
                                        if ($item->icon_class && $item->icon_name && class_exists($item->icon_class)){
                                            $class = $item->icon_class;
                                            $icon = new $class($item->icon_name);
                                            if ($icon && $icon instanceof \adapt\html){
                                                $label = trim($icon . " " . $label);
                                            }
                                        }
                                        switch($item->menu_item_item_type){
                                        case "Link":
                                            $menu->add(new \bootstrap\views\view_dropdown_menu_item($label, $item->link));
                                            break;
                                        case "Divider":
                                            $menu->add(new \bootstrap\views\view_dropdown_divider());
                                            break;
                                        case "Heading":
                                            $menu->add(new \bootstrap\views\view_dropdown_header($label));
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