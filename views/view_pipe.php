<?php

namespace adapt\menus{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class view_pipe extends view{
        
        public function __construct($items = array(), $selected_item = null){
            parent::__construct('nav');
            $this->add_class('menus');
            
            $first = true;
            foreach($items as $menu_item){
                if ($menu_item instanceof model_menu_item){
                    if (!isset($menu_item->permission_id) || $this->session->user->has_permission($menu_item->permission_id)){
                        
                        switch($menu_item->menu_item_type){
                        case "Link":
                            if (!$first){
                                $this->add(" | ");
                            }else{
                                $first = false;
                            }
                            $this->add(new html_a($menu_item->label, array('href' => $menu_item->link)));
                            //$this->add($menu_item->label, $menu_item->link);
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