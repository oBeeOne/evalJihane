<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Route{
    // vars
    static $route = array();
    
    // init
    
    // methods
    
    /**
     * Parsing an url and returning all parameters in an array
     * 
     * @param type $url
     * @return boolean
     */
    static function parseUrl($url, $request){
        $url = trim($url);
        
        if(empty($url)){
            $url = Route::$route[0]['url'];
            //debug($url,'Url is empty !');
        }else{
            foreach (Route::$route as $r){
                //debug($r['catcher'], 'catcher');
                //debug($url, 'requested url');
                if(preg_match($r['catcher'], $url, $match)){
                    //debug($match, 'match');
                    $request->controller = isset($match['controller'])?$match['controller']:'index';
                    $request->action = isset($match['action'])?$match['action']:'index';
                    $request->params = array();
                    foreach ($r['params'] as $k=>$v){
                        $request->params[$k]=$match[$k];
                    }
                    if(!empty($match['args'])){
                        $request->params += explode('/', trim($match['args'],'/'));
                    }
					//debug($request, 'request');
                    return $request;
                }
            }
        }
        
        
        $params  = explode('/', $url);
        $request->controller = isset($params[0])?$params[0]:'index';
        $request->action = isset($params[1])?$params[1]:'index';
        $request->args = array_slice($params, 2);
        return true;
        
    }
    
    /**
     * Url rewriting and reformating
     * 
     * @param type $redirect
     * @param type $url
     */
    static function reform($redirect, $url){
        $req = array();
        
        $req['params'] = array();
        $req['url'] = $url;
        $req['redir'] = $redirect;
        
        $req['origin'] = str_replace(':controller', '(?P<controller>([a-z]+))',$url);
        $req['origin'] = str_replace(':action', '(?P<action>([a-z]+))', $req['origin']);
        $req['origin'] = str_replace('/:args', '', $req['origin']);
        $req['origin'] = '/'.str_replace('/', '\/', $req['origin']).'/';
                
        $params = explode('/',$url);
        
        foreach($params as $k=>$v){
            if(strpos($v,'=')){
                $p = explode('=',$v);
                $req['params'][$p[0]] = $p[1]; 
            }else{
                if($k==0){
                    $req['controller'] = $v;
                }elseif($k==1){
                    $req['action'] = $v; 
                }
            }
        }
        //debug($req['params'], 'params');
        if($redirect==='/'){
            $req['catcher'] = '/^\/$/';
        }else{
            $req['catcher'] = $redirect;
            $req['catcher'] = str_replace(':controller', '(?P<controller>([a-z]+))', $req['catcher']);
            $req['catcher'] = str_replace(':action','(?P<action>([a-z]+))',$req['catcher']);
            
            if(empty($req['params'])){
                $req['redir'] = str_replace('/:args', '', $req['redir']);
                $req['catcher'] = str_replace('/:args', '', $req['catcher']);
            }else{
                foreach($req['params'] as $k=>$v){
                    $req['catcher'] .= "\/(?P<$k>$v)";
                }
            }
            $req['catcher'] = '/^\/'.str_replace('/','\/',$req['catcher']).'$/';
        }
        //debug($req, 'req');
        
        self::$route[] = $req;
    }
    
    static function url($url){
        foreach(self::$route as $r){
            if(preg_match($r['origin'],$url,$match)){
                //debug($match, 'match');
                foreach($match as $k=>$v){
                    if(!is_numeric($k)){
                        $r['redir'] = str_replace(":$k",$v,$r['redir']); 
                    }
                }
                return BASE_URL.str_replace('//','/','/'.$r['redir']); 
            }
        }
        return BASE_URL.'/'.$url;
    }
}