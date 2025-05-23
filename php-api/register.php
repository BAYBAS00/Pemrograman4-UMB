<?php

include "koneksi.php";

// Ambil data dari POST
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$email    = $_POST['email'] ?? '';

// Validasi input tidak boleh kosong
if (empty($username) || empty($password) || empty($email)) {
    echo "Input harus diisi semua";
    exit;
}

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Format email tidak valid";
    exit;
}

// Validasi panjang password
if (strlen($password) < 6) {
    echo "Password minimal 6 karakter";
    exit;
}

// Cek apakah username sudah ada
$stmt = $koneksi->prepare("SELECT username FROM auth WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "User sudah ada, silahkan pilih username lain";
} else {
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan user baru
    $stmt = $koneksi->prepare("INSERT INTO auth (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $email);

    if ($stmt->execute()) {
        echo "Registrasi berhasil";
    } else {
        echo "Terjadi kesalahan saat registrasi";
    }
}

$stmt->close();
$koneksi->close();
?>
