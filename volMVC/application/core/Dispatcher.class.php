<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dispatcher {
    
    //vars
    protected $request;
    
    // init
    public function __construct() {
        $this->request = new Request(); 
        
        // parsing requested url through the router
        Route::parseUrl($this->request->url,$this->request);
        
        // loading the controller defined in url request
        $controller = $this->loadController();
        //debug($controller, 'controller');
		
        // checking if action in requested url exists in the defined controller
        if(!in_array($this->request->action , array_diff(get_class_methods($controller),get_class_methods('Controller'))) ){
            $this->error('Cette page n\'existe pas...'); 
        }
        
        // loading the requested action
        call_user_func_array(array($controller,$this->request->action),$this->request->params); 
        
        // rendering the action to the corresponding view
        if($this->request->action == 'index'){
            $title='accueil';
        }
        else{
            $title = $this->request->action;
        }
		
		//debug($this->request->action, 'request');
        $controller->setVars('title', ucfirst($title));
        $controller->render($this->request->action);
    }
    
    /**
     * Controller auto-loading
     * 
     * @return \name
     */
    function loadController(){
        $name = ucfirst($this->request->controller).'Controller';
        $file = APPLICATION_PATH.'/controllers/'.$name.'.php';
        require_once $file;
        return new $name($this->request);
    }
    
    /**
     * Error page
     * 
     * @param type $msg
     */
    function error($msg){
        header("HTTP/1.0 404 Not Found");
        $controller = new Controller($this->request);
        $controller->setVars('message', $msg);
        $controller->setVars('controller', $this->request->controller);
        $this->request->controller = 'error';
        $controller->render('404');
        die();
    }
}

