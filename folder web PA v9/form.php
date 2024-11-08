<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Pesawat</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .footer {
            background-color: #131313;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer__links ul {
            list-style: none;
            padding: 0;
        }

        .footer__links li {
            margin-bottom: 5px;
        }

        .footer__copyright {
            margin-top: 10px;
            font-size: 14px;
        }

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
            <a href="" id="logo__navbar">RIDERANK</a>
        </div>
        <div class="toggle__navbar" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="menu__navbar">
        <li class="barang__navbar">
                <a href="pilots.php" class="links__navbar">CRUD</a>
            </li>
            <li class="Barang__navbar">
                <a href="About Me.html" class="links__navbar">About Me</a>
            </li>
            <li class="barang__navbar">
                <a href="index.php" class="links__navbar">Login</a>
            </li>
            <li class="Barang__navbar">
                <a href="register.html" class="links__navbar">Register</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container__form">
        <h1>Register</h1>

        <form method="POST" action="">
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" required><br><br>

            <label for="umur">Umur:</label><br>
            <input type="number" id="umur" name="umur" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password_login">Password:</label><br>
            <input type="password" id="password_login" name="password_login" required><br><br>

            <input type="submit" value="Register">
        </form>

        <?php
        include 'koneksi.php';  

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $nama = htmlspecialchars($_POST["nama"]);
            $umur = htmlspecialchars($_POST["umur"]);
            $email = htmlspecialchars($_POST["email"]);
            $password_login = htmlspecialchars($_POST["password_login"]);

           
            $hashed_password = password_hash($password_login, PASSWORD_DEFAULT);

            
            $sql = "INSERT INTO login (nama, umur, email, password_login) VALUES ('$nama', '$umur', '$email', '$hashed_password')";

            
            if ($conn->query($sql) === TRUE) {
                echo "<p>Registrasi berhasil!</p>";
            } else {
                
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
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
        &copy; 2024 Punya Rayhan. All Rights Reserved. Pirates shall be hanged.
    </div>
</footer>

</body>
</html>
