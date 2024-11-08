<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_akun = $_POST['nama_akun'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password

    // Cek jika email sudah ada
    $check_email = $conn->prepare("SELECT * FROM akun WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        echo "<p>Email sudah terdaftar. Silakan gunakan email lain.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO akun (nama_akun, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama_akun, $email, $password);

        if ($stmt->execute()) {
            echo "<p>Registrasi berhasil! Silakan <a href='index.php'>login</a>.</p>";
        } else {
            echo "<p>Terjadi kesalahan. Coba lagi.</p>";
        }

        $stmt->close();
    }

    $check_email->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Website RideRank</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container__form">
    <h1>Register</h1>

    <form method="POST" action="">
        <label for="nama_akun">Nama Akun:</label>
        <input type="text" id="nama_akun" name="nama_akun" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Register">
    </form>

    <p class="login-link">Sudah punya akun? <a href="index.php">Login di sini</a>.</p>
</div>

</body>
</html>
