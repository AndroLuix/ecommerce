<?php
/**
 * COMANDI UTILI
 *      cd test/orm-base
 *      php test.php
 */


use Database\ManagementDatabase;

echo PATH_INDEX;

$db = new ManagementDatabase();

$table = 'user';

$columns = array(
    'name' => 'Mario',
    'lastname' => 'Rossi',
    'birthdate' => '10/20/1990',
    'email' => 'mario.rossi@email.it',
    'tel' => 555123555123,
    'password' => 'password',
    'role' => 'seller'
);

$insert = $db->insert($table, $columns);

if ($insert != -1) {
    echo "Record inserito con successo! ID generato: $insert";
} else {
    echo "Errore durante l'inserimento del record.";
}

$query = ' SELECT * FROM user';
$result = $db->select($query);
print_r($result);
