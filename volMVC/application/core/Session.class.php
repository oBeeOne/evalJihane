<?php

class Session {
    // vars
    protected $duration;
    protected $starttime;
    protected $timeout;
    static $instance = 0;


    // init
    function __construct() {
        session_start();
        $this->timeout = 300;
        //$_SESSION['starttime'] = time();
        self::$instance = 1;
    }
    
    static function getInstance(){
        if(self::$instance == 0){
            return new self();
        }
        else{
            return true;
        }
    }
            
    function timeOut(){
        if(isset($_SESSION['starttime'])){
            $this->starttime = $_SESSION['starttime'];
            $this->duration = time() - $this->starttime;
            
            //debug($this->duration, 'session duration');
            //debug($this->timeout, 'session timeout');
            
            if($this->duration > $this->timeout){
                session_unset();
                session_destroy();
                header('Location: '.Route::url('index'));
            }
            else {
                $_SESSION['starttime'] = time();
            }
        }
        else{
            $_SESSION['starttime'] = time();
        }
    }
    
    static function end(){
        session_unset();
        session_destroy();
    }
}