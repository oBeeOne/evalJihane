<?php

/**
 * Query builder
 */

interface Dbquery {
    public function select(string $select) : Dbquery ;
    public function from(string $from) : Dbquery ;
    public function where(string $where) : Dbquery ;
    public function delete() : Dbquery ;
    public function update(string $select) : Dbquery ; 
    public function set(string $select) : Dbquery ;
    public function insert(string $table) : Dbquery ;    
    public function values(array $values) : Dbquery;
    public function getQuery(): string;
}