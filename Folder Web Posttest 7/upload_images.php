<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Pesawat</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        form {
            display: flex;
            flex-direction: column; 
            width: 100%; 
        }
        .containerpilot {
            margin: 10px auto;
            background-color: white;
            min-height: 300px; 
            width: 75%;
            display: flex;
            flex-direction: column; 
            align-items: center; 
            justify-content: flex-start; 
            padding: 20px;
            border-radius: 10%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        table {
            width: 100%;
            margin-top: 20px; 
        }
    </style>
</head>
<body>
    
    <nav class="navbar">
        <div class="kotak__navbar">
            <div class="logo__navbar">
                <a href="#" id="logo__navbar">WRIGHT AVIATION</a>
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
                <li class="tombol__navbar">
                    <a href="form.php" class="tombol">Register</a>
                </li> 
            </ul>
        </div>
    </nav>

    <div class="containerpilot"> 
    <?php
    include 'koneksi.php'; 
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['delete'])) {
        $id = intval($_POST['id']);
        $sql = "SELECT image_path FROM images WHERE id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imagePath = $row['image_path'];
            $sql = "DELETE FROM images WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                if (file_exists($imagePath)) {
                    unlink($imagePath); 
                }
                echo "Image deleted successfully.";
            } else {
                echo "Error deleting image: " . $conn->error;
            }
        } else {
            echo "Image not found.";
        }
    }

    $sql = "SELECT * FROM images";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Image</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td><img src='" . htmlspecialchars($row['image_path']) . "' width='100' height='100'></td>";
            echo "</tr>";
        }
        echo "</table>";
    } 

    if (isset($_POST['submit'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }
        if (file_exists($target_file)) {
            echo "maaf, file sudah ada.";
            $uploadOk = 0;
        }
        if ($_FILES["image"]["size"] > 5000000) {
            echo "File terlalu besar.";
            $uploadOk = 0;
        }
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "maaf, hanya menerima JPG, JPEG, PNG & GIF files.";
            $uploadOk = 0;
        }
        if ($uploadOk === 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO images (image_path) VALUES ('$target_file')"; 
                if ($conn->query($sql) === TRUE) {
                    echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " sudah terupload.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "error.";
            }
        }
    }

    $conn->close();
    ?>      

        <form action="" method="post" enctype="multipart/form-data">
            <label for="image">Select Image:</label>
            <input type="file" name="image" id="image" required>
            <button type="submit" name="submit">Upload</button>
        </form>

        <form action="" method="post">
            <label for="id">Delete Image by ID:</label>
            <input type="number" name="id" id="id" required>
            <button type="submit" name="delete">Delete</button>
        </form>  
    </div>

    <footer class="footer">
        <div class="footer__links">
            <ul>
                <li><a href="#contact">Contact</a></li>
                <li>mrayhanat37@gmail.com</li>
                <li>081244746892</li>
            </ul>
        </div>
        <div class="footer__copyright">
            &copy; 2024 Punya Rayhan. All Rights Reserved. Pirates shall be hanged.
        </div>
    </footer>
</body>
</html>
