<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Shows a debug window
 * 
 * @param type $var
 * @param type $comment
 */
function debug($var, $comment=NULL){
    
    if(Config::$debug>0){
        $backtrace = debug_backtrace();

        echo '<pre class="debug">';
        echo "<a href='#'>".$backtrace[0]['file']." line ".$backtrace[0]['line']."</a>";
        if($comment!=NULL){
            echo "<h3>Dump de $comment dans la fonction ".$backtrace[1]['function']."()</h3>";
        }
        var_dump($var);
        echo '</pre>';
    }
}
