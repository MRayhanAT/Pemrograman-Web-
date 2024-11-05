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
            width: 75%;
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

        .container-mobil {
            display: grid;
            background-color: rgba(255, 255, 255, 1); 
            grid-template-columns: 1fr 2fr;
            gap: 20px;
            padding: 20px;
            max-width: 800px;
            min-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .foto-mobil {
            grid-column: 1 / 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .foto-mobil img {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .info-mobil {
            grid-column: 2 / 3;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .info-mobil h2, .info-mobil h3 {
            margin: 0;
        }

        .rating-mobil {
            font-weight: bold;
            color: #f39c12;
        }

        .deskripsi-mobil {
            font-size: 0.9em;
            color: #666;
        }

        .btn-detail {
            padding: 8px 12px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-detail:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="kotak__navbar">
        <div class="logo__navbar">
            <a href="#" id="logo__navbar">RANKRIDE</a>
        </div>
        <ul class="menu__navbar">
            <li class="barang__navbar">
                <a href="galeri.php" class="links__navbar">CRUD</a>
            </li>
            <li class="barang__navbar">
                <a href="About Me.html" class="links__navbar">About Me</a>
            </li>
            <li class="barang__navbar">
                <a href="index.php" class="links__navbar">Login</a>
            </li>
            <li class="barang__navbar">
                <a href="register.php" class="links__navbar">Register</a>
            </li>
            <li class="barang__navbar">

                <a href="logout.php" class="links__navbar">LogOut</a>
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
                            <img src='" . htmlspecialchars($row["foto_mobil"]) . "' alt='Foto Mobil'>
                        </div>
                        <div class='info-mobil'>
                            <h2>ID Mobil: " . htmlspecialchars($row["id_mobil"]) . "</h2>
                            <h3>Nama Mobil: " . htmlspecialchars($row["nama_mobil"]) . "</h3>
                            <p class='rating-mobil'>Rata-Rata Rating: " . htmlspecialchars($row["rata_rata_rating"]?? ' ') . "</p>
                            <p class='deskripsi-mobil'>Deskripsi: " . htmlspecialchars($row["deskripsi"]) . "</p>
                            <a href='detail_mobil.php?id_mobil=" . htmlspecialchars($row["id_mobil"]) . "' class='btn-detail'>Lihat Detail</a>
                        </div>
                    </div>";
            }
        } else {
            echo "<p>Belum ada data mobil.</p>";
        }
    }

    echo "<h2>Mobil</h2>";
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