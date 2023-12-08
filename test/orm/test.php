<?php
/**
 * COMANDI UTILI
 *      cd test/orm
 *      php test.php
 */
require_once '../../vendor/autoload.php';
require_once '../../config.php';

use Database\ManagementDatabase;

echo PATH_INDEX;

$db = new ManagementDatabase();

$table = 'user';

$columns = array(
    'name' => 'Mario',
    'lastname' => 'Rossi',
    'birthdate' => '1990/10/10',
    'email' => 'mario.rossi@email.it',
    'tel' => intval('555123555'),
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
