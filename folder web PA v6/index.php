<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Website RideRank</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container__form">
    <h1>Login</h1>

    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>

    <?php
    session_start();
    include 'koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // ck email di tabel admin
        $stmt = $conn->prepare("SELECT id_admin, nama_admin, password FROM admin_mobil WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // cek password admin
            if (password_verify($password, $user['password'])) {

                $_SESSION['id_admin'] = $user['id_admin'];
                $_SESSION['nama_admin'] = $user['nama_admin'];
                $_SESSION['email'] = $email;

                echo "<p>Login berhasil! Selamat datang, " . htmlspecialchars($user['nama_admin']) . ".</p>";
                header("Location: galeri_admin.php"); 
                exit();
            } else {
                echo "<p>Password salah admin. Silakan coba lagi.</p>";
            }
        } else {
            $stmt->close(); 
            $stmt = $conn->prepare("SELECT id_akun, nama_akun, password FROM akun WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                
                if (password_verify($password, $user['password'])) {
                    $_SESSION['id_akun'] = $user['id_akun'];
                    $_SESSION['nama_akun'] = $user['nama_akun'];
                    $_SESSION['email'] = $email;

                    echo "<p>Login berhasil! Selamat datang, " . htmlspecialchars($user['nama_akun']) . ".</p>";
                    header("Location: pilots2.php"); 
                    exit();
                } else {
                    echo "<p>Password salah. Silakan coba lagi.</p>";
                }
            } else {
                echo "<p>Email tidak ditemukan. Silakan daftar terlebih dahulu.</p>";
            }
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <p class="register-link">Tidak punya akun? <a href="register.php">Daftar di sini</a>.</p>
</div>

</body>
</html>
