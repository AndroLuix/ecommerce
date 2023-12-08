<?php 
namespace Database;
use Database\Mana;

Class Entity extends ManagementDatabase {
    private $database;
    private $table; 
    private $columns;

    public function __construct(){
        $this->database = new ManagementDatabase;
    }

    protected function getAll(){
        $results = self::selectAll((string)$this->table, $this->columns);
        $object = array();
        
        foreach($results as $result){
            array_push($object, (object)$result);
        }

        return $object;
    }

    protected function find($id){
        $result = self::findById((string)$this->table, $this->columns ,(int) $id);
        return (object) $result;
    }

    protected function update( $colVal, $id ){
        $result = self::updateWhereId($this->table, (array) $colVal, $id);
        return $result;
    }

    protected function delete($id){
        $result = self::deleteWhereId($this->table, $id);

        return $result;
    }


}