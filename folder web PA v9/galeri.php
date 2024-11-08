<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website RankRide</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* You can add additional styles here if needed */
    </style>
</head>
<body>

<nav class="navbar">
    <div class="kotak__navbar">
        <div class="logo__navbar">
            <a href="#" id="logo__navbar">RANKRIDE</a>
        </div>
        <ul class="menu__navbar">
            <div class="search-container">
            <form action="" method="get" class="search-form">
                <input type="text" name="nama_mobil" id="nama_mobil" placeholder="Cari Kendaraan" value="<?= htmlspecialchars(isset($_GET['nama_mobil']) ? $_GET['nama_mobil'] : '') ?>" class="search-input">
                <button type="submit" class="search-button">Cari</button>
            </form>
        </div>
        </ul>

        <div class="barang__navbar">
                <a href="logout.php" class="links__navbar">LogOut</a>
</div>
    </div>
</nav>

<div class="search-results-wrapper">
                <?php
                require_once "koneksi.php";
                $nama_kendaraan = isset($_GET['nama_mobil']) ? $_GET['nama_mobil'] : '';

                if ($nama_kendaraan) {
                    $sql = "SELECT * FROM mobil WHERE nama_mobil LIKE ?";
                    if ($stmt = $conn->prepare($sql)) {
                        $search_term = '%' . $nama_kendaraan . '%';
                        $stmt->bind_param("s", $search_term);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        echo "<h2 class='search-title'>Hasil Pencarian untuk: " . htmlspecialchars($nama_kendaraan) . "</h2>";

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='container-mobil'>
                                        <div class='foto-mobil'>
                                            <img src='uploads/" . htmlspecialchars($row["foto_mobil"]) . "' alt='Foto Mobil'>
                                        </div>
                                        <div class='info-mobil'>
                                            <h2>ID Mobil: " . htmlspecialchars($row["id_mobil"]) . "</h2>
                                            <h3>Nama Mobil: " . htmlspecialchars(string: $row["nama_mobil"]) . "</h3>
                                            <p class='rating-mobil'>Rata-Rata Rating: " . htmlspecialchars($row["rata_rata_rating"] ?? ' ') . "</p>
                                            <p class='deskripsi-mobil'>Deskripsi: " . htmlspecialchars($row["deskripsi"]) . "</p>
                                            <a href='detail_mobil_admin.php?id_mobil=" . htmlspecialchars($row["id_mobil"]) . "' class='btn-detail'>Lihat Detail</a>
                                        </div>
                                    </div>";
                            }
                        } else {
                            echo "<p class='no-results'>Tidak ada kendaraan yang ditemukan dengan nama tersebut.</p>";
                        }

                        $stmt->close();
                    } else {
                        echo "<p class='error-message'>Terjadi kesalahan dalam proses pencarian. Silakan coba lagi.</p>";
                    }
                }
                ?>
            </div>

<div class="container2">
    <?php
    include 'koneksi.php';

    function tampilkan_mobil($conn) {
        $sql_mobil = "SELECT * FROM mobil";
        $result_mobil = $conn->query($sql_mobil);

        if ($result_mobil->num_rows > 0) {
            while ($row = $result_mobil->fetch_assoc()) {
                echo "<div class='container-mobil'>
                        <div class='foto-mobil'>
                            <img src='uploads/" . htmlspecialchars($row["foto_mobil"]) . "' alt='Foto Mobil'>
                        </div>
                        <div class='info-mobil'>
                            <h2>ID Mobil: " . htmlspecialchars($row["id_mobil"]) . "</h2>
                            <h3>Nama Mobil: " . htmlspecialchars($row["nama_mobil"]) . "</h3>
                            <p class='rating-mobil'>Rata-Rata Rating: " . htmlspecialchars($row["rata_rata_rating"] ?? ' ') . "</p>
                            <p class='deskripsi-mobil'>Deskripsi: " . htmlspecialchars($row["deskripsi"]) . "</p>
                            <a href='detail_mobil.php?id_mobil=" . htmlspecialchars($row["id_mobil"]) . "' class='btn-detail'>Lihat Detail</a>
                        </div>
                    </div>";
            }
        } else {
            echo "<p>Belum ada data mobil.</p>";
        }
    }

    tampilkan_mobil($conn);
    ?>
</div>

<footer class="footer">
    <div class="footer__links">
        <ul>
            <li><a href="#contact" style="color: white;">Contact</a></li>
            <li>mrayhanat37@gmail.com</li>
            <li>081244746892</li>
        </ul>
    </div>
    <div class="footer__copyright">
        &copy; 2024 Punya Rayhan. All Rights Reserved.
    </div>
</footer>

</body>
</html>
