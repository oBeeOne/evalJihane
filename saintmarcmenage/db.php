<?php
/**
 * Classe Db
 * Connection à la base de données
 */

 class Db {
     private $user = 'todo';
     private $pwd = 'todopwd';
     private $dbname = 'todo';
     private $domain = 'localhost';

     protected $instance = 0;

     public function __construct(){
        try{ 
            $this->db = new PDO('mysql:host='.$this->domain.';dbname='.$this->dbname, $this->user, $this->pwd)
            or die('Erreur de connexion à la base de données !');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->instance = 1;
        }
        catch(PDOException $e){
                throw new Exception($e->getMessage());
        }
    }

    /**
     *  Définition des "Getters" dans la BDD
     */
     public function getInstance(){
         return $this->instance;
     }

     /**
     * Executes a prepared query and returns a fetchAll result object
     * @param string $sql
     * @param array $params
     * @return object resultset
     * @throws Exception
     */
	 public function getRows($sql, $params=NULL){
		try{
			$stm = $this->db->prepare($sql);
			
			if($params && $params!=NULL){
				for($i=0; $i<count($params); $i++){
					if(is_int($params[$i])){
						$stm->bindValue($i+1, $params[$i], PDO::PARAM_INT);
					}
					else{
						$stm->bindValue($i+1, $params[$i], PDO::PARAM_STR);
					}
				}
			}
			
			$stm->execute();
			return $stm->fetchAll();
		}
		catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
    }
        
    /**
     * Executes a prepared query and returns a fetch result object
     * @param string $sql
     * @param array $params
     * @return object resultset
     * @throws Exception
     */
	public function getRow($sql, $params=NULL){
		try{
			$stm = $this->db->prepare($sql);
			
			if($params && $params!=NULL){
				for($i=0; $i<count($params); $i++){
					if(is_int($params[$i])){
						$stm->bindValue($i+1, $params[$i], PDO::PARAM_INT);
					}
					else{
						$stm->bindValue($i+1, $params[$i], PDO::PARAM_STR);
					}
				}
			}
			
			$stm->execute();
			return $stm->fetch();
		}
		catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
    }
	
	/**
     * Inserts datas into targeted table
     * @param string $table
     * @param array $params
     * @return boolean result
     * @throws Exception
     */
	public function insert($table, array $params){
		try{
			$sql = "insert into ".$table;
						
			$sql .= " (".implode(", ", array_keys($params)).") values ('".implode("', '", $params)."')";
			
			$stm = $this->db->exec($sql);
			return $stm;
		}
		catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	
	/**
     * Updating datas in targeted table
     * @param string $table
     * @param array $params
     * @param array $where
     * @return boolean result
     * @throws Exception
     */
	public function update($table, array $params, array $where){
		try{
			$sql = "update ".$table." set ";
			
			$sql .= implode(array_keys($params));
			$sql .= "='".implode($params)."'";
			$sql .= " where ".implode(array_keys($where));
			$sql .= "=".implode($where);
			
			//var_dump($sql);
			
			return $this->db->exec($sql);
		}
		catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	
	/**
     * Deleting a row in targeted table
     * @param string $table
     * @param array $params
     * @return boolean result
     * @throws Exception
     */
	public function delete($table, $params){
		try{
			$sql = "delete from ".$table;
			$sql .= " where ".implode(array_keys($params))." = ".implode($params);
			
			return $this->db->exec($sql);
		}
		catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
 }
?>