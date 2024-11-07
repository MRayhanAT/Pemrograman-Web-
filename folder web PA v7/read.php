<?php
require_once "koneksi.php";

$sql = "SELECT * FROM komentar_mobil";
$result = $link->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Review Kendaraan</title>
</head>
<body>
    <h2>Daftar Review Kendaraan</h2>
    <a href="create_review.php">Tambah Review Baru</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Kendaraan</th>
            <th>Rating</th>
            <th>Komentar</th>
            <th>Tanggal Review</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nama_kendaraan']; ?></td>
            <td><?php echo $row['rating']; ?> ⭐</td>
            <td><?php echo $row['komentar']; ?></td>
            <td><?php echo $row['tanggal_review']; ?></td>
            <td>
                <a href="update_review.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_review.php?id=<?php echo $row['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
