<?php

$host = "localhost";
$user = "root";
$pass = "root";
$db = "php_api";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if ($koneksi) {
    // echo "koneksi berhasil";
} else {
    echo "koneksi gagal";
}