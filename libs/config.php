<?php
require __DIR__ . '/database.class.php';

define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_USER', 'postgres');
define('DB_PASS', '123');
define('DB_DBNAME', 'Slimshop');


$db = new database();
try {
    $this->$db;
} catch (PDOException $e) {
    return $e->getMessage();
}
return true;
$res = $db->insert('users',
    [
        'username' => 'Vuhoanggiang123',
        'fullname' => 'omgomgomg123',
        'email' => 'hiihihg@gmail.com'
    ]);


if ($res === true) {
    echo $db->lastInserId('users_id_seq');
} else {
    var_dump($res);
    echo $res;
}


?>


