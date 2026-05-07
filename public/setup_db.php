<?php
/**
 * Database Setup Script for Egg Store
 * This script creates the database and required tables for Shield authentication.
 */

$hostname = "localhost";
$username = "root";
$password = "";
$database = "egg_store";

echo "<h1>Egg Store Database Setup</h1>";

// 1. Connect to MySQL
$mysqli = new mysqli($hostname, $username, $password);

if ($mysqli->connect_error) {
    die("<p style='color:red'>Connection failed: " . $mysqli->connect_error . "</p><p>Please make sure MySQL is started in XAMPP.</p>");
}
echo "<p style='color:green'>Connected to MySQL server successfully.</p>";

// 2. Create Database
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($mysqli->query($sql) === TRUE) {
    echo "<p style='color:green'>Database '$database' created or already exists.</p>";
} else {
    die("<p style='color:red'>Error creating database: " . $mysqli->error . "</p>");
}

// 3. Select Database
$mysqli->select_db($database);

// 4. Read SQL file
$sqlFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'database.sql';
if (!file_exists($sqlFile)) {
    die("<p style='color:red'>SQL file not found at: $sqlFile</p>");
}

$sqlContent = file_get_contents($sqlFile);

// 5. Execute Multi-Query
if ($mysqli->multi_query($sqlContent)) {
    do {
        // Store first result set
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
    
    echo "<p style='color:green'>All tables created successfully!</p>";
} else {
    echo "<p style='color:red'>Error creating tables: " . $mysqli->error . "</p>";
}

$mysqli->close();

echo "<h2>Setup Complete!</h2>";
echo "<p>You can now go back to the <a href='/'>Home Page</a> and try to Register or Login.</p>";
echo "<p style='color:gray'><i>Note: For security, you should delete this file (public/setup_db.php) after use.</i></p>";
