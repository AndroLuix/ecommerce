<?php

namespace Management; 

use Base\Base;
use mysqli;

use function PHPSTORM_META\type;

class ManagementDatabase extends Base
{
    private $mysqli;
    public $pdo;


    public function __construct()
    {

        global $mysqli;
        global $base;
        $this->mysqli = new \mysqli(HOSTNAME, USERNAME, PASSWORD);

      
       

        // Check connection
        if ($this->mysqli->connect_error) {
            require view('errors/server-error-500');
            exit;
        }else{
            echo '<br>connect success!';
        }
    }

    protected function select($query)
    {
        //variabile con all'interno al query
        $result = $this->mysqli->query($query);

        if (!$result) {
            die('Execute query error, because: ' . print_r($this->mysqli->error_list, true));
        }

        return $result;
    }

    /**
     * recupera i dati dalla tabella con SELECT (SOLO RDBSM)
     * 
     * @Annotation Seleziona tutte le colonne o solo quelle specificate
     * 
     * @param string $table - prende tutti i dati della tabella selezionata
     * 
     * @param array $columns - un array cotenente le colonne selezionate, se vuoto seleziona tutte.
     * 
     * @return array - Ritrona un array associativo con tutte le righe recuperate dalla query 
     */

    protected function all($table, $columns = array())
    {
        //Istanziamento oggetto della classe Base

        //funzione per la gestione della query: 
        $query = $this->buildSelectQuery($table,$columns);
        
        // Dopo aver compilato la query, inserico la variabile
        // all'interno di questo funzione.
        return $resutlArray = $this->executeQuery($query);

    }

    protected  function find($table, $columns = array(), $id) {
        $cols = '';
        
        //Unisco tutte le colonne messe nella string $cols e proteggeremi da SQL innjection
        foreach($columns as $colName){
            $colName = Base::esc($colName);
            $cols .= ' '. $colName .', ';
        }
     
        //tolgo le virgole
        $cols = substr($cols, 0, -1);

        // protezione SQL injection 
        $id = Base::esc($id);

        //costruzione della query: 
        $query = 'SELECT '. $cols . ' FROM '. $table .' WHERE ID '. $id;

        //esecuzione
        $resQuery = mysqli_query($this->mysqli, $query);

        //restituisco un array associativo
        $resutlArray = mysqli_fetch_array($resQuery);

        // libero lo spazio dalla memory
        mysqli_free_result($resQuery);
        
        return $resutlArray;

    }

    protected function delete($table, $id){

        $query = " DELETE FROM $table WHERE id = ?";

        // esc per l'di
        $id = self::esc($id);

        $table = self::esc($table);

        //preparazione della query
        $stmt = $this->mysqli->prepare($query);

        //richiesta della stringa
        $stmt->bind_param('ss', $id , $table);

        //esecuzione
        $stmt->execute();

        //riga interessata della tabella selezionata
        $rowAffected = $stmt->affected_rows;

        //chiusura dello statement 
        $stmt->close();

        return $rowAffected;

    }

    protected function update($table,$columns = array(), $id){
        if(empty($columns)){
           echo 'Select a column name';
           return; //necessario per evitare che si compili il resto del codice
        }

        //qui verranno messe le colonne selezionate dal developer
        $colSelected = '';
        //qui verranno inseriti i valori dinamicamente nomeTabella => valore
        $params = array();

        //si esegue quindi un ciclo  che riempie la stringa colmnset
        foreach($columns as $colName => $colValue){
            $colSelected.= "$colName = ? , ";
            $params[] = $colValue;
        }

        $colSelected = rtrim($colSelected,', ');

        //aggiungimento id come ultimo parametro
        $params[] =  $id;

        $query = " UPDATE $table SET $colSelected WHERE id = ?";

        foreach($params as &$param){
            $param = self::esc($param);
        }
        unset($param);

        // preparazione statement
        $stmt = $this->mysqli->prepare($query);

        /**
         * 
         * preparazione query con algoritmo
         * 
         */

        // calcolo del numero totale dei parametri:
        $numParams = count($params);

        //inizializzare una stringa vuota per i tipi
        $types = '';

        //itera attraverso ciascun parametro
        for($i = 0; $i < $numParams; $i++){
            //aggiunta del char 's' per indicare la tipologia

            $types.='s';

            //aggiungi virgola, eccetto l'ultimo parametro
            if($i < $numParams -1){
                $types .=' , ';
            }
        }

        /***
         * bindParam
         */

         //conversione stringa in un array
         $allTypesArray = str_split($types);

         $blindParams = array();

         //Iterazione attraverso i tipi e i parametri

         foreach($allTypesArray as $type){
            if($type === 's'){
                //ecape solo se la tipologia è una stringa
                $blindParams[] = self::esc(array_shift($params));
            }else{
                $blindParams[]= array_shift($params);
            }
            
         }

         //collegamento dei paramettri
         call_user_func_array(array($stmt, 'bind_param'), array_merge(array($types), $blindParams));

         $stmt->execute();

         if($stmt->error){
            echo 'Error in statemnt execution: '. $stmt->error;
         }

         $rowsAffected = $stmt->affected_rows;

         $stmt->close();

         return $rowsAffected;
    }

    //inserimento del database di nuovo record
    protected function insert($table, $columns = array()){
        //stringa contenente tutte le colonne
        $strCol = '';
        //stringa con i valori da inserire nelle relative colonne
        $strValues = '';
        foreach($columns as $colName => $colValue){

            $colName = self::esc($colName);
            $$colValue = self::esc($colValue);


            $strCol .= ' '. $colName.' , ';
            $strValues .= ' '. $colValue.' ,' ;
        }

        //rimozione ultima virgola per le colonne
        $strCol = rtrim($strCol,' ,');
    
        // rimozione ultima virgola per i valori da inserire
        $strValues = rtrim($strValues,' ,');

        $query = " INSERT INTO $table ($strCol) VALUES ($strValues)";

        if(mysqli_query($this->mysqli, $query)){
            //genera un auto increment
            $lastId= mysqli_insert_id($this->mysqli);
            return $lastId;
        }else{
            return -1;
        }

    }

}
