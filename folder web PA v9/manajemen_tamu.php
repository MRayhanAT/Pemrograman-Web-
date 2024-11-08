<?php
include 'koneksi.php';

// Delete 
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $delete_query = "DELETE FROM akun WHERE id_akun = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manajemen_tamu.php"); 
    exit();
}


$query = "SELECT id_akun, nama_akun, email FROM akun";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dashboard admin - Website RideRank</title>
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
            <li class="barang__navbar_sisi">
                <a href="galeri_admin.php" class="links__navbar_sisi">Dashboard</a>
            </li>
            <li class="barang__navbar_sisi">
                <a href="post.php" class="links__navbar_sisi">Manajemen Post</a>
            </li>
            <li class="barang__navbar_sisi">
                <a href="manajemen_tamu.php" class="links__navbar_sisi">Manajemen Users</a>
            </li>
            <li class="barang__navbar_sisi">
                <a href="management_admin.php" class="links__navbar_sisi">Manajemen Admin</a>
            </li>
            <li class="barang__navbar_sisi">
                <a href="logout.php" class="links__navbar_sisi">Logout</a>
            </li>
        </ul>
    </div>
</nav>


<div class="container__post">
    <h2>Daftar users</h2>
    
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_akun']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_akun']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <a href="?delete=<?php echo $row['id_akun']; ?>" class="delete-button" onclick="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php $conn->close(); ?>

</body>
</html>
