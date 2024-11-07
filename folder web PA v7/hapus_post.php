<?php

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_mobil = $_GET['id'];
    $delete_query = "DELETE FROM post_mobil WHERE id_mobil = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id_mobil);
    $stmt->execute();
    $stmt->close();
    header("Location: daftar_post.php");
    exit();
}
?>

