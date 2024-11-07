<?php
include 'koneksi.php';
session_start();

if (isset($_GET['id_mobil'])) {
    $id_mobil = $_GET['id_mobil'];

    $sql = "SELECT * FROM mobil WHERE id_mobil = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_mobil);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mobil = $result->fetch_assoc();
    } else {
        echo "<p>Mobil dengan ID tersebut tidak ditemukan.</p>";
        exit();
    }
} else {
    echo "<p>ID mobil tidak tersedia.</p>";
    exit();
}

// Pastikan pengguna sudah login dan memiliki `id_akun` yang valid
if (!isset($_SESSION['id_akun'])) {
    echo "<p>Anda harus login untuk memberikan komentar.</p>";
    exit();
} else {
    $id_akun = $_SESSION['id_akun'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating']) && isset($_POST['komentar'])) {
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];

    $sql_insert = "INSERT INTO komentar_mobil (id_mobil, id_akun, rating, komentar) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iids", $id_mobil, $id_akun, $rating, $komentar);
    if ($stmt_insert->execute()) {

        // Menghitung rata-rata rating untuk id_mobil saat ini
        $sql_avg = "SELECT AVG(rating) as rata_rata FROM komentar_mobil WHERE id_mobil = ?";
        $stmt_avg = $conn->prepare($sql_avg);
        $stmt_avg->bind_param("i", $id_mobil);
        $stmt_avg->execute();
        $result_avg = $stmt_avg->get_result();
        $avg_rating = $result_avg->fetch_assoc()['rata_rata'];

        // Memperbarui rata-rata rating di tabel mobil
        $sql_update = "UPDATE mobil SET rata_rata_rating = ? WHERE id_mobil = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("di", $avg_rating, $id_mobil);
        $stmt_update->execute();

        // Menutup statement setelah selesai
        $stmt_avg->close();
        $stmt_update->close();
    } else {
        echo "<p>Terjadi kesalahan saat menambahkan komentar.</p>";
    }
}

// Query untuk mengambil semua komentar dan rating
$sql_komentar = "SELECT k.rating, k.komentar, a.nama_akun 
                 FROM komentar_mobil k 
                 JOIN akun a ON k.id_akun = a.id_akun 
                 WHERE k.id_mobil = ?";
$stmt_komentar = $conn->prepare($sql_komentar);
$stmt_komentar->bind_param("i", $id_mobil);
$stmt_komentar->execute();
$result_komentar = $stmt_komentar->get_result();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mobil - <?php echo htmlspecialchars($mobil['nama_mobil']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container-detail {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .foto-mobil, .info-mobil, .form-komentar, .komentar-section {
            margin-top: 20px;
        }
        .foto-mobil img {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .form-komentar input, .form-komentar textarea, .form-komentar button {
            width: 100%;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-komentar button {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .komentar-item {
            border-top: 1px solid #ddd;
            padding: 10px 0;
        }
        .komentar-item p {
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container-detail">
    <div class="foto-mobil">
        <img src="uploads/<?php echo htmlspecialchars($mobil['foto_mobil']); ?>" alt="Foto Mobil">
    </div>
    <div class="info-mobil">
        <h2>ID Mobil: <?php echo htmlspecialchars($mobil['id_mobil']); ?></h2>
        <h3>Nama Mobil: <?php echo htmlspecialchars($mobil['nama_mobil']); ?></h3>
        <td><?php echo $mobil['rata_rata_rating'] !== null ? htmlspecialchars($mobil['rata_rata_rating']) : 'Rating belum ada'; ?></td>
        <p class="deskripsi-mobil">Deskripsi: <?php echo htmlspecialchars($mobil['deskripsi']); ?></p>
    </div>
    <a href="galeri.php" class="btn-back">Kembali ke Daftar Mobil</a>

    <!-- Formulir Tambah Rating dan Komentar -->
    <div class="form-komentar">
        <h3>Tambah Rating dan Komentar</h3>
        <form action="" method="POST">
            <input type="number" name="rating" step="0.1" min="1" max="5" placeholder="Rating (1-5)" required>
            <textarea name="komentar" placeholder="Komentar Anda" required></textarea>
            <button type="submit">Kirim Komentar</button>
        </form>
    </div>
    

    <!-- Tampilkan Komentar dan Rating -->
    <div class="komentar-section">
        <h3>Komentar dan Rating</h3>
        <?php if ($result_komentar->num_rows > 0): ?>
            <?php while ($row_komentar = $result_komentar->fetch_assoc()): ?>
                <div class="komentar-item">
                    <p><strong><?php echo htmlspecialchars($row_komentar['nama_akun']); ?></strong> memberikan rating <?php echo htmlspecialchars($row_komentar['rating']); ?></p>
                    <p><?php echo htmlspecialchars($row_komentar['komentar']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada komentar untuk mobil ini.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
