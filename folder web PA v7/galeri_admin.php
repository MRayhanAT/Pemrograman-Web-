<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website RankRide</title>
    <link rel="stylesheet" href="styles.css">
    <style>

        
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
                            <p class='rating-mobil'>Rata-Rata Rating: " . htmlspecialchars($row["rata_rata_rating"]?? ' ') . "</p>
                            <p class='deskripsi-mobil'>Deskripsi: " . htmlspecialchars($row["deskripsi"]) . "</p>
                            <a href='detail_mobil_admin.php?id_mobil=" . htmlspecialchars($row["id_mobil"]) . "' class='btn-detail'>Lihat Detail</a>
                        </div>
                    </div>";
            }
        } else {
            echo "<p>Belum ada data mobil.</p>";
        }
    }

    echo '<h2 style="color: white;">Galeri</h2>';
    tampilkan_mobil($conn);
    ?>
</div>
</div>


</body>
</html>
