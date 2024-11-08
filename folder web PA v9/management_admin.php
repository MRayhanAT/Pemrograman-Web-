<?php
include 'koneksi.php';

// Handle delete action
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $delete_query = "DELETE FROM admin_mobil WHERE id_admin = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: management_admin.php"); 
    exit();
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_admin = $_POST['nama_admin'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = $conn->prepare("SELECT * FROM admin_mobil WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Email sudah terdaftar. Silakan gunakan email lain.";
    } else {
        // Insert new admin
        $stmt = $conn->prepare("INSERT INTO admin_mobil (nama_admin, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama_admin, $email, $password);

        if ($stmt->execute()) {
            $success_message = "Registrasi berhasil!";
        } else {
            $error_message = "Terjadi kesalahan. Coba lagi.";
        }

        $stmt->close();
    }

    $check_email->close();
}

// Fetch admin data for listing
$query = "SELECT id_admin, nama_admin, email FROM admin_mobil";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Admin - Website RideRank</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<!-- Navbar -->
<div class="wrapper">
<nav class="navbar_sisi">
    <div class="logo__navbar">
        <a href="#" id="logo__navbar">RANKRIDE</a>
    </div>
    <ul class="menu__navbar_sisi">
        <li class="barang__navbar_sisi"><a href="galeri_admin.php" class="links__navbar_sisi">Dashboard</a></li>
        <li class="barang__navbar_sisi"><a href="post.php" class="links__navbar_sisi">Manajemen Post</a></li>
        <li class="barang__navbar_sisi"><a href="manajemen_tamu.php" class="links__navbar_sisi">Manajemen Users</a></li>
        <li class="barang__navbar_sisi"><a href="management_admin.php" class="links__navbar_sisi">Manajemen Admin</a></li>
        <li class="barang__navbar_sisi"><a href="logout.php" class="links__navbar_sisi">Logout</a></li>
    </ul>
</div>
</nav>

<!-- Main content container -->
<div class="container__post">
    <h1>Register Admin</h1>
    <form method="POST" action="">
        <label for="nama_admin">Nama Admin:</label>
        <input type="text" id="nama_admin" name="nama_admin" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Register">
    </form>
<?php $conn->close(); ?>
    <h2>Daftar Admin</h2>
    
    <!-- Display Messages -->
    <?php if (isset($success_message)): ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php elseif (isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_admin']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_admin']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <a href="?delete=<?php echo $row['id_admin']; ?>" class="delete-button" onclick="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>


</body>
</html>
