<?php
require_once "classes to connect to db/Database.php";

$db = new Database();
$query = "SELECT * FROM users LIMIT 5";
$result = $db->read($query);

if ($result) {
    echo "<pre>";
    print_r($result);
    echo "</pre>";
} else {
    echo "Database connection is successful, but no users were found.";
}
?>
