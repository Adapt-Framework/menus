<?php

namespace adapt\menus{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class model_menu_item_item extends \adapt\model{
        
        public function __construct($id = null){
            parent::__construct('menu_item_item', $id);
        }
        
    }
    
}

?>