<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuReader
 *
 * @author Nganthoiba
 */
class MenuReader {
    private $conn;
    public function __construct() {
        $this->conn = Database::connect();
    }
    
    public function readMenu($role_id){
        $parent_menus = $this->getParentMenus($role_id);
        $menu = array();
        foreach ($parent_menus as $parent_menu) {
            $parent_menu['child_menu'] = $this->getChildMenus($parent_menu['menu_id']);
            $menu[] = $parent_menu;
        }
        return $menu;
    }
    
    private function getParentMenus($role_id){
        $qry =  " select * from menu M  ".
                " where M.menu_id in ( ".
                "     select MRM.menu_id  ".
                "     from menu_role_mapping MRM ".
                "     where MRM.role_id=? ".
                ") ".      
                "Order by M.menu_name ";
        $stmt = $this->conn->prepare($qry);
        $stmt->execute([$role_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    private function getChildMenus($parent_menu_id){
        $child_menus = array();//child menu
        $qry = "select * from menu M where M.parent_menu_id = ? ";
        $stmt = $this->conn->prepare($qry);
        $stmt->execute([$parent_menu_id]);
        if($stmt->rowCount()){
            $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($menus as $menu){
                $parent_menu_id = $menu['menu_id'];
                $menu['child_menu'] = $this->getChildMenus($parent_menu_id);
                $child_menus[] = $menu;
            }
        }
        return $child_menus;
    }
}