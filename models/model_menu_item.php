<?php

namespace extensions\menus{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class model_menu_item extends \frameworks\adapt\model{
        
        public function __construct($id = null){
            parent::__construct('menu_item', $id);
        }
        
        /* Over-ride the initialiser to auto load children */
        public function initialise(){
            /* We must initialise first! */
            parent::initialise();
            
            /* We need to limit what we auto load */
            $this->_auto_load_only_tables = array(
                'menu_item_item'
            );
            
            /* Switch on auto loading */
            $this->_auto_load_children = true;
        }
        
        public function get_view(&$nav){
            if ($this->is_loaded){
                
                switch($this->menu_item_type){
                case "Link":
                    $nav->add($this->label, $this->link);
                    break;
                case "Dropdown menu":
                case "Custom view":
                }
                
                //$style = \extensions\bootstrap_views\view_form::NORMAL;
                //if ($this->style == 'Inline'){
                //    $style = \extensions\bootstrap_views\view_form::INLINE;
                //}elseif($this->style == 'Horizontal'){
                //    $style = \extensions\bootstrap_views\view_form::HORIZONTAL;
                //}
                //$show_steps = $this->show_steps == 'Yes' ? true : false;
                //$show_processing_page = $this->show_processing_page == 'Yes' ? true : false;
                //$view = new view_form($this->submission_url, $this->actions, $this->method, $this->title, $this->description, $style, $show_steps, $show_processing_page);
                //$view->attr('data-form_id', $this->form_id);
                //
                //for($i = 0; $i < $this->count(); $i++){
                //    $child = $this->get($i);
                //    if (is_object($child) && $child instanceof model_form_page){
                //        $view->add($child->get_view($form_data));
                //    }
                //}
                //
                //return $view;
            }
            
            return null;
        }
        
    }
    
}

?>