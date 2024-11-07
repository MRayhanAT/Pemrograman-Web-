
<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_mobil']) && !empty($_POST['id_mobil'])) {
        $id_mobil = $_POST['id_mobil'];
        $nama_mobil = $_POST['nama_mobil'];
        $deskripsi = $_POST['deskripsi'];
        $foto_mobil = $_FILES['foto_mobil']['name'];

        if ($foto_mobil) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($foto_mobil);
            move_uploaded_file($_FILES['foto_mobil']['tmp_name'], $target_file);
            $update_query = "UPDATE post_mobil SET foto_mobil = ?, nama_mobil = ?, deskripsi = ? WHERE id_mobil = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("sssi", $foto_mobil, $nama_mobil, $deskripsi, $id_mobil);
        } else {
            $update_query = "UPDATE post_mobil SET nama_mobil = ?, deskripsi = ? WHERE id_mobil = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ssi", $nama_mobil, $deskripsi, $id_mobil);
        }
        $stmt->execute();
        $stmt->close();
        header("Location: daftar_post.php");
        exit();
    } else {
        $nama_mobil = $_POST['nama_mobil'];
        $deskripsi = $_POST['deskripsi'];
        $foto_mobil = $_FILES['foto_mobil']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto_mobil);

        if (move_uploaded_file($_FILES['foto_mobil']['tmp_name'], $target_file)) {
            $insert_query = "INSERT INTO mobil (foto_mobil, nama_mobil, rata_rata_rating, deskripsi) VALUES (?, ?, NULL, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sss", $foto_mobil, $nama_mobil, $deskripsi);
            $stmt->execute();
            $stmt->close();
            header("Location: daftar_post.php");
            exit();
        }
    }
} elseif (isset($_GET['id']) && isset($_GET['action'])) {
    if ($_GET['action'] === 'delete') {
        $id_mobil = $_GET['id'];
        $delete_query = "DELETE FROM post_mobil WHERE id_mobil = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $id_mobil);
        $stmt->execute();
        $stmt->close();
        header("Location: daftar_post.php");
        exit();
    } elseif ($_GET['action'] === 'edit') {
        $id_mobil = $_GET['id'];
        $query = "SELECT * FROM post_mobil WHERE id_mobil = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_mobil);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website RankRide</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container2 {
            margin: 10px auto;
            background-color: rgba(255, 255, 255, 0.0);        
            min-height: 600px; 
            width: 65%;
            display: grid;
            justify-content: space-evenly;
            place-items: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            font-size: large;
            font-family: 'sans-serif';
        }

        
    </style>
</head>
<body>
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
    <main>
        <section>
            <h2><?php echo isset($data) ? 'Edit' : 'Tambah'; ?> Post Mobil</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <?php if (isset($data)): ?>
                    <input type="hidden" name="id_mobil" value="<?php echo $data['id_mobil']; ?>">
                <?php endif; ?>
                <input type="text" name="nama_mobil" value="<?php echo isset($data) ? htmlspecialchars($data['nama_mobil']) : ''; ?>" placeholder="Nama Mobil" required>
                <input type="text" name="deskripsi" placeholder="Deskripsi" required><?php echo isset($data) ? htmlspecialchars($data['deskripsi']) : ''; ?></textarea>
                <input type="file" name="foto_mobil" <?php echo isset($data) ? '' : 'required'; ?>>
                <button type="submit" class="button"><?php echo isset($data) ? 'Update' : 'Tambah'; ?> Mobil</button>
            </form>
        </section>

        <section class="table-section">
            <h2>Daftar Post Mobil</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Mobil</th>
                        <th>Rating</th>
                        <th>Deskripsi</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM mobil";
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_mobil']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_mobil']); ?></td>
                            <td><?php echo $row['rata_rata_rating'] !== null ? htmlspecialchars($row['rata_rata_rating']) : 'belum ada'; ?></td>
                            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td><img src="uploads/<?php echo htmlspecialchars($row['foto_mobil']); ?>" alt="Foto Mobil" width="50"></td>
                            <td>
                                <a href="?id=<?php echo $row['id_mobil']; ?>&action=edit">Edit</a> |
                                <a href="?id=<?php echo $row['id_mobil']; ?>&action=delete" onclick="return confirm('Apakah Anda yakin ingin menghapus post ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>


</body>
</html>
