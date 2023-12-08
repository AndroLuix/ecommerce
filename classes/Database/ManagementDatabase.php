<?php
/***
 * 
 * STRUTTURA BASE ORM (Object Relational Mapping)
 */
namespace Database;

use Collator;
use mysqli;

use function PHPSTORM_META\type;

class ManagementDatabase 
{

    private $conn;


    public function __construct()
    {
        $this->conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        if ($this->conn->connect_error) {
            die('<br>Connect Error (' . $this->conn->connect_errno . ') ' . $this->conn->connect_error);
        } else {
            echo "\n Connected to the database!\n";
        }

    }

    /**
     * FUNZIONI UTILI:
     */
    public function esc($input){
        return mysqli_real_escape_string($this->conn, $input);
    }



    /**
     *   -----------------------
     *          SELECT
     *   -----------------------
     * 
     * @param $query - verrà inserita la query all'interno di questa funzione
     * 
     *  In questa funzione si possono fare query autonome per query complesse o semplici, join, viste, UNION, etc
     * 
     */

    public function select($query)
    {
        //variabile con all'interno al query
        $result = $this->conn->query($query);

        if (!$result) {
            die('Execute query error, because: ' . print_r($this->conn->error_list, true));
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

    protected function selectAll($table, $columns = array())
    {
        $instance = ' SELECT * ';
        $colNames = '';

        foreach($columns as $col){
            $colNames .= " $col ,";
        }

        $colNames = substr($colNames, 0, -1);

        $query = $instance.$colNames;

        $resQuery = mysqli_query($this->conn, $query);

        //restituisco un array associativo
        $resutlArray = mysqli_fetch_array($resQuery);

        // libero lo spazio dalla memory
        mysqli_free_result($resQuery);
        
        //ritorno un array
        return $resutlArray;
    

    }










    /**
     *   -----------------------
     *          FIND BY ID
     *   -----------------------
     * 
     * @param $table - verrà inserito il nome della tabella per specificare l'entità
     * 
     * @param $columns (array) - un array delle colonne da selezionare
     * 
     * @param $Id - verrà inserito l'id per precisare l'elemento da mostrare
     * 
     * @return ' SELECT $nome, $cognome, $eta FROM $tab_persona WHERE $id
     * 
    
     * 
     */
    protected  function findById($table, $columns = array(), $id) {
        $cols = '';
        
        //Unisco tutte le colonne messe nella string $cols e proteggeremi da SQL innjection
        foreach($columns as $colName){
            $colName = $this->esc($colName);
            $cols .= ' '. $colName .', ';
        }
     
        //tolgo le virgole
        $cols = substr($cols, 0, -1);

        // protezione SQL injection 
        $id = $this->esc($id);

        //costruzione della query: 
        $query = 'SELECT '. $cols . ' FROM '. $table .' WHERE ID '. $id;

        //esecuzione
        $resQuery = mysqli_query($this->conn, $query);

        //restituisco un array associativo
        $resutlArray = mysqli_fetch_array($resQuery);

        // libero lo spazio dalla memory
        mysqli_free_result($resQuery);
        
        //ritorno un array
        return $resutlArray;
    }


    
    /**
     *   -----------------------
     *          DELETE
     *   ----------------------
     * 
     * @param $table - verrà inserito il nome della tabella
     * 
     * @param $Id - verrà inserito l'id per poter selezionare l'elemento da eliminare
     * 
    
     * 
     */

    protected function deleteWhereId($table, $id){

        $query = " DELETE FROM $table WHERE id = ?";

        // esc per l'di se non è un INT
      
        $id = $this->esc($id); 
        $table = $this->esc($table);

        //preparazione della query
        $stmt = $this->conn->prepare($query);

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

    
    /**
     *   -----------------------
     *      UPDATE WHERE VALUE
     *   ----------------------
     * 
     * @param $table - verrà inserito il nome della tabella
     * 
     * @param $columns = array()  - verra inserito un array con chiave valore, quindi un array associativo
     * 
     *  ESEMPIO 
     *  colonne [
     *   nome => mario,
     *   cognome => rossi, 
     *   età => 29,
     *   
     * ]
     * 
     * @param $val - valore per identificare il record
     */

    protected function updateWhereVal($table, $columns = array(), $val){
        if(empty($columns)){
            echo 'Select one column name and value';
            return; //necessario per evitare che si compili il resto del codice
         }elseif(empty($id)){
             echo 'Select value for seach';
         }

         $colSelected = '';
        $arrayAssoc = array();

          //si esegue quindi un ciclo  che riempie la stringa colmnset
        foreach($columns as $colName => $colValue){
            $colSelected.= "$colName = ? , ";
            $arrayAssoc[] = $colValue;
        }

        $colSelected = rtrim($colSelected,', '); //rimuovo l'ultima virgola


 
        
    }

    /**
     *   -----------------------
     *      UPDATE WHERE ID
     *   ----------------------
     * 
     * @param $table - verrà inserito il nome della tabella
     * 
     * @param $columns = array()  - verra inserito un array con chiave valore, quindi un array associativo
     * 
     *  ESEMPIO 
     *  colonne [
     *   nome => mario,
     *   cognome => rossi, 
     *   età => 29,
     * ]
     * 
     * @param $id - l'Id come identificativo per selezonare il record da modificare
     * 

     */

    protected function updateWhereId($table, $columns = array(), $id){
        if(empty($columns)){
           echo '<br>Select one column name and value';
           return; //necessario per evitare che si compili il resto del codice
        }elseif(empty($id)){
            echo '<br>Select id';
            return;
        }

        //qui verranno messe le colonne selezionate 
        $colSelected = '';
        //qui verranno inseriti i valori dinamicamente nomeTabella => valore
        $arrayAssoc = array();

        //si esegue quindi un ciclo  che riempie la stringa colmnset
        foreach($columns as $colName => $colValue){
            $colSelected.= "$colName = ? , ";
            $arrayAssoc[] = $colValue;
        }

        $colSelected = rtrim($colSelected,', ');

        //aggiungimento id 
        $arrayAssoc[] =  $id;

        $query = " UPDATE $table SET $colSelected WHERE id = ?";

        foreach($arrayAssoc as &$param){
            $param = $this->esc($param);
        }
        unset($param);

        // preparazione statement
        $stmt = $this->conn->prepare($query);

        /**
         * 
         * preparazione query con algoritmo
         * 
         */

        // calcolo del numero totale dei parametri:
        $numParams = count($arrayAssoc);

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
                $blindParams[] = $this->esc(array_shift($arrayAssoc));
            }else{
                $blindParams[]= array_shift($arrayAssoc);
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

    //inserimento  di nuovi records
    public function insert($table, $columns = array()){
        //stringa contenente tutte le colonne
        $strCol = '';
        //stringa con i valori da inserire nelle relative colonne
        $strValues = '';
        foreach($columns as $colName => $colValue){

            $colName = $this->esc($colName);
            $$colValue = $this->esc($colValue);


            $strCol .= ' '. $colName.' ,';
            $strValues .= ' \''. $colValue.'\' ,' ;
        }

        //rimozione ultima virgola per le colonne
        $strCol = rtrim($strCol,' ,');

        
    
        // rimozione ultima virgola per i valori da inserire
        $strValues = rtrim($strValues,' ,');

        $query = " INSERT INTO $table ($strCol) VALUES ($strValues)";
        echo $query;

        $result = mysqli_query($this->conn, $query);


        if ($result) {
            // Restituisci l'ID del nuovo record
            return mysqli_insert_id($this->conn);
        } else {
            // Restituisci un valore che indica l'errore
            echo  mysqli_error($this->conn);
            return -1;
        }

    }

}
