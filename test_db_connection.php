<?php
/**
 * Test Database Connection
 * File ini untuk testing koneksi database
 * Akses melalui: http://localhost/foodedu/test_db_connection.php
 */

require_once 'auth/config.php';

echo "<h2>Test Koneksi Database FoodEdu</h2>";

try {
    // Test koneksi
    $stmt = $pdo->query("SELECT DATABASE() as db_name");
    $result = $stmt->fetch();
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    echo "<p>Database: <strong>" . $result['db_name'] . "</strong></p>";
    
    // Test apakah tabel users ada
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✅ Tabel 'users' ditemukan!</p>";
        
        // Hitung jumlah user
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
        $count = $stmt->fetch();
        echo "<p>Total user terdaftar: <strong>" . $count['total'] . "</strong></p>";
    } else {
        echo "<p style='color: red;'>❌ Tabel 'users' tidak ditemukan!</p>";
        echo "<p>Silakan import file <strong>database.sql</strong> ke phpMyAdmin</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Error koneksi database:</p>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<p><strong>Solusi:</strong></p>";
    echo "<ul>";
    echo "<li>Pastikan MySQL/XAMPP sudah running</li>";
    echo "<li>Pastikan database 'foodedu' sudah dibuat</li>";
    echo "<li>Periksa konfigurasi di <code>auth/config.php</code></li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><a href='index.html'>Kembali ke Halaman Utama</a></p>";
echo "<p><a href='auth.html'>Halaman Login/Register</a></p>";
?>

