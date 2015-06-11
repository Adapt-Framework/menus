<?php

namespace extensions\menus{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class view_nav extends \extensions\bootstrap_views\view_nav{
        
        public function __construct($items = array(), $selected_item = null){
            parent::__construct('navbar', $items, $selected_item);
            $this->add_class('menus');
        }
        
    }

}

?>