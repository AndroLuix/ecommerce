<?php
namespace Base;
class Base{
    private $mysqli;

    public function __construct(){
        global $mysqli;
        $this->mysqli = $mysqli;
        self::$mysqli = $mysqli;
    }

    /**
     * Protezione contro SQL injection
     */
    protected static function esc($input){
        return mysqli_real_escape_string(self::$mysqli, $input);
    }

    protected function buildSelectQuery($table, $columns){
        // Inizializza la parte iniziale della query con "SELECT"
        $selectClause = ' SELECT ';

        // Se l'array $columns è vuoto, seleziona tutte le colonne, altrimenti costruisci la lista di colonne
        if (empty($columns)) {
            $selectClause .= '* ';
        } else {
            // Applica la funzione di escape a ciascun nome di colonna e uniscili con una virgola
            $escapedColumns = array_map([$this, 'esc'], $columns);
            $selectClause .= implode(', ', $escapedColumns);
        }

        // Aggiungi la parte "FROM" della query, applicando la funzione di escape al nome della tabella
        $fromClause = ' FROM ' . $this->esc($table);

        // Componi e restituisci la query completa
        return $selectClause . $fromClause;
    }

    protected function executeQuery($query){
        // Esecuzione della query sulla connessione memorizzata nell'oggetto
        $result = mysqli_query($this->mysqli, $query);

        if(!$result){
            die('Error, Execute query is wrong because: ' . print_r($this->mysqli->error_list, true));
        }

        // Recupera tutte le righe in un array associativo
        $resultArray = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Liberazione della memoria
        mysqli_free_result($result);

        return $resultArray;
    }
}
?>
