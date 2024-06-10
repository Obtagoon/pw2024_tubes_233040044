<?php
require 'function.php';

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $conn = koneksi();
    $sql = "SELECT * FROM otomotive WHERE motor LIKE '%$query%' OR tipemotor LIKE '%$query%' OR harga LIKE '%$query%' OR deskripsi LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="card mb-3">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row['motor'] . '</h5>';
            echo '<p class="card-text">Tipe: ' . $row['tipemotor'] . '</p>';
            echo '<p class="card-text">Harga: ' . $row['harga'] . '</p>';
            echo '<p class="card-text">Deskripsi: ' . $row['deskripsi'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No results found.</p>';
    }
}
