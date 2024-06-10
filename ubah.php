<?php
require 'function.php';

// Check if 'id' is set in $_GET and validate it
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Retrieve the record from the database
    $conn = koneksi();
    $query = "SELECT * FROM otomotive WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Data not found!";
        exit;
    }
} else {
    echo "Invalid ID!";
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data
    $gambar = $_POST['gambar'];
    $motor = $_POST['motor'];
    $tipemotor = $_POST['tipemotor'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    // Update the record in the database
    $query = "UPDATE otomotive SET gambar = '$gambar', motor = '$motor', tipemotor = '$tipemotor', harga = '$harga', deskripsi = '$deskripsi' WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'index.php';
              </script>";
    } else {
        echo "Failed to update data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data</title>
</head>

<body>
    <h1>Ubah Data</h1>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $data['id']; ?>">
        <label for="gambar">Gambar:</label><br>
        <input type="file" id="gambar" name="gambar" value="<?= $data['gambar']; ?>"><br>
        <label for="motor">Motor:</label><br>
        <input type="text" id="motor" name="motor" value="<?= $data['motor']; ?>"><br>
        <label for="tipemotor">Tipe Motor:</label><br>
        <input type="text" id="tipemotor" name="tipemotor" value="<?= $data['tipemotor']; ?>"><br>
        <label for="harga">Harga:</label><br>
        <input type="text" id="harga" name="harga" value="<?= $data['harga']; ?>"><br>
        <label for="deskripsi">Deskripsi:</label><br>
        <textarea id="deskripsi" name="deskripsi"><?= $data['deskripsi']; ?></textarea><br><br>
        <button type="submit">Simpan Perubahan</button>
    </form>
</body>

</html>