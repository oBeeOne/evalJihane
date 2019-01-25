<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller {
    
    //vars
    protected $vars = array();
    protected $layout = 'layout';
    protected $request;
    protected $title;


    //init
    function __construct($request=NULL) {
        if($request){
            $this->request = $request;
        }
    }

    // methods
    
    /**
     * Passing parameters to the view
     * 
     * @param type $key
     * @param type $value
     */
    public function setVars($key, $value=NULL){
        if (is_array($key)){
            $this->vars += $key;
        }  else {
            $this->vars[$key] = $value;
        }
    }
    
	/**
	 * Callback function for ob_start()
	 *
	 * @param string content
	 * @return type callback
	 */
	 function callback($string){
		chdir(dirname($_SERVER['SCRIPT_FILENAME']));
		return $string;
	 }
	 	
    /**
     * Rendering view
     * 
     */
    public function render($view){
        extract($this->vars);
		
		//debug($view, 'view');
        $this->title = $this->request->controller;
		
		
        ob_start();
		
		require_once (APPLICATION_PATH.'/views/'.$this->request->controller.'/'.$view.'.php');
		
		$content = ob_get_clean();
 		
		if($this->layout==false){
            echo $content;
        }  else {
            
			require_once APPLICATION_PATH.'/models/layout/'.$this->layout.'.php';
        }
    }
    
    /**
     * Auto loading controller and action defined in url request
     * 
     * @param string $controller
     * @param string $action
     * @return type
     */
    public function request($controller, $action){
        $controller .= 'Controller';
        require_once APPLICATION_PATH.'/controllers/'.$controller.'.php';
        $c = new $controller();
        return $c->$action();
    }
    
    /**
     * Calling a redirection from anywhere in the controller context
     * 
     * @param type $url
     * @param type $code
     */
    public function redirect($url, $code = 301){
        if($code == 301){
            header("HTTP/1.1 301 Moved Permanently");
        }
        //sleep(3);
        header("Location: ".Route::url($url));
    }
    
    /**
     * Testing if request is XMLHttpRequest (ajax request)
     * 
     * @return type
     */
    public function isXhr(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&$_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
    }
}