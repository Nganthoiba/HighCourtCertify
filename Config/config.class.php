<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author Nganthoiba
 */
class Config {
    protected static $setting = array();
    public static function get($key){
        return isset(self::$setting[$key])?self::$setting[$key]:null;
    }
    public static function set($key, $value){
        self::$setting[$key] = $value;
    }
}
