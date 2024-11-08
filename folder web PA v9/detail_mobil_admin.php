<?php
include 'koneksi.php';

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
        .foto-mobil, .info-mobil, .komentar-section {
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
        <img src="images/<?php echo htmlspecialchars($mobil['foto_mobil']); ?>" alt="Foto Mobil">
    </div>
    <div class="info-mobil">
        <h2>ID Mobil: <?php echo htmlspecialchars($mobil['id_mobil']); ?></h2>
        <h3>Nama Mobil: <?php echo htmlspecialchars($mobil['nama_mobil']); ?></h3>
        <p class="rating-mobil">Rata-Rata Rating: <?php echo htmlspecialchars($mobil['rata_rata_rating']); ?></p>
        <p class="deskripsi-mobil">Deskripsi: <?php echo htmlspecialchars($mobil['deskripsi']); ?></p>
    </div>
    <a href="galeri_admin.php" class="btn-back">Kembali ke Daftar Mobil</a>

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
