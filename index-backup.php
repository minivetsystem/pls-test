<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Example: connect to mysql
//
// Option 1: using mysqli
$servername = "mysql";
$username = "root";
$password = "password";
$db = "mysql";

$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully using mysqli<br>";

// Option 2: using PDO
try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully using PDO<br>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Example: connect to postgresql
$dbconn = pg_connect("host=db dbname=postgres user=postgres password=password")
or die('Connection failed: ' . pg_last_error());

// Eine SQL-Abfrge ausführen
$query = 'SELECT * FROM pg_stat_activity';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
var_dump($result);

phpinfo();