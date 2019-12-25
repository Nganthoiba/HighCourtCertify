<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author Nganthoiba
 */
class Menu extends model{
    public $menu_id; //menu id
    public $menu_name; //name of the menu
    public $link;//link or url of the menu
    public $parent_menu_id;//for sub menu
    public $sequence;//for sequence of displaying menu
    //Overriding Constructor for menu
    public function __construct() {
        parent::__construct();
        $this->setKey("menu_id");
        $this->setTable("Menu");
        
        $this->menu_name = "";
        $this->link = "";
        $this->parent_menu_id = NULL;
        $this->sequence = NULL;
        
    }
    //Add new menu
    public function add(){
        $this->menu_id = $this->findMaxColumnValue('menu_id')+1;
        $this->sequence = $this->findMaxColumnValue('sequence')+1;
        $data = [
            "menu_id"=>$this->menu_id,
            "menu_name"=>$this->menu_name,
            "link"=>$this->link,
            "parent_menu_id"=>$this->parent_menu_id,
            "sequence"=>$this->sequence
        ];
        return parent::create($data);
    }
    //read menu
    public function read($columns = array (), $cond = array (), $order_by = "") {
        return parent::read($columns, $cond, $order_by);
    }
    //save menu
    public function save(){
        $params = [
            "menu_name"=>$this->menu_name,
            "link"=>$this->link,
            "parent_menu_id"=>$this->parent_menu_id,
            "sequence"=>$this->sequence
        ];
        $cond = [
            $this->getKey() => $this->menu_id
        ];
        return parent::update($params, $cond);
    }
    //remove menu
    public function remove(){
        $cond = [
            $this->getKey() => $this->menu_id
        ];
        return parent::delete($cond);
    }    
}
