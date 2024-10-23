<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Pesawat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <nav class="navbar">
        <div class="kotak__navbar">
            <div class="logo__navbar">
                <a href="" id="logo__navbar">WRIGHT AVIATION</a>
            </div>
            <div class="toggle__navbar" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="menu__navbar">
                <li class="barang__navbar">
                    <a href="index.html" class="links__navbar">Home</a>
                </li>
                <li class="barang__navbar">
                    <a href="pilots.php" class="links__navbar">CRUD</a>
                </li>
                <li class="barang__navbar">
                    <a href="planes.html" class="links__navbar">Planes</a>
                </li> 
                <li class="Barang__navbar">
                    <a href="About Me.html" class="links__navbar">About Me</a>
                </li> 
                <li class="Barang__navbar">
                    <a href="upload_images.php" class="links__navbar">Upload File</a>
                </li> 
                <li class="Barang__navbar">
                    <a href="login.php" class="links__navbar">login</a>
                </li> 
                <li class="tombol__navbar">
                    <a href="form.php" class="tombol">Register</a>
                </li> 
            </ul>
        </div>
    </nav>
    
    <div class="containerpilot">
        <h1>Search Pilots</h1>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by Name" required>
            <input type="submit" value="Search">
        </form>
        
        <?php
        include 'koneksi.php';  

        if (isset($_GET['search'])) {
            $search = htmlspecialchars($_GET['search']);
            $sql = "SELECT id, name, pesawat, jam_terbang FROM pilots WHERE name LIKE '%$search%'";
        } else {
            $sql = "SELECT id, name, pesawat, jam_terbang FROM pilots";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Pesawat</th>
                        <th>Jam Terbang</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["id"]) . "</td>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["pesawat"]) . "</td>
                        <td>" . htmlspecialchars($row["jam_terbang"]) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No pilots found.";
        }
        ?>
    </div>
    
    <div class="container__form">
        <h1>Form edit</h1>

        <form method="POST" action="">
            <label for="tambah">Tambah:</label>
            <input type="radio" id="tambah" name="pilih" value="tambah" required><br><br>

            <label for="update">Update:</label>
            <input type="radio" id="update" name="pilih" value="update" required><br><br>

            <label for="delete">Delete:</label>
            <input type="radio" id="delete" name="pilih" value="delete" required><br><br>

            <label for="id">ID (Wajib untuk update dan delete):</label><br>
            <input type="number" id="id" name="id" required value="<?php echo isset($_POST['id']) ? htmlspecialchars($_POST['id']) : ''; ?>"><br><br>

            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>"><br><br>

            <label for="pesawat">Pesawat:</label><br>
            <input type="text" id="pesawat" name="pesawat" value="<?php echo isset($_POST['pesawat']) ? htmlspecialchars($_POST['pesawat']) : ''; ?>"><br><br>

            <label for="jam_terbang">Jam Terbang:</label><br>
            <input type="number" id="jam_terbang" name="jam_terbang" value="<?php echo isset($_POST['jam_terbang']) ? htmlspecialchars($_POST['jam_terbang']) : ''; ?>"><br><br>

            <input type="submit" value="Submit">
        </form>

        <?php
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = htmlspecialchars($_POST["id"]);
            $nama = htmlspecialchars($_POST["nama"]);
            $pesawat = htmlspecialchars($_POST["pesawat"]);
            $jam_terbang = htmlspecialchars($_POST["jam_terbang"]);
            $action = $_POST['pilih'];

            if ($action == 'tambah') {
                $sql_insert = "INSERT INTO pilots (name, pesawat, jam_terbang) VALUES ('$nama', '$pesawat', '$jam_terbang')";
                if ($conn->query($sql_insert) === TRUE) {
                    echo "<p>Pilot baru sudah ditambah!</p>";
                } else {
                    echo "Error: " . $conn->error;
                }
            } elseif ($action == 'update') {
                $sql_update = "UPDATE pilots SET name='$nama', pesawat='$pesawat', jam_terbang='$jam_terbang' WHERE id='$id'";
                if ($conn->query($sql_update) === TRUE) {
                    echo "<p>Pilot telah diedit!</p>";
                } else {
                    echo "Error: " . $conn->error;
                }
            } elseif ($action == 'delete') {
                $sql_delete = "DELETE FROM pilots WHERE id='$id'";
                if ($conn->query($sql_delete) === TRUE) {
                    echo "<p>Pilot telah dihapus!</p>";
                } else {
                    echo "Error: " . $conn->error;
                }
            }
        }
        ?>
    </div>

    <footer class="footer">
        <div class="footer__links">
            <ul>
                <li><a href="#contact">Contact</a></li>
                <div>
                    <li>mrayhanat37@gmail.Com</li>
                    <li>081244746892</li>
                </div>
            </ul>
        </div>

        <div class="footer__copyright">
            &copy; 2024 Punya Rayhan. All Rights Reserved. Pirates shall be hanged.
        </div>
    </footer>
</body>
</html>
