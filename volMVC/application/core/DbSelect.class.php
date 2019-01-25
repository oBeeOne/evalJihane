<?php

/**
 * Select Query Obect
 */

 class DbSelect extends QueryCommon implements FinalQuery {
     private $request;

     public function __construct(){
        $this->request = "SELECT ";
     }

     public function from(string $from) : string {
        $this->request .= " FROM ".$from;

     }

     public function where(string $where) : string {
        $this->request .= " WHERE ".$where;

     }

     public function query() : string {
         return $this->request;
     }
 }