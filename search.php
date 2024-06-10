<?php
session_start();
require 'function.php';
$user = $_SESSION['user'];

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $conn = koneksi();
    $sql = "SELECT * FROM otomotive WHERE motor LIKE '%$query%' OR tipemotor LIKE '%$query%' OR harga LIKE '%$query%' OR deskripsi LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<th scope="row">' . $no++ . '</th>';
            $imagePath = 'img/' . $row['gambar'];
            if (file_exists($imagePath)) {
                echo '<td><img src="' . $imagePath . '" width="70"></td>';
            } else {
                echo '<td>Image not found</td>';
            }
            echo '<td>' . $row['motor'] . '</td>';
            echo '<td>Tipe: ' . $row['tipemotor'] . '</td>';
            echo '<td>Harga: ' . $row['harga'] . '</td>';
            echo '<td>Deskripsi: ' . $row['deskripsi'] . '</td>';
            if ($user['role'] == 'admin') {
                echo '<td>';
                echo '<a href="ubah.php?id=' . $row['id'] . '">Ubah</a> |';
                echo '<a href="hapus.php?id=' . $row['id'] . '">Hapus</a>';
                echo '</td>';
            }
            echo '</tr>';
        }
    } else {
        echo '<p>No results found.</p>';
    }
}
