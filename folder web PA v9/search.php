<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Kendaraan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="search-container">
    <!-- Search Form -->
    <form action="" method="get" class="search-form">
        <label for="nama_mobil" class="search-label">Cari Kendaraan:</label>
        <input type="text" name="nama_mobil" id="nama_mobil" placeholder="Masukkan nama kendaraan" value="<?= htmlspecialchars(isset($_GET['nama_mobil']) ? $_GET['nama_mobil'] : '') ?>" class="search-input">
        <button type="submit" class="search-button">Cari</button>
    </form>
</div>

<div class="search-results-wrapper">
    <?php
    require_once "koneksi.php";

    $nama_kendaraan = isset($_GET['nama_mobil']) ? $_GET['nama_mobil'] : '';

    $sql = "SELECT * FROM mobil WHERE nama_mobil LIKE ?";
    if ($stmt = $conn->prepare($sql)) {
        $search_term = '%' . $nama_kendaraan . '%';
        $stmt->bind_param("s", $search_term);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h2 class='search-title'>Hasil Pencarian untuk: " . htmlspecialchars($nama_kendaraan) . "</h2>";

        if ($result->num_rows > 0) {
            echo "<table class='results-table'>";
            echo "<tr><th>ID Kendaraan</th><th>Nama Kendaraan</th><th>Rating</th><th>Deskripsi</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id_mobil']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_mobil']) . "</td>";
                echo "<td>" . htmlspecialchars($row['rata_rata_rating'] ?? 'N/A') . "</td>";
                echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-results'>Tidak ada kendaraan yang ditemukan dengan nama tersebut.</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='error-message'>Terjadi kesalahan dalam proses pencarian. Silakan coba lagi.</p>";
    }

    $conn->close();
    ?>
</div>
</body>
</html>
