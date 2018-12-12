<?php
/**
 * Traitement de la ToDo list
 * Chargement initial
 */

 /**
  * Includes
  */

  require_once 'db.php';
  
  $db = new Db();

  /**
   * Main code
   */

   $get = $_GET['cmd'];

   switch($get){

        case 'init':
            initialise($db);
            die;
            break;

        case 'add':
            addTodo($db, $_GET['titre'], $_GET['desc']);
            die;
            break;

        case 'mod':
            modTodo($db, $_GET['id'], $_GET['titre'], $_GET['description']);
            die;
            break;
    
        case 'del':
            delTodo($db, $_GET['id']);
            die;
            break;
   }

    function initialise($db){
        $sql = 'SELECT * FROM list';

        $ret = $db->getRows($sql);

        foreach($ret as $r){
            echo '<tr id="'.$r->id.'" onclick="edit()"><td>'.$r->titre.'</td><td>'.$r->description.'</td><td><a href="" onclick="del('.$r->id.')">DEL</a></td></tr>';
        }
   }

    function addTodo($db, $titre, $description){
        $sql = 'INSERT INTO list ("titre", "description") VALUES (:titre, :description)';
        $exec = $db->insert($sql, array('titre'=>$titre, 'description'=>$description));

        $sql = 'SELECT * FROM list WHERE id=(SELECT max(id) FROM list)';
        $ret = $db->getRow($sql);
        echo '<tr id="'.$ret->id.'"><td>'.$ret->titre.'</td><td>'.$ret->description.'</td><td><span onclick="del('.$ret->id.')">DEL</span></td></tr>';

    }

    function modToDo($db, $id, $titre, $description){
               
        $exec = $db->update('list', array('titre'=>$titre, 'description'=>$description), array('id'=>$id));
        echo '<tr id="'.$id.'"><td>'.$titre.'</td><td>'.$description.'</td><td><span onclick="del('.$id.')">DEL</span></td></tr>';

   }

   function delTodo($db, $id){
        
        $exec = $db->delete('list', array('id'=>$id));

    }

?>