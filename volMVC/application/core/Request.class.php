<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Request {
    
    // vars
    public $url;
    
    // init
    public function __construct() {
        $this->url = $_SERVER['REQUEST_URI'];
    }
    // methods
}