database.php

<?php
// deklarasi parameter koneksi database
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'db_php_sql';

// koneksi database
$mysqli = new mysqli($server, $username, $password, $database);

// cek koneksi
if ($mysqli->connect_error) {
    die('Koneksi Database Gagal : ' . $mysqli->connect_error);
}
?>