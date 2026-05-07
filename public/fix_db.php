<?php
$mysqli = new mysqli("localhost", "root", "", "egg_store");
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

$sqlContent = file_get_contents(__DIR__ . "/../database.sql");

if ($mysqli->multi_query($sqlContent)) {
    do {
        if ($result = $mysqli->store_result()) $result->free();
    } while ($mysqli->more_results() && $mysqli->next_result());
    echo "<h1>Database fixed successfully!</h1>";
} else {
    echo "<h1>Error: " . $mysqli->error . "</h1>";
}
$mysqli->close();
?>
<p><a href="/admin/stock-intake">Go back to Stock Intake</a></p>
