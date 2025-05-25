<?php
//jika belum login tidak bisa masuk index
if(!isset($_SESSION['log'])){
    header('location:login.php');
}

// Ambil peran pengguna dari sesi, default ke 'guest' jika tidak ada
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
?>
