<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Website Pesawat</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container__form {
            margin: 20px auto;
            width: 50%;
            text-align: center;
        }

        .container__form form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container__form label,
        .container__form input {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .container__form input {
            padding: 10px;
            width: 70%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container__form input[type="submit"] {
            width: 50%;
            background-color: #131313;
            color: white;
            cursor: pointer;
        }

        .result {
            display: none; 
        }
    </style>
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
                <a href="login.php" class="links__navbar">Login</a>
            </li>
            <li class="tombol__navbar">
                <a href="form.php" class="tombol">Register</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container__form">
    <h1>Login</h1>

    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>

    <?php
    include 'koneksi.php';  

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);

        $sql = "SELECT * FROM login WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password_login'])) {
                echo "<p>Login Berhasil selamat datang, " . htmlspecialchars($row['nama']) . ".</p>";
            } else {
                echo "<p>Password salah, coba lagi.</p>";
            }
        } else {
            echo "<p>tidak ada akun dengan email tersebut.</p>";
        }
    }
    ?>
</div>

</body>
</html>
