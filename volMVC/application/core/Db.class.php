<?php
/*
*	Database Generic class
*	Uses PDO to extend compatibility
*	with all DBMS
*
*	
*/

class Db implements Dbquery {
	// vars
	protected $db;			// database object
	protected $conf;
	protected $sql;

    // init
	public function __construct(){
		
		try{
			$this->conf = Config::getDbParams();
			$this->db = new PDO($this->conf->dsn, $this->conf->user, $this->conf->pwd) or die('Erreur de connexion à : '.$access);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
             throw new Exception($e->getMessage());
		}
		
	}

	// methods

	/**
	 * Select
	 */

	public function select(string $select) : Dbquery {
		$this->sql = new DbSelect();
	}

    public function from(string $from) : Dbquery {
		$this->sql->from($from);

	}

    public function where(string $where) : Dbquery {
		$this->sql->where($where);

	}

	/**
	 * CRUD oprearations
	 */

    public function delete() : Dbquery {
		$this->sql = "DELETE";

	}

    public function update(string $select) : Dbquery {
		$this->sql = "UPDATE ".$select;

	}

    public function set(string $select) : Dbquery {
		$this->sql .= " SET ";
		$this->sql .= implode(array_keys($select));
		$this->sql .= "='".implode($select)."'";

	}

    public function insert(string $table) : Dbquery {
		$this->sql = "INSERT INTO ".$table;

	}

    public function values(array $values) : Dbquery {
		$this->sql .= " (".implode(", ", array_keys($values)).") values ('".implode("', '", $values)."')";

	}

	/**
	 * get the Query to execute
	 */

    public function getQuery(): string {
		return $this->sql;
	}
	
	/**
	 * Fetcher
	 */

	 /**
	 * Executes a prepared query and returns a fetchAll result object
	 * @param string $sql
	 * @return object resultset
	 * @throws Exception
	 */
	public function getRows(){
		try{
			$stm = $this->db->prepare($this->sql);			
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
	 * @return object resultset
	 * @throws Exception
	 */
	public function getRow($sql){
		try{
			$stm = $this->db->prepare($this->sql);
			$stm->execute();
			return $stm->fetch();
		}
		catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
    }
}