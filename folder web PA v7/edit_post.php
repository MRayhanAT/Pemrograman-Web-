<?php

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_mobil = $_GET['id'];
    $query = "SELECT * FROM post_mobil WHERE id_mobil = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_mobil);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mobil = $_POST['id_mobil'];
    $nama_mobil = $_POST['nama_mobil'];
    $rata_rata_rating = $_POST['rata_rata_rating'];
    $deskripsi = $_POST['deskripsi'];
    $foto_mobil = $_FILES['foto_mobil']['name'];

    if ($foto_mobil) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto_mobil);
        move_uploaded_file($_FILES['foto_mobil']['tmp_name'], $target_file);
        $update_query = "UPDATE post_mobil SET foto_mobil = ?, nama_mobil = ?, rata_rata_rating = ?, deskripsi = ? WHERE id_mobil = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssisi", $foto_mobil, $nama_mobil, $rata_rata_rating, $deskripsi, $id_mobil);
    } else {
        $update_query = "UPDATE post_mobil SET nama_mobil = ?, rata_rata_rating = ?, deskripsi = ? WHERE id_mobil = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sisi", $nama_mobil, $rata_rata_rating, $deskripsi, $id_mobil);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: daftar_post.php");
    exit();
}
?>

<main>
    <section>
        <h2>Edit Post Mobil</h2>
        <form action="edit_post.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_mobil" value="<?php echo $data['id_mobil']; ?>">
            <input type="text" name="nama_mobil" value="<?php echo htmlspecialchars($data['nama_mobil']); ?>" required>
            <input type="number" name="rata_rata_rating" value="<?php echo htmlspecialchars($data['rata_rata_rating']); ?>" required>
            <textarea name="deskripsi" required><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
            <input type="file" name="foto_mobil">
            <button type="submit">Update Mobil</button>
        </form>
    </section>
</main>

<?php include 'footer.php'; ?>
