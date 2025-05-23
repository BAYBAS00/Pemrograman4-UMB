<?php

include "koneksi.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input
if (empty($username) || empty($password)) {
    echo "Username dan password harus diisi";
    exit;
}

// Ambil data user berdasarkan username
$stmt = $koneksi->prepare("SELECT password FROM auth WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    echo "User tidak ada";
} else {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        echo "Login berhasil";
    } else {
        echo "Username atau password salah";
    }
}

$stmt->close();
$koneksi->close();
?>
