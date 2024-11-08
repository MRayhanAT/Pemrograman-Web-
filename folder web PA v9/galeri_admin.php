<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website RankRide</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
        </nav>

        <div class="container2">
            <!-- Search Form -->
            <div class="search-container">
                <form action="" method="get" class="search-form">
                    <label for="nama_mobil" class="search-label">Cari Kendaraan:</label>
                    <input type="text" name="nama_mobil" id="nama_mobil" placeholder="Masukkan nama kendaraan" value="<?= htmlspecialchars(isset($_GET['nama_mobil']) ? $_GET['nama_mobil'] : '') ?>" class="search-input">
                    <button type="submit" class="search-button">Cari</button>
                </form>
            </div>

            <!-- Search Results -->
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
                                            <h3>Nama Mobil: " . htmlspecialchars($row["nama_mobil"]) . "</h3>
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

            <!-- Galeri Kendaraan -->
            <h2 class="gallery-title">Galeri</h2>
            <?php
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
                                    <a href='detail_mobil_admin.php?id_mobil=" . htmlspecialchars($row["id_mobil"]) . "' class='btn-detail'>Lihat Detail</a>
                                </div>
                            </div>";
                    }
                } else {
                    echo "<p>Belum ada data mobil.</p>";
                }
            }

            tampilkan_mobil($conn);
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
